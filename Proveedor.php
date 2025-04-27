<?php
class Proveedor {
    private $conn;
    private $table_name = "proveedor";

    public $ID_PROVEEDOR;
    public $RUC_CEDULA;
    public $NOMBRE;
    public $DIRECCION;
    public $TELEFONO;
    public $CORREO;
    public $ESTADO;
    public $FECHA_REGISTRO;
    public $OBSERVACIONES;

    public function __construct($db) {
        $this->conn = $db;
    }

    function crear() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET RUC_CEDULA=:RUC_CEDULA, NOMBRE=:NOMBRE, DIRECCION=:DIRECCION, 
                      TELEFONO=:TELEFONO, CORREO=:CORREO, ESTADO='1', 
                      FECHA_REGISTRO=CURDATE(), OBSERVACIONES=:OBSERVACIONES";
        
        $stmt = $this->conn->prepare($query);
        
        $this->RUC_CEDULA = htmlspecialchars(strip_tags($this->RUC_CEDULA));
        $this->NOMBRE = htmlspecialchars(strip_tags($this->NOMBRE));
        $this->DIRECCION = htmlspecialchars(strip_tags($this->DIRECCION));
        $this->TELEFONO = htmlspecialchars(strip_tags($this->TELEFONO));
        $this->CORREO = htmlspecialchars(strip_tags($this->CORREO));
        $this->OBSERVACIONES = htmlspecialchars(strip_tags($this->OBSERVACIONES));
        
        $stmt->bindParam(":RUC_CEDULA", $this->RUC_CEDULA);
        $stmt->bindParam(":NOMBRE", $this->NOMBRE);
        $stmt->bindParam(":DIRECCION", $this->DIRECCION);
        $stmt->bindParam(":TELEFONO", $this->TELEFONO);
        $stmt->bindParam(":CORREO", $this->CORREO);
        $stmt->bindParam(":OBSERVACIONES", $this->OBSERVACIONES);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function leer() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY NOMBRE";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function leerUno() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE ID_PROVEEDOR = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->ID_PROVEEDOR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->RUC_CEDULA = $row['RUC_CEDULA'];
        $this->NOMBRE = $row['NOMBRE'];
        $this->DIRECCION = $row['DIRECCION'];
        $this->TELEFONO = $row['TELEFONO'];
        $this->CORREO = $row['CORREO'];
        $this->ESTADO = $row['ESTADO'];
        $this->FECHA_REGISTRO = $row['FECHA_REGISTRO'];
        $this->OBSERVACIONES = $row['OBSERVACIONES'];
    }

    function actualizar() {
        $query = "UPDATE " . $this->table_name . " 
                  SET RUC_CEDULA=:RUC_CEDULA, NOMBRE=:NOMBRE, DIRECCION=:DIRECCION, 
                      TELEFONO=:TELEFONO, CORREO=:CORREO, OBSERVACIONES=:OBSERVACIONES 
                  WHERE ID_PROVEEDOR=:ID_PROVEEDOR";
        
        $stmt = $this->conn->prepare($query);
        
        $this->RUC_CEDULA = htmlspecialchars(strip_tags($this->RUC_CEDULA));
        $this->NOMBRE = htmlspecialchars(strip_tags($this->NOMBRE));
        $this->DIRECCION = htmlspecialchars(strip_tags($this->DIRECCION));
        $this->TELEFONO = htmlspecialchars(strip_tags($this->TELEFONO));
        $this->CORREO = htmlspecialchars(strip_tags($this->CORREO));
        $this->OBSERVACIONES = htmlspecialchars(strip_tags($this->OBSERVACIONES));
        $this->ID_PROVEEDOR = htmlspecialchars(strip_tags($this->ID_PROVEEDOR));
        
        $stmt->bindParam(":RUC_CEDULA", $this->RUC_CEDULA);
        $stmt->bindParam(":NOMBRE", $this->NOMBRE);
        $stmt->bindParam(":DIRECCION", $this->DIRECCION);
        $stmt->bindParam(":TELEFONO", $this->TELEFONO);
        $stmt->bindParam(":CORREO", $this->CORREO);
        $stmt->bindParam(":OBSERVACIONES", $this->OBSERVACIONES);
        $stmt->bindParam(":ID_PROVEEDOR", $this->ID_PROVEEDOR);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function eliminar() {
        $query = "DELETE FROM " . $this->table_name . " WHERE ID_PROVEEDOR = ?";
        $stmt = $this->conn->prepare($query);
        $this->ID_PROVEEDOR = htmlspecialchars(strip_tags($this->ID_PROVEEDOR));
        $stmt->bindParam(1, $this->ID_PROVEEDOR);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>