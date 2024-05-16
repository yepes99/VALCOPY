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


public function actualizarCantidadEnCesta($id_usuario, $id_producto, $cantidad)
{
    try {
        // Verificar si el producto está en la cesta del usuario
        $stmt = $this->conexion->prepare("SELECT * FROM cesta WHERE id_usuario = ? AND id_producto = ?");
        $stmt->execute([$id_usuario, $id_producto]);
        $producto = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($producto) {
            // Actualizar la cantidad del producto en la cesta
            $stmt = $this->conexion->prepare("UPDATE cesta SET cantidad = ? WHERE id_usuario = ? AND id_producto = ?");
            $stmt->execute([$cantidad, $id_usuario, $id_producto]);
            return true; // Indicar que la operación fue exitosa
        } else {
            return false; // Indicar que el producto no está en la cesta
        }
    } catch (PDOException $e) {
        echo "Error al actualizar cantidad en la cesta: " . $e->getMessage();
        return false; // Indicar que hubo un error en la operación
    }
}

public function eliminarProductoDeCesta($id_usuario, $id_producto)
    {
        try {
            // Eliminar el producto de la cesta del usuario
            $stmt = $this->conexion->prepare("DELETE FROM cesta WHERE id_usuario = ? AND id_producto = ?");
            $stmt->execute([$id_usuario, $id_producto]);
            return true; // Indicar que la operación fue exitosa
        } catch (PDOException $e) {
            echo "Error al eliminar producto de la cesta: " . $e->getMessage();
            return false; // Indicar que hubo un error en la operación
        }
    }
       // Función para vaciar la cesta por completo
       public function vaciarCesta($id_usuario)
       {
           try {
               // Vaciar la cesta del usuario
               $stmt = $this->conexion->prepare("DELETE FROM cesta WHERE id_usuario = ?");
               $stmt->execute([$id_usuario]);
               return true; // Indicar que la operación fue exitosa
           } catch (PDOException $e) {
               echo "Error al vaciar la cesta: " . $e->getMessage();
               return false; // Indicar que hubo un error en la operación
           }
       }

       public function obtenerProductosEnLaCesta($id_usuario)
{
    try {
        // Preparar la consulta SQL para obtener los productos en la cesta del usuario
        $stmt = $this->conexion->prepare("SELECT p.id_producto, p.nombre, p.precio, cp.cantidad
                                          FROM productos AS p
                                          INNER JOIN cesta AS cp ON p.id_producto = cp.id_producto
                                          WHERE cp.id_usuario = ?");
        // Ejecutar la consulta
        $stmt->execute([$id_usuario]);

        // Obtener y devolver los productos en la cesta como un array asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener productos en la cesta: " . $e->getMessage();
        return []; // Devolver un array vacío en caso de error
    }
}


public function agregarProductoACesta($id_usuario, $id_producto, $cantidad)
{
    try {
        // Verificar si el producto ya está en la cesta del usuario
        $stmt = $this->conexion->prepare("SELECT * FROM cesta WHERE id_usuario = ? AND id_producto = ?");
        $stmt->execute([$id_usuario, $id_producto]);
        $producto = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($producto) {
            // Si el producto ya está en la cesta, actualizar la cantidad
            $cantidad += $producto['cantidad'];
            $stmt = $this->conexion->prepare("UPDATE cesta SET cantidad = ? WHERE id_usuario = ? AND id_producto = ?");
            $stmt->execute([$cantidad, $id_usuario, $id_producto]);
        } else {
            // Si el producto no está en la cesta, insertarlo
            $stmt = $this->conexion->prepare("INSERT INTO cesta (id_usuario, id_producto, cantidad) VALUES (?, ?, ?)");
            $stmt->execute([$id_usuario, $id_producto, $cantidad]);
        }

        return true; // Indicar que la operación fue exitosa
    } catch (PDOException $e) {
        echo "Error al agregar producto a la cesta: " . $e->getMessage();
        return false; // Indicar que hubo un error en la operación
    }
}

public function obtenerProductosEnCesta($id_usuario) {
    try {
        $sql = "SELECT p.id_producto, p.nombre, p.precio, c.cantidad 
                FROM productos p
                INNER JOIN cesta c ON p.id_producto = c.id_producto
                WHERE c.id_usuario = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id_usuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener productos en cesta: " . $e->getMessage();
        return false;
    }
}


public function actualizarPerfil($id_usuario, $datos_actualizados) {
    try {
        // Construir la consulta SQL para actualizar el perfil del usuario
        $sql = "UPDATE usuarios SET nombre = :nombre, apellidos = :apellidos, telefono = :telefono, ciudad = :ciudad, pais = :pais, email = :email, direccion = :direccion, codigo_postal = :codigo_postal WHERE id_usuario = :id_usuario";

        
        // Preparar la consulta
        $stmt = $this->conexion->prepare($sql);
        
        // Ejecutar la consulta con los valores proporcionados
        return $stmt->execute(array_merge($datos_actualizados, ['id_usuario' => $id_usuario]));
    } catch (PDOException $e) {
        echo "Error al actualizar perfil: " . $e->getMessage();
        return false; // Indicar que hubo un error al actualizar el perfil
    }
}


public function registrarPedido($id_usuario, $total) {
    try {
        // Obtener la fecha y hora actuales
        $fecha_pedido = date('Y-m-d H:i:s');

        // Preparar la consulta SQL para registrar el pedido
        $sql = "INSERT INTO pedidos (id_usuario, fecha_pedido, total, estado) VALUES (?, ?, ?, 'pendiente')";
        $stmt = $this->conexion->prepare($sql);

        // Ejecutar la consulta con los valores proporcionados
        $stmt->execute([$id_usuario, $fecha_pedido, $total]);

        // Devolver el ID del pedido recién registrado
        return $this->conexion->lastInsertId();
    } catch (PDOException $e) {
        echo "Error al registrar el pedido: " . $e->getMessage();
        return false; // Indicar que hubo un error al registrar el pedido
    }
}

public function registrarLineaPedido($id_pedido, $id_producto, $cantidad, $precio) {
    try {
        // Preparar la consulta SQL para insertar una nueva línea de pedido
        $sql = "INSERT INTO lineas_pedido (id_pedido, id_producto, cantidad, precio) VALUES (?, ?, ?, ?)";

        // Preparar y ejecutar la consulta
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id_pedido, $id_producto, $cantidad, $precio]);

        // Devolver el ID de la línea de pedido recién insertada
        return $this->conexion->lastInsertId();
    } catch (PDOException $e) {
        echo "Error al registrar línea de pedido: " . $e->getMessage();
        return false; // Indicar que hubo un error al registrar la línea de pedido
    }
}
 // Función para generar una factura y asociarla a un pedido
 public function generarFactura($pedido_id, $usuario_id, $productos_cesta, $total) {
    try {
        // Crear un nuevo registro en la tabla 'facturas' para asociarla al pedido
        $sql = "INSERT INTO facturas (id_pedido, id_usuario, fecha_factura, total, iva, forma_pago) VALUES (:id_pedido, :id_usuario, NOW(), :total, :iva, 'Tarjeta de crédito')";
        $stmt = $this->conexion->prepare($sql);
        
        // Calcular el total con IVA (asumiendo un 21% de IVA)
        $iva = $total * 0.21;
        $total_con_iva = $total + $iva;

        // Asignar los valores a los parámetros de la consulta
        $stmt->bindParam(':id_pedido', $pedido_id, PDO::PARAM_INT);
        $stmt->bindParam(':id_usuario', $usuario_id, PDO::PARAM_INT);
        $stmt->bindParam(':total', $total_con_iva, PDO::PARAM_STR);
        $stmt->bindParam(':iva', $iva, PDO::PARAM_STR);
        
        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el ID de la factura recién generada
        $factura_id = $this->conexion->lastInsertId();

        // Registrar los detalles de la factura (productos comprados)
        foreach ($productos_cesta as $producto) {
            $this->registrarDetalleFactura($factura_id, $producto['id_producto'], $producto['nombre'], $producto['cantidad'], $producto['precio']);
        }

        return $factura_id; // Devolver el ID de la factura generada
    } catch (PDOException $e) {
        echo "Error al generar la factura: " . $e->getMessage();
        return false; // Indicar que hubo un error al generar la factura
    }
}
// Función para registrar los detalles de una factura (productos comprados)
private function registrarDetalleFactura($factura_id, $id_producto, $nombre_producto, $cantidad, $precio_unitario) {
    try {
        // Preparar la consulta SQL para insertar los detalles de la factura
        $sql = "INSERT INTO detalles_factura (id_factura, id_producto, nombre_producto, cantidad, precio_unitario) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        
        // Ejecutar la consulta con los valores proporcionados
        $stmt->execute([$factura_id, $id_producto, $nombre_producto, $cantidad, $precio_unitario]);
    } catch (PDOException $e) {
        echo "Error al registrar detalles de factura: " . $e->getMessage();
        return false; // Indicar que hubo un error al registrar los detalles de la factura
    }
}

