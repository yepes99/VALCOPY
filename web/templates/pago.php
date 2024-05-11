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
} else {
    // Si no hay un usuario autenticado, redirigir al usuario a la página de inicio de sesión
    header("Location: index.php?ctl=inicioSesion");
    exit;
}
?>

<div class="container mt-5">
  <h1 class="mb-4">Proceso de Pago</h1>
  <form action="index.php?ctl=pago" method="POST">
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
      <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Dirección de Facturación" value="<?php echo $usuario['direccion']; ?>" required>
    </div>
    <div class="mb-3">
      <label for="ciudad" class="form-label">Ciudad</label>
      <input type="text" class="form-control" id="ciudad" name="ciudad" placeholder="Ciudad" value="<?php echo $usuario['ciudad']; ?>" required>
    </div>
    <div class="mb-3">
      <label for="codigo_postal" class="form-label">Código Postal</label>
      <input type="text" class="form-control" id="codigo_postal" name="codigo_postal" placeholder="Código Postal" value="<?php echo $usuario['codigo_postal']; ?>" required>
    </div>
    <button type="submit" class="btn btn-primary" name="bAceptar">Realizar pedido</button>
  </form>
</div>
