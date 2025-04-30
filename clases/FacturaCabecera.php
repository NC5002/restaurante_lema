<?php
class FacturaCabecera {
    private $conn;
    private $table_name = "factura_cabecera";

    public $ID_FACTURA_CABECERA;
    public $NUMERO_FACTURA;
    public $ID_CLIENTE;
    public $FECHA_EMISION;
    public $SUBTOTAL;
    public $IVA;
    public $TOTAL;
    public $ESTADO;
    public $METODO_PAGO;
    public $ID_USUARIO;

    public function __construct($db) {
        $this->conn = $db;
    }

    function crear() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET NUMERO_FACTURA=:NUMERO_FACTURA, 
                      ID_CLIENTE=:ID_CLIENTE, 
                      SUBTOTAL=:SUBTOTAL, 
                      IVA=:IVA, 
                      TOTAL=:TOTAL, 
                      METODO_PAGO=:METODO_PAGO, 
                      ID_USUARIO=:ID_USUARIO, 
                      FECHA_EMISION=CURRENT_TIMESTAMP()";
        
        $stmt = $this->conn->prepare($query);
        
        $this->NUMERO_FACTURA = htmlspecialchars(strip_tags($this->NUMERO_FACTURA));
        $this->ID_CLIENTE = htmlspecialchars(strip_tags($this->ID_CLIENTE));
        $this->SUBTOTAL = htmlspecialchars(strip_tags($this->SUBTOTAL));
        $this->IVA = htmlspecialchars(strip_tags($this->IVA));
        $this->TOTAL = htmlspecialchars(strip_tags($this->TOTAL));
        $this->METODO_PAGO = htmlspecialchars(strip_tags($this->METODO_PAGO));
        $this->ID_USUARIO = htmlspecialchars(strip_tags($this->ID_USUARIO));
        
        $stmt->bindParam(":NUMERO_FACTURA", $this->NUMERO_FACTURA);
        $stmt->bindParam(":ID_CLIENTE", $this->ID_CLIENTE);
        $stmt->bindParam(":SUBTOTAL", $this->SUBTOTAL);
        $stmt->bindParam(":IVA", $this->IVA);
        $stmt->bindParam(":TOTAL", $this->TOTAL);
        $stmt->bindParam(":METODO_PAGO", $this->METODO_PAGO);
        $stmt->bindParam(":ID_USUARIO", $this->ID_USUARIO);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function leer() {
        $query = "SELECT f.*, c.NOMBRE as NOMBRE_CLIENTE, c.APELLIDO as APELLIDO_CLIENTE 
                  FROM " . $this->table_name . " f
                  LEFT JOIN clientes c ON f.ID_CLIENTE = c.ID_CLIENTE
                  ORDER BY f.FECHA_EMISION DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function leerUno() {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE ID_FACTURA_CABECERA = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->ID_FACTURA_CABECERA);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->NUMERO_FACTURA = $row['NUMERO_FACTURA'];
        $this->ID_CLIENTE = $row['ID_CLIENTE'];
        $this->FECHA_EMISION = $row['FECHA_EMISION'];
        $this->SUBTOTAL = $row['SUBTOTAL'];
        $this->IVA = $row['IVA'];
        $this->TOTAL = $row['TOTAL'];
        $this->ESTADO = $row['ESTADO'];
        $this->METODO_PAGO = $row['METODO_PAGO'];
        $this->ID_USUARIO = $row['ID_USUARIO'];
    }

    function actualizar() {
        $query = "UPDATE " . $this->table_name . " 
                  SET NUMERO_FACTURA=:NUMERO_FACTURA, 
                      ID_CLIENTE=:ID_CLIENTE, 
                      SUBTOTAL=:SUBTOTAL, 
                      IVA=:IVA, 
                      TOTAL=:TOTAL, 
                      METODO_PAGO=:METODO_PAGO, 
                      ID_USUARIO=:ID_USUARIO
                  WHERE ID_FACTURA_CABECERA=:ID_FACTURA_CABECERA";
        
        $stmt = $this->conn->prepare($query);
        
        $this->NUMERO_FACTURA = htmlspecialchars(strip_tags($this->NUMERO_FACTURA));
        $this->ID_CLIENTE = htmlspecialchars(strip_tags($this->ID_CLIENTE));
        $this->SUBTOTAL = htmlspecialchars(strip_tags($this->SUBTOTAL));
        $this->IVA = htmlspecialchars(strip_tags($this->IVA));
        $this->TOTAL = htmlspecialchars(strip_tags($this->TOTAL));
        $this->METODO_PAGO = htmlspecialchars(strip_tags($this->METODO_PAGO));
        $this->ID_USUARIO = htmlspecialchars(strip_tags($this->ID_USUARIO));
        $this->ID_FACTURA_CABECERA = htmlspecialchars(strip_tags($this->ID_FACTURA_CABECERA));
        
        $stmt->bindParam(":NUMERO_FACTURA", $this->NUMERO_FACTURA);
        $stmt->bindParam(":ID_CLIENTE", $this->ID_CLIENTE);
        $stmt->bindParam(":SUBTOTAL", $this->SUBTOTAL);
        $stmt->bindParam(":IVA", $this->IVA);
        $stmt->bindParam(":TOTAL", $this->TOTAL);
        $stmt->bindParam(":METODO_PAGO", $this->METODO_PAGO);
        $stmt->bindParam(":ID_USUARIO", $this->ID_USUARIO);
        $stmt->bindParam(":ID_FACTURA_CABECERA", $this->ID_FACTURA_CABECERA);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function eliminar() {
        $query = "DELETE FROM " . $this->table_name . " WHERE ID_FACTURA_CABECERA = ?";
        $stmt = $this->conn->prepare($query);
        $this->ID_FACTURA_CABECERA = htmlspecialchars(strip_tags($this->ID_FACTURA_CABECERA));
        $stmt->bindParam(1, $this->ID_FACTURA_CABECERA);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>