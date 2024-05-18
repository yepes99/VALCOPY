<?php include __DIR__ . '/layout.php'; ?>

<div class="container">
    <h2>Mensajes Recibidos</h2>
    <div class="row">
        <?php foreach ($mensajes as $mensaje): ?>
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($mensaje['nombre']) ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?= htmlspecialchars($mensaje['email']) ?></h6>
                        <p class="card-text"><?= htmlspecialchars($mensaje['mensaje']) ?></p>
                        <a href="index.php?ctl=responder&id=<?= $mensaje['id'] ?>" class="card-link">Responder</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
