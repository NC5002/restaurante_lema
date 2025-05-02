<?php
$title = 'Registro de Usuario';
include './includes/head.php'; // Incluimos el head con Bootstrap

function validarContrasena($contrasena) {
    // Verificar si la contraseña tiene al menos 8 caracteres
    if (strlen($contrasena) < 8) {
        return "La contraseña debe tener al menos 8 caracteres.";
    }

    // Verificar si tiene al menos una letra mayúscula
    if (!preg_match('/[A-Z]/', $contrasena)) {
        return "La contraseña debe contener al menos una letra mayúscula.";
    }

    // Verificar si tiene al menos una letra minúscula
    if (!preg_match('/[a-z]/', $contrasena)) {
        return "La contraseña debe contener al menos una letra minúscula.";
    }

    // Verificar si tiene al menos un número
    if (!preg_match('/[0-9]/', $contrasena)) {
        return "La contraseña debe contener al menos un número.";
    }

    // Verificar si tiene al menos un símbolo especial
    if (!preg_match('/[\W_]/', $contrasena)) {
        return "La contraseña debe contener al menos un símbolo especial.";
    }

    return true; // La contraseña es válida
}

function validarCedula($cedula) {
    // Verificar que la cédula tenga exactamente 10 dígitos
    if (strlen($cedula) != 10) {
        return "La cédula debe tener 10 dígitos.";
    }

    // Los dos primeros dígitos deben estar entre 01 y 24, que son las provincias de Ecuador
    $provincia = substr($cedula, 0, 2);
    if ($provincia < 1 || $provincia > 24) {
        return "La cédula no corresponde a una provincia válida.";
    }

    // El tercer dígito debe estar entre 0 y 6 para cédulas de personas naturales
    $tercerDigito = substr($cedula, 2, 1);
    if ($tercerDigito > 6) {
        return "El tercer dígito es inválido.";
    }

    // Aplicar el algoritmo de verificación de cédula
    $coeficientes = [2, 1, 2, 1, 2, 1, 2, 1, 2]; // Coeficientes para multiplicar los primeros 9 dígitos
    $suma = 0;

    // Calcular la suma del algoritmo de verificación
    for ($i = 0; $i < 9; $i++) {
        $valor = (int)$cedula[$i] * $coeficientes[$i];
        if ($valor >= 10) {
            $valor -= 9;
        }
        $suma += $valor;
    }

    // Obtener el dígito verificador
    $digitoVerificador = (10 - ($suma % 10)) % 10;

    // Comparar el dígito verificador con el último dígito de la cédula
    if ($digitoVerificador != (int)$cedula[9]) {
        return "La cédula es inválida.";
    }

    return true; // La cédula es válida
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require './db.php';
    $nombre = $_POST['nombre'];  // Encriptar el nombre
    $email = $_POST['email'];
    $cedula = $_POST['cedula'];  // Encriptar la cédula
    $password = $_POST['password'];
    $passwordAgain = $_POST['password-again'];

    // Validación de cédula (sin encriptar)
    $validacionCedula = validarCedula($_POST['cedula']);
    if ($validacionCedula !== true) {
        $validacionCedula = "Tu mensaje de validación aquí.";
        header('Location: ./register.php?error=' . urlencode($validacionCedula));
        exit();
    } 
    // Validación de contraseñas
    else {
        $validacionContrasena = validarContrasena($password);
        if ($validacionContrasena !== true) {
            $validacionCedula = "Tu mensaje de validación aquí.";
            header('Location: ./register.php?error=' . urlencode($validacionCedula));
            exit();
        } else if ($password !== $passwordAgain) {
            header('Location: ./register.php?error=Las contraseñas no coinciden.');
            exit();
        } else {
            $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ? OR cedula = ?");
            $stmt->bind_param("ss", $email, $cedula);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                header('Location: ./register.php?error=El correo o la cédula ya están registrados.');
                exit();
            } else {
                // Consulta para obtener el código (ID) del tipo de usuario 'usuario'
                $stmt = $conn->prepare("SELECT id FROM roles WHERE nombre = ?");
                $tipoUsuario = 'Usuario';
                $stmt->bind_param("s", $tipoUsuario);
                $stmt->execute();
                $stmt->bind_result($codigoTipoUsuario);
                $stmt->fetch();
                $stmt->close();
                $estado = 0; // Por defecto, el usuario no está aprobado
                $passwordHashed = password_hash( $password, PASSWORD_BCRYPT);
                $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, cedula, password, rol_id, estado, fecha_registro) VALUES (?, ?, ?, ?, ?, ?, NOW())");
                $stmt->bind_param("ssssii", $nombre, $email, $cedula, $passwordHashed, $codigoTipoUsuario, $estado);
            
                if ($stmt->execute()) {
                    header('Location: ./register.php?success=Registro exitoso..');
                    exit();
                } else {
                    header('Location: ./register.php?error=Error en el registro:'.$conn->error );
                    exit();
                }
            }
            $stmt->close();
        }
    }
}

