<?php

class param_controlador extends controller {

    private $_param;

    public function __construct() {
        if (!$this->acceso()) {
            $this->redireccionar('error/access/5050');
        }
        parent::__construct();
        $this->_param = $this->cargar_modelo('param');
    }

    public function index() {
        $this->_vista->titulo = 'Lista de Parametros';
        $this->_vista->datos = $this->_param->selecciona();
        $this->_vista->setJs(array('funcion'));
        $this->_vista->setJs_Foot(array('scriptgrilla'));
        $this->_vista->renderizar('index');
    }
    
    public function buscador(){
        if($_POST['filtro']==0){
            $this->_param->id_param=$_POST['id_param'];
        }
        echo json_encode($this->_param->selecciona());
    }
    
    public function nuevo() {
        if ($_POST['guardar'] == 1) {
//            echo '<pre>';print_r($_POST);exit;
            $this->_param->id_param = $_POST['id_param'];
            $this->_param->valor = $_POST['valor'];
            $this->_param->descripcion = $_POST['descripcion'];
            $this->_param->inserta();
            $this->redireccionar('param');
        }
        $this->_vista->titulo = 'Registrar Parametro';
        $this->_vista->action = BASE_URL . 'param/nuevo';
        $this->_vista->setJs(array('funciones_form'));
        $this->_vista->renderizar('form');
    }

    public function editar($id) {
        $this->_param->id_param = $id;
        $this->_vista->datos = $this->_param->selecciona();

        if ($_POST['guardar'] == 1) {
            $this->_param->id_param = $_POST['id_param'];
            $this->_param->valor = $_POST['valor'];
            $this->_param->descripcion = $_POST['descripcion'];
            $this->_param->actualiza();
            $this->redireccionar('param');
        }
        $this->_vista->titulo = 'Actualizar Parametro';
        $this->_vista->setJs(array('funciones_form'));
        $this->_vista->renderizar('form');
    }

    public function eliminar($id) {
        $this->_param->id_param = $id;
        $this->_param->elimina();
        $this->redireccionar('param');
    }
    
    public function getParam(){
        $this->_param->id_param = $_POST['id_param'];
        echo json_encode($this->_param->selecciona());
    }

}

?>
