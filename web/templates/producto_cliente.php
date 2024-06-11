<?php

include('./templates/layout.php');

// Crear una instancia de la clase Consultas
$consultas = new Consultas();

// Obtener todas las categorías
$categorias = $consultas->obtenerCategorias();
$productos_por_categoria = [];

// Obtener productos de cada categoría
if (!empty($categorias)) {
    foreach ($categorias as $categoria) {
        $productos = $consultas->obtenerProductosPorCategoria($categoria['id_categoria']);
        if (!empty($productos)) {
            $productos_por_categoria[$categoria['id_categoria']] = $productos;
        }
    }
}
?>

<style>
    /* Estilos CSS para el mensaje de "Vaya!" */
    .no-product-message {
    text-align: center;
    margin-bottom: 30px; /* Espacio inferior para separar del contenido siguiente */
    width: 100%; /* Ancho del mensaje para que coincida con el espacio de una tarjeta */
    max-width: 600px; /* Ancho máximo del mensaje */
    margin-left: auto;
    margin-right: 30px; /* Aumentar margen derecho */
}

    /* Estilos para la tarjeta de producto */
    .card-product {
        border: 0;
        margin-bottom: 30px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        /* Sombra ligera */
    }

    .card-product p {
        margin-bottom: 0;
    }

    .card-product__img {
        position: relative;
    }

    .card-product__imgOverlay {
        background: rgba(255, 255, 255, 0.5);
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        padding: 10px 5px;
        transform: translateY(30px);
        opacity: 0;
        z-index: -1;
        transition: all .48s ease;
    }

    .card-product__imgOverlay li {
        display: inline-block;
    }

    .card-product__imgOverlay li button {
        border: 0;
        border-radius: 0;
        padding: 7px 12px;
        background: #8894ff;
    }

    .card-product__imgOverlay li button i,
    .card-product__imgOverlay li button span {
        font-size: 15px;
        color: #fff;
        vertical-align: middle;
    }

    .card-product__imgOverlay li button:hover {
        background: #384aeb;
    }

    .card-product__imgOverlay li:not(:last-child) {
        margin-right: 5px;
    }

    .card-product__title a {
        color: #222;
    }

    .card-product__price {
        font-size: 18px;
        font-weight: 500;
    }

    .card-product:hover .card-product__imgOverlay {
        opacity: 1;
        z-index: 1;
        transform: translateY(0);
    }

    .card-product:hover .card-product__title a {
        color: #384aeb;
    }
</style>
<div class="container mt-4">
    <?php if (!empty($mensaje)) : ?>
        <div id="alertMessage" class="alert alert-<?php echo htmlspecialchars($tipo_mensaje); ?> alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($mensaje); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="cerrarMensaje()">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
</div>


<section class="section-margin calc-60px mt-5">
    <div class="container">
        <div class="row">
            <!-- Categorías -->
            <div class="col-md-12 col-lg-3 mb-4 mb-lg-0">
                <div class="list-group">
                    <!-- Enlaces de categoría -->
                    <?php if (!empty($categorias)) : ?>
                        <?php foreach ($categorias as $categoria) : ?>
                            <a href="#" class="list-group-item list-group-item-action" onclick="mostrarProductosCategoria(<?php echo $categoria['id_categoria']; ?>)">
                                <?php echo htmlspecialchars($categoria['nombre']); ?>
                            </a>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p>No hay categorías disponibles.</p>
                    <?php endif; ?>
                </div>
            </div>
            <!-- Productos -->
            <div class="col-md-12 col-lg-9">
                <div class="row" id="productosContainer">
                    <!-- Espacio reservado para mensaje cuando no hay productos -->
                    <div class="col-md-12 col-lg-4 col-xl-3" id="noProductMessage" style="display: none;">
                        <div class="text-center">
                            <div class="no-product-message">
                                <p class="mb-0 text-muted">Vaya! Parece que no tenemos lo que estás buscando en esta categoría.</p>
                                <p class="mb-0"><a href="#">Contáctanos</a> y estaremos encantados de ayudarte.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Productos dinámicos se insertarán aquí -->
                    <?php if (!empty($productos_por_categoria)) : ?>
                        <?php foreach ($productos_por_categoria as $id_categoria => $productos) : ?>
                            <?php foreach ($productos as $producto) : ?>
                                <div class="col-md-12 col-lg-4 col-xl-3 producto categoria-<?php echo $id_categoria; ?>">
                                    <div class="card text-center card-product">
                                        <div class="card-product__img">
                                            <img class="card-img" src="../app/archivos/img/productos_imagenes/<?php echo htmlspecialchars($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                                            <ul class="card-product__imgOverlay">
                                                <li><button onclick="addToCart(<?php echo $producto['id_producto']; ?>)"><span class="fas fa-shopping-cart"></span></button></li>
                                                <li><button onclick="verMas(<?php echo $producto['id_producto']; ?>)"><span class="fas fa-eye"></span></button></li>
                                            </ul>
                                        </div>
                                        <div class="card-body">
                                            <p><?php echo htmlspecialchars($producto['nombre']); ?></p>
                                            <h4 class="card-product__title"><a href="#" onclick="verMas(<?php echo $producto['id_producto']; ?>)"><?php echo htmlspecialchars($producto['descripcion']); ?></a></h4>
                                            <p class="card-product__price">$<?php echo htmlspecialchars($producto['precio']); ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Función para mostrar solo los productos de la categoría seleccionada
    function mostrarProductosCategoria(categoria) {
        // Ocultar mensaje de no productos
        document.getElementById('noProductMessage').style.display = 'none';

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

        // Mostrar mensaje si no hay productos visibles
        if (productosCategoria.length === 0) {
            document.getElementById('noProductMessage').style.display = 'block';
        }
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

    // Inicialmente mostrar productos de la primera categoría si hay categorías disponibles
    document.addEventListener('DOMContentLoaded', function() {
        if (<?php echo !empty($categorias) ? 'true' : 'false'; ?>) {
            mostrarProductosCategoria(<?php echo $categorias[0]['id_categoria']; ?>);
        }
    });
    function cerrarMensaje() {
        var alertMessage = document.getElementById('alertMessage');
        alertMessage.style.display = 'none';
    }
</script>