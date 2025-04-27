<header>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="bi bi-cup-hot-fill"></i> Restaurante Lema
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?= ($pagina_actual == 'index.php') ? 'active' : '' ?>" href="../index.php">
                            <i class="bi bi-house-door"></i> Inicio
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link " href="./categoria/index.php" >
                            <i class="bi bi-bookmark"></i> Categorías
                        </a>
                        
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./menu/index_menu.php">
                            <i class="bi bi-menu-button"></i> Menú
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./cliente/index_cliente.php">
                            <i class="bi bi-people"></i> Clientes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./medida/index_medida.php">
                            <i class="bi bi-rulers"></i> Medidas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./proveedor/index_proveedor.php">
                            <i class="bi bi-person-lines-fill"></i> Proveedor
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./inventario/index_inventario.php">
                            <i class="bi bi-box-seam"></i> Inventario
                        </a>
                    </li>
                </ul>
                <div class="d-flex">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i> Usuario
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="bi bi-person"></i> Perfil
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="bi bi-gear"></i> Configuración
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger" href="#">
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
</header>    