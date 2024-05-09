<?php
include('./templates/layout.php');

// Crear una instancia de la clase Consultas
$consultas = new Consultas();

// Obtener productos de cada categoría
$productos_categoria1 = $consultas->obtenerProductosPorCategoria(1);
$productos_categoria2 = $consultas->obtenerProductosPorCategoria(2);
$productos_categoria3 = $consultas->obtenerProductosPorCategoria(3);
?>

<script>
    // Función para mostrar solo los productos de la categoría seleccionada
    function mostrarProductosCategoria(categoria) {
        // Ocultar todos los productos
        var productos = document.querySelectorAll('.producto');
        productos.forEach(function(producto) {
            producto.style.display = 'none';
        });

        // Mostrar solo los productos de la categoría seleccionada
        var productosCategoria = document.querySelectorAll('.categoria-' + categoria);
        productosCategoria.forEach(function(productoCategoria) {
            productoCategoria.style.display = 'block';
        });
    }

    // Función para manejar el clic en el botón "Ver más"
    function verMas(idProducto) {
        // Simplemente redirige a la página de detalle del producto pasando el ID del producto como parámetro
        window.location.href = 'index.php?ctl=producto&id_producto=' + idProducto;
    }
    // Función para manejar el clic en el botón "Add to Cart"
    function addToCart(idProducto) {
        // Redirigir al controlador de la cesta (verCesta) pasando el ID del producto
        window.location.href = 'index.php?ctl=verCesta&id_producto=' + idProducto;
    }
</script>

<section>
    <div class="container py-5">
        <div class="row">
            <!-- Categorías -->
            <div class="col-md-12 col-lg-3 mb-4 mb-lg-0">
                <div class="list-group">
                    <!-- Enlaces de categoría -->
                    <a href="#" class="list-group-item list-group-item-action" onclick="mostrarProductosCategoria(1)">Categoria 1</a>
                    <a href="#" class="list-group-item list-group-item-action" onclick="mostrarProductosCategoria(2)">Categoria 2</a>
                    <a href="#" class="list-group-item list-group-item-action" onclick="mostrarProductosCategoria(3)">Categoria 3</a>
                </div>
            </div>
            <!-- Productos -->
            <div class="col-md-12 col-lg-9">
                <!-- Laptops -->
                <div class="row">
                    <?php
                    // Iterar sobre los productos de la categoría 1
                    foreach ($productos_categoria1 as $producto) {
                        ?>
                        <div class="col-md-12 col-lg-4 mb-4 mb-lg-0 mb-3 mt-4 mt-lg-4 producto categoria-1">
                            <div class="card">
                                <?php echo $producto['imagen']; ?>
                                <img src="../app/archivos/img/productos_imagenes/<?php echo $producto['imagen']; ?>" class="card-img-top" alt="<?php echo $producto['nombre']; ?>" />
                                <div class="card-body">
                                    <h5 class="mb-0"><?php echo $producto['nombre']; ?></h5>
                                    <h5 class="text-dark mb-0">$<?php echo $producto['precio']; ?></h5>
                                    <div class="d-flex justify-content-between ">
                                        <button class="btn btn-primary btn-sm m-2" onclick="verMas(<?php echo $producto['id_producto']; ?>)"><i class="fas fa-eye"></i> Ver más</button>
                                        <button class="btn btn-success btn-sm m-2" onclick="addToCart(<?php echo $producto['id_producto']; ?>)"><i class="fas fa-cart-plus"></i> Añadir al carro</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>

                    <?php
                    // Iterar sobre los productos de la categoría 2
                    foreach ($productos_categoria2 as $producto) {
                        ?>
                        <div class="col-md-12 col-lg-4 mb-4 mb-lg-0 mb-3 mt-4 mt-lg-4 producto categoria-2">
                            <div class="card">
                                <?php echo $producto['imagen']; ?>
                                <img src="../app/archivos/img/productos_imagenes/<?php echo $producto['imagen']; ?>" class="card-img-top" alt="<?php echo $producto['nombre']; ?>" />
                                <div class="card-body">
                                    <h5 class="mb-0"><?php echo $producto['nombre']; ?></h5>
                                    <h5 class="text-dark mb-0">$<?php echo $producto['precio']; ?></h5>
                                    <div class="d-flex justify-content-between ">
                                        <button class="btn btn-primary btn-sm m-2" onclick="verMas(<?php echo $producto['id_producto']; ?>)"><i class="fas fa-eye"></i> View Details</button>
                                        <button class="btn btn-success btn-sm m-2" onclick="addToCart(<?php echo $producto['id_producto']; ?>)"><i class="fas fa-cart-plus"></i> Añadir al carro</button>                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>

                    <?php
                    // Iterar sobre los productos de la categoría 3
                    foreach ($productos_categoria3 as $producto) {
                        ?>
                        <div class="col-md-12 col-lg-4 mb-4 mb-lg-0 mb-3 mt-4 mt-lg-4 producto categoria-3">
                            <div class="card">
                                <?php echo $producto['imagen']; ?>
                                <img src="../app/archivos/img/productos_imagenes/<?php echo $producto['imagen']; ?>" class="card-img-top" alt="<?php echo $producto['nombre']; ?>" />
                                <div class="card-body">
                                    <h5 class="mb-0"><?php echo $producto['nombre']; ?></h5>
                                    <h5 class="text-dark mb-0">$<?php echo $producto['precio']; ?></h5>
                                    <div class="d-flex justify-content-between ">
                                        <button class="btn btn-primary btn-sm m-2" onclick="verMas(<?php echo $producto['id_producto']; ?>)"><i class="fas fa-eye"></i> View Details</button>
                                        <button class="btn btn-success btn-sm m-2" onclick="addToCart(<?php echo $producto['id_producto']; ?>)"><i class="fas fa-cart-plus"></i> Añadir al carro</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>