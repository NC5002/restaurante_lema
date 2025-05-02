<?php
class Usuario {
    private $conn;
    private $table_name = "usuarios";

    public $id;
    public $nombre;
    public $email;
    public $cedula;
    public $password;
    public $rol_id;
    public $estado;
    public $perfil;
    public $fecha_registro;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Crear usuario
    function crear() {
        $query = "INSERT INTO " . $this->table_name . "
                SET nombre=:nombre, email=:email, cedula=:cedula, 
                password=:password, rol_id=:rol_id, estado=1, perfil=:perfil";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitizar datos
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->cedula = htmlspecialchars(strip_tags($this->cedula));
        $this->rol_id = htmlspecialchars(strip_tags($this->rol_id));
        $this->perfil = htmlspecialchars(strip_tags($this->perfil));
        
        // Hash de la contraseña
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
        
        // Bind parameters
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":cedula", $this->cedula);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":rol_id", $this->rol_id);
        $stmt->bindParam(":perfil", $this->perfil);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Leer todos los usuarios
    function leer() {
        $query = "SELECT u.*, r.nombre as rol_nombre 
                 FROM " . $this->table_name . " u
                 LEFT JOIN roles r ON u.rol_id = r.id
                 ORDER BY u.nombre ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Leer un solo usuario
    function leerUno() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row) {
            $this->nombre = $row['nombre'];
            $this->email = $row['email'];
            $this->cedula = $row['cedula'];
            $this->rol_id = $row['rol_id'];
            $this->estado = $row['estado'];
            $this->perfil = $row['perfil'];
            $this->fecha_registro = $row['fecha_registro'];
            return true;
        }
        return false;
    }

    // Actualizar usuario
    function actualizar() {
        // Query sin password
        $query = "UPDATE " . $this->table_name . "
                SET nombre=:nombre, email=:email, cedula=:cedula, 
                rol_id=:rol_id, estado=:estado, perfil=:perfil
                WHERE id=:id";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitizar
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->cedula = htmlspecialchars(strip_tags($this->cedula));
        $this->rol_id = htmlspecialchars(strip_tags($this->rol_id));
        $this->estado = htmlspecialchars(strip_tags($this->estado));
        $this->perfil = htmlspecialchars(strip_tags($this->perfil));
        $this->id = htmlspecialchars(strip_tags($this->id));
        
        // Bind parameters
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":cedula", $this->cedula);
        $stmt->bindParam(":rol_id", $this->rol_id);
        $stmt->bindParam(":estado", $this->estado);
        $stmt->bindParam(":perfil", $this->perfil);
        $stmt->bindParam(":id", $this->id);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Actualizar contraseña
    function actualizarPassword($nueva_password) {
        $query = "UPDATE " . $this->table_name . " SET password=:password WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        
        $this->password = password_hash($nueva_password, PASSWORD_BCRYPT);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":id", $this->id);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Eliminar usuario (cambiar estado)
    function eliminar() {
        $query = "UPDATE " . $this->table_name . " SET estado=0 WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Activar usuario
    function activar() {
        $query = "UPDATE " . $this->table_name . " SET estado=1 WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Verificar si email existe
    function emailExiste() {
        $query = "SELECT id FROM " . $this->table_name . " WHERE email = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $this->email = htmlspecialchars(strip_tags($this->email));
        $stmt->bindParam(1, $this->email);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    // Verificar si cédula existe
    function cedulaExiste() {
        $query = "SELECT id FROM " . $this->table_name . " WHERE cedula = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $this->cedula = htmlspecialchars(strip_tags($this->cedula));
        $stmt->bindParam(1, $this->cedula);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
}
?>