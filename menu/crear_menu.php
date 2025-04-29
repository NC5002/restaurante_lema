<?php
include '../includes/conexion.php'; 
include '../clases/Menu.php';

$database = new Conexion();
$db = $database->obtenerConexion();
$pdo = $database->obtenerConexion();

$menu = new Menu($db);
$categorias = $menu->leerCategorias();

// Consulta para obtener las categorías activas
try {
    $sql = "SELECT ID_CATEGORIA, NOMBRE FROM categoria WHERE ESTADO = 1 ORDER BY NOMBRE ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener categorías: " . $e->getMessage());
}

if($_POST){
    $menu->NOMBRE = $_POST['NOMBRE'];
    $menu->DESCRIPCION = $_POST['DESCRIPCION'];
    $menu->PRECIO = $_POST['PRECIO'];
    $menu->NUMERO_CATEGORIA = $_POST['NUMERO_CATEGORIA'];
    $menu->IMAGEN = $_FILES['IMAGEN']['name'];
    
    // Subir imagen
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["IMAGEN"]["name"]);
    move_uploaded_file($_FILES["IMAGEN"]["tmp_name"], $target_file);
    
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
                                <select class="form-select" id="ID_CATEGORIA" name="ID_CATEGORIA" placeholder="categorias" required>
                                    <option value="">Seleccione una categoría</option>
                                    <?php foreach ($categorias as $categoria): ?>
                                        <option value="<?= htmlspecialchars($categoria['ID_CATEGORIA']) ?>">
                                            <?= htmlspecialchars($categoria['NOMBRE']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="ID_CATEGORIA" class="form-label">Categoría
                                </label>
                            </div>
                            <div class="col-12 form-floating mb-3">
                                
                                <textarea class="form-control" id="DESCRIPCION" name="DESCRIPCION" placeholder="descripcion" rows="3"></textarea>
                                <label for="DESCRIPCION" class="form-label">Descripción</label>
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