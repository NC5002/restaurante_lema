<?php
class Menu {
    private $conn;
    private $table_name = "menu";

    public $CODIGO_MENU;
    public $NOMBRE;
    public $DESCRIPCION;
    public $MEDIDA;
    public $PRECIO;
    public $NUMERO_CATEGORIA;
    public $ESTADO;
    public $IMAGEN;
    public $FECHA_REGISTRO;

    public function __construct($db) {
        $this->conn = $db;
    }

    function crear() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET NOMBRE=:NOMBRE, DESCRIPCION=:DESCRIPCION, MEDIDA=:MEDIDA ,PRECIO=:PRECIO, 
                      NUMERO_CATEGORIA=:NUMERO_CATEGORIA, ESTADO='ACTIVO', IMAGEN=:IMAGEN, FECHA_REGISTRO=CURDATE()";
        
        $stmt = $this->conn->prepare($query);
        
        $this->NOMBRE = $this->NOMBRE;
        $this->DESCRIPCION = $this->DESCRIPCION;
        $this->MEDIDA = $this->MEDIDA;
        $this->PRECIO = $this->PRECIO;
        $this->NUMERO_CATEGORIA = $this->NUMERO_CATEGORIA;
        $this->IMAGEN = $this->IMAGEN;
        
        $stmt->bindParam(":NOMBRE", $this->NOMBRE);
        $stmt->bindParam(":DESCRIPCION", $this->DESCRIPCION);
        $stmt->bindParam(":MEDIDA", $this->MEDIDA);
        $stmt->bindParam(":PRECIO", $this->PRECIO);
        $stmt->bindParam(":NUMERO_CATEGORIA", $this->NUMERO_CATEGORIA);
        $stmt->bindParam(":IMAGEN", $this->IMAGEN);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    function leer() {
        // Consulta modificada para mostrar solo los datos del menú
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY NOMBRE";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function leerUno() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE CODIGO_MENU = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->CODIGO_MENU);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->NOMBRE = $row['NOMBRE'];
        $this->DESCRIPCION = $row['DESCRIPCION'];
        $this->MEDIDA = $row['MEDIDA'];
        $this->PRECIO = $row['PRECIO'];
        $this->NUMERO_CATEGORIA = $row['NUMERO_CATEGORIA'];
        $this->ESTADO = $row['ESTADO'];
        $this->IMAGEN = $row['IMAGEN'];
        $this->FECHA_REGISTRO = $row['FECHA_REGISTRO'];
    }

    function actualizar() {
        $query = "UPDATE " . $this->table_name . " 
                  SET NOMBRE=:NOMBRE, DESCRIPCION=:DESCRIPCION, MEDIDA=:MEDIDA, PRECIO=:PRECIO, 
                      NUMERO_CATEGORIA=:NUMERO_CATEGORIA, ESTADO=:ESTADO, IMAGEN=:IMAGEN
                  WHERE CODIGO_MENU=:CODIGO_MENU";
        
        $stmt = $this->conn->prepare($query);
        
        $this->NOMBRE = $this->NOMBRE;
        $this->DESCRIPCION = $this->DESCRIPCION;
        $this->MEDIDA = $this->MEDIDA;
        $this->PRECIO = $this->PRECIO;
        $this->NUMERO_CATEGORIA = $this->NUMERO_CATEGORIA;
        $this->ESTADO = $this->ESTADO;
        $this->IMAGEN = $this->IMAGEN;
        $this->CODIGO_MENU = $this->CODIGO_MENU;
        
        $stmt->bindParam(":NOMBRE", $this->NOMBRE);
        $stmt->bindParam(":DESCRIPCION", $this->DESCRIPCION);
        $stmt->bindParam(":MEDIDA", $this->MEDIDA);
        $stmt->bindParam(":PRECIO", $this->PRECIO);
        $stmt->bindParam(":NUMERO_CATEGORIA", $this->NUMERO_CATEGORIA);
        $stmt->bindParam(":ESTADO", $this->ESTADO);
        $stmt->bindParam(":IMAGEN", $this->IMAGEN);
        $stmt->bindParam(":CODIGO_MENU", $this->CODIGO_MENU);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    function eliminar() {
        $query = "UPDATE " . $this->table_name . " SET ESTADO='0' WHERE CODIGO_MENU = ?";
        $stmt = $this->conn->prepare($query);
        $this->CODIGO_MENU = $this->CODIGO_MENU;
        $stmt->bindParam(1, $this->CODIGO_MENU);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    function activar() {
        $query = "UPDATE " . $this->table_name . " SET ESTADO='1' WHERE CODIGO_MENU = ?";
        $stmt = $this->conn->prepare($query);
        $this->CODIGO_MENU = $this->CODIGO_MENU;
        $stmt->bindParam(1, $this->CODIGO_MENU);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    function leerCategorias() {
        $query = "SELECT ID_CATEGORIA, NOMBRE FROM categoria WHERE ESTADO='ACTIVO' ORDER BY NOMBRE";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    // Nueva función para obtener el nombre de la categoría por su ID
    function obtenerNombreCategoria($id_categoria) {
        $query = "SELECT NOMBRE FROM categoria WHERE ID_CATEGORIA = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id_categoria);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['NOMBRE'] : 'Sin categoría';
    }
}
?>