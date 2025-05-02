<?php
include './includes/head.php'; // Incluimos el head con Bootstrap
require './includes/bd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    if (empty($email) || empty($password)) {
        header('Location: login.php?error=Todos los campos son obligatorios.');
        exit();
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: login.php?error=Correo electrónico no válido.');
        exit();
    }
    $stmt = $conn->prepare("
    SELECT usuarios.id, usuarios.nombre, usuarios.password, usuarios.perfil, roles.nombre AS nombre_rol, roles.id AS rol_id 
    FROM usuarios 
    JOIN roles ON usuarios.rol_id = roles.id 
    WHERE usuarios.email = ?
        ");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($user_id, $user_nombre, $stored_hash, $perfil, $nombre_rol, $rol_id);
        if ($stmt->fetch()) {
            if (password_verify($password, $stored_hash)) {
                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_nombre'] = $user_nombre;
                $_SESSION['user_perfil'] = $perfil;
                $_SESSION['user_rol_nombre'] = $nombre_rol;
                $_SESSION['user_rol'] = $rol_id; // Cambié $rol_nombre por $rol_id ya que no estás seleccionando rol_nombre
                $_SESSION['user_fecha'] = date('Y-m-d');
                $stmt->close();

                $sql_ingreso = "INSERT INTO control_ingreso(user_id) VALUES (?)";
                $stmt_ingreso = $conn->prepare($sql_ingreso);
                $stmt_ingreso->bind_param("i", $user_id); // Cambié "s" por "i" ya que id es numérico
                $stmt_ingreso->execute();
                $stmt_ingreso->close();

                header("Location: dashboard.php");
                exit();
            }
        else {
            header('Location: login.php?error=Contraseña incorrecta.');
            exit();
            }
        } 
        else {
            header('Location: login.php?error=Usuario no encontrado.');
        exit();
        }
    $stmt->close();
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurante</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <link href="../includes/img/favicon.png" rel="icon">
    <link href="../includes/img/apple-touch-icon.png" rel="apple-touch-icon"> 

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

<div class="container mt-5 text-center">
<div class="text-center mb-4">
        <img src="./includes/img/logo.png" alt="logo" class="img-fluid" width="200px">
    </div>
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h1 class="text-center color-primario">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-person-bounding-box" viewBox="0 0 20 20">
            <path d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5M.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5m15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5"/>
            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
            </svg>
            Iniciar Sesión</h1>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <form method="POST" action="login.php">
                <div class="form-floating mb-3">
                    <input type="email" name="email" class="form-control" id="email" placeholder="nombre@ejemplo.com" required>
                    <label for="email">Correo Electrónico</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" name="password" class="form-control" id="password" placeholder="Contraseña" required>
                    <label for="password">Contraseña</label>
                </div>
                <button type="submit" class="btn btn-primario w-100 mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-bounding-box" viewBox="0 0 20 20">
                    <path d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5M.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5m15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5"/>
                    <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                    </svg>
                Iniciar Sesión</button>
            </form>
            <a href="./index.php" class="btn btn-secundario w-100">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-return-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5"/>
                </svg> 
            Regresar</a>
        </div>
    </div>
</div>

<?php 
include './includes/footer.php'; 
?>
