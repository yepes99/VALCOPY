<?php include __DIR__ . '/../../web/templates/layout.php'; ?>

<div class="container">
    <h2>Buscar y Editar Usuario</h2>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">Buscar Usuario</div>
                <div class="card-body">
                    <form action="index.php?ctl=gestionUsuarios" method="POST">
                        <div class="form-group">
                            <label for="id_usuario">ID del Usuario:</label>
                            <input type="text" class="form-control" id="id_usuario" name="id_usuario" required>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3" name="bBuscar">Buscar Usuario</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">Listar Todos los Usuarios</div>
                <div class="card-body">
                    <form action="index.php?ctl=gestionUsuarios" method="POST">
                        <button type="submit" class="btn btn-primary" name="bListar">Listar Todos los Usuarios</button>
                    </form>
                    <?php if (isset($usuarios) && is_array($usuarios)) : ?>
                        <table class="table mt-3">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre de Usuario</th>
                                    <th>Nombre</th>
                                    <th>Apellidos</th>
                                    <th>Email</th>
                                    <!-- Agregar aquí más encabezados si es necesario -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($usuarios as $usuario) : ?>
                                    <tr>
                                        <td><?= $usuario['id_usuario'] ?></td>
                                        <td><?= $usuario['user'] ?></td>
                                        <td><?= $usuario['nombre'] ?></td>
                                        <td><?= $usuario['apellidos'] ?></td>
                                        <td><?= $usuario['email'] ?></td>
                                        <!-- Agregar aquí más campos si es necesario -->
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No hay usuarios para mostrar.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php if ($usuario) : ?>
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">Información del Usuario</div>
                    <div class="card-body">
                        <p>ID: <?= $usuario['id_usuario'] ?></p>
                        <p>Nombre de usuario: <?= $usuario['user'] ?></p>
                        <p>Nombre: <?= $usuario['nombre'] ?></p>
                        <p>Apellidos: <?= $usuario['apellidos'] ?></p>
                        <p>Email: <?= $usuario['email'] ?></p>
                        <!-- Agregar aquí más campos si es necesario -->
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
