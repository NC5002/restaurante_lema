<?php
include '../includes/conexion.php';
include '../clases/Ingrediente.php';

$database = new Conexion();
$db       = $database->obtenerConexion();
$ing      = new Ingrediente($db);


// Obtener medidas
try {
    $sql = "SELECT ID_MEDIDA, DESCRIPCION 
            FROM medidas 
            ORDER BY DESCRIPCION ASC";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $medidas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener medidas: " . $e->getMessage());
}

if ($_POST) {
    try {
        // Validar campos requeridos
        if (
            empty($_POST['NOMBRE']) ||
            empty($_POST['MEDIDA']) ||
            empty($_FILES['IMAGEN']['name'])
        ) {
            throw new Exception("Todos los campos requeridos deben estar completos.");
        }

        // Procesar imagen
        $target_dir    = "../includes/img/";
        $base_name     = preg_replace('/[^a-zA-Z0-9]/', '_', $_POST['NOMBRE']);
        $ext           = pathinfo($_FILES['IMAGEN']['name'], PATHINFO_EXTENSION);
        $file_name     = uniqid() . "_{$base_name}.{$ext}";
        $target_file   = $target_dir . $file_name;

        // Validar tipo MIME
        $mime_permitidos = ['image/jpeg', 'image/png', 'image/gif'];
        $finfo           = new finfo(FILEINFO_MIME_TYPE);
        $mime_actual     = $finfo->file($_FILES['IMAGEN']['tmp_name']);
        if (!in_array($mime_actual, $mime_permitidos)) {
            throw new Exception("Solo se permiten imágenes JPG, PNG o GIF.");
        }

        // Mover archivo subido
        if (!move_uploaded_file($_FILES['IMAGEN']['tmp_name'], $target_file)) {
            throw new Exception("Error subiendo la imagen.");
        }

        // Asignar valores al objeto
        $ing->NOMBRE           = $_POST['NOMBRE'];
        $ing->DESCRIPCION      = $_POST['DESCRIPCION'];
        $ing->MEDIDA           = $_POST['MEDIDA'];
        $ing->IMAGEN           = $file_name;

        // Crear registro
        if ($ing->crear()) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill"></i> Ingrediente creado exitosamente.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                  </div>';
        } else {
            // Si falla BD, eliminar imagen subida
            @unlink($target_file);
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill"></i> No se pudo crear el ingrediente.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                  </div>';
        }
    } catch (Exception $e) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i> ' . $e->getMessage() . '
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>';
    }
}

include '../includes/head.php';
include '../includes/header_configuracion.php';
?>

<body>
  <div class="container mt-4">
    <div class="row">
      <div class="col-md-12">
        <div class="card shadow">
          <div class="card-header bg-dark text-white">
            <h3 class="mb-0 color-primario"><i class="bi bi-journal-plus"></i> Nuevo Ingrediente</h3>
          </div>
          <div class="card-body">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" 
                  method="post" enctype="multipart/form-data">
              <div class="row g-3">

                <div class="col-md-6 form-floating mb-3">
                  <input type="text" class="form-control" id="NOMBRE" name="NOMBRE" placeholder="Nombre" required>
                  <label for="NOMBRE"> Nombre</label>
                </div>

                <div class="col-6 form-floating mb-3">
                  <select class="form-select" id="MEDIDA" name="MEDIDA" required>
                    <option value="">Seleccione una medida</option>
                    <?php foreach ($medidas as $med): ?>
                      <option value="<?php echo htmlspecialchars($med['ID_MEDIDA']); ?>">
                        <?php echo htmlspecialchars($med['DESCRIPCION']); ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                  <label for="MEDIDA"> Medida</label>
                </div>

                <div class="col-12 form-floating mb-3">
                  <textarea class="form-control" id="DESCRIPCION" name="DESCRIPCION" 
                            placeholder="Descripción" style="height:100px;"></textarea>
                  <label for="DESCRIPCION"> Descripción</label>
                </div>

                <div class="col-md-8 mb-3">
                  <input class="form-control" type="file" id="IMAGEN" name="IMAGEN" accept="image/*" required>
                </div>

                <div class="col-12 mt-4 d-grid gap-2 d-md-flex justify-content-md-end">
                  <button type="submit" class="btn btn-primario me-md-2">
                    <i class="bi bi-save"></i> Guardar
                  </button>
                  <a href="./index_ingrediente.php" class="btn btn-secundario">
                    <i class="bi bi-arrow-left"></i> Volver
                  </a>
                </div>

              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php include '../includes/footer.php'; ?>
