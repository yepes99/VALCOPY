<?php include __DIR__ . '/layout.php'; ?>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <img src="path_to_profile_picture.jpg" class="card-img-top" alt="Foto de Perfil">
               
            </div>
        </div>
        <div class="col-md-8">
            <h3>Detalles del Perfil</h3>
            <table class="table">
                <tbody>
                    <tr>
                        <th>Nombre:</th>
                        <td id="nombre_completo_usuario"><?php echo htmlspecialchars($nombre) . ' ' . htmlspecialchars($apellidos); ?></td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td id="email_usuario_detalles"><?php echo htmlspecialchars($email); ?></td>
                    </tr>
                    <tr>
                        <th>Teléfono:</th>
                        <td id="telefono_usuario_detalles"><?php echo htmlspecialchars($telefono); ?></td>
                    </tr>
                    <tr>
                        <th>Dirección:</th>
                        <td id="direccion_usuario_detalles"><?php echo htmlspecialchars($direccion); ?></td>
                    </tr>
                    <tr>
                        <th>Ciudad:</th>
                        <td id="ciudad_usuario_detalles"><?php echo htmlspecialchars($ciudad); ?></td>
                    </tr>
                    <tr>
                        <th>Código Postal:</th>
                        <td id="codigo_postal_usuario"><?php echo htmlspecialchars($codigo_postal); ?></td>
                    </tr>
                    <tr>
                        <th>País:</th>
                        <td id="pais_usuario_detalles"><?php echo htmlspecialchars($pais); ?></td>
                    </tr>
                    <tr>
                        <th>Tipo de Usuario:</th>
                        <td id="tipo_usuario"><?php echo htmlspecialchars($tipo_usuario); ?></td>
                    </tr>
                    <tr>
                        <th>Fecha de Alta:</th>
                        <td id="fecha_alta_usuario"><?php echo htmlspecialchars($fecha_alta); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
