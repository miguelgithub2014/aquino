<?php

class web_controlador extends controller {
    
    private $_informacion;
    private $_clientes;

    public function __construct() {
        parent::__construct();
        $this->_informacion = $this->cargar_modelo('informacion');
        $this->_clientes = $this->cargar_modelo('clientes_web');
        $this->_servicios = $this->cargar_modelo('servicios_web');
    }
    
    public function index() {
        $this->_vista->datos_c = $this->_clientes->selecciona();
        $this->_vista->datos_s = $this->_servicios->selecciona();
        $this->_vista->renderiza_web('index');
    }
    
    public function nosotros(){
        $this->_vista->datos = $this->_informacion->selecciona();
        $this->_vista->renderiza_web('nosotros');
    }
    
    public function clientes(){
        $this->_vista->datos = $this->_clientes->selecciona();
        $this->_vista->renderiza_web('clientes');
    }
    
    public function servicios(){
        $this->_vista->datos = $this->_servicios->selecciona();
        $this->_vista->renderiza_web('servicios');
    }
        
    public function contactenos(){
        $this->_vista->renderiza_web('contactenos');
    }
    
}

?>
