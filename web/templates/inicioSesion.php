<?php include('./templates/layout.php'); ?>


<div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-md-6">
            <form action="index.php?ctl=inicioSesion" method="post">
                <h2 class="text-center mb-4">Inicia Sesion</h2>
                <!-- Aquí el mensaje de error -->
            <?php
            if (isset($params['mensaje']) && !empty($params['mensaje'])) {
                echo '<div class="alert alert-danger" role="alert">';
                foreach ($params['mensaje'] as $mensaje) {
                    echo $mensaje . '<br>';
                }
                echo '</div>';
            }
            ?>
                <div class="mb-3">
                    <input type="email" class="form-control" name="email" placeholder="Email" required>
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" name="pass" placeholder="Contraseña" required>
                </div>
               
                <input type="submit" class="btn btn-primary" name="bAceptar"></input>
                <p class="mt-3 text-center">¿No tienes una cuenta? <a href="index.php?ctl=registro" onclick="toggleForm();">Registrate</a></p>
            </form>
        </div>
    </div>


