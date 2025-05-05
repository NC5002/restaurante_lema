<?php
include '../includes/conexion.php';
include '../clases/Ingrediente.php';

$database = new Conexion();
$db       = $database->obtenerConexion();

$query = "
  SELECT 
    i.ID_INGREDIENTE,
    i.NOMBRE,
    i.DESCRIPCION,
    m.DESCRIPCION AS medida_desc,
    i.ESTADO,
    i.IMAGEN,
    i.FECHA_REGISTRO
  FROM ingredientes i 
  LEFT JOIN medidas m 
    ON i.MEDIDA = m.ID_MEDIDA
  ORDER BY i.ID_INGREDIENTE DESC
";
$stmt = $db->prepare($query);
$stmt->execute();

include '../includes/head.php';
include '../includes/header_configuracion.php';
?>

<body>
  <div class="container mt-4">
    <div class="card">
      <div class="card-header bg-dark d-flex justify-content-between align-items-center">
        <h2 class="mb-0 color-primario"><i class="bi bi-box-seam"></i> Lista de Ingredientes</h2>
        <a href="crear_ingrediente.php" class="btn btn-primario">
          <i class="bi bi-plus-circle"></i> Nuevo Ingrediente
        </a>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped table-hover table-light">
            <thead class="table-dark">
              <tr>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Medida</th>
                <th>Estado</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                <?php if($row['ESTADO'] == '1'): ?>
                  <tr>
                    <td>
                        <img src="../includes/img/<?php echo $row['IMAGEN']; ?>"
                            alt="<?php echo htmlspecialchars($row['NOMBRE']); ?>" 
                            class="img-fluid" width="50" height="50"> </td>
                    <td><?php echo htmlspecialchars($row['NOMBRE']); ?></td>
                    <td><?php echo htmlspecialchars($row['DESCRIPCION']); ?></td>
                    <td><?php echo htmlspecialchars($row['medida_desc']); ?></td>
                    <td>
                      <span class="badge bg-<?php echo $row['ESTADO']=='1' ? 'dark' : 'warning'; ?>">
                        <?php echo $row['ESTADO']=='1' ? 'Activo' : 'Inactivo'; ?>
                      </span>
                    </td>
                    <td>
                      <div class="btn-group" role="group">
                        <a href="editar_ingrediente.php?ID_INGREDIENTE=<?php echo $row['ID_INGREDIENTE']; ?>" 
                          class="btn btn-sm btn-primario">
                          <i class="bi bi-pencil"></i>
                        </a>
                        <?php if($row['ESTADO']=='1'): ?>
                        <a href="eliminar_ingrediente.php?ID_INGREDIENTE=<?php echo $row['ID_INGREDIENTE']; ?>" 
                          class="btn btn-sm btn-terciario" 
                          onclick="return confirm('¿Desactivar este ingrediente?')">
                          <i class="bi bi-trash"></i>
                        </a>
                        <?php else: ?>
                        <a href="activar_ingrediente.php?ID_INGREDIENTE=<?php echo $row['ID_INGREDIENTE']; ?>" 
                          class="btn btn-sm btn-secundario" 
                          onclick="return confirm('¿Activar este ingrediente?')">
                          <i class="bi bi-check-square"></i>
                        </a>
                        <?php endif; ?>
                      </div>
                    </td>
                  </tr>
                <?php endif ?>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
<?php include '../includes/footer.php'; ?>
