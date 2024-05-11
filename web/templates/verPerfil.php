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

<!-- Mostrar los datos actuales del usuario -->
<p>Nombre de Usuario: <?php echo $user; ?></p>
<p>Nombre: <?php echo $nombre; ?></p>
<p>Apellidos: <?php echo $apellidos; ?></p>
<p>Número de Teléfono: <?php echo $telefono; ?></p>
<p>Ciudad: <?php echo $ciudad; ?></p>
<p>País: <?php echo $pais; ?></p>
<p>Correo Electrónico: <?php echo $email; ?></p>

<!-- Formulario para actualizar el perfil -->
<form action="index.php?ctl=verPerfil" method="POST">
    <label for="inputUsername">Nombre de Usuario:</label><br>
    <input type="text" id="inputUsername" name="user" value="<?php echo $user; ?>"><br><br>
    
    <label for="inputFirstName">Nombre:</label><br>
    <input type="text" id="inputFirstName" name="nombre" value="<?php echo $nombre; ?>"><br><br>
    
    <label for="inputLastName">Apellidos:</label><br>
    <input type="text" id="inputLastName" name="apellidos" value="<?php echo $apellidos; ?>"><br><br>
    
    <label for="inputPhone">Número de Teléfono:</label><br>
    <input type="tel" id="inputPhone" name="telefono" value="<?php echo $telefono; ?>"><br><br>
    
    <label for="inputCity">Ciudad:</label><br>
    <input type="text" id="inputCity" name="ciudad" value="<?php echo $ciudad; ?>"><br><br>
    
    <label for="inputCountry">País:</label><br>
    <input type="text" id="inputCountry" name="pais" value="<?php echo $pais; ?>"><br><br>
    
    <label for="inputEmail">Correo Electrónico:</label><br>
    <input type="email" id="inputEmail" name="email" value="<?php echo $email; ?>"><br><br>
    
    <input type="submit" value="Actualizar Datos" name="bAceptar">
</form>
