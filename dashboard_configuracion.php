<?php
session_start(); // Start the session to manage user sessions
if (!isset($_SESSION['user_id'])){
    header("Location: ../index.php?error=Usuario no se ha logeado correctamente.");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurante</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <link href="./assets/img/favicon.png" rel="icon">
    <link href="./assets/img/apple-touch-icon.png" rel="apple-touch-icon"> 
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="./includes/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="./includes/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="./includes/vendor/aos/aos.css" rel="stylesheet">
    <link href="./includes/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="./includes/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    
    <!-- Custom CSS (Opcional) -->
    <link rel="stylesheet" href="./includes/css/style.css">
    <link href="./includes/css/main.css" rel="stylesheet">
</head>

<body>

<header>
    <div class="container">
    <nav class="navbar navbar-expand-lg  bg-dark shadow-sm">
        <div class="container">

            <button class="navbar-toggler btn-primario" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon "></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link link-primario" href="./dashboard.php">
                            <i class="bi bi-house-door"></i> Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link color-primario" href="./usuario/index_usuario.php">
                            <i class="bi bi-people"></i> Usuarios
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link color-primario " href="./categoria/index_categoria.php" >
                            <i class="bi bi-bookmark"></i> Categorías
                        </a>
                        
                    </li>
                    <li class="nav-item">
                        <a class="nav-link color-primario" href="./medida/index_medida.php">
                            <i class="bi bi-rulers"></i> Medidas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link color-primario" href="../rol/index_rol.php">
                            <i class="bi bi-person"></i> Roles
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link color-primario" href="./control/index_contol.php">
                            <i class="bi bi-door-open"></i> Ingresos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link color-primario" href="./empresa/index_empresa.php">
                        <i class="bi bi-building"></i> Empresa
                        </a>
                    </li>
                </ul>
                <div class="d-flex">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle color-primario" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i> Usuario
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item color-secundario" href="./logout.php">
                                        <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    </div>

</header>    

<div class="container">
    <div class="hstack gap-3">
    <div class="p-2">Nombre: <?php echo $_SESSION['user_nombre']; ?></div>
    <div class="p-2 ms-auto"><?php echo $_SESSION['user_rol_nombre']?></div>
    <div class="vr"></div>
    <div class="p-2"><?php echo $_SESSION['user_fecha']?></div>
    </div>
</div>
    

<div class="text-center mb-4">
        <img src="./includes/img/logo.png" alt="logo" class="img-fluid" width="200px">
    </div>

    <div class="container mt-5 text-center">
        <h1 class="display-4">Bienvenido a la Sección de Configuración</h1>
    
        </div>  
<?php
include './includes/footer.php'; // Include footer file for Bootstrap and other scripts
?>