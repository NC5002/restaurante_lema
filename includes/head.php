<?php 
session_start();

if (isset($_GET['success'])): ?>
    <div class="alert alert-success text-center">
        <?php echo htmlspecialchars($_GET['success']); ?>
    </div>
<?php 
endif; 
if (isset($_GET['error'])): ?>
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
    <link href="../includes/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../includes/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../includes/vendor/aos/aos.css" rel="stylesheet">
    <link href="../includes/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="../includes/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

    <!-- Custom CSS (Opcional) -->
    <link rel="stylesheet" href="../includes/css/style.css">
    <link href="../includes/css/main.css" rel="stylesheet">

</head>