<?php
class Empresa {
    private $conn;
    private $table_name = "empresa";

    public $id;
    public $nombre;
    public $ruc;
    public $direccion;
    public $telefono;
    public $correo;
    public $sitio_web;
    public $logo;
    public $ciudad;
    public $provincia;
    public $pais;
    public $mensaje_factura;

    public function __construct($db) {
        $this->conn = $db;
    }

    function crear() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET nombre=:nombre, ruc=:ruc, direccion=:direccion, telefono=:telefono, correo=:correo,
                      sitio_web=:sitio_web, logo=:logo, ciudad=:ciudad, provincia=:provincia, pais=:pais, mensaje_factura=:mensaje_factura";
        
        $stmt = $this->conn->prepare($query);

        foreach (get_object_vars($this) as $key => $value) {
            if ($key != 'conn' && $key != 'table_name') {
                $this->$key = htmlspecialchars(strip_tags($this->$key));
                $stmt->bindParam(":$key", $this->$key);
            }
        }

        return $stmt->execute();
    }

    function leer() {
        $query = "SELECT * FROM " . $this->table_name . " LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function actualizar() {
        $query = "UPDATE " . $this->table_name . " 
                  SET nombre=:nombre, ruc=:ruc, direccion=:direccion, telefono=:telefono, correo=:correo,
                      sitio_web=:sitio_web, logo=:logo, ciudad=:ciudad, provincia=:provincia, pais=:pais, mensaje_factura=:mensaje_factura
                  WHERE id=:id";
        
        $stmt = $this->conn->prepare($query);

        foreach (get_object_vars($this) as $key => $value) {
            if ($key != 'conn' && $key != 'table_name') {
                $this->$key = htmlspecialchars(strip_tags($this->$key));
                $stmt->bindParam(":$key", $this->$key);
            }
        }

        return $stmt->execute();
    }

    function leerUno() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            foreach ($row as $key => $value) {
                $this->$key = $value;
            }
        }
    }
}
?>
