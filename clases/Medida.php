<?php
class Medida {
    private $conn;
    private $table_name = "medidas";

    public $ID_MEDIDA;
    public $DESCRIPCION;
    public $FECHA_REGISTRO;

    public function __construct($db) {
        $this->conn = $db;
    }

    function crear() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET DESCRIPCION=:DESCRIPCION, FECHA_REGISTRO=NOW()";
        
        $stmt = $this->conn->prepare($query);
        
        $this->DESCRIPCION = htmlspecialchars(strip_tags($this->DESCRIPCION));
        
        $stmt->bindParam(":DESCRIPCION", $this->DESCRIPCION);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    function leer() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY ID_MEDIDA";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function leerUno() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE ID_MEDIDA = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->ID_MEDIDA);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->DESCRIPCION = $row['DESCRIPCION'];
        $this->FECHA_REGISTRO = $row['FECHA_REGISTRO'];
    }

    function actualizar() {
        $query = "UPDATE " . $this->table_name . " 
                  SET DESCRIPCION=:DESCRIPCION 
                  WHERE ID_MEDIDA=:ID_MEDIDA";
        
        $stmt = $this->conn->prepare($query);
        
        $this->DESCRIPCION = htmlspecialchars(strip_tags($this->DESCRIPCION));
        $this->ID_MEDIDA = htmlspecialchars(strip_tags($this->ID_MEDIDA));
        
        $stmt->bindParam(":DESCRIPCION", $this->DESCRIPCION);
        $stmt->bindParam(":ID_MEDIDA", $this->ID_MEDIDA);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    function eliminar() {
        $query = "DELETE FROM " . $this->table_name . " WHERE ID_MEDIDA=:ID_MEDIDA";
        $stmt = $this->conn->prepare($query);
        $this->ID_MEDIDA = htmlspecialchars(strip_tags($this->ID_MEDIDA));
        $stmt->bindParam(":ID_MEDIDA", $this->ID_MEDIDA);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>