<?php
// Verifica si el usuario es administrador
$isAdmin = false; // Asume que el usuario no es administrador por defecto
if (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'administrador') {
    $isAdmin = true; // Establece la variable a true si el usuario es administrador
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Valcopy</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-vAFs/zCzc9Ql71kEZ8X+ueP1TwtxHA0r36TVBhUQ+kXtd+6CgGQWuKU/dhzyU4Mv5HfDEEgjtfeTOZqweuW9sg==" crossorigin="anonymous" referrerpolicy="no-referrer" />


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
       
       <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>

    <link rel="stylesheet" href="../web/styles/styles.css" />
   


</head>

<body>

    <?php if ($isAdmin) : ?>
        <!-- Navbar para administradores -->
        <nav class="navbar navbar-expand-md navbar-light bg-light">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="index.php?ctl=panelAdmin">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?ctl=gestionProductos">Gestión de Productos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="gestionPedidos.html">Gestión de Pedidos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?ctl=inicio">Volver Web</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?ctl=cerrarSesion">Cerrar Sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

    <?php else : ?>
        <!-- Navbar para usuarios no administradores -->
        <nav class="custom-navbar navbar navbar-expand-md navbar-dark bg-dark" arial-label="Furni navigation bar">
            <div class="container">
                <a class="navbar-brand" href="index.php?ctl=inicio">Valcopy<span></span></a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni" aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarsFurni">
                    <ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
                        <li class="nav-item active">
                            <a class="nav-link" href="index.php?ctl=inicio">Home</a>
                        </li>
                        <li><a class="nav-link" href="index.php?ctl=visualizarProductos">Productos</a></li>
                        <li><a class="nav-link" href="about.html">Sobre Nosotros</a></li>
                        <li><a class="nav-link" href="services.html">Servicios</a></li>
                        <li><a class="nav-link" href="blog.html">Contáctanos</a></li>
                    
                    </ul>

                    <ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                        </svg>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="index.php?ctl=registro">Registro</a></li>
                   
                        <li><a class="dropdown-item" href="index.php?ctl=verPerfil">Ajustes</a></li>
                    </ul>
                </li>
                        <li><a class="nav-link" href="index.php?ctl=verCesta2" dir="ltr">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                                    <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
                                </svg></a>
                        </li>
                        

                    </ul>
                </div>
            </div>
        </nav>
    <?php endif; ?>


</body>

</html>