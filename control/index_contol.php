<?php
include '../includes/conexion.php';

$database = new Conexion();
$db = $database->obtenerConexion();

// Fechas para filtrar
$today       = date('Y-m-d');
$startOfWeek = date('Y-m-d', strtotime('-' . (date('N') - 1) . ' days')); // lunes de esta semana

// 1) Ingresos de hoy
$stmtDaily = $db->prepare("
    SELECT 
      ci.user_id, 
      u.nombre AS usuario_nombre, 
      ci.fecha_ingreso 
    FROM control_ingreso ci
    JOIN usuarios u ON ci.user_id = u.id
    WHERE DATE(ci.fecha_ingreso) = :today
    ORDER BY ci.fecha_ingreso DESC
");
$stmtDaily->bindParam(':today', $today);
$stmtDaily->execute();

// 2) Ingresos días anteriores de esta semana (desde lunes hasta ayer)
$stmtWeek = $db->prepare("
    SELECT 
      ci.user_id, 
      u.nombre AS usuario_nombre, 
      ci.fecha_ingreso 
    FROM control_ingreso ci
    JOIN usuarios u ON ci.user_id = u.id
    WHERE DATE(ci.fecha_ingreso) >= :startOfWeek
      AND DATE(ci.fecha_ingreso) < :today
    ORDER BY ci.fecha_ingreso DESC
");
$stmtWeek->bindParam(':startOfWeek', $startOfWeek);
$stmtWeek->bindParam(':today', $today);
$stmtWeek->execute();

// 3) Ingresos del resto del mes (antes del lunes de esta semana, pero en este mes)
$stmtMonth = $db->prepare("
    SELECT 
      ci.user_id, 
      u.nombre AS usuario_nombre, 
      ci.fecha_ingreso 
    FROM control_ingreso ci
    JOIN usuarios u ON ci.user_id = u.id
    WHERE DATE(ci.fecha_ingreso) < :startOfWeek
      AND MONTH(ci.fecha_ingreso) = MONTH(CURDATE())
      AND YEAR(ci.fecha_ingreso) = YEAR(CURDATE())
    ORDER BY ci.fecha_ingreso DESC
");
$stmtMonth->bindParam(':startOfWeek', $startOfWeek);
$stmtMonth->execute();
?>

<?php include '../includes/head.php'; ?>
<?php include '../includes/header_configuracion.php'; ?>

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-dark d-flex justify-content-between align-items-center">
            <h3 class="mb-0 color-primario"><i class="bi bi-calendar3-week"></i> Verificacion de Ingresos de Usuarios</h3>

        </div>
        <div class="card-body">
            <div class="accordion" id="accordionIngresos">
                <!-- Hoy -->
                <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button color-primario" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapseToday"
                            aria-expanded="true" aria-controls="collapseToday">
                    <i class="bi bi-calendar4-event me-2"></i> <strong>Ingresos de Hoy</strong>
                    </button>
                </h2>
                <div id="collapseToday" class="accordion-collapse collapse show" data-bs-parent="#accordionIngresos">
                    <div class="accordion-body">
                    <?php if ($stmtDaily->rowCount()): ?>
                        <table class="table table-striped table-hover table-dark">
                        <thead class="table-dark">
                            <tr>
                            <th style="color:var(--color-primario)">Usuario (ID – Nombre)</th>
                            <th style="color:var(--color-primario)">Fecha y Hora</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $stmtDaily->fetch(PDO::FETCH_ASSOC)): ?>
                            <tr>
                                <td>
                                <?php 
                                    echo htmlspecialchars($row['user_id'] . ' - ' . $row['usuario_nombre']); 
                                ?>
                                </td>
                                <td><?php echo htmlspecialchars($row['fecha_ingreso']); ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                        </table>
                    <?php else: ?>
                        <div class="alert alert-primary">No hay ingresos registrados hoy.</div>
                    <?php endif; ?>
                    </div>
                </div>
                </div>

                <!-- Esta semana (antes de hoy) -->
                <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed color-primario" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapseWeek"
                            aria-expanded="false" aria-controls="collapseWeek">
                    <i class="bi bi-calendar-week me-2"></i> <strong>Ingresos de esta Semana</strong>
                    </button>
                </h2>
                <div id="collapseWeek" class="accordion-collapse collapse" data-bs-parent="#accordionIngresos">
                    <div class="accordion-body">
                    <?php if ($stmtWeek->rowCount()): ?>
                        <table class="table table-striped table-hover table-light">
                        <thead class="table-dark ">
                            <tr>
                            <th style="color:var(--color-primario)">Usuario (ID – Nombre)</th>
                            <th style="color:var(--color-primario)">Fecha y Hora</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $stmtWeek->fetch(PDO::FETCH_ASSOC)): ?>
                            <tr>
                                <td>
                                <?php 
                                    echo htmlspecialchars($row['user_id'] . ' - ' . $row['usuario_nombre']); 
                                ?>
                                </td>
                                <td><?php echo htmlspecialchars($row['fecha_ingreso']); ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                        </table>
                    <?php else: ?>
                        <div class="alert alert-primary">No hay ingresos anteriores a hoy en esta semana.</div>
                    <?php endif; ?>
                    </div>
                </div>
                </div>

                <!-- Resto del mes -->
                <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed color-primario" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapseMonth"
                            aria-expanded="false" aria-controls="collapseMonth">
                    <i class="bi bi-calendar-month me-2"></i> <strong>Ingresos del Resto del Mes</strong>
                    </button>
                </h2>
                <div id="collapseMonth" class="accordion-collapse collapse" data-bs-parent="#accordionIngresos">
                    <div class="accordion-body">
                    <?php if ($stmtMonth->rowCount()): ?>
                        <table class="table table-striped table-hover table-light">
                        <thead class="table-dark">
                            <tr>
                            <th style="color:var(--color-primario)">Usuario (ID – Nombre)</th>
                            <th style="color:var(--color-primario)">Fecha y Hora</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $stmtMonth->fetch(PDO::FETCH_ASSOC)): ?>
                            <tr>
                                <td>
                                <?php 
                                    echo htmlspecialchars($row['user_id'] . ' - ' . $row['usuario_nombre']); 
                                ?>
                                </td>
                                <td><?php echo htmlspecialchars($row['fecha_ingreso']); ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                        </table>
                    <?php else: ?>
                        <div class="alert alert-primary">No hay ingresos registrados en el resto del mes.</div>
                    <?php endif; ?>
                    </div>
                </div>
                </div>

            </div>
        </div>
    </div>        
</div>

<?php include '../includes/footer.php'; ?>
