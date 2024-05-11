<?php

include('./templates/layout.php');
?>
<div class="container">
    <h1 class="mt-5">Proceso de Pago</h1>
    <div class="row mt-4">
      <div class="col-md-6">
        <!-- Paso 1: Selección del Método de Pago -->
        <div class="card">
          <div class="card-header">
            Paso 1: Selección del Método de Pago
          </div>
          <div class="card-body">
            <form id="formMetodoPago">
              <div class="mb-3">
                <label for="metodo_pago" class="form-label">Selecciona un Método de Pago:</label>
                <select class="form-select" id="metodo_pago" name="metodo_pago" required>
                  <option value="">Selecciona un método de pago...</option>
                  <option value="tarjeta_credito">Tarjeta de Crédito</option>
                  <option value="paypal">PayPal</option>
                  <!-- Agrega más opciones de método de pago según sea necesario -->
                </select>
              </div>
              <button type="submit" class="btn btn-primary">Continuar</button>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <!-- Paso 2: Detalles del Pago -->
        <div class="card">
          <div class="card-header">
            Paso 2: Detalles del Pago
          </div>
          <div class="card-body" id="detallesPago">
            <!-- Aquí se mostrarán los detalles del pago dependiendo del método seleccionado en el Paso 1 -->
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    // Verificar si los datos del perfil están completos
    var userDataComplete = <?php echo $userDataComplete ? 'true' : 'false'; ?>;

    // Si los datos del perfil no están completos, mostrar un mensaje de alerta
    if (!userDataComplete) {
        alert('Por favor, complete todos los campos del perfil antes de proceder al pago.');
    }
</script>