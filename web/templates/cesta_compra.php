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
                                <td><?php echo $producto['cantidad']; ?></td>
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
             <a href="index.php?ctl=pago" class="btn btn-primary" id="btnGenerarFactura">Pagar</a>
        </div>
    </div>
</div>

<script>
    // Función para generar la factura en PDF
    document.getElementById('btnGenerarFactura').addEventListener('click', function() {
        const doc = new jsPDF();
        const marginLeft = 10;
        const marginTop = 10;
        const lineHeight = 7;
        let y = marginTop;

        // Título
        doc.setFontSize(20);
        doc.text('Factura de Compra', marginLeft, y);
        y += lineHeight * 2;

        // Datos del cliente
        doc.setFontSize(14);
        doc.text('Datos del Cliente:', marginLeft, y);
        doc.setFontSize(12);
        y += lineHeight;
        doc.text(`Nombre: <?php echo $usuario['nombre']; ?>`, marginLeft, y);
        y += lineHeight;
        doc.text(`Dirección: <?php echo $usuario['direccion']; ?>`, marginLeft, y);
        y += lineHeight;
        doc.text(`Ciudad: <?php echo $usuario['ciudad']; ?>`, marginLeft, y);
        y += lineHeight;
        doc.text(`Código Postal: <?php echo $usuario['codigo_postal']; ?>`, marginLeft, y);
        y += lineHeight * 2;

        // Detalles de la compra
        doc.setFontSize(14);
        doc.text('Detalles de la Compra:', marginLeft, y);
        doc.setFontSize(12);
        y += lineHeight;
        <?php foreach($productos_cesta as $producto) { ?>
            doc.text(`Producto: <?php echo $producto['nombre']; ?> - Cantidad: <?php echo $producto['cantidad']; ?> - Precio Unitario: $<?php echo number_format($producto['precio'], 2); ?>`, marginLeft, y);
            y += lineHeight;
        <?php } ?>
        y += lineHeight * 2;

        // Total
        doc.setFontSize(14);
        doc.text(`Total: $<?php echo number_format($total, 2); ?>`, marginLeft, y);

        // Guardar el PDF
        doc.save('factura.pdf');
    });

    // Función para eliminar un producto de la cesta
    document.addEventListener('DOMContentLoaded', function() {
        var btnRemove = document.querySelectorAll('.btn-remove');
        btnRemove.forEach(function(btn) {
            btn.addEventListener('click', function() {
                var productId = this.getAttribute('data-product-id');
                // Aquí puedes agregar código para enviar una solicitud AJAX para eliminar el producto de la base de datos o actualizar la sesión de la cesta
                // Aquí por simplicidad, se puede eliminar la fila del producto de la tabla directamente en el DOM
                var tr = this.closest('tr');
                tr.parentNode.removeChild(tr);
            });
        });
    });
</script>
