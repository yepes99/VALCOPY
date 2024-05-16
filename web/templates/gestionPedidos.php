<?php include __DIR__ . '/../../web/templates/layout.php'; ?>

<div class="container">
  <h2>Gestión de Pedidos</h2>
  <div class="row">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header bg-primary text-white">Opciones de Gestión</div>
        <div class="card-body">
          <div class="list-group">
            <a href="#" class="list-group-item list-group-item-action" onclick="mostrarFormulario('editar')">Editar Pedido Existente</a>
            <a href="#" class="list-group-item list-group-item-action" onclick="mostrarFormulario('eliminar')">Eliminar Pedido</a>
         
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
    <div class="card">
        <div class="card-header bg-primary text-white">Ver Pedidos por Cliente</div>
        <div class="card-body">
            <!-- Formulario para ingresar el ID del cliente -->
            <form action="index.php?ctl=verPedidosPorCliente" method="POST">
                <div class="form-group">
                    <label for="cliente_id">ID del Cliente:</label>
                    <input type="text" class="form-control" id="cliente_id" name="cliente_id">
                </div>
                <button type="submit" class="btn btn-sm btn-primary mt-3" name="verPedidosCliente">Ver Pedidos</button>
            </form>

            <!-- Aquí se mostrarán los pedidos del cliente seleccionado -->
            <?php if(isset($pedidosCliente) && !empty($pedidosCliente)) : ?>
                <h4>Pedidos del Cliente</h4>
                <ul class="list-group">
                    <?php foreach($pedidosCliente as $pedido) : ?>
                        <li class="list-group-item">Pedido <?php echo $pedido['id_pedido']; ?> - <?php echo $pedido['estado']; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>

</div>

  </div>

  <!-- Formulario para editar pedido -->

<div id="formularioEditar" style="display: none;">
    <h3>Editar Pedido Existente</h3>
    <form action="index.php?ctl=editarPedido" method="POST">
        <div class="form-group">
            <label for="pedido_id">ID del Pedido:</label>
            <input type="text" class="form-control" id="pedido_id" name="pedido_id">
        </div>
        <div class="form-group">
            <label for="nuevo_estado">Nuevo Estado:</label>
            <select class="form-control" id="nuevo_estado" name="nuevo_estado">
                <option value="pendiente">Pendiente</option>
                <option value="enviado">Enviado</option>
                <option value="entregado">Entregado</option>
                <option value="cancelado">Cancelado</option>
            </select>
        </div>
        <div class="form-group">
            <label for="transportista">Transportista:</label>
            <input type="text" class="form-control" id="transportista" name="transportista">
        </div>
        <div class="form-group">
            <label for="metodo_pago">Método de Pago:</label>
            <input type="text" class="form-control" id="metodo_pago" name="metodo_pago">
        </div>
        <button type="submit" class="btn btn-sm btn-primary mt-3" name="bAceptarEditar">Editar</button>
    </form>
</div>


  <!-- Formulario para eliminar pedido -->
  <div id="formularioEliminar" style="display: none;">
    <h3>Eliminar Pedido</h3>
    <form action="index.php?ctl=eliminarPedido" method="POST">
      <div class="form-group">
        <label for="pedido_id_eliminar">ID del Pedido:</label>
        <input type="text" class="form-control" id="pedido_id_eliminar" name="pedido_id">
      </div>
      <button type="submit" class="btn btn-sm btn-danger mt-3" name="bAceptarEliminar">Eliminar</button>
    </form>
  </div>

 
<script>
  function mostrarFormulario(formulario) {
    document.getElementById('formularioEditar').style.display = 'none';
    document.getElementById('formularioEliminar').style.display = 'none';
    document.getElementById('formularioAgregar').style.display = 'none';
    
    if (formulario === 'editar') {
      document.getElementById('formularioEditar').style.display = 'block';
    } else if (formulario === 'eliminar') {
      document.getElementById('formularioEliminar').style.display = 'block';
    } else if (formulario === 'agregar') {
      document.getElementById('formularioAgregar').style.display = 'block';
    }
  }
</script>
