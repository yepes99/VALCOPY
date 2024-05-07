<!-- ================ trending product section start ================= -->  
<?php include('./templates/layout.php'); ?>

<section>
    <div class="container py-5">
        <div class="row">
            <!-- Categorías -->
            <div class="col-md-12 col-lg-3 mb-4 mb-lg-0">
                <div class="list-group">
                    <a href="#laptops" class="list-group-item list-group-item-action active">Categoria 1</a>
                    <a href="#desktops" class="list-group-item list-group-item-action">Categoria 2</a>
                    <a href="#accessories" class="list-group-item list-group-item-action">Categoria 1</a>
                </div>
            </div>
            <!-- Productos -->
            <div class="col-md-12 col-lg-9">
                <!-- Laptops -->
                <div class="row">
                    <?php
                    // Incluir el archivo que contiene la clase Consultas
                    include('./ruta/a/Consultas.php');

                    // Crear una instancia de la clase Consultas
                    $consultas = new Consultas();

                    // Obtener todos los productos de la base de datos
                    $productos = $consultas->obtenerProductos();

                    // Verificar si se obtuvieron productos
                    if ($productos) {
                        // Iterar sobre los productos y mostrar cada uno
                        foreach ($productos as $producto) {
                            ?>
                            <div class="col-md-12 col-lg-4 mb-4 mb-lg-0 mb-3 mt-4 mt-lg-4">
                                <div class="card">
                                    <img src="<?php echo $producto['imagen']; ?>" class="card-img-top" alt="<?php echo $producto['nombre']; ?>" />
                                    <div class="card-body">
                                        <h5 class="mb-0"><?php echo $producto['nombre']; ?></h5>
                                        <h5 class="text-dark mb-0">$<?php echo $producto['precio']; ?></h5>
                                        <div class="d-flex justify-content-between ">
                                            <button class="btn btn-primary btn-sm m-2"><i class="fas fa-eye"></i> View Details</button>
                                            <button class="btn btn-success btn-sm m-2"><i class="fas fa-cart-plus"></i> Add to Cart</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        // Mostrar un mensaje si no se encontraron productos
                        echo "<p>No se encontraron productos.</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
