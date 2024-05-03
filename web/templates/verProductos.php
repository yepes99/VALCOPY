<?php include('./templates/layout.php'); ?>
<div class="container mt-5">
        <h1 class="mb-4">Lista de Productos</h1>
        <table class="table">
            <thead>
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
                <!-- Aquí se deben iterar los productos y mostrarlos en la tabla -->
                <?php
                // Reemplaza esto con tu lógica para obtener y mostrar los productos
                foreach ($productos as $producto) {
                    echo "<tr>";
                    echo "<td>{$producto['id_producto']}</td>";
                    echo "<td>{$producto['nombre']}</td>";
                    echo "<td>{$producto['descripcion']}</td>";
                    echo "<td>{$producto['categoria']}</td>";
                    echo "<td>{$producto['precio']}</td>";
                    echo "<td>{$producto['disponibilidad']}</td>";
                    echo "<td>{$producto['medidas']}</td>";
                    echo "<td>{$producto['imagen']}</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>