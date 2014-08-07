<?php
error_reporting(0);
define('DS', DIRECTORY_SEPARATOR); // guardamos '/' 
define('ROOT', realpath(dirname(__FILE__)) . DS); //ruta raiz de nuestra aplicacion
define('APP_PATH', ROOT . 'aplicacion' . DS); // ruta del directorio de las aplicaciones
define('BASE_DATOS', ROOT . 'basedatos' . DS);

try {
//aqui incluimos todos los archivos de la aplicación
    require_once APP_PATH . 'configuracion.php';
    require_once APP_PATH . 'request.php';
    require_once APP_PATH . 'FrontController.php';
    require_once APP_PATH . 'controller.php';
    require_once APP_PATH . 'view.php';
    require_once APP_PATH . 'session.php';
    require_once BASE_DATOS . 'conexion.php';
    require_once BASE_DATOS . 'Main.php';
    session::init();
    
    FrontController::main(new request);
    
} catch (Exception $e) {
    echo(utf8_decode($e->getMessage()));
}
?>