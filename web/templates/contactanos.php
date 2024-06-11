<?php include __DIR__ . '/../../web/templates/layout.php'; ?>

<div class="container">
    <h2>Contáctanos</h2>
    <?php if (isset($mensaje_exito)): ?>
        <div class="alert alert-success" role="alert">
            <?= $mensaje_exito ?>
        </div>
    <?php elseif (isset($mensaje_error)): ?>
        <div class="alert alert-danger" role="alert">
            <?= $mensaje_error ?>
        </div>
    <?php endif; ?>

    <form action="index.php?ctl=contactanos" method="POST">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="mensaje">Mensaje:</label>
            <textarea class="form-control" id="mensaje" name="mensaje" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-2" name="bAceptar">Enviar</button>
    </form>
</div>
