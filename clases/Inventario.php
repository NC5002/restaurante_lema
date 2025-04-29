<?php
class Inventario {
    private $conn;
    private $table_name = "inventario";

    public $ID_INVENTARIO;
    public $CODIGO_MENU;
    public $NOMBRE_INGREDIENTE;
    public $CANTIDAD;
    public $ID_USUARIO;
    public $FECHA_REGISTRO;

    public function __construct($db) {
        $this->conn = $db;
    }

    function crear() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET CODIGO_MENU=:CODIGO_MENU, NOMBRE_INGREDIENTE=:NOMBRE_INGREDIENTE, 
                      CANTIDAD=:CANTIDAD, ID_USUARIO=:ID_USUARIO, FECHA_REGISTRO=CURDATE()";
        
        $stmt = $this->conn->prepare($query);
        
        $this->CODIGO_MENU = htmlspecialchars(strip_tags($this->CODIGO_MENU));
        $this->NOMBRE_INGREDIENTE = htmlspecialchars(strip_tags($this->NOMBRE_INGREDIENTE));
        $this->CANTIDAD = htmlspecialchars(strip_tags($this->CANTIDAD));
        $this->ID_USUARIO = htmlspecialchars(strip_tags($this->ID_USUARIO));
        
        $stmt->bindParam(":CODIGO_MENU", $this->CODIGO_MENU);
        $stmt->bindParam(":NOMBRE_INGREDIENTE", $this->NOMBRE_INGREDIENTE);
        $stmt->bindParam(":CANTIDAD", $this->CANTIDAD);
        $stmt->bindParam(":ID_USUARIO", $this->ID_USUARIO);
        
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
        $query = "SELECT * FROM " . $this->table_name . " WHERE ID_INVENTARIO = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->ID_INVENTARIO);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->CODIGO_MENU = $row['CODIGO_MENU'];
        $this->NOMBRE_INGREDIENTE = $row['NOMBRE_INGREDIENTE'];
        $this->CANTIDAD = $row['CANTIDAD'];
        $this->ID_USUARIO = $row['ID_USUARIO'];
        $this->FECHA_REGISTRO = $row['FECHA_REGISTRO'];
    }

    function actualizar() {
        $query = "UPDATE " . $this->table_name . " 
                  SET CODIGO_MENU=:CODIGO_MENU, NOMBRE_INGREDIENTE=:NOMBRE_INGREDIENTE, 
                      CANTIDAD=:CANTIDAD, ID_USUARIO=:ID_USUARIO 
                  WHERE ID_INVENTARIO=:ID_INVENTARIO";
        
        $stmt = $this->conn->prepare($query);
        
        $this->CODIGO_MENU = htmlspecialchars(strip_tags($this->CODIGO_MENU));
        $this->NOMBRE_INGREDIENTE = htmlspecialchars(strip_tags($this->NOMBRE_INGREDIENTE));
        $this->CANTIDAD = htmlspecialchars(strip_tags($this->CANTIDAD));
        $this->ID_USUARIO = htmlspecialchars(strip_tags($this->ID_USUARIO));
        $this->ID_INVENTARIO = htmlspecialchars(strip_tags($this->ID_INVENTARIO));
        
        $stmt->bindParam(":CODIGO_MENU", $this->CODIGO_MENU);
        $stmt->bindParam(":NOMBRE_INGREDIENTE", $this->NOMBRE_INGREDIENTE);
        $stmt->bindParam(":CANTIDAD", $this->CANTIDAD);
        $stmt->bindParam(":ID_USUARIO", $this->ID_USUARIO);
        $stmt->bindParam(":ID_INVENTARIO", $this->ID_INVENTARIO);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function eliminar() {
        $query = "DELETE FROM " . $this->table_name . " WHERE ID_INVENTARIO = ?";
        $stmt = $this->conn->prepare($query);
        $this->ID_INVENTARIO = htmlspecialchars(strip_tags($this->ID_INVENTARIO));
        $stmt->bindParam(1, $this->ID_INVENTARIO);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>