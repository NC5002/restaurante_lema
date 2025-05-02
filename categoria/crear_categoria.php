<?php
include '../includes/conexion.php'; 
include '../clases/Categoria.php';

$database = new Conexion(); // Ensure the 'Conexion' class is defined in '/assets/config/bd.php'
$db = $database->obtenerConexion();

$categoria = new Categoria($db);

if($_POST){
    $categoria->NOMBRE = $_POST['NOMBRE'];
    
    if($categoria->crear()){
        echo "<div class='alert alert-success'>Categoría creada exitosamente.</div>";
    } else{
        echo "<div class='alert alert-danger'>No se pudo crear la categoría.</div>";
    }
}
include '../includes/head.php'; // Include header file for Bootstrap and other styles
include '../includes/header_configuracion.php';
?>


<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-dark">
                        <h2 class="mb-0 color-primario"><i class="bi bi-plus-circle"></i> Crear Nueva Categoría</h2>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="form-floating mb-3">
                                
                                <input type="text" class="form-control" id="NOMBRE" name="NOMBRE" required placeholder="nombre">
                                <label for="NOMBRE" class="form-label"><i class="bi bi-tag"></i> Nombre</label>

                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-primario me-md-2"><i class="bi bi-save"></i> Guardar</button>
                                <a href="./index_categoria.php" class="btn btn-secundario"><i class="bi bi-arrow-left"></i> Volver</a>
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