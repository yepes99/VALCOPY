<?php include __DIR__ . '/layout.php'; ?>

<div class="container">
    <h2>Responder Mensaje</h2>
    <?php if (isset($mensaje_exito)): ?>
        <div class="alert alert-success" role="alert">
            <?= $mensaje_exito ?>
        </div>
    <?php elseif (isset($mensaje_error)): ?>
        <div class="alert alert-danger" role="alert">
            <?= $mensaje_error ?>
        </div>
    <?php endif; ?>

    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($mensaje['nombre']) ?></h5>
            <h6 class="card-subtitle mb-2 text-muted"><?= htmlspecialchars($mensaje['email']) ?></h6>
            <p class="card-text"><?= htmlspecialchars($mensaje['mensaje']) ?></p>
        </div>
    </div>

    <form action="index.php?ctl=responder&id=<?= $mensaje['id'] ?>" method="POST">
        <div class="form-group">
            <label for="respuesta">Respuesta:</label>
            <textarea class="form-control" id="respuesta" name="respuesta" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-3" name="bEnviar">Enviar Respuesta</button>
    </form>
</div>
