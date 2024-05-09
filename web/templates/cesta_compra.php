<?php
include('./templates/layout.php');
?>

<div class="container mt-5">
    <h1 class="mb-4">Cesta de la Compra</h1>
    <div class="row">
        <div class="col">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Precio</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Total</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="cart-items">
                        <?php foreach($productos_cesta as $producto) { ?>
                            <tr>
                                <td><?php echo $producto['nombre']; ?></td>
                                <td>$<?php echo number_format($producto['precio'], 2); ?></td>
                                <td>
                                    <!-- Botones de aumento y disminución de cantidad -->
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-outline-secondary btn-minus" type="button" data-product-id="<?php echo $producto['id_producto']; ?>">-</button>
                                        </div>
                                        <input type="text" class="form-control text-center quantity" value="<?php echo $producto['cantidad']; ?>" readonly>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary btn-plus" type="button" data-product-id="<?php echo $producto['id_producto']; ?>">+</button>
                                        </div>
                                    </div>
                                </td>
                                <td class="product-total" data-price="<?php echo $producto['precio']; ?>">
                                    $<?php echo number_format($producto['precio'] * $producto['cantidad'], 2); ?>
                                </td>
                                <td>
                                    <!-- Botón para eliminar el producto de la cesta -->
                                    <button class="btn btn-danger btn-remove" type="button" data-product-id="<?php echo $producto['id_producto']; ?>">Eliminar</button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col">
            <h5>Total:</h5>
            <h3 id="total">$<?php
            // Calcular el total sumando el precio de todos los productos en la cesta
            $total = 0;
            foreach($productos_cesta as $producto) {
                $total += $producto['precio'] * $producto['cantidad'];
            }
            echo number_format($total, 2);
            ?></h3>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col">
            <button class="btn btn-primary">Pagar</button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Delegación de eventos para aumentar la cantidad de productos
        document.addEventListener('click', function (event) {
            if (event.target.classList.contains('btn-plus')) {
                var productId = event.target.getAttribute('data-product-id');
                var quantityElement = event.target.parentElement.parentElement.parentElement.querySelector('.quantity');
                var currentQuantity = parseInt(quantityElement.value);
                quantityElement.value = currentQuantity + 1;

                // Actualizar el precio total
                updateTotal();
            }
        });

        // Delegación de eventos para disminuir la cantidad de productos
        document.addEventListener('click', function (event) {
            if (event.target.classList.contains('btn-minus')) {
                var productId = event.target.getAttribute('data-product-id');
                var quantityElement = event.target.parentElement.parentElement.parentElement.querySelector('.quantity');
                var currentQuantity = parseInt(quantityElement.value);
                if (currentQuantity > 1) {
                    quantityElement.value = currentQuantity - 1;

                    // Actualizar el precio total
                    updateTotal();
                }
            }
        });

        // Delegación de eventos para eliminar un producto de la cesta
        document.addEventListener('click', function (event) {
            if (event.target.classList.contains('btn-remove')) {
                event.target.parentElement.parentElement.remove();

                // Actualizar el precio total
                updateTotal();
            }
        });

        // Función para actualizar el precio total
        function updateTotal() {
            var total = 0;
            document.querySelectorAll('.product-total').forEach(function (element) {
                var quantity = parseInt(element.parentElement.querySelector('.quantity').value);
                var price = parseFloat(element.dataset.price); // Obtener el precio del dataset
                total += price * quantity; // Multiplicar el precio por la cantidad
            });
            document.getElementById('total').textContent = '$' + total.toFixed(2);
        }
    });
</script>