public function eliminarPedido($pedido_id) {
    try {
        // Preparar la consulta SQL para eliminar el pedido
        $sql = "DELETE FROM pedidos WHERE id_pedido = ?";
        $stmt = $this->conexion->prepare($sql);

        // Ejecutar la consulta con el ID del pedido proporcionado
        $stmt->execute([$pedido_id]);

        // Devolver true si se eliminó correctamente
        return true;
    } catch (PDOException $e) {
        echo "Error al eliminar el pedido: " . $e->getMessage();
        return false; // Indicar que hubo un error al eliminar el pedido
    }
}





public function editarPedido($pedido_id, $nuevo_estado, $transportista, $metodo_pago)
{
    try {
        // Preparar la consulta SQL para actualizar el estado, transportista y método de pago del pedido
        $sql = "UPDATE pedidos SET estado = ?, transportista = ?, metodo_pago = ? WHERE id_pedido = ?";
        $stmt = $this->conexion->prepare($sql);

        // Ejecutar la consulta con los nuevos datos y el ID del pedido
        $stmt->execute([$nuevo_estado, $transportista, $metodo_pago, $pedido_id]);

        // Devolver true si se actualizó correctamente
        return true;
    } catch (PDOException $e) {
        echo "Error al editar el pedido: " . $e->getMessage();
        return false; // Indicar que hubo un error al editar el pedido
    }
}
public function obtenerFacturaPorPedido($pedido_id)
{
    try {
        // Preparar la consulta SQL para obtener la factura asociada al pedido
        $sql = "SELECT * FROM facturas WHERE id_pedido = ?";
        $stmt = $this->conexion->prepare($sql);

        // Ejecutar la consulta con el ID del pedido
        $stmt->execute([$pedido_id]);

        // Obtener los datos de la factura
        $factura = $stmt->fetch(PDO::FETCH_ASSOC);

        // Devolver los datos de la factura
        return $factura;
    } catch (PDOException $e) {
        echo "Error al obtener la factura del pedido: " . $e->getMessage();
        return false; // Indicar que hubo un error al obtener la factura
    }
}

