<?php include ('./templates/layout.php'); ?>

<section id="wrapper">
    <section>
        <h3 class="mb-4">Gestión de productos</h3>
        <p class="section-lead">Gestiona los productos noseque</p>
        <div class="row mx-auto">
            <div class="col-lg-6 col-md-6 mb-2">
                <div class="service-box border rounded text-center p-4">
                    <a href="index.php?ctl=agregarProducto">
                        <i class="bi bi-plus-circle-fill fs-2 mb-3"></i>
                        <h4 class="mb-0">Agregar producto</h4>
                    </a>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 mb-2">
                <div class="service-box border rounded text-center p-4">
                    <a href="index.php?ctl=editarProducto">
                        <i class="bi bi-plus-circle-fill fs-2 mb-3"></i>
                        <h4 class="mb-0">Editar producto</h4>
                    </a>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="service-box border rounded text-center p-4">
                    <a href="index.php?ctl=agregarCategoria">
                        <i class="bi bi-plus-circle-fill fs-2 mb-3"></i>
                        <h4 class="mb-0">Agregar categoría</h4>
                    </a>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 mb-2">
                <div class="service-box border rounded text-center p-4">
                    <a href="index.php?ctl=borrarProducto">
                        <i class="bi bi-plus-circle-fill fs-2 mb-3"></i>
                        <h4 class="mb-0">Borrar producto</h4>
                    </a>
                </div>
            </div>
            <div class="col-lg-8 col-md-8 mx-auto">
    <div class="service-box border rounded text-center p-4 hover hover-animate">
        <a href="index.php?ctl=verProductos">
            <i class="bi bi-plus-circle-fill fs-2 mb-3"></i>
            <h4 class="mb-0">Ver producto</h4>
        </a>
    </div>
</div>

        </div>
    </section>
</section>
