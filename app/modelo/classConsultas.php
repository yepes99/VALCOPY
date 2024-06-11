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

        return true; 
    } catch (PDOException $e) {
        echo "Error al insertar usuario: " . $e->getMessage();
        return false; 
    }
}

public function insertarProducto($nombre, $descripcion, $categoria, $precio, $disponibilidad, $medidas, $imagen)
    {
        try {
        
            $stmt = $this->conexion->prepare("INSERT INTO productos (nombre, descripcion, categoria, precio, disponibilidad, medidas, imagen) VALUES (?, ?, ?, ?, ?, ?, ?)");

         
            $stmt->execute([$nombre, $descripcion, $categoria, $precio, $disponibilidad, $medidas, $imagen]);

            return true; 
        } catch (PDOException $e) {
            echo "Error al insertar producto: " . $e->getMessage();
            return false; 
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

    public function obtenerCategorias() {
        try {
            $stmt = $this->conexion->prepare("SELECT * FROM categorias");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al obtener categorías: " . $e->getMessage();
            return [];
        }
    }

    // Método para obtener productos por categoría
    public function obtenerProductosPorCategoria($id_categoria) {
        try {
            $stmt = $this->conexion->prepare("SELECT * FROM productos WHERE categoria = ?");
            $stmt->execute([$id_categoria]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al obtener productos: " . $e->getMessage();
            return [];
        }
    }
    
    
    public function actualizarProducto($id_producto, $nombre, $descripcion, $categoria, $precio, $disponibilidad, $medidas, $imagen)
    {
        try {
           
            $stmt = $this->conexion->prepare("UPDATE productos SET nombre = ?, descripcion = ?, categoria = ?, precio = ?, disponibilidad = ?, medidas = ?, imagen = ? WHERE id_producto = ?");
    
       
            $stmt->execute([$nombre, $descripcion, $categoria, $precio, $disponibilidad, $medidas, $imagen, $id_producto]);
    
            // Verificar si se actualizó al menos una fila
            if ($stmt->rowCount() > 0) {
                return true; // Indicar que la actualización fue exitosa
            } else {
                return false; // Indicar que no se realizó ninguna actualización
            }
        } catch (PDOException $e) {
            echo "Error al actualizar el producto: " . $e->getMessage();
            return false; 
        }
    }
    
    public function borrarProducto($id_producto)
{
    try {
      
        $stmt = $this->conexion->prepare("DELETE FROM productos WHERE id_producto = ?");

    
        $stmt->execute([$id_producto]);

        return true; 
    } catch (PDOException $e) {
        echo "Error al borrar el producto: " . $e->getMessage();
        return false; 
    }
}
public function obtenerProductos()
{
    try {
    
        $stmt = $this->conexion->prepare("SELECT * FROM productos");

      
        $stmt->execute();

    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener productos: " . $e->getMessage();
        return false; 
    }
}


public function obtenerUsuarioPorId($id_usuario)
{
    try {
        // Preparar la consulta SQL para obtener el usuario por su ID
        $stmt = $this->conexion->prepare("SELECT * FROM usuarios WHERE id_usuario = ?");

        // Enlazar parámetro y ejecutar la consulta
        $stmt->execute([$id_usuario]);

      
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener usuario por ID: " . $e->getMessage();
        return false; 
    }
}

public function obtenerProductoPorId($id_producto)
{
    try {
       
        $stmt = $this->conexion->prepare("SELECT * FROM productos WHERE id_producto = :id");

      
        $stmt->bindParam(":id", $id_producto, PDO::PARAM_INT);


        $stmt->execute();

      
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Manejar cualquier error de consulta
        echo "Error al obtener el producto: " . $e->getMessage();
        return false; 
    }
}


public function actualizarCantidadEnCesta($id_usuario, $id_producto, $cantidad)
{
    try {
       
        $stmt = $this->conexion->prepare("SELECT * FROM cesta WHERE id_usuario = ? AND id_producto = ?");
        $stmt->execute([$id_usuario, $id_producto]);
        $producto = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($producto) {
            // Actualizar la cantidad del producto en la cesta
            $stmt = $this->conexion->prepare("UPDATE cesta SET cantidad = ? WHERE id_usuario = ? AND id_producto = ?");
            $stmt->execute([$cantidad, $id_usuario, $id_producto]);
            return true; 
        } else {
            return false; 
        }
    } catch (PDOException $e) {
        echo "Error al actualizar cantidad en la cesta: " . $e->getMessage();
        return false; 
    }
}

public function eliminarProductoDeCesta($id_usuario, $id_producto)
    {
        try {
            // Eliminar el producto de la cesta del usuario
            $stmt = $this->conexion->prepare("DELETE FROM cesta WHERE id_usuario = ? AND id_producto = ?");
            $stmt->execute([$id_usuario, $id_producto]);
            return true; 
        } catch (PDOException $e) {
            echo "Error al eliminar producto de la cesta: " . $e->getMessage();
            return false;
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
               return false; 
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

       
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener productos en la cesta: " . $e->getMessage();
        return []; 
    }
}


public function agregarProductoACesta($id_usuario, $id_producto, $cantidad)
{
    try {
        
        $stmt = $this->conexion->prepare("SELECT * FROM cesta WHERE id_usuario = ? AND id_producto = ?");
        $stmt->execute([$id_usuario, $id_producto]);
        $producto = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($producto) {
          
            $cantidad += $producto['cantidad'];
            $stmt = $this->conexion->prepare("UPDATE cesta SET cantidad = ? WHERE id_usuario = ? AND id_producto = ?");
            $stmt->execute([$cantidad, $id_usuario, $id_producto]);
        } else {
            // Si el producto no está en la cesta, insertarlo
            $stmt = $this->conexion->prepare("INSERT INTO cesta (id_usuario, id_producto, cantidad) VALUES (?, ?, ?)");
            $stmt->execute([$id_usuario, $id_producto, $cantidad]);
        }

        return true; 
    } catch (PDOException $e) {
        echo "Error al agregar producto a la cesta: " . $e->getMessage();
        return false; 
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


public function actualizarPerfil($id_usuario, $datos_actualizados, $foto_perfil)
{
    try {
       
        $foto_perfil_nombre = '';

      
        if (!empty($foto_perfil) && $foto_perfil['error'] === 0) {
            $foto_perfil_nombre = $foto_perfil['name'];

      
            $directorio_destino = __DIR__ . '/../../app/archivos/img/usuario/';
            $ruta_destino = $directorio_destino . $foto_perfil_nombre;

           
            move_uploaded_file($foto_perfil['tmp_name'], $ruta_destino);
        }

       
        $sql = "UPDATE usuarios SET nombre = :nombre, apellidos = :apellidos, telefono = :telefono, ciudad = :ciudad, pais = :pais, email = :email, direccion = :direccion, codigo_postal = :codigo_postal";

        // Agregar la actualización de la foto de perfil solo si se subió una nueva
        if (!empty($foto_perfil_nombre)) {
            $sql .= ", foto_perfil = :foto_perfil";
        }

        $sql .= " WHERE id_usuario = :id_usuario";

        // Preparar la consulta
        $stmt = $this->conexion->prepare($sql);

        // Bind de los parámetros
        $stmt->bindParam(':nombre', $datos_actualizados['nombre'], PDO::PARAM_STR);
        $stmt->bindParam(':apellidos', $datos_actualizados['apellidos'], PDO::PARAM_STR);
        $stmt->bindParam(':telefono', $datos_actualizados['telefono'], PDO::PARAM_STR);
        $stmt->bindParam(':ciudad', $datos_actualizados['ciudad'], PDO::PARAM_STR);
        $stmt->bindParam(':pais', $datos_actualizados['pais'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $datos_actualizados['email'], PDO::PARAM_STR);
        $stmt->bindParam(':direccion', $datos_actualizados['direccion'], PDO::PARAM_STR);
        $stmt->bindParam(':codigo_postal', $datos_actualizados['codigo_postal'], PDO::PARAM_STR);

        // Bind del nombre de la foto de perfil si se subió una nueva
        if (!empty($foto_perfil_nombre)) {
            $stmt->bindParam(':foto_perfil', $foto_perfil_nombre, PDO::PARAM_STR);
        }

        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);

        // Ejecutar la consulta
        $resultado = $stmt->execute();

        // Verificar el éxito de la ejecución y actualizar correctamente la foto de perfil
        if ($resultado && !empty($foto_perfil_nombre)) {
            // Actualizar el nombre de la foto de perfil en la sesión o en el array de datos actualizados si es necesario
            $_SESSION['foto_perfil'] = $foto_perfil_nombre; // Actualiza la sesión si es necesario
            $datos_actualizados['foto_perfil'] = $foto_perfil_nombre; // Actualiza el array de datos actualizados si es necesario
        }

        return $resultado;
    } catch (PDOException $e) {
        echo "Error al actualizar perfil: " . $e->getMessage();
        return false; // Indicar que hubo un error al actualizar el perfil
    }
}




public function registrarPedido($id_usuario, $total) {
    try {
        
        $fecha_pedido = date('Y-m-d H:i:s');

       
        $sql = "INSERT INTO pedidos (id_usuario, fecha_pedido, total, estado) VALUES (?, ?, ?, 'pendiente')";
        $stmt = $this->conexion->prepare($sql);

      
        $stmt->execute([$id_usuario, $fecha_pedido, $total]);

       
        return $this->conexion->lastInsertId();
    } catch (PDOException $e) {
        echo "Error al registrar el pedido: " . $e->getMessage();
        return false; // Indicar que hubo un error al registrar el pedido
    }
}

public function registrarLineaPedido($id_pedido, $id_producto, $cantidad, $precio) {
    try {
        
        $sql = "INSERT INTO lineas_pedido (id_pedido, id_producto, cantidad, precio) VALUES (?, ?, ?, ?)";

        
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id_pedido, $id_producto, $cantidad, $precio]);

       
        return $this->conexion->lastInsertId();
    } catch (PDOException $e) {
        echo "Error al registrar línea de pedido: " . $e->getMessage();
        return false; 
    }
}
 // Función para generar una factura y asociarla a un pedido
 public function generarFactura($pedido_id, $usuario_id, $productos_cesta, $total) {
    try {
        
        $sql = "INSERT INTO facturas (id_pedido, id_usuario, fecha_factura, total, iva, forma_pago) VALUES (:id_pedido, :id_usuario, NOW(), :total, :iva, 'Tarjeta de crédito')";
        $stmt = $this->conexion->prepare($sql);
        
        
        $iva = $total * 0.21;
        $total_con_iva = $total + $iva;

      
        $stmt->bindParam(':id_pedido', $pedido_id, PDO::PARAM_INT);
        $stmt->bindParam(':id_usuario', $usuario_id, PDO::PARAM_INT);
        $stmt->bindParam(':total', $total_con_iva, PDO::PARAM_STR);
        $stmt->bindParam(':iva', $iva, PDO::PARAM_STR);
        
       
        $stmt->execute();

      
        $factura_id = $this->conexion->lastInsertId();

      
        foreach ($productos_cesta as $producto) {
            $this->registrarDetalleFactura($factura_id, $producto['id_producto'], $producto['nombre'], $producto['cantidad'], $producto['precio']);
        }

        return $factura_id; 
    } catch (PDOException $e) {
        echo "Error al generar la factura: " . $e->getMessage();
        return false; 
    }
}

private function registrarDetalleFactura($factura_id, $id_producto, $nombre_producto, $cantidad, $precio_unitario) {
    try {
       
        $sql = "INSERT INTO detalles_factura (id_factura, id_producto, nombre_producto, cantidad, precio_unitario) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        
       
        $stmt->execute([$factura_id, $id_producto, $nombre_producto, $cantidad, $precio_unitario]);
    } catch (PDOException $e) {
        echo "Error al registrar detalles de factura: " . $e->getMessage();
        return false; 
    }
}

public function eliminarPedido($pedido_id) {
    try {
      
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
       
        $sql = "UPDATE pedidos SET estado = ?, transportista = ?, metodo_pago = ? WHERE id_pedido = ?";
        $stmt = $this->conexion->prepare($sql);

       
        $stmt->execute([$nuevo_estado, $transportista, $metodo_pago, $pedido_id]);

        
        return true;
    } catch (PDOException $e) {
        echo "Error al editar el pedido: " . $e->getMessage();
        return false; // Indicar que hubo un error al editar el pedido
    }
}
public function obtenerFacturaPorPedido($pedido_id)
{
    try {
      
        $sql = "SELECT * FROM facturas WHERE id_pedido = ?";
        $stmt = $this->conexion->prepare($sql);

      
        $stmt->execute([$pedido_id]);

    
        $factura = $stmt->fetch(PDO::FETCH_ASSOC);

       
        return $factura;
    } catch (PDOException $e) {
        echo "Error al obtener la factura del pedido: " . $e->getMessage();
        return false; // Indicar que hubo un error al obtener la factura
    }
}

public function obtenerPedidosPorCliente($cliente_id)
{
    try {
        
        $sql = "SELECT * FROM pedidos WHERE id_usuario = ?";
        $stmt = $this->conexion->prepare($sql);
        
    
        $stmt->execute([$cliente_id]);

     
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener los pedidos del cliente: " . $e->getMessage();
        return [];
    }
}
public function buscarUsuarioPorId($id_usuario){
   

    
    $sql = "SELECT * FROM usuarios WHERE id_usuario = :id_usuario";

   
    $stmt = $this->conexion->prepare($sql);
    
    $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);

   
    $stmt->execute();

   
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Retornar el resultado
    return $usuario;
}
public function listarTodosLosUsuarios(){
   
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


public function insertarMensaje($nombre, $email, $mensaje) {
    try {
        $sql = "INSERT INTO mensajes2 (nombre, email, mensaje) VALUES (:nombre, :email, :mensaje)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':mensaje', $mensaje, PDO::PARAM_STR);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        echo "Error al insertar el mensaje: " . $e->getMessage();
        return false;
    }
}

public function obtenerMensajes() {
    try {
        $sql = "SELECT * FROM mensajes2";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener mensajes: " . $e->getMessage();
        return [];
    }
}
public function obtenerMensajePorId($id) {
    try {
        $sql = "SELECT * FROM mensajes2 WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener mensaje por ID: " . $e->getMessage();
        return null;
    }
}
public function insertarRespuesta($idMensaje, $respuesta) {
    try {
        $sql = "INSERT INTO respuesta2 (id_mensaje, respuesta) VALUES (:id_mensaje, :respuesta)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id_mensaje', $idMensaje, PDO::PARAM_INT);
        $stmt->bindParam(':respuesta', $respuesta, PDO::PARAM_STR);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        echo "Error PDO al insertar respuesta: " . $e->getMessage();
    } 
}

public function obtenerUsuarioConFotoPorId($id_usuario) {
    try {
        // Construir la consulta SQL para obtener el usuario con la foto de perfil
        $sql = "SELECT id_usuario, user, nombre, apellidos, telefono, ciudad, pais, email, direccion, codigo_postal, tipo_usuario, fecha_alta, foto_perfil FROM usuarios WHERE id_usuario = :id_usuario";

        // Preparar la consulta
        $stmt = $this->conexion->prepare($sql);

        // Bind de parámetros
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);

       
        $stmt->execute();

      
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // Retornar los datos del usuario con la foto de perfil
        return $usuario;

    } catch (PDOException $e) {
        echo "Error al obtener usuario con foto de perfil: " . $e->getMessage();
        return false; // Indicar que hubo un error al obtener el usuario
    }
}


public function obtenerUsuarioPorEmail($email) {
    $query = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $this->conexion->prepare($query);
    $stmt->execute([$email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
public function obtenerMensajesYRespuestasPorEmail($email) {
    $query = "SELECT m.id, m.mensaje, m.fecha, r.respuesta
              FROM mensajes2 m
              LEFT JOIN respuestas2 r ON m.id = r.id_mensaje
              WHERE m.email = ?";
    $stmt = $this->conexion->prepare($query);
    $stmt->execute([$email]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function obtenerRespuestasPorIdMensaje($id_mensaje) {
    $query = "SELECT * FROM respuesta2 WHERE id_mensaje = ?";
    $stmt = $this->conexion->prepare($query);
    $stmt->execute([$id_mensaje]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function obtenerEmailPorIdUsuario($id_usuario) {
    $query = "SELECT email FROM usuarios WHERE id_usuario = ?";
    $stmt = $this->conexion->prepare($query);
    $stmt->execute([$id_usuario]);
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    return $resultado['email'] ?? null;
}
public function obtenerMensajesPorUsuarioEmail($email) {
    $query = "SELECT * FROM mensajes2 WHERE email = ?";
    $stmt = $this->conexion->prepare($query);
    $stmt->execute([$email]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Método para obtener productos de la cesta por ID de usuario
public function obtenerProductosCestaPorUsuario($id_usuario) {
    try {
        // Consulta SQL ajustada para obtener los productos de la cesta del usuario
        $sql = "SELECT p.nombre, p.precio, c.cantidad
                FROM cesta c
                INNER JOIN productos p ON c.id_producto = p.id_producto
                WHERE c.id_usuario = :id_usuario";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);

       
        $stmt->execute();

      
        $productos_comprados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Devolver el resultado
        return $productos_comprados;

    } catch (PDOException $e) {
     
        echo "Error al obtener productos de la cesta: " . $e->getMessage();
        return false;
    }
}

}


