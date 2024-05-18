<?php include('./templates/layout.php'); ?>

<?php
// Verificar si hay una sesión iniciada y obtener el ID de usuario
if (isset($_SESSION['id_usuario'])) {
    $id_usuario = $_SESSION['id_usuario'];
    
    // Crear una instancia de la clase Consultas
    $consultas = new Consultas();
    
    // Obtener los datos del usuario desde la base de datos
    $usuario = $consultas->obtenerUsuarioPorId($id_usuario);
    
    // Verificar si se encontró al usuario
    if ($usuario) {
        // Extraer los datos del usuario
        $user = $usuario['user'];
        $nombre = $usuario['nombre'];
        $apellidos = $usuario['apellidos'];
        $telefono = $usuario['telefono'];
        $ciudad = $usuario['ciudad'];
        $pais = $usuario['pais'];
        $email = $usuario['email'];
    } else {
        // Mostrar un mensaje de error si no se encontró al usuario
        echo "Error: Usuario no encontrado.";
        exit; // Salir del script
    }
} else {
    // Si no hay una sesión iniciada, redirigir al usuario a la página de inicio de sesión
    header("Location: index.php?ctl=inicioSesion");
    exit; // Salir del script
}
?>



<!-- Formulario para actualizar el perfil -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="index.php?ctl=verPerfil" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="inputUsername" class="form-label">Nombre de Usuario:</label>
                    <input type="text" id="inputUsername" name="user" class="form-control" value="<?php echo $user; ?>">
                </div>

                <div class="mb-3">
                    <label for="inputFirstName" class="form-label">Nombre:</label>
                    <input type="text" id="inputFirstName" name="nombre" class="form-control" value="<?php echo $nombre; ?>">
                </div>

                <div class="mb-3">
                    <label for="inputLastName" class="form-label">Apellidos:</label>
                    <input type="text" id="inputLastName" name="apellidos" class="form-control" value="<?php echo $apellidos; ?>">
                </div>

                <div class="mb-3">
                    <label for="inputPhone" class="form-label">Número de Teléfono:</label>
                    <input type="tel" id="inputPhone" name="telefono" class="form-control" value="<?php echo $telefono; ?>">
                </div>

                <div class="mb-3">
                    <label for="inputCity" class="form-label">Ciudad:</label>
                    <input type="text" id="inputCity" name="ciudad" class="form-control" value="<?php echo $ciudad; ?>">
                </div>

                <div class="mb-3">
                    <label for="inputCountry" class="form-label">País:</label>
                    <input type="text" id="inputCountry" name="pais" class="form-control" value="<?php echo $pais; ?>">
                </div>

                <div class="mb-3">
                    <label for="inputEmail" class="form-label">Correo Electrónico:</label>
                    <input type="email" id="inputEmail" name="email" class="form-control" value="<?php echo $email; ?>">
                </div>

                <div class="mb-3">
                    <label for="inputAddress" class="form-label">Dirección:</label>
                    <input type="text" id="inputAddress" name="direccion" class="form-control" value="<?php echo $direccion; ?>">
                </div>

                <div class="mb-3">
                    <label for="inputPostalCode" class="form-label">Código Postal:</label>
                    <input type="text" id="inputPostalCode" name="codigo_postal" class="form-control" value="<?php echo $codigo_postal; ?>">
                </div>

                <div class="mb-3">
                    <label for="inputProfilePicture" class="form-label">Foto de Perfil:</label>
                    <input type="file" id="inputProfilePicture" name="foto_perfil" class="form-control">
                    <?php if (!empty($foto_perfil)): ?>
                        <img src="path_to_uploads/<?php echo htmlspecialchars($foto_perfil); ?>" alt="Foto de Perfil Actual" class="img-thumbnail mt-2">
                    <?php endif; ?>
                </div>
             

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary" name="bAceptar">Actualizar Datos</button>
                </div>
            </form>
        </div>
    </div>
</div>