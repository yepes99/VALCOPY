<?php include('./templates/layout.php'); ?>

<section id="wrapper">
    <div class="container rounded bg-light p-5 mt-5">
        <h1 class="mt-5">Agregar Nueva Categoría</h1>
        <form method="POST" action="index.php?ctl=agregarCategoria">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre de la categoría</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <button type="submit" class="btn btn-primary" name="bAceptar">Agregar Categoría</button>
        </form>
    </div>
</section>
