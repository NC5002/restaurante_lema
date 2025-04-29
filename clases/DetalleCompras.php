<?php
class DetalleCompras {
    private $conn;
    private $table_name = "detalle_compras";

    public $ID_DETALLE_COMPRA;
    public $NUMERO_FACTURA_COMPRA;
    public $DESCRIPCION;
    public $CANTIDAD;
    public $PRECIO_UNITARIO;

    public function __construct($db) {
        $this->conn = $db;
    }

    function crear() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET NUMERO_FACTURA_COMPRA=:NUMERO_FACTURA_COMPRA, 
                      DESCRIPCION=:DESCRIPCION, 
                      CANTIDAD=:CANTIDAD, 
                      PRECIO_UNITARIO=:PRECIO_UNITARIO";
        
        $stmt = $this->conn->prepare($query);
        
        $this->NUMERO_FACTURA_COMPRA = htmlspecialchars(strip_tags($this->NUMERO_FACTURA_COMPRA));
        $this->DESCRIPCION = htmlspecialchars(strip_tags($this->DESCRIPCION));
        $this->CANTIDAD = htmlspecialchars(strip_tags($this->CANTIDAD));
        $this->PRECIO_UNITARIO = htmlspecialchars(strip_tags($this->PRECIO_UNITARIO));
        
        $stmt->bindParam(":NUMERO_FACTURA_COMPRA", $this->NUMERO_FACTURA_COMPRA);
        $stmt->bindParam(":DESCRIPCION", $this->DESCRIPCION);
        $stmt->bindParam(":CANTIDAD", $this->CANTIDAD);
        $stmt->bindParam(":PRECIO_UNITARIO", $this->PRECIO_UNITARIO);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function leerPorFactura($numero_factura) {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE NUMERO_FACTURA_COMPRA = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $numero_factura);
        $stmt->execute();
        return $stmt;
    }

    function eliminar($id_detalle) {
        $query = "DELETE FROM " . $this->table_name . " WHERE ID_DETALLE_COMPRA = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id_detalle);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>