<?php
class Receta {
    private $conn;
    private $table_name = "receta";

    public $id;
    public $codigo_menu;
    public $id_ingrediente;
    public $cantidad;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Crear receta
    function crear() {
        $query = "INSERT INTO " . $this->table_name . " 
                 SET codigo_menu = :codigo_menu, 
                     id_ingrediente = :id_ingrediente, 
                     cantidad = :cantidad";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitizar datos
        $this->codigo_menu = htmlspecialchars(strip_tags($this->codigo_menu));
        $this->id_ingrediente = htmlspecialchars(strip_tags($this->id_ingrediente));
        $this->cantidad = htmlspecialchars(strip_tags($this->cantidad));
        
        // Bind parameters
        $stmt->bindParam(":codigo_menu", $this->codigo_menu);
        $stmt->bindParam(":id_ingrediente", $this->id_ingrediente);
        $stmt->bindParam(":cantidad", $this->cantidad);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Leer todas las recetas
    function leer() {
        $query = "SELECT r.*, m.NOMBRE as menu_nombre, i.NOMBRE as ingrediente_nombre 
                 FROM " . $this->table_name . " r
                 LEFT JOIN menu m ON r.codigo_menu = m.CODIGO_MENU
                 LEFT JOIN ingredientes i ON r.id_ingrediente = i.ID_INGREDIENTE
                 ORDER BY m.NOMBRE, i.NOMBRE";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Leer recetas por menú
    function leerPorMenu($codigo_menu) {
        $query = "SELECT r.*, i.NOMBRE as ingrediente_nombre, i.MEDIDA
                 FROM " . $this->table_name . " r
                 LEFT JOIN ingredientes i ON r.id_ingrediente = i.ID_INGREDIENTE
                 WHERE r.codigo_menu = ?
                 ORDER BY i.NOMBRE";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $codigo_menu);
        $stmt->execute();
        return $stmt;
    }

    // Leer una receta específica
    function leerUno() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row) {
            $this->codigo_menu = $row['codigo_menu'];
            $this->id_ingrediente = $row['id_ingrediente'];
            $this->cantidad = $row['cantidad'];
            return true;
        }
        return false;
    }

    // Actualizar receta
    function actualizar() {
        $query = "UPDATE " . $this->table_name . " 
                 SET codigo_menu = :codigo_menu, 
                     id_ingrediente = :id_ingrediente, 
                     cantidad = :cantidad
                 WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitizar datos
        $this->codigo_menu = htmlspecialchars(strip_tags($this->codigo_menu));
        $this->id_ingrediente = htmlspecialchars(strip_tags($this->id_ingrediente));
        $this->cantidad = htmlspecialchars(strip_tags($this->cantidad));
        $this->id = htmlspecialchars(strip_tags($this->id));
        
        // Bind parameters
        $stmt->bindParam(":codigo_menu", $this->codigo_menu);
        $stmt->bindParam(":id_ingrediente", $this->id_ingrediente);
        $stmt->bindParam(":cantidad", $this->cantidad);
        $stmt->bindParam(":id", $this->id);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Eliminar receta
    function eliminar() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>