<?php
 /* Ejecutando este fichero crearemos la BD en nuestro servidor de BD.
 * Los datos de conexión son los siguientes, comprueba que coinciden con los tuyos, sino no funcionará.
 * Los leeremos de config.php
 $db_hostname = "localhost";
 $db_nombre = "inkbyte";
 $db_usuario = "root";
 $db_clave = "";
*/

//En config.php tenemos los valores de conexión a la BD
include ('../libs/config.php');
try {
    /*
     * Conectamos
     * No le pasamos nombre de BD porque vamos a crearla
     */
    echo ("1");
    $pdo = new PDO('mysql:host='.Config::$db_hostname, Config::$db_usuario, Config::$db_clave);
    echo ("2");
    //UTF8
    $pdo->exec("set names utf8");
    echo ("3");
    // Accionamos el uso de excepciones
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo ("4");
    //Leemos el fichero que contiene el sql
    $sqlBD = file_get_contents("../../web/valcopy.sql");
    echo ("5");
    //Ejecutamos la consulta
    $pdo->exec($sqlBD);
    echo ("La BD ha sido creada");
    //Cerramos conexion
    $pdo = null;
} catch (PDOException $e) {
    // En este caso guardamos los errores en un archivo de errores log
    error_log($e->getMessage() . "## Fichero: " . $e->getFile() . "## Línea: " . $e->getLine() . "##Código: " . $e->getCode() . "##Instante: " . microtime() . PHP_EOL, 3, "logBD.txt");
    // guardamos en ·errores el error que queremos mostrar a los usuarios
    $errores['datos'] = "Ha habido un error <br>";
}