<?php
include '../includes/conexion.php'; 
include '../clases/Menu.php';

$database = new Conexion();
$db = $database->obtenerConexion();

$menu = new Menu($db);
$menu->CODIGO_MENU = isset($_GET['CODIGO_MENU']) ? $_GET['CODIGO_MENU'] : die('ERROR: ID no encontrado.');
$menu->leerUno();

$categorias = $menu->leerCategorias();

if($_POST){
    $menu->NOMBRE = $_POST['NOMBRE'];
    $menu->DESCRIPCION = $_POST['DESCRIPCION'];
    $menu->PRECIO = $_POST['PRECIO'];
    $menu->NUMERO_CATEGORIA = $_POST['NUMERO_CATEGORIA'];
    $menu->ESTADO = $_POST['ESTADO'];
    
    if(!empty($_FILES['IMAGEN']['name'])) {
        $menu->IMAGEN = $_FILES['IMAGEN']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["IMAGEN"]["name"]);
        move_uploaded_file($_FILES["IMAGEN"]["tmp_name"], $target_file);
    }
    
    if($menu->actualizar()){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill"></i> Ítem de menú actualizado exitosamente.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>';
    } else{
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i> No se pudo actualizar el ítem de menú.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>';
    }
}
include '../includes/head.php'; 
include '../includes/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-dark">
                    <h3 class="mb-0 color-primario"><i class="bi bi-journal-text"></i> Editar Ítem de Menú</h3>
                </div>
                <div class="card-body">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?CODIGO_MENU={$menu->CODIGO_MENU}"); ?>" method="post" enctype="multipart/form-data">
                        <div class="row g-3">
                            <div class="col-md-6 form-floating">
                                
                                <input type="text" class="form-control" id="NOMBRE" name="NOMBRE" value="<?= htmlspecialchars($menu->NOMBRE) ?>" required placeholder="nombre" >
                                <label for="NOMBRE" class="form-label">Nombre</label>
                            </div>
                            <div class="col-md-6 form-floating">
                                
                                <select class="form-select" id="NUMERO_CATEGORIA" name="NUMERO_CATEGORIA" required placeholder="numero">
                                    <option value="<?= htmlspecialchars($menu->NUMERO_CATEGORIA) ?>"><?= htmlspecialchars($menu->NUMERO_CATEGORIA) ?></option>
                                    <?php while ($categoria = $categorias->fetch(PDO::FETCH_ASSOC)): ?>
                                        <option value="<?= $categoria['NUMERO_CATEGORIA'] ?>" <?= ($categoria['NUMERO_CATEGORIA'] == $menu->NUMERO_CATEGORIA) ? 'selected' : '' ?>>
                                            <?= $categoria['NOMBRE'] ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                                <label for="NUMERO_CATEGORIA" class="form-label">Categoría</label>
                            </div>
                            <div class="col-12 form-floating">
                                <textarea class="form-control" id="DESCRIPCION" name="DESCRIPCION" rows="3" placeholder="descripcion"><?= htmlspecialchars($menu->DESCRIPCION) ?></textarea>
                                <label for="DESCRIPCION" class="form-label"><i class="bi bi-text-paragraph"></i> Descripción</label>
                            </div>
                            <div class="col-md-4 form-floating">
                                
                                    <input type="number" class="form-control" id="PRECIO" name="PRECIO" value="<?= htmlspecialchars($menu->PRECIO) ?>" step="0.01" min="0" required>
                                <label for="PRECIO" class="form-label">Precio</label>
                            </div>
                            <div class="col-md-4 form-floating">
  
                                <select class="form-select" id="ESTADO" name="ESTADO" required>
                                    <option value="ACTIVO" <?= ($menu->ESTADO == '1') ? 'selected' : '' ?>>Activo</option>
                                    <option value="INACTIVO" <?= ($menu->ESTADO == '0') ? 'selected' : '' ?>>Inactivo</option>
                                </select>
                                <label for="ESTADO" class="form-label">Estado</label>
                            </div>
                            <div class="col-md-4 form-floating">
                                
                                <input type="text" class="form-control" value="<?= date('d/m/Y', strtotime($menu->FECHA_REGISTRO)) ?>" readonly placeholder="date">
                                <label class="form-label">Fecha de Registro</label>
                            </div>
                            <div class="row g-3 ">
                                <div class="col-md-6 form-floating">
                                    <input class="form-control" type="text" id="IMAGEN" name="IMAGEN" value="<?= htmlspecialchars($menu->IMAGEN) ?>" readonly placeholder="imagen">    
                                    <label for="IMAGEN" class="form-label">Imagen</label>
                                </div>
                                <div class="col-md-6 d-flex justify-content-center">
                                    <img src='../includes/img/<?php echo htmlspecialchars($menu->IMAGEN)?>.png' class="img-thumbnail img-fluid align-self-center">       
                                </div>    
                            </div>
                            <div class="col-12 mt-4">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="submit" class="btn btn-primario me-md-2">
                                        <i class="bi bi-save"></i> Guardar Cambios
                                    </button>
                                    <a href="index_menu.php" class="btn btn-secundario">
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