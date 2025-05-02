<?php
include '../includes/conexion.php'; 
include '../clases/Cliente.php';

$database = new Conexion();
$db = $database->obtenerConexion();

$cliente = new Cliente($db);

// --- INICIO MODIFICACIÓN FILTRO ---
// Obtener el término de búsqueda si existe
$cedula_buscar = isset($_GET['cedula_buscar']) ? trim($_GET['cedula_buscar']) : '';

if (!empty($cedula_buscar)) {
    // Si hay un término de búsqueda, usar el método de búsqueda
    $stmt = $cliente->buscarPorCedula($cedula_buscar);
} else {
    // Si no hay búsqueda, obtener todos los clientes
    $stmt = $cliente->leer();
}
// --- FIN MODIFICACIÓN FILTRO ---


include '../includes/head.php'; // Include header file for Bootstrap and other styles
include '../includes/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-dark d-flex justify-content-between align-items-center">
                    <h3 class="mb-0 color-primario"><i class="bi bi-people"></i> Listado de Clientes</h3>
                    <a href="crear_cliente.php" class="btn btn-primario">
                        <i class="bi bi-plus-circle"></i> Nuevo Cliente
                    </a>
                </div>
                <div class="card-body">
                    
                    <!-- --- INICIO FORMULARIO DE BÚSQUEDA --- -->
                    <form method="GET" action="./index_cliente.php" class="mb-4">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-8">
                            <input 
                                type="text" 
                                class="form-control" 
                                name="cedula_buscar" 
                                placeholder="Buscar por Cédula..." 
                                value="<?= htmlspecialchars($cedula_buscar) ?>" 
                            />
                            </div>
                            <div class="col-md-4 align-items-end">
                            <?php if (!empty($cedula_buscar)): ?>
                                <div class="row">
                                <a href="./index_cliente.php" class="btn btn-terciario w-100" title="Limpiar búsqueda">
                                    <i class="bi bi-x-lg"></i> Limpiar
                                </a>
                                </div>
                            <?php else: ?>  
                                <button class="btn btn-primario w-100" type="submit">
                                    <i class="bi bi-search"></i> Buscar
                                </button>     
                            <?php endif; ?>
                            </div>
                            
                        </div>
                    </form>
                    <!-- --- FIN FORMULARIO DE BÚSQUEDA --- -->

                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-light">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cédula</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Teléfono</th>
                                    <th>Registro</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                // --- INICIO VERIFICACIÓN RESULTADOS ---
                                if ($stmt->rowCount() > 0): 
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): 
                                ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['ID_CLIENTE']) ?></td>
                                        <td><?= htmlspecialchars($row['NUMERO_CEDULA']) ?></td>
                                        <td><?= htmlspecialchars($row['NOMBRE']) ?></td>
                                        <td><?= htmlspecialchars($row['APELLIDO']) ?></td>
                                        <td><?= htmlspecialchars($row['TELEFONO']) ?></td>
                                        <td><?= date('d/m/Y', strtotime($row['FECHA_REGISTRO'])) ?></td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="ver_cliente.php?ID_CLIENTE=<?= $row['ID_CLIENTE'] ?>" 
                                                   class="btn btn-sm btn-secundario" title="Ver detalles">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="editar_cliente.php?ID_CLIENTE=<?= $row['ID_CLIENTE'] ?>" 
                                                   class="btn btn-sm btn-primario" title="Editar">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a href="eliminar_cliente.php?ID_CLIENTE=<?= $row['ID_CLIENTE'] ?>" 
                                                   class="btn btn-sm btn-terciario" 
                                                   onclick="return confirm('¿Está seguro de eliminar este cliente?')" title="Eliminar">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php 
                                    endwhile; 
                                else: 
                                // --- MENSAJE SI NO HAY RESULTADOS ---
                                ?>
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            No se encontraron clientes<?= !empty($cedula_buscar) ? ' con la cédula indicada.' : '.' ?>
                                        </td>
                                    </tr>
                                <?php 
                                endif; 
                                // --- FIN VERIFICACIÓN RESULTADOS ---
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
include '../includes/footer.php'; // Include footer file for Bootstrap and other scripts
?>