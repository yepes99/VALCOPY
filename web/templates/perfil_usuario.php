<?php
include __DIR__ . '/layout.php';

// Verificar si hay una sesión iniciada y obtener el id de usuario
if (isset($_SESSION['id_usuario'])) {
    $consultas = new Consultas();
    $id_usuario = $_SESSION['id_usuario'];

    // Obtener el email del usuario por su ID
    $email = $consultas->obtenerEmailPorIdUsuario($id_usuario);

    // Verificar si se encontró el email del usuario
    if ($email) {
        // Obtener los datos del usuario con el email
        $usuario = $consultas->obtenerUsuarioPorEmail($email);

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

            // Verificar si el usuario tiene una foto de perfil
            if (!empty($usuario['foto_perfil'])) {
               
                $ruta_foto_perfil = '../app/archivos/img/usuario/' . htmlspecialchars($usuario['foto_perfil']);
            } else {
                // Ruta de la imagen por defecto
                $ruta_foto_perfil = '../app/archivos/img/usuario/profile-icon-design-free-vector.jpg';
            }

            // Obtener mensajes del usuario por su email
            $mensajes = $consultas->obtenerMensajesPorUsuarioEmail($email);

            // Mostrar perfil del usuario
            echo '<div class="container mt-5">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <img src="' . $ruta_foto_perfil . '" class="card-img-top" alt="Foto de Perfil">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h3>Detalles del Perfil</h3>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>Nombre:</th>
                                        <td>' . $nombre . ' ' . $apellidos . '</td>
                                    </tr>
                                    <tr>
                                        <th>Email:</th>
                                        <td>' . $email . '</td>
                                    </tr>
                                    <tr>
                                        <th>Teléfono:</th>
                                        <td>' . $telefono . '</td>
                                    </tr>
                                    <tr>
                                        <th>Dirección:</th>
                                        <td>' . $direccion . '</td>
                                    </tr>
                                    <tr>
                                        <th>Ciudad:</th>
                                        <td>' . $ciudad . '</td>
                                    </tr>
                                    <tr>
                                        <th>Código Postal:</th>
                                        <td>' . $codigo_postal . '</td>
                                    </tr>
                                    <tr>
                                        <th>País:</th>
                                        <td>' . $pais . '</td>
                                    </tr>
                                    <tr>
                                        <th>Tipo de Usuario:</th>
                                        <td>' . $tipo_usuario . '</td>
                                    </tr>
                                    <tr>
                                        <th>Fecha de Alta:</th>
                                        <td>' . $fecha_alta . '</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>';

            // Mostrar mensajes y respuestas
            echo '<div class="container mt-5">
                    <div class="row">
                        <div class="col-md-12">
                            <h3>Mensajes y Respuestas</h3>';
            if (!empty($mensajes)) {
                foreach ($mensajes as $mensaje) {
                    echo '<div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Mensaje</h5>
                                <p class="card-text">' . htmlspecialchars($mensaje['mensaje']) . '</p>
                                <p class="card-text"><small class="text-muted">Enviado el: ' . htmlspecialchars($mensaje['fecha']) . '</small></p>';

                    // Obtener respuestas para este mensaje
                    $respuestas = $consultas->obtenerRespuestasPorIdMensaje($mensaje['id']);
                    if (!empty($respuestas)) {
                        echo '<h6>Respuestas:</h6>';
                        foreach ($respuestas as $respuesta) {
                            echo '<div class="card mb-2">
                                    <div class="card-body">
                                        <p class="card-text">' . htmlspecialchars($respuesta['respuesta']) . '</p>
                                        <p class="card-text"><small class="text-muted">Fecha: ' . htmlspecialchars($respuesta['fecha']) . '</small></p>
                                    </div>
                                </div>';
                        }
                    } else {
                        echo '<p>No hay respuestas para este mensaje.</p>';
                    }

                    echo '</div>
                        </div>';
                }
            } else {
                echo '<p>No hay mensajes disponibles.</p>';
            }
            echo '</div>
                </div>
            </div>';
        } else {
            echo "Error: Usuario no encontrado.";
            exit; // Salir del script si el usuario no se encuentra
        }
    } else {
        echo "Error: No se pudo obtener el email del usuario.";
        exit; // Salir del script si no se obtiene el email del usuario
    }
} else {
    echo "Error: No hay sesión iniciada.";
    exit; // Salir del script si no hay sesión iniciada
}
?>
