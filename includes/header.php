<?php 
if (!isset($_SESSION['user_id'])){
    header("Location: ../index.php?error=Usuario no se ha logeado correctamente.");
    exit();
}
?>

<body>
<header>
    <div class="container">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link color-primario" href="../dashboard.php">
                            <i class="bi bi-house-door"></i> Inicio
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link color-primario" href="../menu/index_menu.php">
                            <i class="bi bi-menu-button"></i> Menú
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link color-primario" href="../cliente/index_cliente.php">
                            <i class="bi bi-people"></i> Clientes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link color-primario" href="../proveedor/index_proveedor.php">
                            <i class="bi bi-person-lines-fill"></i> Proveedor
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link color-primario" href="../inventario/index_inventario.php">
                            <i class="bi bi-box-seam"></i> Inventario
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link color-primario" href="../compra/index_compra.php">
                            <i class="bi bi-cart-plus"></i> Compras
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link color-primario" href="../factura/index_factura.php">
                            <i class="bi bi-receipt-cutoff"></i> Facturas
                        </a>
                    </li>
                    <li>
                        <a class="nav-link color-primario" href="../dashboard_configuracion.php">
                            <i class="bi bi-gear"></i> Configuración
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
                                    <a class="dropdown-item color-secundario" href="../logout.php">
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

<main>

<div class="container">
    <div class="hstack gap-3">
    <div class="p-2">Nombre: <?php echo $_SESSION['user_nombre']; ?></div>
    <div class="p-2 ms-auto"><?php echo $_SESSION['user_rol_nombre']?></div>
    <div class="vr"></div>
    <div class="p-2"><?php echo $_SESSION['user_fecha']?></div>
    </div>
</div>