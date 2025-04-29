<?php
class Categoria {
    private $conn;
    private $table_name = "categoria";

    public $ID_CATEGORIA;
    public $NOMBRE;
    public $ESTADO;

    public function __construct($db) {
        $this->conn = $db;
    }

    function crear() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET NOMBRE=:NOMBRE, ESTADO='1'";
        
        $stmt = $this->conn->prepare($query);
        
        $this->NOMBRE = htmlspecialchars(strip_tags($this->NOMBRE));
        
        $stmt->bindParam(":NOMBRE", $this->NOMBRE);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    function leer() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY ID_CATEGORIA";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function leerUno() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE ID_CATEGORIA = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->ID_CATEGORIA);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->NOMBRE = $row['NOMBRE'];
        $this->ESTADO = $row['ESTADO'];
    }

    function actualizar() {
        $query = "UPDATE " . $this->table_name . " 
                  SET NOMBRE=:NOMBRE 
                  WHERE ID_CATEGORIA=:ID_CATEGORIA";
        
        $stmt = $this->conn->prepare($query);
        
        $this->NOMBRE = htmlspecialchars(strip_tags($this->NOMBRE));
        $this->ID_CATEGORIA = htmlspecialchars(strip_tags($this->ID_CATEGORIA));
        
        $stmt->bindParam(":NOMBRE", $this->NOMBRE);
        $stmt->bindParam(":ID_CATEGORIA", $this->ID_CATEGORIA);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    function eliminar() {
        $query = "UPDATE " . $this->table_name . " SET ESTADO='0' WHERE ID_CATEGORIA=:ID_CATEGORIA";
        $stmt = $this->conn->prepare($query);
        $this->ID_CATEGORIA = htmlspecialchars(strip_tags($this->ID_CATEGORIA));
        $stmt->bindParam(":ID_CATEGORIA", $this->ID_CATEGORIA);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    function activar() {
        $query = "UPDATE " . $this->table_name . " SET ESTADO='1' WHERE ID_CATEGORIA=:ID_CATEGORIA";
        $stmt = $this->conn->prepare($query);
        $this->ID_CATEGORIA = htmlspecialchars(strip_tags($this->ID_CATEGORIA));
        $stmt->bindParam(":ID_CATEGORIA", $this->ID_CATEGORIA);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>