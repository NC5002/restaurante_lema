<?php
class Usuario {
    private $conn;
    private $table_name = "usuario";

    public $ID_USUARIO;
    public $USUARIO;
    public $CORREO;
    public $CONTRASENA;
    public $TIPO_USUARIO;
    public $FECHA_REGISTRO;
    public $ESTADO;

    public function __construct($db) {
        $this->conn = $db;
    }

    function crear() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET USUARIO=:USUARIO, CORREO=:CORREO, CONTRASENA=:CONTRASENA, 
                      TIPO_USUARIO=:TIPO_USUARIO, FECHA_REGISTRO=CURDATE(), ESTADO=:ESTADO";
        
        $stmt = $this->conn->prepare($query);
        
        $this->USUARIO = htmlspecialchars(strip_tags($this->USUARIO));
        $this->CORREO = htmlspecialchars(strip_tags($this->CORREO));
        $this->CONTRASENA = password_hash($this->CONTRASENA, PASSWORD_BCRYPT);
        $this->TIPO_USUARIO = htmlspecialchars(strip_tags($this->TIPO_USUARIO));
        $this->ESTADO = htmlspecialchars(strip_tags($this->ESTADO));
        
        $stmt->bindParam(":USUARIO", $this->USUARIO);
        $stmt->bindParam(":CORREO", $this->CORREO);
        $stmt->bindParam(":CONTRASENA", $this->CONTRASENA);
        $stmt->bindParam(":TIPO_USUARIO", $this->TIPO_USUARIO);
        $stmt->bindParam(":ESTADO", $this->ESTADO);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function leer() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY FECHA_REGISTRO DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function leerUno() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE ID_USUARIO = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->ID_USUARIO);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->USUARIO = $row['USUARIO'];
        $this->CORREO = $row['CORREO'];
        $this->TIPO_USUARIO = $row['TIPO_USUARIO'];
        $this->FECHA_REGISTRO = $row['FECHA_REGISTRO'];
        $this->ESTADO = $row['ESTADO'];
    }

    function actualizar() {
        $query = "UPDATE " . $this->table_name . " 
                  SET USUARIO=:USUARIO, CORREO=:CORREO, TIPO_USUARIO=:TIPO_USUARIO, 
                      ESTADO=:ESTADO 
                  WHERE ID_USUARIO=:ID_USUARIO";
        
        $stmt = $this->conn->prepare($query);
        
        $this->USUARIO = htmlspecialchars(strip_tags($this->USUARIO));
        $this->CORREO = htmlspecialchars(strip_tags($this->CORREO));
        $this->TIPO_USUARIO = htmlspecialchars(strip_tags($this->TIPO_USUARIO));
        $this->ESTADO = htmlspecialchars(strip_tags($this->ESTADO));
        $this->ID_USUARIO = htmlspecialchars(strip_tags($this->ID_USUARIO));
        
        $stmt->bindParam(":USUARIO", $this->USUARIO);
        $stmt->bindParam(":CORREO", $this->CORREO);
        $stmt->bindParam(":TIPO_USUARIO", $this->TIPO_USUARIO);
        $stmt->bindParam(":ESTADO", $this->ESTADO);
        $stmt->bindParam(":ID_USUARIO", $this->ID_USUARIO);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function eliminar() {
        $query = "DELETE FROM " . $this->table_name . " WHERE ID_USUARIO = ?";
        $stmt = $this->conn->prepare($query);
        $this->ID_USUARIO = htmlspecialchars(strip_tags($this->ID_USUARIO));
        $stmt->bindParam(1, $this->ID_USUARIO);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>