<?php
require_once __DIR__ . '/../app/modelo/classModelo.php';
require_once __DIR__ . '/../app/modelo/classConsultas.php';
require_once __DIR__ . '/../app/libs/config.php';
require_once __DIR__ . '/../app/libs/bGeneral.php';
require_once __DIR__ . '/../app/controlador/controller.php';

session_start(); // Se inicia la sesión

// Si el nivel de usuario no está definido, se establece en 0 por defecto
if (!isset($_SESSION['nivel'])) {
    $_SESSION['nivel'] = 0;
}

// Configuración de las rutas y permisos de acceso
$map = array(
    'inicio' => array('controller' => 'Controller', 'action' => 'inicio', 'nivel' => 0),
    'registro' => array('controller' => 'Controller', 'action' => 'registro', 'nivel' => 0),
    'inicioSesion' => array('controller' => 'Controller', 'action' => 'inicioSesion', 'nivel' => 0),
    'admin' => array('controller' => 'Controller', 'action' => 'admin', 'nivel' => 0),
    'gestionProductos' => array('controller' => 'Controller', 'action' => 'gestionProductos', 'nivel' => 0),
    'agregarProducto' => array('controller' => 'Controller', 'action' => 'agregarProducto', 'nivel' => 0),
    'agregarCategoria' => array('controller' => 'Controller', 'action' => 'agregarCategoria', 'nivel' => 0),
    'editarProducto' => array('controller' => 'Controller', 'action' => 'editarProducto', 'nivel' => 0),
    'borrarProducto' => array('controller' => 'Controller', 'action' =>'borrarProducto', 'nivel' => 0),
    'verProductos' => array('controller' => 'Controller', 'action' =>'verProductos', 'nivel' => 0),
    
);

// Parseo de la ruta
if (isset($_GET['ctl'])) {
    if (isset($map[$_GET['ctl']])) {
        $ruta = $_GET['ctl'];
    } else {
        $ruta = "error"; // Si la ruta no está definida en el mapa, se establece como error
    }
} else {
    $ruta = 'inicio'; // Ruta por defecto
}

$controlador = $map[$ruta];

// Verificar si el método correspondiente a la acción existe
if (method_exists($controlador['controller'], $controlador['action'])) {
    // Verificar permisos de acceso
    if ($controlador['nivel'] <= $_SESSION['nivel']) {
        call_user_func(array(
            new $controlador['controller'],
            $controlador['action']
        ));
    } else {
        // Redirigir al inicio si el usuario no tiene permisos suficientes
        call_user_func(array(
            new $controlador['controller'],
            'inicio'
        ));
    }
} else {
    // Error 404 si el controlador o la acción no existen
    header('Status: 404 Not Found');
    echo '<html><body><h1>Error 404: El controlador <i>' .
        $controlador['controller'] .
        '->' .
        $controlador['action'] .
        '</i> no existe</h1></body></html>';
}
