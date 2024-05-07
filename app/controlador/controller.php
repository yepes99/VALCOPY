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
    // Verificar si hay una sesión iniciada
    session_start();

    // Verificar si el usuario está autenticado
    if (isset($_SESSION['id_usuario'])) {
        // Obtener el ID del usuario de la sesión
        $id_usuario = $_SESSION['id_usuario'];

        // Crear una instancia de Consultas
        $consulta = new Consultas();

        // Obtener los datos del usuario desde la base de datos
        $usuario = $consulta->obtenerUsuarioPorId($id_usuario);

        // Verificar si se encontró el usuario
        if ($usuario) {
            // Asignar los datos del usuario a variables
            $user = $usuario['user'];
            $nombre = $usuario['nombre'];
            $apellidos = $usuario['apellidos'];
            $organizacion = $usuario['organizacion'];
            $ciudad = $usuario['ciudad'];
            $pais = $usuario['pais'];
            $email = $usuario['email'];
            $telefono = $usuario['telefono'];
            $fecha_nacimiento = $usuario['fecha_nacimiento'];
            
            // Incluir la vista para mostrar el perfil del usuario
            include __DIR__ . '/../../web/templates/verPerfil.php';
        } else {
            // En caso de que no se encuentre el usuario, redirigir a una página de error o manejar de otra manera
            echo "Usuario no encontrado.";
            
        }
    } else {
        // Si el usuario no está autenticado, redirigir a la página de inicio de sesión o manejar de otra manera
        echo "Usuario no autenticado.";
        header("Location: index.php?ctl=inicio");
        exit;
    }
}

public function visualizarProductos(){
    // Crear una instancia de la clase Consultas
    $consultas = new Consultas();

    // Obtener los productos de la base de datos
    $productos = $consultas->obtenerProductos();
    include __DIR__ . '/../../web/templates/producto_cliente.php';
}

 public function error() {
        // Error handling logic here
        echo "404 - Contorlador not found";
    }

}
    


