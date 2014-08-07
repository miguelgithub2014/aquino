<?php

//require_once '../modelo/empleados.php';
class webservice_controlador extends controller {

    private $_empleados;
    private $_producto;
    private $_caja;
    private $_proveedor;
    public function __construct() {
        parent::__construct();
        $this->_empleado = $this->cargar_modelo('empleado');
        $this->_producto= $this->cargar_modelo('producto');
        $this->_caja= $this->cargar_modelo('caja');
        $this->_proveedor= $this->cargar_modelo('proveedor');
    }

    //put your code here 
    public function index() {
        $this->_vista->renderizar_webservice('servidor');
    }

    public function login_usuario($usuario, $pass) {
        $r = $this->_empleado->login_android($usuario, $pass);
        return $r;
    }
    
    public function selecciona_productos(){
        $r= $this->_producto->selecciona_android();
        return $r;
    }
    
     public function get_producto($id){
        $r= $this->_producto->get_producto_android($id);
        return $r;
    }
    
    public function selecciona_caja(){
        $r= $this->_caja->selecciona_android();
        return $r;
    }
        public function selecciona_proveedor(){
        $r= $this->_proveedor->selecciona_android();
        return $r;
    }
}

?>
