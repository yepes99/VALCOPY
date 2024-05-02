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

}
    


