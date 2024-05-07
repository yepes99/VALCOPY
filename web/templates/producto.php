<?php
// Incluir el archivo de diseño/layout
include('./templates/layout.php');

// Verificar si se proporciona un ID de producto en la URL
if (isset($_GET['id_producto'])) {
    // Obtener el ID del producto de la URL
    $idProducto = $_GET['id_producto'];

    // Crear una instancia de la clase Consultas
    $consultas = new Consultas();

    // Obtener la información del producto utilizando la consulta de la clase Consultas
    $producto = $consultas->obtenerProductoPorId($idProducto);

    // Verificar si se encontró el producto
    if ($producto) {
        // Mostrar los detalles del producto
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
        <?php
    } else {
        // Si no se encuentra el producto, mostrar un mensaje de error o redirigir al usuario
        echo "El producto no se encontró.";
    }
} else {
    // Si no se proporciona un ID de producto válido en la URL, redirigir al usuario a otra página o mostrar un mensaje de error
    header("Location: index.php"); // Redirigir al inicio o a otra página de error
    exit; // Finalizar la ejecución del script
}
?>
