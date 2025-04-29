<?php
$servername = "localhost";
$username = "root";
$password = ""; // Cambia esto si tienes una contraseña
$dbname = "lema"; // Asegúrate de que este sea el nombre correcto

/*
$servername = "localhost";
$username = "greenpc_bd_gpc";
$password = "7jXtGeM559cYMYP9fhyq"; // Cambia esto si tienes una contraseña
$dbname = "greenpc_bd_gpc"; // Asegúrate de que este sea el nombre correcto
*/

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificamos la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>