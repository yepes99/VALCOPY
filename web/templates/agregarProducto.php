<?php include('./templates/layout.php'); ?>

<div class="container rounded bg-light p-5 mt-5">
    <h1 class="mt-5">Formulario de Producto</h1> 
    <form id="productForm" action="index.php?ctl=agregarProducto" method="post" enctype="multipart/form-data">


        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label for="categoria" class="form-label">Categoría</label>
            <select class="form-select" id="categoria" name="categoria" required>
                <option selected disabled value="">Selecciona una categoría</option>
                <?php
              
                $consulta = new Consultas();
                $categorias = $consulta->obtenerCategorias();

                // Ahora iteramos sobre las categorías para llenar las opciones del select
                foreach ($categorias as $categoria) {
                    echo "<option value='" . $categoria['id_categoria'] . "'>" . $categoria['nombre'] . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input type="number" class="form-control" id="precio" name="precio" step="0.01" required>
        </div>
        <div class="mb-3">
            <label for="disponibilidad" class="form-label">Disponibilidad</label>
            <select class="form-select" id="disponibilidad" name="disponibilidad" required>
                <option selected disabled value="">Selecciona la disponibilidad</option>
                <option value="disponible">Disponible</option>
                <option value="agotado">Agotado</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="medidas" class="form-label">Medidas</label>
            <input type="text" class="form-control" id="medidas" name="medidas">
        </div>
        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen</label>
            <input type="file" class="form-control" id="imagen" name="imagen">
        </div>
        <input type="submit" class="btn btn-primary btn-block" value="Enviar" name="bAceptar">
    </form>
</div>
