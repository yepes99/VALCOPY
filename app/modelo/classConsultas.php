<?php


class Consultas extends Modelo
{
    

    public function buscarUsuarioPorEmail($email)
    {
        $stmt = $this->conexion->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

  // Dentro de la clase Consultas
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

        return true; // Indicar que la inserción fue exitosa
    } catch (PDOException $e) {
        echo "Error al insertar usuario: " . $e->getMessage();
        return false; // Indicar que hubo un error en la inserción
    }
}

public function insertarProducto($nombre, $descripcion, $categoria, $precio, $disponibilidad, $medidas, $imagen)
    {
        try {
            // Preparar la consulta SQL para insertar un nuevo producto
            $stmt = $this->conexion->prepare("INSERT INTO productos (nombre, descripcion, categoria, precio, disponibilidad, medidas, imagen) VALUES (?, ?, ?, ?, ?, ?, ?)");

            // Enlazar parámetros y ejecutar la consulta
            $stmt->execute([$nombre, $descripcion, $categoria, $precio, $disponibilidad, $medidas, $imagen]);

            return true; // Indicar que la inserción fue exitosa
        } catch (PDOException $e) {
            echo "Error al insertar producto: " . $e->getMessage();
            return false; // Indicar que hubo un error en la inserción
        }
    }

    public function insertarCategoria($nombre)
    {
        try {
            // Preparar la consulta SQL para insertar una nueva categoría
            $stmt = $this->conexion->prepare("INSERT INTO categorias (nombre) VALUES (?)");

            // Enlazar parámetros y ejecutar la consulta
            $stmt->execute([$nombre]);

            return true; // Indicar que la inserción fue exitosa
        } catch (PDOException $e) {
            echo "Error al insertar categoría: " . $e->getMessage();
            return false; // Indicar que hubo un error en la inserción
        }
    }
}
