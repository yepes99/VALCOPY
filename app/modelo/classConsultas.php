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

    public function obtenerCategorias()
    {
        try {
            // Preparar la consulta SQL para obtener todas las categorías
            $stmt = $this->conexion->prepare("SELECT id_categoria, nombre FROM categorias");

            // Ejecutar la consulta
            $stmt->execute();

            // Obtener y devolver todas las filas de resultado como un array asociativo
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Manejar cualquier error en la consulta
            echo "Error al obtener categorías: " . $e->getMessage();
            return []; // Devolver un array vacío en caso de error
        }
    }

    public function actualizarProducto($id_producto, $nombre, $descripcion, $categoria, $precio, $disponibilidad, $medidas, $imagen)
    {
        try {
            // Preparar la consulta SQL para actualizar un producto existente
            $stmt = $this->conexion->prepare("UPDATE productos SET nombre = ?, descripcion = ?, categoria = ?, precio = ?, disponibilidad = ?, medidas = ?, imagen = ? WHERE id_producto = ?");
    
            // Enlazar parámetros y ejecutar la consulta
            $stmt->execute([$nombre, $descripcion, $categoria, $precio, $disponibilidad, $medidas, $imagen, $id_producto]);
    
            // Verificar si se actualizó al menos una fila
            if ($stmt->rowCount() > 0) {
                return true; // Indicar que la actualización fue exitosa
            } else {
                return false; // Indicar que no se realizó ninguna actualización
            }
        } catch (PDOException $e) {
            echo "Error al actualizar el producto: " . $e->getMessage();
            return false; // Indicar que hubo un error en la actualización
        }
    }
    
    public function borrarProducto($id_producto)
{
    try {
        // Preparar la consulta SQL para borrar el producto
        $stmt = $this->conexion->prepare("DELETE FROM productos WHERE id_producto = ?");

        // Enlazar parámetros y ejecutar la consulta
        $stmt->execute([$id_producto]);

        return true; // Indicar que el borrado fue exitoso
    } catch (PDOException $e) {
        echo "Error al borrar el producto: " . $e->getMessage();
        return false; // Indicar que hubo un error en el borrado
    }
}
public function obtenerProductos()
{
    try {
        // Preparar la consulta SQL para obtener todos los productos
        $stmt = $this->conexion->prepare("SELECT * FROM productos");

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener y devolver todos los productos como un array asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener productos: " . $e->getMessage();
        return false; // Indicar que hubo un error en la consulta
    }
}
public function obtenerProductosPorCategoria($categoria)
{
    try {
        // Preparar la consulta SQL para obtener productos por categoría
        $stmt = $this->conexion->prepare("SELECT * FROM productos WHERE categoria = :categoria");

        // Vincular el parámetro de categoría
        $stmt->bindParam(':categoria', $categoria, PDO::PARAM_INT);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener y devolver los productos filtrados por categoría como un array asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Manejar errores de base de datos
        echo "Error al obtener productos por categoría: " . $e->getMessage();
        return false; // Indicar que hubo un error en la consulta
    }
}


public function obtenerUsuarioPorId($id_usuario)
{
    try {
        // Preparar la consulta SQL para obtener el usuario por su ID
        $stmt = $this->conexion->prepare("SELECT * FROM usuarios WHERE id_usuario = ?");

        // Enlazar parámetro y ejecutar la consulta
        $stmt->execute([$id_usuario]);

        // Obtener y devolver el usuario como un array asociativo
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener usuario por ID: " . $e->getMessage();
        return false; // Indicar que hubo un error en la consulta
    }
}

public function obtenerProductoPorId($id_producto)
{
    try {
        // Preparar la consulta SQL para obtener un producto por su ID
        $stmt = $this->conexion->prepare("SELECT * FROM productos WHERE id_producto = :id");

        // Vincular el parámetro de ID del producto
        $stmt->bindParam(":id", $id_producto, PDO::PARAM_INT);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener y devolver el producto como un array asociativo
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Manejar cualquier error de consulta
        echo "Error al obtener el producto: " . $e->getMessage();
        return false; // Indicar que hubo un error en la consulta
    }
}

}
