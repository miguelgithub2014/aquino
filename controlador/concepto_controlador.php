<?php

class concepto_controlador extends controller {
    
    private $_concepto;
    private $_tipoconcepto;

    public function __construct() {
        if (!$this->acceso()) {
            $this->redireccionar('error/access/5050');
        }
        parent::__construct();
        $this->_concepto = $this->cargar_modelo('concepto');
        $this->_tipoconcepto = $this->cargar_modelo('tipoconcepto');
    }

    public function index() {
        $this->_vista->titulo = 'Lista de Conceptos';
        $this->_vista->datos = $this->_concepto->selecciona();
        $this->_vista->setJs(array('funcion'));
        $this->_vista->setJs_Foot(array('scriptgrilla'));
        $this->_vista->renderizar('index');
    }
    
    public function buscador(){
        if($_POST['filtro']==0){
            $this->_concepto->descripcion=$_POST['descripcion'];
        }
        if($_POST['filtro']==1){
            $this->_concepto->tipoconcepto=$_POST['descripcion'];
        }
        echo json_encode($this->_concepto->selecciona());
    }
    
    public function nuevo() {
        if ($_POST['guardar'] == 1) {
            $this->_concepto->descripcion = $_POST['descripcion'];
            $this->_concepto->id_tipoconcepto = $_POST['id_tipoconcepto'];
            $this->_concepto->inserta();
            $this->redireccionar('concepto');
        }
        $this->_vista->datos_tipoconcepto = $this->_tipoconcepto->selecciona();
        $this->_vista->titulo = 'Registrar Concepto';
        $this->_vista->action = BASE_URL . 'concepto/nuevo';
        $this->_vista->setJs(array('funciones_form'));
        $this->_vista->renderizar('form');
    }

    public function editar($id) {
        if (!$this->filtrarInt($id)) {
            $this->redireccionar('concepto');
        }

        $this->_concepto->idconcepto = $this->filtrarInt($id);
        $this->_vista->datos = $this->_concepto->selecciona();

        if ($_POST['guardar'] == 1) {
            $this->_concepto->idconcepto = $_POST['codigo'];
            $this->_concepto->descripcion = $_POST['descripcion'];
            $this->_concepto->id_tipoconcepto = $_POST['id_tipoconcepto'];
            $this->_concepto->actualiza();
            $this->redireccionar('concepto');
        }
        $this->_vista->datos_tipoconcepto = $this->_tipoconcepto->selecciona();
        $this->_vista->titulo = 'Actualizar Concepto';
        $this->_vista->setJs(array('funciones_form'));
        $this->_vista->renderizar('form');
    }

    public function eliminar($id) {
        if (!$this->filtrarInt($id)) {
            $this->redireccionar('concepto');
        }
        $this->_concepto->idconcepto = $this->filtrarInt($id);
        $this->_concepto->elimina();
        $this->redireccionar('concepto');
    }
    
}

?>
