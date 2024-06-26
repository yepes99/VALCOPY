<?php
include('./templates/layout.php');

// Verificar si hay un usuario autenticado para obtener la información de la dirección
if(isset($_SESSION['id_usuario'])){
    // Obtener el ID del usuario de la sesión
    $id_usuario = $_SESSION['id_usuario'];

    // Crear una instancia de la clase Consultas
    $consultas = new Consultas();

    // Obtener la información del usuario desde la base de datos
    $usuario = $consultas->obtenerUsuarioPorId($id_usuario);

    // Verificar si se obtuvo la información del usuario correctamente
    if(!$usuario){
        // Si no se puede obtener la información del usuario, redirigir al usuario a la página de inicio de sesión
        header("Location: index.php?ctl=inicioSesion");
        exit;
    }

    // Obtener los productos de la cesta del usuario
    $productos_comprados = $consultas->obtenerProductosCestaPorUsuario($id_usuario);

    // Verificar si se obtuvieron productos de la cesta
    if(!$productos_comprados){
        echo "Error al obtener productos de la cesta.";
        exit;
    }

} else {
    // Si no hay un usuario autenticado, redirigir al usuario a la página de inicio de sesión
    header("Location: index.php?ctl=inicioSesion");
    exit;
}
?>

<div class="container mt-5">
  <h1 class="mb-4">Proceso de Pago</h1>
  <form id="form-pago" action="index.php?ctl=pago" method="POST">
    <div class="mb-3">
      <label for="nombre" class="form-label">Nombre en la Tarjeta</label>
      <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre en la Tarjeta" required>
    </div>
    <div class="mb-3">
      <label for="numero_tarjeta" class="form-label">Número de Tarjeta</label>
      <input type="text" class="form-control" id="numero_tarjeta" name="numero_tarjeta" placeholder="Número de Tarjeta" required>
    </div>
    <div class="row">
      <div class="col-md-6 mb-3">
        <label for="fecha_exp" class="form-label">Fecha de Expiración</label>
        <input type="text" class="form-control" id="fecha_exp" name="fecha_exp" placeholder="MM/AA" required>
      </div>
      <div class="col-md-6 mb-3">
        <label for="cvv" class="form-label">CVV</label>
        <input type="text" class="form-control" id="cvv" name="cvv" placeholder="CVV" required>
      </div>
    </div>
    <div class="mb-3">
      <label for="direccion" class="form-label">Dirección de Facturación</label>
      <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Dirección de Facturación" value="<?php echo isset($usuario['direccion']) ? $usuario['direccion'] : ''; ?>" required>
    </div>
    <div class="mb-3">
      <label for="ciudad" class="form-label">Ciudad</label>
      <input type="text" class="form-control" id="ciudad" name="ciudad" placeholder="Ciudad" value="<?php echo isset($usuario['ciudad']) ? $usuario['ciudad'] : ''; ?>" required>
    </div>
    <div class="mb-3">
      <label for="codigo_postal" class="form-label">Código Postal</label>
      <input type="text" class="form-control" id="codigo_postal" name="codigo_postal" placeholder="Código Postal" value="<?php echo isset($usuario['codigo_postal']) ? $usuario['codigo_postal'] : ''; ?>" required>
    </div>
    <button type="button" id="btn-realizar-pedido" class="btn btn-primary">Realizar pedido</button>
  </form>
</div>

<!-- Importar jsPDF -->
<!-- Importar jsPDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script>

<script>
  document.getElementById('btn-realizar-pedido').addEventListener('click', function() {
    // Crear un nuevo documento PDF
    const doc = new jsPDF();

    // Obtener los datos del formulario
    const nombre = document.getElementById('nombre').value;
    const numeroTarjeta = document.getElementById('numero_tarjeta').value;
    const fechaExp = document.getElementById('fecha_exp').value;
    const cvv = document.getElementById('cvv').value;
    const direccion = document.getElementById('direccion').value;
    const ciudad = document.getElementById('ciudad').value;
    const codigoPostal = document.getElementById('codigo_postal').value;

    // Establecer margen y posición inicial
    let y = 20;

    // Título del documento
    doc.setFontSize(18);
    doc.text('Factura de Compra', 105, y, { align: 'center' });
    y += 10;

    // Detalles del titular de la tarjeta
    doc.setFontSize(12);
    doc.text('Nombre en la Tarjeta:', 20, y);
    doc.text(nombre, 70, y);
    y += 10;

    // Detalles de la tarjeta
    doc.text('Número de Tarjeta:', 20, y);
    doc.text(numeroTarjeta, 70, y);
    y += 10;
    doc.text('Fecha de Expiración:', 20, y);
    doc.text(fechaExp, 70, y);
    y += 10;
    doc.text('CVV:', 20, y);
    doc.text(cvv, 70, y);
    y += 10;

    // Dirección de facturación
    doc.text('Dirección de Facturación:', 20, y);
    doc.text(direccion, 70, y);
    y += 10;
    doc.text('Ciudad:', 20, y);
    doc.text(ciudad, 70, y);
    y += 10;
    doc.text('Código Postal:', 20, y);
    doc.text(codigoPostal, 70, y);
    y += 10;

    // Detalles de los productos comprados
    y += 10;
    doc.setFontSize(14);
    doc.text('Detalles del Pedido', 105, y, { align: 'center' });
    y += 10;
    doc.setFontSize(12);

    <?php
    // Iterar sobre los productos comprados y agregarlos al PDF
    foreach($productos_comprados as $producto) {
        echo "doc.text('Nombre: {$producto['nombre']} - Precio: \${$producto['precio']} - Cantidad: {$producto['cantidad']}', 20, y);\n";
        echo "y += 10;\n";
    }
    ?>

    // Guardar el PDF con nombre 'factura.pdf'
    doc.save('factura.pdf');
  });
</script>

