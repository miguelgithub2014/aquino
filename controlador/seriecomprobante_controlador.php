<?php

class seriecomprobante_controlador extends controller {

    private $_seriecomprobante;

    public function __construct() {
        if (!$this->acceso()) {
            $this->redireccionar('error/access/5050');
        }
        parent::__construct();
        $this->_seriecomprobante = $this->cargar_modelo('seriecomprobante');
    }

    public function index() {
        $this->_vista->titulo = 'Lista de Serie de Comprobante';
        $this->_vista->datos = $this->_seriecomprobante->selecciona();
        $this->_vista->setJs(array('funcion'));
        $this->_vista->setJs_Foot(array('scriptgrilla'));
        $this->_vista->renderizar('index');
    }
    
    public function buscador(){
        if($_POST['filtro']==0){
            $this->_seriecomprobante->tipocomprobante=$_POST['descripcion'];
        }
        echo json_encode($this->_seriecomprobante->selecciona());
    }
    
    public function nuevo() {
        if ($_POST['guardar'] == 1) {
//            echo '<pre>';print_r($_POST);exit;
            $this->_seriecomprobante->serie = $_POST['serie'];
            $this->_seriecomprobante->maxcorrelativo = $_POST['maxcorrelativo'];
            $this->_seriecomprobante->id_tipocomprobante = $_POST['id_tipocomprobante'];
            $this->_seriecomprobante->inserta();
            $this->redireccionar('seriecomprobante');
        }
        $this->_vista->titulo = 'Registrar Serie Comprobante';
        $this->_vista->action = BASE_URL . 'seriecomprobante/nuevo';
        $this->_vista->setJs(array('funciones_form'));
        $this->_vista->renderizar('form');
    }

    public function editar($id) {
        if (!$this->filtrarInt($id)) {
            $this->redireccionar('seriecomprobante');
        }

        $this->_seriecomprobante->id_seriecomprobante = $this->filtrarInt($id);
        $this->_vista->datos = $this->_seriecomprobante->selecciona();

        if ($_POST['guardar'] == 1) {
            $this->_seriecomprobante->id_seriecomprobante = $_POST['codigo'];
            $this->_seriecomprobante->serie = $_POST['serie'];
            $this->_seriecomprobante->maxcorrelativo = $_POST['maxcorrelativo'];
            $this->_seriecomprobante->id_tipocomprobante = $_POST['id_tipocomprobante'];
            $this->_seriecomprobante->actualiza();
            $this->redireccionar('seriecomprobante');
        }
        $this->_vista->titulo = 'Actualizar Serie Comprobante';
        $this->_vista->setJs(array('funciones_form'));
        $this->_vista->renderizar('form');
    }

    public function eliminar($id) {
        if (!$this->filtrarInt($id)) {
            $this->redireccionar('seriecomprobante');
        }
        $this->_seriecomprobante->id_seriecomprobante = $this->filtrarInt($id);
        $this->_seriecomprobante->elimina();
        $this->redireccionar('seriecomprobante');
    }

}

?>
