<?php
class Compras {
    private $conn;
    private $table_name = "compras";

    public $ID_COMPRA;
    public $NUMERO_FACTURA_COMPRA;
    public $NUMERO_PROVEEDOR;
    public $FECHA_REGISTRO;
    public $IVA;
    public $TOTAL_VALOR;
    public $ESTADO;
    public $METODO_PAGO;
    public $ID_USUARIO;

    public function __construct($db) {
        $this->conn = $db;
    }

    function crear() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET NUMERO_FACTURA_COMPRA=:NUMERO_FACTURA_COMPRA, 
                      NUMERO_PROVEEDOR=:NUMERO_PROVEEDOR, 
                      IVA=:IVA, 
                      TOTAL_VALOR=:TOTAL_VALOR, 
                      METODO_PAGO=:METODO_PAGO, 
                      ID_USUARIO=:ID_USUARIO, 
                      FECHA_REGISTRO=CURRENT_TIMESTAMP()";
        
        $stmt = $this->conn->prepare($query);
        
        $this->NUMERO_FACTURA_COMPRA = htmlspecialchars(strip_tags($this->NUMERO_FACTURA_COMPRA));
        $this->NUMERO_PROVEEDOR = htmlspecialchars(strip_tags($this->NUMERO_PROVEEDOR));
        $this->IVA = htmlspecialchars(strip_tags($this->IVA));
        $this->TOTAL_VALOR = htmlspecialchars(strip_tags($this->TOTAL_VALOR));
        $this->METODO_PAGO = htmlspecialchars(strip_tags($this->METODO_PAGO));
        $this->ID_USUARIO = htmlspecialchars(strip_tags($this->ID_USUARIO));
        
        $stmt->bindParam(":NUMERO_FACTURA_COMPRA", $this->NUMERO_FACTURA_COMPRA);
        $stmt->bindParam(":NUMERO_PROVEEDOR", $this->NUMERO_PROVEEDOR);
        $stmt->bindParam(":IVA", $this->IVA);
        $stmt->bindParam(":TOTAL_VALOR", $this->TOTAL_VALOR);
        $stmt->bindParam(":METODO_PAGO", $this->METODO_PAGO);
        $stmt->bindParam(":ID_USUARIO", $this->ID_USUARIO);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function leer() {
        $query = "SELECT c.*, p.NOMBRE as NOMBRE_PROVEEDOR 
                  FROM " . $this->table_name . " c
                  LEFT JOIN proveedor p ON c.NUMERO_PROVEEDOR = p.ID_PROVEEDOR
                  ORDER BY c.FECHA_REGISTRO DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function leerUno() {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE ID_COMPRA = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->ID_COMPRA);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->NUMERO_FACTURA_COMPRA = $row['NUMERO_FACTURA_COMPRA'];
        $this->NUMERO_PROVEEDOR = $row['NUMERO_PROVEEDOR'];
        $this->FECHA_REGISTRO = $row['FECHA_REGISTRO'];
        $this->IVA = $row['IVA'];
        $this->TOTAL_VALOR = $row['TOTAL_VALOR'];
        $this->ESTADO = $row['ESTADO'];
        $this->METODO_PAGO = $row['METODO_PAGO'];
        $this->ID_USUARIO = $row['ID_USUARIO'];
    }

    function actualizar() {
        $query = "UPDATE " . $this->table_name . " 
                  SET NUMERO_FACTURA_COMPRA=:NUMERO_FACTURA_COMPRA, 
                      NUMERO_PROVEEDOR=:NUMERO_PROVEEDOR, 
                      IVA=:IVA, 
                      TOTAL_VALOR=:TOTAL_VALOR, 
                      METODO_PAGO=:METODO_PAGO, 
                      ID_USUARIO=:ID_USUARIO
                  WHERE ID_COMPRA=:ID_COMPRA";
        
        $stmt = $this->conn->prepare($query);
        
        $this->NUMERO_FACTURA_COMPRA = htmlspecialchars(strip_tags($this->NUMERO_FACTURA_COMPRA));
        $this->NUMERO_PROVEEDOR = htmlspecialchars(strip_tags($this->NUMERO_PROVEEDOR));
        $this->IVA = htmlspecialchars(strip_tags($this->IVA));
        $this->TOTAL_VALOR = htmlspecialchars(strip_tags($this->TOTAL_VALOR));
        $this->METODO_PAGO = htmlspecialchars(strip_tags($this->METODO_PAGO));
        $this->ID_USUARIO = htmlspecialchars(strip_tags($this->ID_USUARIO));
        $this->ID_COMPRA = htmlspecialchars(strip_tags($this->ID_COMPRA));
        
        $stmt->bindParam(":NUMERO_FACTURA_COMPRA", $this->NUMERO_FACTURA_COMPRA);
        $stmt->bindParam(":NUMERO_PROVEEDOR", $this->NUMERO_PROVEEDOR);
        $stmt->bindParam(":IVA", $this->IVA);
        $stmt->bindParam(":TOTAL_VALOR", $this->TOTAL_VALOR);
        $stmt->bindParam(":METODO_PAGO", $this->METODO_PAGO);
        $stmt->bindParam(":ID_USUARIO", $this->ID_USUARIO);
        $stmt->bindParam(":ID_COMPRA", $this->ID_COMPRA);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function eliminar() {
        $query = "DELETE FROM " . $this->table_name . " WHERE ID_COMPRA = ?";
        $stmt = $this->conn->prepare($query);
        $this->ID_COMPRA = htmlspecialchars(strip_tags($this->ID_COMPRA));
        $stmt->bindParam(1, $this->ID_COMPRA);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>