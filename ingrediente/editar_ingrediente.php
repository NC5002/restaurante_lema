<?php
include '../includes/conexion.php';
include '../clases/Ingrediente.php';

$database = new Conexion();
$db       = $database->obtenerConexion();
$ing      = new Ingrediente($db);

$ing->ID_INGREDIENTE = isset($_GET['ID_INGREDIENTE']) ? $_GET['ID_INGREDIENTE'] : die('ID no proporcionado.');
$ing->leerUno();

if($_POST){
    foreach($_POST as $k => $v){
        if(property_exists($ing, $k)){
            $ing->$k = $v;
        }
    }
    if($ing->actualizar()){
        echo "<div class='alert alert-success'>Ingrediente actualizado correctamente.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error al actualizar ingrediente.</div>";
    }
}

include '../includes/head.php';
include '../includes/header_configuracion.php';
?>

<body>
  <div class="container mt-5">
    <div class="card">
      <div class="card-header bg-dark">
        <h2 class="mb-0 color-primario"><i class="bi bi-pencil"></i> Editar Ingrediente</h2>
      </div>
      <div class="card-body">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?CODIGO_MENU={$ing->ID_INGREDIENTE}"; ?>" method="post">
          <!-- Mismos campos que en crear, pero con value -->
          <div class="form-floating mb-3">
            <input type="text" name="NOMBRE" id="NOMBRE" class="form-control"
                   value="<?php echo htmlspecialchars($ing->NOMBRE); ?>" required>
            <label for="NOMBRE"> Nombre</label>
          </div>
          <div class="form-floating mb-3">
            <textarea name="DESCRIPCION" id="DESCRIPCION" class="form-control" 
                       required><?php echo htmlspecialchars($ing->DESCRIPCION); ?></textarea>
            <label for="DESCRIPCION"> Descripción</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" name="MEDIDA" id="MEDIDA" class="form-control"
                   value="<?php echo htmlspecialchars($ing->MEDIDA); ?>" required>
            <label for="MEDIDA"> Medida</label>
          </div>
          <div class="mb-3 form-floating">
            
            <input type="text" class="form-control" value="<?php echo $ing->ESTADO=='1'?'Activo':'Inactivo'; ?>" readonly>
            <label class="form-label"> Estado</label>
          </div>
          <div class="mb-3 form-floating">
            
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($ing->FECHA_REGISTRO); ?>" readonly>
            <label class="form-label"><i class="bi bi-clock"></i> Fecha Registro</label>
          </div>
          <div class="row">
            <div class="col-md-6  justify-content-center">
              <div class="form-floating mb-3">
                <input type="text" name="IMAGEN" id="IMAGEN" class="form-control"
                      value="<?php echo htmlspecialchars($ing->IMAGEN); ?>">
                <label for="IMAGEN"><i class="bi bi-image"></i> URL Imagen</label>
              </div>
            </div>
            <div class="col-md 6 text-center" >
              <div class="mb-3">
                <img src="../includes/img/<?php echo htmlspecialchars($ing->IMAGEN); ?>" 
                     alt="<?php echo htmlspecialchars($ing->NOMBRE); ?>" class="img-fluid img-thumbnail" width="200">
              </div>
            </div>
          </div>
          <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-primario me-md-2">
              <i class="bi bi-save"></i> Guardar Cambios
            </button>
            <a href="./index_ingrediente.php" class="btn btn-secundario">
              <i class="bi bi-arrow-left"></i> Volver
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php include '../includes/footer.php'; ?>
