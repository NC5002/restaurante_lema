<?php
include '../includes/conexion.php';
include '../clases/Receta.php';
include '../clases/Menu.php';
include '../clases/Ingrediente.php';

$database = new Conexion();
$db = $database->obtenerConexion();

$receta = new Receta($db);
$menu = new Menu($db);
$ingrediente = new Ingrediente($db);

// Obtener listados para los selects
$menus = $menu->leer();
$ingredientes = $ingrediente->leer();

if($_POST){
    $receta->codigo_menu = $_POST['codigo_menu'];
    $receta->id_ingrediente = $_POST['id_ingrediente'];
    $receta->cantidad = $_POST['cantidad'];
    
    if($receta->crear()){
        header("Location: index_receta.php?creado=1");
        exit();
    } else {
        $error = "Error al crear la receta";
    }
}

include '../includes/head.php';
include '../includes/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12 mx-auto">
            <div class="card shadow">
                <div class="card-header bg-dark ">
                    <h3 class="mb-0 color-primario"><i class="bi bi-book"></i> Nueva Receta</h3>
                </div>
                <div class="card-body">
                    <?php if(isset($error)): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>
                    
                    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
                        <div class="row g-3">
                            <div class="col-md-6 form-floating">
                                <select class="form-select" id="codigo_menu" name="codigo_menu" required>
                                    <option value="">Seleccione un menú</option>
                                    <?php while ($menu = $menus->fetch(PDO::FETCH_ASSOC)): ?>
                                        <option value="<?= htmlspecialchars($menu['CODIGO_MENU']) ?>">
                                            <?= htmlspecialchars($menu['CODIGO_MENU']) ?> - <?= htmlspecialchars($menu['NOMBRE']) ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                                <label for="codigo_menu">Menú</label>
                            </div>
                            
                            <div class="col-md-6 form-floating">
                                <select class="form-select" id="id_ingrediente" name="id_ingrediente" required>
                                    <option value="">Seleccione un ingrediente</option>
                                    <?php while ($ing = $ingredientes->fetch(PDO::FETCH_ASSOC)): ?>
                                        <option value="<?= htmlspecialchars($ing['ID_INGREDIENTE']) ?>">
                                            <?= htmlspecialchars($ing['NOMBRE']) ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                                <label for="id_ingrediente">Ingrediente</label>
                            </div>
                            
                            <div class="col-md-6 form-floating">
                                <input type="number" step="0.01" min="0.01" class="form-control" id="cantidad" name="cantidad" required>
                                <label for="cantidad">Cantidad</label>
                            </div>
                            
                            <div class="col-12">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-save"></i> Guardar Receta
                                    </button>
                                    <a href="index_receta.php" class="btn btn-secondary">
                                        <i class="bi bi-arrow-left"></i> Cancelar
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

<?php include '../includes/footer.php'; ?>