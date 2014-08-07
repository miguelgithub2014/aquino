<?php

class barcode_controlador extends controller {

    private $_producto;

    public function __construct() {
        if (!$this->acceso()) {
            $this->redireccionar('error/access/5050');
        }
        parent::__construct();
        $this->_producto = $this->cargar_modelo('producto');
    }

    public function index() {
        $this->_vista->datos = $this->_producto->selecciona();
        $this->_vista->titulo = 'Generar Codigo de Barras';
        $this->_vista->setJs(array('funcion'));
        $this->_vista->setJs_Foot(array('scriptgrilla'));
        $this->_vista->renderizar('index');
    }
    
}

?>