public function obtenerPedidosPorCliente($cliente_id)
{
    try {
        // Preparar la consulta SQL para obtener los pedidos del cliente
        $sql = "SELECT * FROM pedidos WHERE id_usuario = ?";
        $stmt = $this->conexion->prepare($sql);
        
        // Ejecutar la consulta con el ID del cliente
        $stmt->execute([$cliente_id]);

        // Obtener y devolver los resultados
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener los pedidos del cliente: " . $e->getMessage();
        return []; // Devolver un array vacío en caso de error
    }
}
public function buscarUsuarioPorId($id_usuario){
    // Aquí asumo que tienes una conexión a la base de datos llamada $conexion
    // Debes reemplazar $conexion con tu conexión real a la base de datos

    // Preparar la consulta SQL
    $sql = "SELECT * FROM usuarios WHERE id_usuario = :id_usuario";

    // Preparar la sentencia
    $stmt = $this->conexion->prepare($sql);
    // Vincular parámetros
    $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener el resultado como un array asociativo
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Retornar el resultado
    return $usuario;
}
public function listarTodosLosUsuarios(){
    // Realizar la consulta para obtener todos los usuarios
    $sql = "SELECT * FROM usuarios";
    $result = $this->conexion->query($sql); // Execute the query

    // Verificar si hay resultados
    if ($result !== false) {
        // Inicializar un array para almacenar los usuarios
        $usuarios = array();

        // Iterar sobre los resultados y almacenar cada usuario en el array
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $usuarios[] = $row;
        }

        // Devolver el array de usuarios
        return $usuarios;
    } else {
        // Si no hay usuarios, devolver un array vacío
        return array();
    }
}




}
