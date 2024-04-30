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
        $consulta=new Consultas();
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
            } else if (!filter_var($params["email"], FILTER_VALIDATE_EMAIL)) {
                $params["mensaje"][] = "El correo electrónico ingresado no es válido.";
            } else {
                // Verificar si el correo electrónico ya existe en la base de datos
                $consulta = new Consultas();
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

            // Si no hay mensajes de error, proceder con el registro
            if (empty($params["mensaje"])) {
                // Aquí puedes insertar el código para guardar el usuario en la base de datos
                // y cualquier otra acción que necesites realizar al completar el registro
                // Puedes usar la clase Consultas para interactuar con la base de datos

                // Ejemplo de inserción en la base de datos
                $consulta->insertarUsuario($params);

                // También puedes redirigir al usuario a otra página después de completar el registro
                // header("Location: otra_pagina.php");
                // exit;
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


