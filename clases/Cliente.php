<?php
class Cliente {
    private $conn;
    private $table_name = "clientes";

    public $ID_CLIENTE;
    public $NUMERO_CEDULA;
    public $NOMBRE;
    public $APELLIDO;
    public $TELEFONO;
    public $CORREO;
    public $DIRECCION;
    public $FECHA_REGISTRO;

    public function __construct($db) {
        $this->conn = $db;
    }

    function crear() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET NUMERO_CEDULA=:NUMERO_CEDULA, NOMBRE=:NOMBRE, APELLIDO=:APELLIDO, 
                      TELEFONO=:TELEFONO, CORREO=:CORREO, DIRECCION=:DIRECCION, FECHA_REGISTRO=CURDATE()";
        
        $stmt = $this->conn->prepare($query);
        
        $this->NUMERO_CEDULA = htmlspecialchars(strip_tags($this->NUMERO_CEDULA));
        $this->NOMBRE = htmlspecialchars(strip_tags($this->NOMBRE));
        $this->APELLIDO = htmlspecialchars(strip_tags($this->APELLIDO));
        $this->TELEFONO = htmlspecialchars(strip_tags($this->TELEFONO));
        $this->CORREO = htmlspecialchars(strip_tags($this->CORREO));
        $this->DIRECCION = htmlspecialchars(strip_tags($this->DIRECCION));
        
        $stmt->bindParam(":NUMERO_CEDULA", $this->NUMERO_CEDULA);
        $stmt->bindParam(":NOMBRE", $this->NOMBRE);
        $stmt->bindParam(":APELLIDO", $this->APELLIDO);
        $stmt->bindParam(":TELEFONO", $this->TELEFONO);
        $stmt->bindParam(":CORREO", $this->CORREO);
        $stmt->bindParam(":DIRECCION", $this->DIRECCION);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    function leer() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY APELLIDO, NOMBRE";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function leerUno() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE ID_CLIENTE = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->ID_CLIENTE);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->NUMERO_CEDULA = $row['NUMERO_CEDULA'];
        $this->NOMBRE = $row['NOMBRE'];
        $this->APELLIDO = $row['APELLIDO'];
        $this->TELEFONO = $row['TELEFONO'];
        $this->CORREO = $row['CORREO'];
        $this->DIRECCION = $row['DIRECCION'];
        $this->FECHA_REGISTRO = $row['FECHA_REGISTRO'];
    }

    function actualizar() {
        $query = "UPDATE " . $this->table_name . " 
                  SET NUMERO_CEDULA=:NUMERO_CEDULA, NOMBRE=:NOMBRE, APELLIDO=:APELLIDO, 
                      TELEFONO=:TELEFONO, CORREO=:CORREO, DIRECCION=:DIRECCION
                  WHERE ID_CLIENTE=:ID_CLIENTE";
        
        $stmt = $this->conn->prepare($query);
        
        $this->NUMERO_CEDULA = htmlspecialchars(strip_tags($this->NUMERO_CEDULA));
        $this->NOMBRE = htmlspecialchars(strip_tags($this->NOMBRE));
        $this->APELLIDO = htmlspecialchars(strip_tags($this->APELLIDO));
        $this->TELEFONO = htmlspecialchars(strip_tags($this->TELEFONO));
        $this->CORREO = htmlspecialchars(strip_tags($this->CORREO));
        $this->DIRECCION = htmlspecialchars(strip_tags($this->DIRECCION));
        $this->ID_CLIENTE = htmlspecialchars(strip_tags($this->ID_CLIENTE));
        
        $stmt->bindParam(":NUMERO_CEDULA", $this->NUMERO_CEDULA);
        $stmt->bindParam(":NOMBRE", $this->NOMBRE);
        $stmt->bindParam(":APELLIDO", $this->APELLIDO);
        $stmt->bindParam(":TELEFONO", $this->TELEFONO);
        $stmt->bindParam(":CORREO", $this->CORREO);
        $stmt->bindParam(":DIRECCION", $this->DIRECCION);
        $stmt->bindParam(":ID_CLIENTE", $this->ID_CLIENTE);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    function eliminar() {
        $query = "DELETE FROM " . $this->table_name . " WHERE ID_CLIENTE = ?";
        $stmt = $this->conn->prepare($query);
        $this->ID_CLIENTE = htmlspecialchars(strip_tags($this->ID_CLIENTE));
        $stmt->bindParam(1, $this->ID_CLIENTE);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // --- INICIO NUEVO MÉTODO DE BÚSQUEDA ---
    /**
     * Busca clientes por número de cédula (coincidencia parcial al inicio).
     * @param string $cedula El número de cédula (o parte inicial) a buscar.
     * @return PDOStatement El objeto PDOStatement con los resultados.
     */
    function buscarPorCedula($cedula) {
        // Consulta para buscar cédulas que comiencen con el término proporcionado
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE NUMERO_CEDULA LIKE ? 
                  ORDER BY APELLIDO, NOMBRE";
        
        $stmt = $this->conn->prepare($query);
        
        // Limpiar el término de búsqueda
        $cedula_limpia = htmlspecialchars(strip_tags($cedula));
        
        // Añadir el comodín '%' para buscar coincidencias que *empiecen* con la cédula
        $searchTerm = $cedula_limpia . "%"; 
        
        // Vincular el parámetro de búsqueda
        $stmt->bindParam(1, $searchTerm);
        
        // Ejecutar la consulta
        $stmt->execute();
        
        // Devolver el resultado (PDOStatement)
        return $stmt;
    }
    // --- FIN NUEVO MÉTODO DE BÚSQUEDA ---
}
?>