<?php include('./templates/layout.php'); ?>

<?php
// Simulación de datos del producto (reemplazar con la consulta real a la base de datos)
$producto = array(
    'id_producto' => 1,
    'nombre' => 'Producto de ejemplo',
    'descripcion' => 'Descripción del producto de ejemplo',
    'categoria' => 'Categoría del producto',
    'precio' => 99.99,
    'disponibilidad' => 'disponible',
    'medidas' => 'Medidas del producto',
    'imagen' => 'imagen_ejemplo.jpg' // Ruta de la imagen del producto
);

// Consulta simulada para obtener información adicional del producto
// Aquí se podría hacer una consulta real a la base de datos para obtener más detalles del producto
?>

<div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <img src="../app/archivos/img/productos_imagenes/<?php echo $producto['imagen']; ?>" class="card-img-top" alt="<?php echo $producto['nombre']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $producto['nombre']; ?></h5>
                        <p class="card-text"><?php echo $producto['descripcion']; ?></p>
                        <p class="card-text"><strong>Categoría:</strong> <?php echo $producto['categoria']; ?></p>
                        <p class="card-text"><strong>Precio:</strong> $<?php echo $producto['precio']; ?></p>
                        <p class="card-text"><strong>Disponibilidad:</strong> <?php echo ucfirst($producto['disponibilidad']); ?></p>
                        <p class="card-text"><strong>Medidas:</strong> <?php echo $producto['medidas']; ?></p>
                        <button class="btn btn-primary">Añadir a Favoritos</button>
                        <button class="btn btn-success">Añadir a la Cesta</button>
                    </div>
                </div>
            </div>
        </div>
    </div>