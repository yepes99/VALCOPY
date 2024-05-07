<?php include('./templates/layout.php'); ?>

<div class="container mt-5">
    <h1 class="mb-4">Lista de Productos</h1>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Categoría</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Disponibilidad</th>
                    <th scope="col">Medidas</th>
                    <th scope="col">Imagen</th>
                </tr>
            </thead>
            <tbody>
                <!-- Iteración de productos -->
                <?php foreach ($productos as $producto): ?>
                    <tr>
                        <td><?= $producto['id_producto'] ?></td>
                        <td><?= $producto['nombre'] ?></td>
                        <td><?= $producto['descripcion'] ?></td>
                        <td><?= $producto['categoria'] ?></td>
                        <td><?= $producto['precio'] ?></td>
                        <td><?= $producto['disponibilidad'] ?></td>
                        <td><?= $producto['medidas'] ?></td>
                        <td>
                            <img src="<?= $producto['imagen'] ?>" alt="Imagen de producto" style="max-width: 100px; max-height: 100px;">
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
