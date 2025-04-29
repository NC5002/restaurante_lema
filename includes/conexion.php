<?php
class Conexion {
    private $host = "localhost";
    private $db_name = "lema";
    private $username = "root"; // Cambia según tu configuración
    private $password = ""; // Cambia según tu configuración
    public $conn;

    public function obtenerConexion() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>