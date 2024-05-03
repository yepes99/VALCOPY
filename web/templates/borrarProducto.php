<?php include('./templates/layout.php'); ?>
<div class="container rounded bg-light p-5 mt-5">
    <h1 class="mt-5">Borrar Producto</h1>
    <form id="deleteProductForm" action="index.php?ctl=borrarProducto" method="post">
        <div class="mb-3">
            <label for="id_producto" class="form-label">ID del Producto a Borrar</label>
            <input type="number" class="form-control" id="id_producto" name="id_producto" required>
        </div>
        <input type="submit" class="btn btn-danger btn-block" value="Borrar Producto" name="bBorrar"></input>
    </form>
</div>