?>


<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success text-center">
        <?php echo htmlspecialchars($_GET['success']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger text-center">
        <?php echo htmlspecialchars($_GET['error']); ?>
    </div>
<?php endif; ?>


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
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-textarea-resize" viewBox="0 0 20 20">
            <path d="M0 4.5A2.5 2.5 0 0 1 2.5 2h11A2.5 2.5 0 0 1 16 4.5v7a2.5 2.5 0 0 1-2.5 2.5h-11A2.5 2.5 0 0 1 0 11.5zM2.5 3A1.5 1.5 0 0 0 1 4.5v7A1.5 1.5 0 0 0 2.5 13h11a1.5 1.5 0 0 0 1.5-1.5v-7A1.5 1.5 0 0 0 13.5 3zm10.854 4.646a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708l3-3a.5.5 0 0 1 .708 0m0 2.5a.5.5 0 0 1 0 .708l-.5.5a.5.5 0 0 1-.708-.708l.5-.5a.5.5 0 0 1 .708 0"/>
            </svg>        
            Registro</h1>
            <div class="color-primario text-center">
                    <p>La aplicación encripta la informacion sensible para usted.  
                        Lea nuestra <a class="link-primario link-offset-2 link-underline link-underline-opacity-0" 
                        href="../politicasprivacidad.php">Política de Privacidad</a>.</p>
                </div>
            <form method="POST" action="./register.php" onsubmit="return validarContrasenas();">

                <div class="form-floating mb-3">
                    <input type="text"  name="nombre" class="form-control" id="nombre" placeholder="nombres" required>
                    <label for="nombre">Nombres y Apellidos</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="email"  name="email" class="form-control" id="email" placeholder="email" required>
                    <label for="email">Correo Electrónico</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text"  name="cedula" class="form-control" id="cedula" placeholder="cedula" required>
                    <label for="cedula">Cédula</label>
                </div>

                <div class="color-primario text-center">
                    <p>La contraseña deberá ser mayor a 8 caracteres entre Mayusculas, minisculas, números y caracteres especiales.</p>
                </div>

                <div class="form-floating mb-3">
                    <input type="password"  name="password" class="form-control" id="password" placeholder="password" required >
                    <label for="password">Contraseña</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="password"  name="password-again" class="form-control" id="password-again" placeholder="password-again" required>
                    <label for="password-again">Repetir Contraseña</label>
                </div>



                <button type="submit" class="btn btn-primario w-100 mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-textarea-resize" viewBox="0 0 20 20">
                    <path d="M0 4.5A2.5 2.5 0 0 1 2.5 2h11A2.5 2.5 0 0 1 16 4.5v7a2.5 2.5 0 0 1-2.5 2.5h-11A2.5 2.5 0 0 1 0 11.5zM2.5 3A1.5 1.5 0 0 0 1 4.5v7A1.5 1.5 0 0 0 2.5 13h11a1.5 1.5 0 0 0 1.5-1.5v-7A1.5 1.5 0 0 0 13.5 3zm10.854 4.646a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708l3-3a.5.5 0 0 1 .708 0m0 2.5a.5.5 0 0 1 0 .708l-.5.5a.5.5 0 0 1-.708-.708l.5-.5a.5.5 0 0 1 .708 0"/>
                    </svg>      
                Registrar</button>
            </form>
            <a href="./index.php" class="btn btn-secundario w-100">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-return-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5"/>
                </svg>
            Regresar</a>
        </div>
    </div>
</div>



<?php include './includes/footer.php'; // Incluimos el pie de página ?>

