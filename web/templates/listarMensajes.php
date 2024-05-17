<?php include __DIR__ . '/../../web/templates/layout.php'; ?>

<div class="container">
    <h2>Mensajes Recibidos</h2>
    <?php if (isset($mensaje_exito)): ?>
        <div class="alert alert-success" role="alert">
            <?= $mensaje_exito ?>
        </div>
    <?php elseif (isset($mensaje_error)): ?>
        <div class="alert alert-danger" role="alert">
            <?= $mensaje_error ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($mensajes)): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Mensaje</th>
                    <th>Fecha</th>
                    <th>Respondido</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($mensajes as $mensaje): ?>
                    <tr>
                        <td><?= $mensaje['id'] ?></td>
                        <td><?= $mensaje['nombre'] ?></td>
                        <td><?= $mensaje['email'] ?></td>
                        <td><?= $mensaje['mensaje'] ?></td>
                        <td><?= $mensaje['fecha'] ?></td>
                        <td><?= $mensaje['respondido'] ? 'Sí' : 'No' ?></td>
                        <td>
                            <?php if (!$mensaje['respondido']): ?>
                                <form action="index.php?ctl=responderMensaje" method="POST">
                                    <input type="hidden" name="mensaje_id" value="<?= $mensaje['id'] ?>">
                                    <div class="form-group">
                                        <textarea class="form-control" name="respuesta" rows="2" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="bResponder">Responder</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay mensajes recibidos.</p>
    <?php endif; ?>
</div>
