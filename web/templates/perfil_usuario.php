<?php include('./templates/layout.php'); ?>
<div class="container">
    <h1 class="mt-4">Perfil de Usuario</h1>
    <?php if(isset($nombre) && isset($apellidos) && isset($telefono) && isset($ciudad) && isset($pais) && isset($email) && isset($direccion) && isset($codigo_postal)): ?>
        <div class="card mt-4">
            <div class="card-body">
                <h2 class="card-title">Datos Actualizados</h2>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Nombre: <?php echo $nombre; ?></li>
                    <li class="list-group-item">Apellidos: <?php echo $apellidos; ?></li>
                    <li class="list-group-item">Teléfono: <?php echo $telefono; ?></li>
                    <li class="list-group-item">Ciudad: <?php echo $ciudad; ?></li>
                    <li class="list-group-item">País: <?php echo $pais; ?></li>
                    <li class="list-group-item">Correo Electrónico: <?php echo $email; ?></li>
                    <li class="list-group-item">Dirección: <?php echo $direccion; ?></li>
                    <li class="list-group-item">Código Postal: <?php echo $codigo_postal; ?></li>
                </ul>
                <p class="mt-4">¿Son estos datos correctos?</p>
                <p>Si los datos son correctos, puedes continuar navegando en el sitio. Si deseas actualizarlos, haz clic en el siguiente botón:</p>
                <a href="index.php?ctl=verPerfil" class="btn btn-primary">Actualizar Datos</a>
            </div>
        </div>
    <?php else: ?>
        <p class="mt-4">No se han encontrado datos de usuario.</p>
    <?php endif; ?>
</div>
