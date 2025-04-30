<?php
class FacturaDetalle {
    private $conn;
    private $table_name = "factura_detalle";

    public $ID_FACTURA_DETALLE;
    public $NUMERO_FACTURA;
    public $CODIGO_MENU;  // <-- Añadir esta propiedad
    public $CANTIDAD;
    public $PRECIO;

    public function __construct($db) {
        $this->conn = $db;
    }

    function crear() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET NUMERO_FACTURA=:NUMERO_FACTURA, 
                      CODIGO_MENU=:CODIGO_MENU,  // <-- Añadir esta línea
                      CANTIDAD=:CANTIDAD, 
                      PRECIO=:PRECIO";
        
        $stmt = $this->conn->prepare($query);
        
        $this->NUMERO_FACTURA = htmlspecialchars(strip_tags($this->NUMERO_FACTURA));
        $this->CODIGO_MENU = htmlspecialchars(strip_tags($this->CODIGO_MENU));  // <-- Añadir esta línea
        $this->CANTIDAD = htmlspecialchars(strip_tags($this->CANTIDAD));
        $this->PRECIO = htmlspecialchars(strip_tags($this->PRECIO));
        
        $stmt->bindParam(":NUMERO_FACTURA", $this->NUMERO_FACTURA);
        $stmt->bindParam(":CODIGO_MENU", $this->CODIGO_MENU);  // <-- Añadir esta línea
        $stmt->bindParam(":CANTIDAD", $this->CANTIDAD);
        $stmt->bindParam(":PRECIO", $this->PRECIO);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function leerPorFactura($numero_factura) {
        $query = "SELECT fd.*, m.NOMBRE as NOMBRE_PRODUCTO 
                  FROM " . $this->table_name . " fd
                  LEFT JOIN menu m ON fd.CODIGO_MENU = m.CODIGO_MENU
                  WHERE NUMERO_FACTURA = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $numero_factura);
        $stmt->execute();
        return $stmt;
    }

    function eliminar($id_detalle) {
        $query = "DELETE FROM " . $this->table_name . " WHERE ID_FACTURA_DETALLE = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id_detalle);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>