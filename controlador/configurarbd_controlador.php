<?php

class configurarbd_controlador extends controller {

    public function __construct() {
        if (!$this->acceso()) {
            $this->redireccionar('error/access/5050');
        }
        parent::__construct();
    }

    public function index() {
        $this->_vista->titulo = 'Configurar Base de Datos';
        if ($_POST['guardar'] == 1) {
            $host = $_POST['host'];
            $driver = $_POST['sgbd'];
            $user = $_POST['usuario'];
            $password = $_POST['clave'];
            $port = $_POST['puerto'];
            $dbname = $_POST['basedatos'];
            $archivo = '';
            if ($driver == 'oci') {
                $archivo = 'OCI';
            } else {
                $archivo = 'PDO';
            }
            $configuracion = array("archivo" => $archivo, "driver" => $driver, "usuario" => $user, "password" => $password, "host" => $host,
                "puerto" => $port, "basedatos" => $dbname);
            $fp = fopen(ROOT . DS . "basedatos" . DS . "config.ini", "w");
            fwrite($fp, "[database]");
            $fp = fopen(ROOT . DS . "basedatos" . DS . "config.ini", "a+");
            foreach ($configuracion as $key => $valor) {
                fwrite($fp, "\n" . $key . " = " . $valor);
            }
            fclose($fp);
            session::destroy();
            //            conexion::conexionSingleton();
            echo '<script>
                alert("Datos GRABADOS Correctamente");
                window.location="' . BASE_URL . '";
            </script>';
        }
        $this->_vista->action = BASE_URL . 'configurarbd';
        $this->_vista->setJs(array('funcion'));
        $this->_vista->renderizar('index');
    }

}

?>
