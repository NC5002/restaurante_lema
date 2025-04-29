<?php
include '../includes/conexion.php'; 
include '../clases/Menu.php';

$database = new Conexion();
$db = $database->obtenerConexion();

$menu = new Menu($db);
$categorias = $menu->leerCategorias();

// Consulta para obtener las categorías activas
try {
    $sql = "SELECT ID_CATEGORIA, NOMBRE FROM categoria WHERE ESTADO = 1 ORDER BY NOMBRE ASC";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener categorías: " . $e->getMessage());
}

if($_POST){
    try {
        // Validaciones básicas
        if(empty($_POST['NOMBRE']) || empty($_POST['PRECIO']) || empty($_FILES['IMAGEN']['name'])) {
            throw new Exception("Todos los campos requeridos deben estar completos");
        }

        // Procesar imagen
        $target_dir = "../includes/img/";
        $nombre_base = preg_replace('/[^a-zA-Z0-9]/', '_', $_POST['NOMBRE']);
        $nombre_archivo = uniqid() . '_' . $nombre_base . '.' . pathinfo($_FILES["IMAGEN"]["name"], PATHINFO_EXTENSION);
        $target_file = $target_dir . $nombre_archivo;

        // Validar tipo de imagen
        $mime_permitidos = ['image/jpeg', 'image/png', 'image/gif'];
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime_actual = $finfo->file($_FILES["IMAGEN"]["tmp_name"]);
        
        if(!in_array($mime_actual, $mime_permitidos)) {
            throw new Exception("Solo se permiten imágenes JPG, PNG o GIF");
        }

        // Mover archivo
        if(!move_uploaded_file($_FILES["IMAGEN"]["tmp_name"], $target_file)) {
            throw new Exception("Error subiendo la imagen");
        }

        // Asignar valores
        $menu->NOMBRE = $_POST['NOMBRE'];
        $menu->DESCRIPCION = $_POST['DESCRIPCION'];
        $menu->PRECIO = $_POST['PRECIO'];
        $menu->NUMERO_CATEGORIA = $_POST['NUMERO_CATEGORIA'];
        $menu->MEDIDA = $_POST['MEDIDA'];
        $menu->IMAGEN = $nombre_archivo;

        if($menu->crear()){
            echo '<div class="alert alert-success">Ítem creado exitosamente</div>';
        } else{
            unlink($target_file); // Eliminar imagen si falla la BD
            throw new Exception("Error al guardar en base de datos");
        }
        
    } catch (Exception $e) {
        echo '<div class="alert alert-danger">' . $e->getMessage() . '</div>';
    }

    
    if($menu->crear()){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill"></i> Ítem de menú creado exitosamente.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>';
    } else{
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i> No se pudo crear el ítem de menú.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>';
    }

}
include '../includes/head.php'; // Include header file for Bootstrap and other styles
include '../includes/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    <h3 class="mb-0 color-primario"><i class="bi bi-journal-plus"></i>Nuevo Ítem de Menú</h3>
                </div>
                <div class="card-body">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                        <div class="row g-3">
                            <div class="col-md-6 form-floating mb-3">                            
                               
                                <input type="text" class="form-control" id="NOMBRE" name="NOMBRE" placeholder="nombres"  required>
                                <label for="NOMBRE" class="form-label"> Nombre</label>
                            </div>
                            <div class="col-md-6 form-floating mb-3">
                                <select class="form-select" id="NUMERO_CATEGORIA" name="NUMERO_CATEGORIA" required>
                                        <option value="">Seleccione una categoria</option>
                                        <?php                               
                                        try {
                                            // Consulta para obtener las medidas
                                            $query = "SELECT ID_CATEGORIA, NOMBRE FROM categoria ORDER BY ID_CATEGORIA ASC";
                                            $stmt = $db->prepare($query);
                                            $stmt->execute();
                                            $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                            
                                            // Generar opciones
                                            foreach ($categorias as $categoria) {
                                                echo '<option value="' . htmlspecialchars($categoria['ID_CATEGORIA']) . '">'
                                                    . htmlspecialchars($categoria['NOMBRE']) . '</option>';
                                            }
                                        } catch(PDOException $e) {
                                            echo '<option value="" disabled>Error cargando categorias</option>';
                                        }
                                        ?>
                                    </select>    
                                <label for="NUMERO_CATEGORIA" class="form-label">Categoría
                                </label>
                            </div>
                            <div class="col-6 form-floating mb-3">
                                
                                <textarea class="form-control" id="DESCRIPCION" name="DESCRIPCION" placeholder="descripcion" rows="3"></textarea>
                                <label for="DESCRIPCION" class="form-label">Descripción</label>
                            </div>
                            <div class="col-6 form-floating mb-3">
                                <select class="form-select" id="MEDIDA" name="MEDIDA" required>
                                    <option value="">Seleccione una medida</option>
                                    <?php                               
                                    try {
                                        // Consulta para obtener las medidas
                                        $query = "SELECT ID_MEDIDA, DESCRIPCION FROM medidas ORDER BY DESCRIPCION ASC";
                                        $stmt = $db->prepare($query);
                                        $stmt->execute();
                                        $medidas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                        
                                        // Generar opciones
                                        foreach ($medidas as $medida) {
                                            echo '<option value="' . htmlspecialchars($medida['ID_MEDIDA']) . '">'
                                                . htmlspecialchars($medida['DESCRIPCION']) . '</option>';
                                        }
                                    } catch(PDOException $e) {
                                        echo '<option value="" disabled>Error cargando medidas</option>';
                                    }
                                    ?>
                                </select>
                                <label for="MEDIDA" class="form-label">Medida</label> <!-- Corregí el for para que coincida con el ID -->
                            </div>
                            <div class="col-md-4 form-floating mb-3">
                                
                                    <input type="number" class="form-control" id="PRECIO" name="PRECIO" step="0.01" min="0" required placeholder="precio">
                                <label for="PRECIO" class="form-label">Precio</label>
                            </div>
                            <div class="col-md-8 mb-3">
                                
                                <input class="form-control" type="file" id="IMAGEN" name="IMAGEN" accept="image/*">
                            </div>
                            <div class="col-12 mt-4">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="submit" class="btn btn-primario me-md-2">
                                        <i class="bi bi-save"></i> Guardar
                                    </button>
                                    <a href="./index_menu.php" class="btn btn-secundario">
                                        <i class="bi bi-arrow-left"></i> Volver
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
include '../includes/footer.php'; // Include footer file for Bootstrap and other scripts
?>