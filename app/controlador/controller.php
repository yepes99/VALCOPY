<?php

require __DIR__ . '/../composer/vendor/autoload.php';

require __DIR__ . '/../composer/vendor/phpmailer/phpmailer/src/Exception.php';
require __DIR__ . '/../composer/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require __DIR__ . '/../composer/vendor/phpmailer/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Controller
{
    public function registro()
    {
        $params = array(
            'user' => '', // Nombre de usuario o apodo
            'nombre' => null, // Nombre del usuario
            'apellidos' => null, // Apellidos del usuario
            'email' => '', // Correo electrónico del usuario (único)
            'pass' => '', // Contraseña del usuario
            'pass2' => '', // Confirmación de contraseña del usuario
            'telefono' => null, // Número de teléfono del usuario
            'direccion' => null, // Dirección del usuario
            'ciudad' => null, // Ciudad del usuario
            'codigo_postal' => null, // Código postal del usuario
            'pais' => null, // País del usuario
            'tipo_usuario' => 'cliente', // Tipo de usuario (cliente o administrador)
            'fecha_alta' => date('Y-m-d H:i:s'), // Fecha de alta del usuario (DATETIME)
            'fecha_baja' => null, // Fecha de baja del usuario (DATETIME)
            'foto_perfil' => null, // Archivo de imagen de perfil del usuario
            'mensaje' => [] // Mensajes de error o éxito durante el proceso
        );

        $consulta = new Consultas(); // Crear objeto Consultas

        if (isset($_POST["bAceptar"])) {
            // Recogemos datos de los inputs
            $params["user"] = recoge("user");
            $params["email"] = recoge("email");
            $params["pass"] = recoge("pass");
            $params["pass2"] = recoge("pass2");

            // Validaciones
            if (empty($params["user"])) {
                $params["mensaje"][] = "Por favor ingrese un nombre de usuario.";
            } else {
                $params["user"] = sinEspacios($params["user"]);
            }

            // Validar el correo electrónico
            if (empty($params["email"])) {
                $params["mensaje"][] = "Por favor, ingrese un correo electrónico.";
            } elseif (!filter_var($params["email"], FILTER_VALIDATE_EMAIL)) {
                $params["mensaje"][] = "El correo electrónico ingresado no es válido.";
            } else {
                // Verificar si el correo electrónico ya existe en la base de datos
                $emailExistente = $consulta->buscarUsuarioPorEmail($params["email"]);
                if ($emailExistente) {
                    $params["mensaje"][] = "El correo electrónico ingresado ya está en uso. Por favor, elija otro.";
                }
            }

            // Validamos la contraseña
            if (empty($params["pass"]) || empty($params["pass2"])) {
                $params["mensaje"][] = "Por favor, ingrese la contraseña y la confirmación.";
            } elseif ($params["pass"] !== $params["pass2"]) {
                $params["mensaje"][] = "Las contraseñas no coinciden.";
            } else {
                // La contraseña es válida, la encriptamos
                $params["pass"] = password_hash($params["pass"], PASSWORD_DEFAULT);
            }

            // Insertar usuario en la base de datos si no hay mensajes de error
            if (empty($params["mensaje"])) {
                if ($consulta->insertarUsuario($params)) {
                    echo "¡Registro exitoso!";
                    // Redirigir u otro flujo de la aplicación después de la inserción
                } else {
                    echo "Error al registrar el usuario.";
                }
            } else {
                // Si hay mensajes de error, imprimirlos
                echo "Error al registrar el usuario. Detalles:";
                print_r($params["mensaje"]);
            }
        }

        // Incluir la vista para mostrar el formulario de registro
        require __DIR__ . '/../../web/templates/registro.php';
    }

    public function inicio()
    {
        require __DIR__ . '/../../web/templates/inicio.php';
    }

    public function admin()
    {
        require __DIR__ . '/../../web/templates/panel_admin.php';
    }

    public function gestionProductos(){


            


        require __DIR__ . '/../../web/templates/gestionProductos.php';
    }
    public function agregarProducto()
    {
        // Verificar si se envió el formulario
        if (isset($_POST["bAceptar"])) {
            // Recoger los datos del formulario
            $nombre = $_POST["nombre"];
            $descripcion = $_POST["descripcion"];
            $categoria = $_POST["categoria"];
            $precio = $_POST["precio"];
            $disponibilidad = $_POST["disponibilidad"];
            $medidas = $_POST["medidas"];
            $imagen = $_FILES["imagen"]; // Recoger la imagen del formulario
            
            // Directorio donde se almacenarán las imágenes de productos
            $directorio_destino = __DIR__ . '/../../app/archivos/img/productos_imagenes/';
            
            // Comprobar si se subió la imagen correctamente
            if ($imagen['error'] === UPLOAD_ERR_OK) {
                // Obtener el nombre y la extensión del archivo
                $nombre_imagen = basename($imagen["name"]);
                $nombre_temporal = $imagen["tmp_name"];
                $ruta_destino = $directorio_destino . $nombre_imagen;
                
                // Mover el archivo al directorio de destino
                if (move_uploaded_file($nombre_temporal, $ruta_destino)) {
                    // Crear una instancia de Consultas
                    $consulta = new Consultas();
    
                    // Insertar el producto en la base de datos
                    $exito = $consulta->insertarProducto($nombre, $descripcion, $categoria, $precio, $disponibilidad, $medidas, $ruta_destino);
    
                    // Verificar si la inserción fue exitosa
                    if ($exito) {
                        echo "Producto agregado exitosamente.";
                    } else {
                        echo "Error al agregar el producto.";
                    }
                } else {
                    echo "Error al mover el archivo al directorio de destino.";
                }
            } else {
                // Mostrar mensaje de error según el tipo de error
                switch ($imagen['error']) {
                    case UPLOAD_ERR_INI_SIZE:
                    case UPLOAD_ERR_FORM_SIZE:
                        echo "La foto es demasiado grande.";
                        break;
                    case UPLOAD_ERR_PARTIAL:
                        echo "La foto no se subió completa.";
                        break;
                    case UPLOAD_ERR_NO_FILE:
                        echo "No se subió ninguna foto.";
                        break;
                    case UPLOAD_ERR_NO_TMP_DIR:
                        echo "Falta el directorio temporal.";
                        break;
                    case UPLOAD_ERR_CANT_WRITE:
                        echo "Error al escribir el archivo en el disco.";
                        break;
                    case UPLOAD_ERR_EXTENSION:
                        echo "La subida del archivo fue detenida por la extensión.";
                        break;
                    default:
                        echo "Error desconocido al subir la foto.";
                        break;
                }
            }
        }
    
        // Incluir la vista del formulario para agregar un producto
        require __DIR__ . '/../../web/templates/agregarProducto.php';
    }


    public function agregarCategoria()
{
    // Verificar si se envió el formulario
    if (isset($_POST["bAceptar"])) {
        // Recoger los datos del formulario
        $nombre = $_POST["nombre"];

        // Crear una instancia de Consultas
        $consulta = new Consultas();

        // Insertar la categoría en la base de datos
        $exito = $consulta->insertarCategoria($nombre);

        // Verificar si la inserción fue exitosa
        if ($exito) {
            echo "Categoría agregada exitosamente.";
           
        } else {
            echo "Error al agregar la categoría.";
        }
    }

    // Incluir la vista del formulario para agregar una categoría
    require __DIR__ . '/../../web/templates/agregarCategoria.php';
}

public function editarProducto()
{
    // Verificar si se envió el formulario
    if (isset($_POST["bAceptar"])) {
        // Recoger los datos del formulario
        $id_producto = $_POST["id_producto"];
        $nombre = $_POST["nombre"];
        $descripcion = $_POST["descripcion"];
        $categoria = $_POST["categoria"];
        $precio = $_POST["precio"];
        $disponibilidad = $_POST["disponibilidad"];
        $medidas = $_POST["medidas"];
        $imagen = $_POST["imagen"]; // Aquí deberías manejar la subida de archivos

        // Crear una instancia de Consultas
        $consulta = new Consultas();

        // Actualizar el producto en la base de datos
        $exito = $consulta->actualizarProducto($id_producto, $nombre, $descripcion, $categoria, $precio, $disponibilidad, $medidas, $imagen);

        // Verificar si la actualización fue exitosa
        if ($exito) {
            echo "Producto actualizado exitosamente.";
        } else {
            echo "Error al actualizar el producto.";
        }
    }

    // Incluir la vista del formulario para editar un producto
    require __DIR__ . '/../../web/templates/editarProducto.php';
}


public function borrarProducto()
    {
        // Verificar si se envió el formulario para borrar el producto
        if (isset($_POST["bBorrar"])) {
            // Recoger el ID del producto a borrar
            $id_producto = $_POST["id_producto"];

            // Crear una instancia de Consultas
            $consulta = new Consultas();

            // Intentar borrar el producto
            $exito = $consulta->borrarProducto($id_producto);

            // Verificar si el borrado fue exitoso
            if ($exito) {
                echo "Producto borrado exitosamente.";
            } else {
                echo "Error al borrar el producto.";
            }
        }

        // Incluir la vista del formulario para borrar un producto
        require __DIR__ . '/../../web/templates/borrarProducto.php';
    }

    public function verProductos()
    {
        // Crear una instancia de la clase Consultas
        $consulta = new Consultas();

        // Obtener todos los productos de la base de datos
        $productos = $consulta->obtenerProductos();

        // Incluir la vista para visualizar los productos
        require __DIR__ . '/../../web/templates/verProductos.php';
    }

    public function panelAdmin(){

        require __DIR__ . '/../../web/templates/panel_admin.php';
    }

    public function inicioSesion()
{
    $params = array(
        'email' => '', // Correo electrónico del usuario
        'pass' => '', // Contraseña del usuario
        'mensaje' => array() // Mensajes de error o éxito durante el proceso
    );

    if (isset($_POST["bAceptar"])) {
        // Recogemos datos del formulario
        $params["email"] = recoge("email");
        $params["pass"] = recoge("pass");

        // Verificamos si se han ingresado los datos correctamente
        if (empty($params["email"]) || empty($params["pass"])) {
            $params["mensaje"][] = "Por favor, ingrese el correo electrónico y la contraseña.";
        } else {
            // Consultamos la base de datos para verificar el correo electrónico y la contraseña
            $consulta = new Consultas();
            $usuario = $consulta->buscarUsuarioPorEmail($params["email"]);

            if ($usuario) {
                // Verificamos si el correo es "valcopy@gmail.com"
                if ($params["email"] === "valcopy@gmail.com") {
                    // Si coincide, comparamos la contraseña directamente
                    if ($params["pass"] === $usuario["password"]) {
                        // Si la contraseña es correcta, redirigimos según el tipo de usuario
                        if ($usuario['tipo_usuario'] === 'administrador') {
                            $_SESSION['tipo_usuario'] = $usuario['tipo_usuario'];
                            $_SESSION['id_usuario'] = $usuario['id_usuario'];
                            header("Location: index.php?ctl=admin");
                            exit;
                        } else {
                            $_SESSION['id_usuario'] = $usuario['id_usuario']; // Establecer la variable de sesión para el usuario normal
                            var_dump($_SESSION); // Agregar var_dump para verificar
                            header("Location: index.php?ctl=inicio");
                            exit;
                        }
                    } else {
                        $params["mensaje"][] = "La contraseña ingresada es incorrecta.";
                    }
                } else {
                    // Si el correo no coincide, usamos password_verify()
                    if (password_verify($params["pass"], $usuario["password"])) {
                        // Si la contraseña es correcta, redirigimos según el tipo de usuario
                        if ($usuario['tipo_usuario'] === 'administrador') {
                            header("Location: index.php?ctl=admin");
                            exit;
                        } else {
                            $_SESSION['id_usuario'] = $usuario['id_usuario']; // Establecer la variable de sesión para el usuario normal
                
                            var_dump($_SESSION); // Agregar var_dump para verificar
                            header("Location: index.php?ctl=inicio");
                            exit;
                        }
                    } else {
                        $params["mensaje"][] = "La contraseña ingresada es incorrecta.";
                    }
                }
            } else {
                $params["mensaje"][] = "El correo electrónico ingresado no está registrado.";
            }
        }
    }

    // Incluimos la vista para mostrar el formulario de inicio de sesión
    require __DIR__ . '/../../web/templates/inicioSesion.php';
}


public function cerrarSesion()
{
    // Eliminar todas las variables de sesión
    session_unset();

    // Destruir la sesión
    session_destroy();

    // Redirigir al inicio del sitio web
    header("Location: index.php?ctl=inicio");
    exit;
}

public function verPerfil()
{
   // Verificar si hay una sesión iniciada y obtener el ID de usuario
   if (isset($_SESSION['id_usuario'])) {
    $id_usuario = $_SESSION['id_usuario'];
    
    // Crear una instancia de la clase Consultas
    $consultas = new Consultas();
    
    // Obtener los datos del usuario desde la base de datos
    $usuario = $consultas->obtenerUsuarioPorId($id_usuario);

    // Verificar si se encontró al usuario
    if ($usuario) {
        // Verificar si se envió el formulario de actualización
        if (isset($_POST['bAceptar'])) {
            // Recoger los datos del formulario
            $nombre = $_POST["nombre"];
            $apellidos = $_POST["apellidos"];
            $telefono = $_POST["telefono"];
            $ciudad = $_POST["ciudad"];
            $pais = $_POST["pais"];
            $email = $_POST["email"];
            $direccion = $_POST["direccion"];
            $codigo_postal = $_POST["codigo_postal"];
            $foto_perfil = $_FILES["foto_perfil"];

            // Crear un array para almacenar los datos actualizados
            $datos_actualizados = [
                'nombre' => $nombre,
                'apellidos' => $apellidos,
                'telefono' => $telefono,
                'ciudad' => $ciudad,
                'pais' => $pais,
                'email' => $email,
                'direccion' => $direccion,
                'codigo_postal' => $codigo_postal,
                'foto_perfil'=> $foto_perfil
               
            ];

            // Actualizar perfil, incluyendo la foto de perfil
            if ($consultas->actualizarPerfil($id_usuario, $datos_actualizados,$foto_perfil)) {
                // Redireccionar a la página de perfil del usuario con un mensaje de éxito
                header("Location: index.php?ctl=perfilUsuario");
                exit;
            } else {
                // Mostrar un mensaje de error si no se pudo actualizar
                echo "Error al actualizar el perfil.";
            }
        }

        // Extraer los datos del usuario
        $nombre = $usuario['nombre'];
        $apellidos = $usuario['apellidos'];
        $telefono = $usuario['telefono'];
        $ciudad = $usuario['ciudad'];
        $pais = $usuario['pais'];
        $email = $usuario['email'];
        $password = $usuario['password'];
        $direccion = $usuario['direccion'];
        $codigo_postal = $usuario['codigo_postal'];
        $tipo_usuario = $usuario['tipo_usuario'];
        $foto_perfil = $usuario['foto_perfil'];

        // Incluir el archivo de la vista verPerfil.php y pasar los datos del usuario a la misma
        include __DIR__ . '/../../web/templates/verPerfil.php';
    } else {
        echo "Error: Usuario no encontrado.";
    }
} else {
    header("Location: index.php?ctl=inicioSesion");
    exit;
}
}


public function perfilUsuario() {
   // Obtener los datos del usuario con la foto de perfil
   $consultas = new Consultas();
   $id_usuario = $_SESSION['id_usuario'];
    $usuario = $consultas->obtenerUsuarioConFotoPorId($id_usuario);

// Verificar si se encontró al usuario
if ($usuario) {
    // Asignar los datos del usuario para ser mostrados en la vista
    $nombre = htmlspecialchars($usuario['nombre']);
    $apellidos = htmlspecialchars($usuario['apellidos']);
    $telefono = htmlspecialchars($usuario['telefono']);
    $ciudad = htmlspecialchars($usuario['ciudad']);
    $pais = htmlspecialchars($usuario['pais']);
    $email = htmlspecialchars($usuario['email']);
    $direccion = htmlspecialchars($usuario['direccion']);
    $codigo_postal = htmlspecialchars($usuario['codigo_postal']);
    $tipo_usuario = htmlspecialchars($usuario['tipo_usuario']);
    $fecha_alta = htmlspecialchars($usuario['fecha_alta']);

    // Construir la ruta de la foto de perfil
    $ruta_foto_perfil = '/archivos/img/usuario/' . htmlspecialchars($usuario['foto_perfil']);

    // Incluir el archivo de la vista perfil_usuario.php y pasar los datos del usuario a la misma
    include __DIR__ . '/../../web/templates/perfil_usuario.php';
} else {
    echo "Error: Usuario no encontrado.";
}

}





public function visualizarProductos(){
    // Crear una instancia de la clase Consultas
    $consultas = new Consultas();

    // Obtener los productos de la base de datos
    $productos = $consultas->obtenerProductos();
    include __DIR__ . '/../../web/templates/producto_cliente.php';
}

 
public function producto(){
    // Crear una instancia de la clase Consultas
    $consultas = new Consultas();


    include __DIR__ . '/../../web/templates/producto.php';
}

public function verCesta(){
    // Verificar si se pasa el ID del producto como parámetro
    if(isset($_GET['id_producto'])){
        // Obtener el ID del producto de la URL
        $id_producto = $_GET['id_producto'];
        
        // Crear una instancia de la clase Consultas
        $consultas = new Consultas();
        
        // Insertar el producto en la cesta
        if(empty($_SESSION['id_usuario'])){
            header("Location: index.php?ctl=inicioSesion");
            exit;
        } else {
            $id_usuario = $_SESSION['id_usuario']; // Obtener el ID del usuario de la sesión
        }
       
        $cantidad = 1; // Cantidad por defecto
        if($consultas->agregarProductoACesta($id_usuario, $id_producto, $cantidad)) {
            echo "Producto agregado a la cesta correctamente.";
        } else {
            echo "Error al agregar el producto a la cesta.";
        }
    } else {
        // Manejar el caso en que no se pase el ID del producto como parámetro
        echo "ID del producto no especificado.";
    }
}

public function verCesta2(){
    // Verificar si hay una sesión iniciada y obtener el ID de usuario
    if(isset($_SESSION['id_usuario'])){
        $id_usuario = $_SESSION['id_usuario'];
        
        // Crear una instancia de la clase Consultas
        $consultas = new Consultas();
        
        // Obtener los productos de la cesta del usuario
        $productos_cesta = $consultas->obtenerProductosEnCesta($id_usuario);
        
        // Incluir la plantilla cesta_compra.php y pasar los productos a la misma
        include __DIR__ . '/../../web/templates/cesta_compra.php';
    } else {
        // Si no hay una sesión iniciada, redirigir al usuario a la página de inicio de sesión
        header("Location: index.php?ctl=inicioSesion");
        exit;
    }
}

public function pago() {
    if(isset($_POST['bAceptar'])) {
        // Obtener los datos del formulario de pago
        $nombreTarjeta = $_POST['nombre'];
        $numeroTarjeta = $_POST['numero_tarjeta'];
        $fechaExpiracion = $_POST['fecha_exp'];
        $cvv = $_POST['cvv'];
        $direccionFacturacion = $_POST['ciudad'];
        $codigoPostal = $_POST['codigo_postal'];
    
        // Validar datos del formulario
        if(empty($nombreTarjeta) || empty($numeroTarjeta) || empty($fechaExpiracion) || empty($cvv) || empty($direccionFacturacion) || empty($codigoPostal)) {
            echo"Por favor, complete todos los campos del formulario de pago.";
            return;
        }
    
        // Simular el procesamiento del pago (aquí deberías agregar la lógica real de procesamiento de pago)
        $pagoExitoso = true;
    
        if($pagoExitoso) {
            // Obtener el ID del usuario de la sesión
            if(isset($_SESSION['id_usuario'])) {
                $id_usuario = $_SESSION['id_usuario'];
    
                // Crear instancias de las clases de consultas
               
    
                // Obtener detalles del usuario y productos en la cesta
                $consulta=new Consultas();
                $usuario =  $consulta->obtenerUsuarioPorId($id_usuario);
                $productos_cesta =  $consulta->obtenerProductosEnCesta($id_usuario);
    
                // Calcular el total de la cesta con el 21% de IVA
                $totalCesta = 0;
                foreach ($productos_cesta as $producto) {
                    $totalCesta += $producto['precio'];
                }
                $iva = $totalCesta * 0.21;
                $totalConIva = $totalCesta + $iva;
    
                // Registrar el pedido
                $pedido_id = $consulta->registrarPedido($id_usuario, $totalConIva);
    
                // Generar la factura
                if($pedido_id !== false) {
                    $facturaGenerada = $consulta->generarFactura($pedido_id, $id_usuario, $productos_cesta, $totalConIva);

                    if($facturaGenerada) {
                        // Eliminar productos de la cesta después de generar la factura
                        // Aquí deberías agregar el código para eliminar productos de la cesta
                        // por ejemplo: $consultasProductos->eliminarProductosEnCesta($id_usuario);
    
                        // Mostrar mensaje de pago exitoso con detalles de la factura
                      echo "Pago exitoso.\n\nDetalles de la factura:\nTotal: $totalConIva (IVA incluido)\nIVA (21%): $iva";
                    } else {
                        echo"Error al generar la factura.";
                    }
                } else {
                    echo"Error al registrar el pedido.";
                }
            } else {
                echo"Error: Usuario no identificado.";
            }
        } else {
           echo"Error en el procesamiento del pago.";
        }
    }
    include __DIR__ . '/../../web/templates/pago.php';

  
 
}

public function gestionPedidos()
{
    include __DIR__ . '/../../web/templates/gestionPedidos.php';
}



public function eliminarPedido()
{
    if (isset($_POST['bAceptarEliminar'])) {
        // Obtener el ID del pedido a eliminar
        $pedido_id = $_POST['pedido_id'];

        // Eliminar el pedido de la base de datos
        $consultas = new Consultas(); // Instancia de la clase Consultas
        $exito = $consultas->eliminarPedido($pedido_id);

        if ($exito) {
            // Redirigir o mostrar un mensaje de éxito
            header('Location: index.php?ctl=gestionPedidos');
            exit();
        } else {
            echo "Error al eliminar el pedido.";
        }
    }
}


public function editarPedido()
{
    if (isset($_POST['bAceptarEditar'])) {
        // Obtener datos del formulario
        $pedido_id = $_POST['pedido_id'];
        $nuevo_estado = $_POST['nuevo_estado'];
        $transportista = $_POST['transportista'];
        $metodo_pago = $_POST['metodo_pago'];

        // Validar que el nuevo estado sea uno de los valores permitidos
        $estadosPermitidos = ['pendiente', 'enviado', 'entregado', 'cancelado'];
        if (!in_array($nuevo_estado, $estadosPermitidos)) {
            echo "Error: Estado de pedido no válido.";
            return;
        }

        // Obtener datos adicionales de la factura asociada al pedido
        $consultas = new Consultas();
        $factura = $consultas->obtenerFacturaPorPedido($pedido_id);
        $transportista_factura = $factura['transportista'];
        $metodo_pago_factura = $factura['metodo_pago'];

        // Actualizar el pedido en la base de datos
        $exito = $consultas->editarPedido($pedido_id, $nuevo_estado, $transportista, $metodo_pago);

        if ($exito) {
            // Redirigir o mostrar un mensaje de éxito
            header('Location: index.php?ctl=gestionPedidos');
            exit();
        } else {
            echo "Error al editar el pedido.";
        }
    }
}
public function verPedidosPorCliente()
{
    if (isset($_POST['verPedidosCliente'])) {
        // Obtener el ID del cliente ingresado en el formulario
        $cliente_id = $_POST['cliente_id'];

        // Consultar la base de datos para obtener los pedidos del cliente
        $consultas = new Consultas();
        $pedidosCliente = $consultas->obtenerPedidosPorCliente($cliente_id);

        // Pasar los datos a la vista
        include __DIR__ . '/../../web/templates/gestionPedidos.php';
    }
}

public function gestionUsuarios(){
    $consulta = new Consultas();
    $usuario = null; // Initialize $usuario variable

    // Verificar si se está realizando una búsqueda
    if(isset($_POST['bBuscar'])){
        // Obtener el ID del usuario a buscar
        $id_usuario = $_POST['id_usuario'];

        // Realizar la búsqueda del usuario por su ID
        $usuario = $consulta->buscarUsuarioPorId($id_usuario);
    } else {
        if(isset($_POST['bListar'])){
            // Call the listarTodosLosUsuarios() function from the Consultas class
            $usuarios = $consulta->listarTodosLosUsuarios();
        }
    }

    include __DIR__ . '/../../web/templates/gestionUsuarios.php';
}


public function contactanos(){
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['bAceptar'])) {
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $mensaje = $_POST['mensaje'];

        if (!empty($nombre) && !empty($email) && !empty($mensaje)) {
            $consultas = new Consultas();
            if ($consultas->insertarMensaje($nombre, $email, $mensaje)) {
                $mensaje_exito = "Tu mensaje ha sido enviado con éxito.";
            } else {
                $mensaje_error = "Error al enviar el mensaje. Por favor, intenta nuevamente.";
            }
        } else {
            $mensaje_error = "Todos los campos son obligatorios.";
        }
    }

    include __DIR__ . '/../../web/templates/contactanos.php';
}
function responder() {
    if (isset($_GET['id'])) {
        $idMensaje = $_GET['id'];
        $consultas = new Consultas();
        $mensaje = $consultas->obtenerMensajePorId($idMensaje); // Método para obtener un mensaje por su ID

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bEnviar'])) {
            $respuesta = $_POST['respuesta'];
            if (!empty($respuesta)) {
                // Insertar respuesta en la base de datos
                if ($consultas->insertarRespuesta($idMensaje, $respuesta)) {
                    $mensaje_exito = "Respuesta enviada correctamente.";
                } else {
                    $mensaje_error = "Error al enviar la respuesta.";
                }
            } else {
                $mensaje_error = "Por favor, escribe una respuesta.";
            }
        }

        include __DIR__ . '/../../web/templates/responder.php'; // Vista para responder al mensaje
    } else {
        // Manejo de error si no se proporciona ID válido
        echo "ID de mensaje no válido.";
    }
}

function verMensajes() {
    $consultas = new Consultas();
    $mensajes = $consultas->obtenerMensajes(); // Método para obtener todos los mensajes

    include __DIR__ . '/../../web/templates/ver_mensajes.php'; // Vista para mostrar los mensajes
}




public function error() {
        // Error handling logic here
        echo "404 - Contorlador not found";
    }



}
    


