<?php
include __DIR__ . '/layout.php';

// Verificar si hay una sesión iniciada y obtener el ID de usuario
if (isset($_SESSION['id_usuario'])) {
    $consultas = new Consultas();
    $id_usuario = $_SESSION['id_usuario'];

    // Obtener los datos del usuario con la foto de perfil
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
        $ruta_foto_perfil = '/../../app/archivos/img/usuario/' . htmlspecialchars($usuario['foto_perfil']);
    } else {
        echo "Error: Usuario no encontrado.";
        exit; // Salir del script si el usuario no se encuentra
    }
} else {
    header("Location: index.php?ctl=inicioSesion");
    exit; // Redirigir si no hay sesión iniciada
}
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <?php echo $ruta_foto_perfil?>
                <?php if (!empty($ruta_foto_perfil)): ?>
                    <img src="<?php $ruta_foto_perfil ?>" class="card-img-top" alt="Foto de Perfil">
                <?php else: ?>
                    <img src="ruta_por_defecto.jpg" class="card-img-top" alt="Foto de Perfil por Defecto">
                <?php endif; ?>
            </div>
        </div>
        <div class="col-md-8">
            <h3>Detalles del Perfil</h3>
            <table class="table">
                <tbody>
                    <tr>
                        <th>Nombre:</th>
                        <td><?php echo htmlspecialchars($nombre) . ' ' . htmlspecialchars($apellidos); ?></td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td><?php echo htmlspecialchars($email); ?></td>
                    </tr>
                    <tr>
                        <th>Teléfono:</th>
                        <td><?php echo htmlspecialchars($telefono); ?></td>
                    </tr>
                    <tr>
                        <th>Dirección:</th>
                        <td><?php echo htmlspecialchars($direccion); ?></td>
                    </tr>
                    <tr>
                        <th>Ciudad:</th>
                        <td><?php echo htmlspecialchars($ciudad); ?></td>
                    </tr>
                    <tr>
                        <th>Código Postal:</th>
                        <td><?php echo htmlspecialchars($codigo_postal); ?></td>
                    </tr>
                    <tr>
                        <th>País:</th>
                        <td><?php echo htmlspecialchars($pais); ?></td>
                    </tr>
                    <tr>
                        <th>Tipo de Usuario:</th>
                        <td><?php echo htmlspecialchars($tipo_usuario); ?></td>
                    </tr>
                    <tr>
                        <th>Fecha de Alta:</th>
                        <td><?php echo htmlspecialchars($fecha_alta); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
