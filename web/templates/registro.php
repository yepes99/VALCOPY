<?php include('./templates/layout.php'); ?>
<div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-md-6">
            <form action="index.php?ctl=registro" method="post">
                <h2 class="text-center mb-4">Crea una cuenta</h2>
                <div class="mb-3">
                    <input type="text" class="form-control" name="user" placeholder="Usuario" required>
                </div>
                <div class="mb-3">
                    <input type="email" class="form-control" name="email" placeholder="Email" required>
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" name="pass" placeholder="Contraseña" required>
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" name="pass2" placeholder="Confirma Contraseña" required>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="terms" name="terminos" required>
                    <label class="form-check-label" for="terms">Acepto los términos y condiciones</label>
                </div>
                <input type="submit" class="btn btn-primary" name="bAceptar"></input>
                <p class="mt-3 text-center">¿Ya tienes una cuenta? <a href="index.php?ctl=inicioSesion" onclick="toggleForm();">Inicia sesión</a></p>
            </form>
        </div>
    </div>


