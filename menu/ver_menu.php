<?php
include '../includes/conexion.php'; 
include '../clases/Menu.php';
include '../clases/Categoria.php';

$database = new Conexion();
$db = $database->obtenerConexion();

$menu = new Menu($db);
$categoria = new Categoria($db);

$menu->CODIGO_MENU = isset($_GET['CODIGO_MENU']) ? $_GET['CODIGO_MENU'] : die('ERROR: ID de menú no encontrado.');
$menu->leerUno();

// Obtener nombre de la categoría
$categoria->ID_CATEGORIA = $menu->NUMERO_CATEGORIA;
$nombre_categoria = $menu->obtenerNombreCategoria($menu->NUMERO_CATEGORIA);

// Obtener descripción de la medida
try {
    $query = "SELECT DESCRIPCION FROM medidas WHERE ID_MEDIDA = ?";
    $stmt_medida = $db->prepare($query);
    $stmt_medida->execute([$menu->MEDIDA]);
    $medida = $stmt_medida->fetch(PDO::FETCH_ASSOC);
    $descripcion_medida = htmlspecialchars($medida['DESCRIPCION'] ?? 'No especificado');
} catch(PDOException $e) {
    $descripcion_medida = 'Error al cargar';
}

include '../includes/head.php';
include '../includes/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-dark d-flex justify-content-between align-items-center">
                    <h3 class="mb-0 color-primario"><i class="bi bi-egg-fried"></i> Detalles del Ítem de Menú</h3>
                </div>
                <div class="card-body">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-md-4 text-center mb-4 ">
                            <?php if($menu->IMAGEN): ?>
                                <img src="../includes/img/<?= htmlspecialchars($menu->IMAGEN)?>" 
                                     alt="<?= htmlspecialchars($menu->NOMBRE) ?>" 
                                     class="rounded img-thumbnail ">
                            <?php else: ?>
                                <div class="bg-light p-5 text-center">
                                    <i class="bi bi-image" style="font-size: 5rem;"></i>
                                    <p class="mt-2">Sin imagen</p>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-8">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th class="bg-light" style="width: 30%"><i class="bi bi-tag"></i> Código:</th>
                                            <td><?= htmlspecialchars($menu->CODIGO_MENU) ?></td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light"><i class="bi bi-card-text"></i> Nombre:</th>
                                            <td><?= htmlspecialchars($menu->NOMBRE) ?></td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light"><i class="bi bi-text-paragraph"></i> Descripción:</th>
                                            <td><?= htmlspecialchars($menu->DESCRIPCION) ?></td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light"><i class="bi bi-rulers"></i> Medida:</th>
                                            <td><?= $descripcion_medida ?></td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light"><i class="bi bi-bookmark"></i> Categoría:</th>
                                            <td><?= htmlspecialchars($nombre_categoria) ?></td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light"><i class="bi bi-currency-dollar"></i> Precio:</th>
                                            <td>$<?= number_format($menu->PRECIO, 2) ?></td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light"><i class="bi bi-circle-fill"></i> Estado:</th>
                                            <td>
                                                <span class="badge bg-<?= $menu->ESTADO == '1' ? 'success' : 'secondary' ?>">
                                                    <?= $menu->ESTADO == '1' ? 'Activo' : 'Inactivo' ?>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light"><i class="bi bi-calendar"></i> Fecha Registro:</th>
                                            <td><?= date('d/m/Y', strtotime($menu->FECHA_REGISTRO)) ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                
                                <a href="./index_menu.php" class="btn btn-primario"><i class="bi bi-arrow-left"></i> Volver al Listado</a>

                </div>
            </div>
        </div>
    </div>
</div>

<?php 
include '../includes/footer.php';
?>