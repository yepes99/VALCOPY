<?php


class Consultas
{
    
    public function buscarUsuarioPorEmail($email)
    {
        $stmt = $this->conexion->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insertarUsuario($params)
    {
        try {
            // Preparar la consulta SQL para insertar un nuevo usuario
            $stmt = $this->conexion->prepare("INSERT INTO usuarios (user, nombre, apellidos, email, password, telefono, direccion, ciudad, codigo_postal, pais, tipo_usuario, fecha_alta, fecha_baja, foto_perfil) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            // Enlazar parámetros y ejecutar la consulta
            $stmt->execute([
                $params['user'],
                $params['nombre'],
                $params['apellidos'],
                $params['email'],
                $params['pass'], 
                $params['telefono'],
                $params['direccion'],
                $params['ciudad'],
                $params['codigo_postal'],
                $params['pais'],
                $params['tipo_usuario'],
                $params['fecha_alta'],
                $params['fecha_baja'],
                $params['foto_perfil']
            ]);
        } catch (PDOException $e) {
            echo "Error al insertar usuario: " . $e->getMessage();
            exit;
        }
    }
}

?>
