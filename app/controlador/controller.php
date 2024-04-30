<?php

require __DIR__ . '/../composer/vendor/autoload.php';

require __DIR__ . '/../composer/vendor/phpmailer/phpmailer/src/Exception.php';
require __DIR__ . '/../composer/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require __DIR__ . '/../composer/vendor/phpmailer/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Controller
{



   // Dentro de la función registro del controlador Controller
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
        // Validar campos y realizar operaciones de inserción...

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

   

    


}


