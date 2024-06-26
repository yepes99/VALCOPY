
<?php
require_once __DIR__ . '/../app/modelo/classModelo.php';
require_once __DIR__ . '/../app/modelo/classConsultas.php';
require_once __DIR__ . '/../app/libs/config.php';
require_once __DIR__ . '/../app/libs/bGeneral.php';
require_once __DIR__ . '/../app/controlador/controller.php';

session_start(); // Se inicia la sesion
//Este logueado o no el usuario, siempre tendra un nivel_usuario

if (!isset($_SESSION['nivel'])) {
    $_SESSION['nivel'] = 0;
}


/**
 * Enrutamiento
 * Le añadimos el nivel mínimo que tiene que tener el usuario para ejecutar la acción
 *
 * controller se refiere a controller.php
 * Controller.php se refiere a la clase Controller dentro de controller.php
 * action lo que va a hacer
 * home la función home dentro de la clase controller
 * nivel el nivel del usuario
 **/

$map = array(
    'inicio' => array('controller' => 'Controller', 'action' => 'inicio', 'nivel' => 0),
    'panelAdmin' => array('controller' => 'Controller', 'action' => 'panelAdmin', 'nivel' => 0),
    'registro' => array('controller' => 'Controller', 'action' => 'registro', 'nivel' => 0),
    'inicioSesion' => array('controller' => 'Controller', 'action' => 'inicioSesion', 'nivel' => 0),
    'admin' => array('controller' => 'Controller', 'action' => 'admin', 'nivel' => 0),
    'gestionProductos' => array('controller' => 'Controller', 'action' => 'gestionProductos', 'nivel' => 0),
    'agregarProducto' => array('controller' => 'Controller', 'action' => 'agregarProducto', 'nivel' => 0),
    'agregarCategoria' => array('controller' => 'Controller', 'action' => 'agregarCategoria', 'nivel' => 0),
    'editarProducto' => array('controller' => 'Controller', 'action' => 'editarProducto', 'nivel' => 0),
    'borrarProducto' => array('controller' => 'Controller', 'action' => 'borrarProducto', 'nivel' => 0),
    'verProductos' => array('controller' => 'Controller', 'action' => 'verProductos', 'nivel' => 0),
    'cerrarSesion' => array('controller' => 'Controller', 'action' => 'cerrarSesion', 'nivel' => 0),
    'verPerfil' => array('controller' => 'Controller', 'action' => 'verPerfil', 'nivel' => 0),
    'perfilUsuario' => array('controller' => 'Controller', 'action' => 'perfilUsuario', 'nivel' => 0),
    'error' => array('controller' => 'Controller', 'action' => 'error', 'nivel' => 0),
    'visualizarProductos' => array('controller' => 'Controller', 'action' => 'visualizarProductos', 'nivel' => 0),
    'producto' => array('controller' => 'Controller', 'action' => 'producto', 'nivel' => 0),
    'verCesta' => array('controller' => 'Controller', 'action' => 'verCesta', 'nivel' => 0),
    'verCesta2' => array('controller' => 'Controller', 'action' => 'verCesta2', 'nivel' => 0),
    'pago' => array('controller' => 'Controller', 'action' => 'pago', 'nivel' => 0),
    'gestionPedidos' => array('controller' => 'Controller', 'action' => 'gestionPedidos', 'nivel' => 0),
    'editarPedido' => array('controller' => 'Controller', 'action' => 'editarPedido', 'nivel' => 0),
    'eliminarPedido' => array('controller' => 'Controller', 'action' => 'eliminarPedido', 'nivel' => 0),
    'verPedidosPorCliente' => array('controller' => 'Controller', 'action' => 'verPedidosPorCliente', 'nivel' => 0),
    'gestionUsuarios' => array('controller' => 'Controller', 'action' => 'gestionUsuarios', 'nivel' => 0),
    'agregarUsuario' => array('controller' => 'Controller', 'action' => 'gestionUsuarios', 'nivel' => 0),
    'contactanos' => array('controller' => 'Controller', 'action' => 'contactanos', 'nivel' => 0),
    'verMensajes' => array('controller' => 'Controller', 'action' => 'verMensajes', 'nivel' => 0),
    'responder' => array('controller' => 'Controller', 'action' => 'responder', 'nivel' => 0),
 
 
);

// Parseo de la ruta
if (isset($_GET['ctl'])) {
    if (isset($map[$_GET['ctl']])) {
        $ruta = $_GET['ctl'];
    } else {

        $ruta = "error";
    }
} else {
    $ruta = 'inicio';
}
$controlador = $map[$ruta];
/*
Comprobamos si el metodo correspondiente a la acción relacionada con el valor de ctl existe,
si es así ejecutamos el método correspondiente.
En caso de no existir cabecera de error.
En caso de estar utilizando sesiones y permisos en las diferentes acciones comprobariamos tambien
si el usuario tiene permiso suficiente para ejecutar esa acción
*/

if (method_exists($controlador['controller'], $controlador['action'])) {

    if ($controlador['nivel'] <= $_SESSION['nivel']) {
        call_user_func(array(
            new $controlador['controller'],
            $controlador['action']
        ));
    } else {
        call_user_func(array(
            new $controlador['controller'],
            'inicio'
        ));
    }
} else {
    header('Status: 404 Not Found');
    echo '<html><body><h1>Error 404: El controlador <i>' .
        $controlador['controller'] .
        '->' .
        $controlador['action'] .
        '</i> no existe</h1></body></html>';
    //console_log("entrarErrorInicio");
}
