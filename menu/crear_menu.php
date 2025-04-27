<?php
include '../conexion.php'; 
include '../Menu.php';

$database = new Conexion();
$db = $database->obtenerConexion();

$menu = new Menu($db);
$categorias = $menu->leerCategorias();

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
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0"><i class="bi bi-journal-plus"></i> Nuevo Ítem de Menú</h3>
                </div>
                <div class="card-body">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="NOMBRE" class="form-label"><i class="bi bi-card-heading"></i> Nombre</label>
                                <input type="text" class="form-control" id="NOMBRE" name="NOMBRE" required>
                            </div>
                            <div class="col-md-6">
                                <label for="NUMERO_CATEGORIA" class="form-label"><i class="bi bi-bookmark"></i> Categoría</label>
                                <select class="form-select" id="NUMERO_CATEGORIA" name="NUMERO_CATEGORIA" required>
                                    <option value="">Seleccione una categoría</option>
                                    <?php while ($categoria = $categorias->fetch(PDO::FETCH_ASSOC)): ?>
                                        <option value="<?= $categoria['NUMERO_CATEGORIA'] ?>"><?= $categoria['NOMBRE'] ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="DESCRIPCION" class="form-label"><i class="bi bi-text-paragraph"></i> Descripción</label>
                                <textarea class="form-control" id="DESCRIPCION" name="DESCRIPCION" rows="3"></textarea>
                            </div>
                            <div class="col-md-4">
                                <label for="PRECIO" class="form-label"><i class="bi bi-currency-dollar"></i> Precio</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" id="PRECIO" name="PRECIO" step="0.01" min="0" required>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <label for="IMAGEN" class="form-label"><i class="bi bi-image"></i> Imagen</label>
                                <input class="form-control" type="file" id="IMAGEN" name="IMAGEN" accept="image/*">
                            </div>
                            <div class="col-12 mt-4">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="submit" class="btn btn-primary me-md-2">
                                        <i class="bi bi-save"></i> Guardar
                                    </button>
                                    <a href="index_menu.php" class="btn btn-outline-secondary">
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