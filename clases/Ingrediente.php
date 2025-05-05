<?php
class Ingrediente {
    private $conn;
    private $table_name = "ingredientes";
    public $ID_INGREDIENTE;
    public $NOMBRE;
    public $DESCRIPCION;
    public $MEDIDA;
    public $ESTADO;
    public $IMAGEN;
    public $FECHA_REGISTRO;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Crear ingrediente
    function crear() {
        $query = "INSERT INTO {$this->table_name}
                  SET NOMBRE=:NOMBRE,
                      DESCRIPCION=:DESCRIPCION,
                      MEDIDA=:MEDIDA,
                      ESTADO='1',
                      IMAGEN=:IMAGEN";
        $stmt = $this->conn->prepare($query);

        // Sanitizar y bindear
        $stmt->bindParam(":NOMBRE",           $this->NOMBRE);
        $stmt->bindParam(":DESCRIPCION",      $this->DESCRIPCION);
        $stmt->bindParam(":MEDIDA",           $this->MEDIDA);
        $stmt->bindParam(":IMAGEN",           $this->IMAGEN);

        return $stmt->execute();
    }

    // Leer todos los ingredientes
    function leer() {
        $query = "SELECT * FROM {$this->table_name} ORDER BY ID_INGREDIENTE";
        $stmt  = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Leer un solo ingrediente
    function leerUno() {
        $query = "SELECT * FROM {$this->table_name} WHERE ID_INGREDIENTE = ? LIMIT 0,1";
        $stmt  = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->ID_INGREDIENTE);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            foreach ($row as $key => $val) {
                $this->$key = $val;
            }
        }
    }

    // Actualizar ingrediente
    function actualizar() {
        $query = "UPDATE {$this->table_name}
                  SET NOMBRE=:NOMBRE,
                      DESCRIPCION=:DESCRIPCION,
                      MEDIDA=:MEDIDA,
                      IMAGEN=:IMAGEN
                  WHERE ID_INGREDIENTE=:ID_INGREDIENTE";
        $stmt = $this->conn->prepare($query);

        // Sanitizar y bindear

        $stmt->bindParam(":CODIGO_MENU",      $this->ID_INGREDIENTE);
        $stmt->bindParam(":NOMBRE",           $this->NOMBRE);
        $stmt->bindParam(":DESCRIPCION",      $this->DESCRIPCION);
        $stmt->bindParam(":MEDIDA",           $this->MEDIDA);
        $stmt->bindParam(":IMAGEN",           $this->IMAGEN);

        return $stmt->execute();
    }

    // Desactivar ingrediente
    function eliminar() {
        $query = "UPDATE {$this->table_name}
                  SET ESTADO='0'
                  WHERE ID_INGREDIENTE=:ID_INGREDIENTE";
        $stmt = $this->conn->prepare($query);
        $this->ID_INGREDIENTE = htmlspecialchars(strip_tags($this->ID_INGREDIENTE));
        $stmt->bindParam(":ID_INGREDIENTE", $this->ID_INGREDIENTE);
        return $stmt->execute();
    }

    // Activar ingrediente
    function activar() {
        $query = "UPDATE {$this->table_name}
                  SET ESTADO='1'
                  WHERE ID_INGREDIENTE=:ID_INGREDIENTE";
        $stmt = $this->conn->prepare($query);
        $this->ID_INGREDIENTE = htmlspecialchars(strip_tags($this->ID_INGREDIENTE));
        $stmt->bindParam(":ID_INGREDIENTE", $this->ID_INGREDIENTE);
        return $stmt->execute();
    }
}
?>
