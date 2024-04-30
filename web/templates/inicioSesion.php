<script type="module" src="../web/scripts/validar_inicio_sesion.js"></script>
          <div class="container-md container-lg">
          <div class="modal-header p-5 pb-4 border-bottom-0 mt-5">
            <h1 class="fw-bold mb-0 fs-2">Inicio de Sesión</h1>
          </div>
          <div class="modal-body p-5 pt-0">
            <form method="post" action="index.php?ctl=iniciarSesion">
              <div class="form-floating">
                <input type="email" class="form-control rounded-3" id="mail" placeholder="name@example.com" name="mail" required>
                <label for="email">Correo Electrónico</label>
              </div>

              <div id="mailMal" class="mb-3 text-danger"></div>

              <div class="form-floating">
                <input type="password" class="form-control rounded-3" id="pass" placeholder="Password" name="pass" required>
                <label for="pass">Contraseña</label>
              </div>

              <div id="passMal" class="mb-3 text-danger"></div>

              <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary mt-4" type="submit" id="bAceptar" name="bAceptar">Iniciar Sesión</button>
              <small class="text-body-secondary ">Si aún no tienes cuenta <a href="index.php?ctl=registro">registrate aquí</a>.</small>
            </form>
          </div>
          </div>


<?php include 'layout.php' ?>