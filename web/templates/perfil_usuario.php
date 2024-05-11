<div class="container">
        <h1>Perfil de Usuario</h1>
        <?php if(isset($nombre) && isset($apellidos) && isset($telefono) && isset($ciudad) && isset($pais) && isset($email) && isset($direccion) && isset($codigo_postal)): ?>
            <h2>Datos Actualizados</h2>
            <ul>
                <li>Nombre: <?php echo $nombre; ?></li>
                <li>Apellidos: <?php echo $apellidos; ?></li>
                <li>Teléfono: <?php echo $telefono; ?></li>
                <li>Ciudad: <?php echo $ciudad; ?></li>
                <li>País: <?php echo $pais; ?></li>
                <li>Correo Electrónico: <?php echo $email; ?></li>
                <li>Dirección: <?php echo $direccion; ?></li>
                <li>Código Postal: <?php echo $codigo_postal; ?></li>
            </ul>
            <p>¿Son estos datos correctos?</p>
            <p>Si los datos son correctos, puedes continuar navegando en el sitio. Si deseas actualizarlos, haz clic en el siguiente botón:</p>
            <a href="index.php?ctl=verPerfil" class="btn btn-primary">Actualizar Datos</a>
        <?php else: ?>
            <p>No se han encontrado datos de usuario.</p>
        <?php endif; ?>
    </div>