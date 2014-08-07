<?php

class unidadmedida_controlador extends controller{

    private $_unidadmedida;

    public function __construct() {
        if (!$this->acceso()) {
            $this->redireccionar('error/access/5050');
        }
        parent::__construct();
        $this->_unidadmedida=  $this->cargar_modelo('unidadmedida');
    }

    public function index() {
        $this->_vista->titulo = 'Lista de Unidades de Medida';
        $this->_vista->datos = $this->_unidadmedida->selecciona();
        $this->_vista->setJs(array('funcion'));
        $this->_vista->setJs_Foot(array('scriptgrilla'));
        $this->_vista->renderizar('index');
    }
    
    public function buscador(){
        if($_POST['filtro']==0){
            $this->_unidadmedida->descripcion=$_POST['cadena'];
        }
        if($_POST['filtro']==1){
            $this->_unidadmedida->prefijo=$_POST['cadena'];
        }
        echo json_encode($this->_unidadmedida->selecciona());
    }

    public function nuevo() {
//        echo '<pre>';print_r($_POST);exit;
        if ($_POST['guardar'] == 1) {
            $this->_unidadmedida->descripcion = $_POST['descripcion'];
            $this->_unidadmedida->prefijo = $_POST['prefijo'];
            $this->_unidadmedida->cant_unidad = $_POST['cant_unidad'];
            $this->_unidadmedida->equivalenteunidad = $_POST['equivalenteunidad'];
            $this->_unidadmedida->inserta();
            $this->redireccionar('unidadmedida');
        }
        $this->_vista->datos_unidadbase = $this->_unidadmedida->selecciona_unidadbase();
        $this->_vista->titulo = 'Registrar Unidad de Medida';
        $this->_vista->action = BASE_URL . 'unidadmedida/nuevo';
        $this->_vista->setJs(array('funciones_form'));
        $this->_vista->renderizar('form');
    }

    public function editar($id) {
        if (!$this->filtrarInt($id)) {
            $this->redireccionar('unidadmedida');
        }
        $this->_vista->datos_unidadbase = $this->_unidadmedida->selecciona_unidadbase();
        $this->_unidadmedida->id_unidadmedida = $this->filtrarInt($id);
        $this->_vista->datos = $this->_unidadmedida->selecciona();

        if ($_POST['guardar'] == 1) {
            $this->_unidadmedida->id_unidadmedida = $_POST['codigo'];
            $this->_unidadmedida->descripcion = $_POST['descripcion'];
            $this->_unidadmedida->prefijo = $_POST['prefijo'];
            $this->_unidadmedida->cant_unidad = $_POST['cant_unidad'];
            $this->_unidadmedida->equivalenteunidad = $_POST['equivalenteunidad'];
            $this->_unidadmedida->actualiza();
            $this->redireccionar('unidadmedida');
        }
        $this->_vista->titulo = 'Actualizar Unidad de Medida';
        $this->_vista->setJs(array('funciones_form'));
        $this->_vista->renderizar('form');
    }

    public function eliminar($id) {
        if (!$this->filtrarInt($id)) {
            $this->redireccionar('unidadmedida');
        }
        $this->_unidadmedida->id_unidadmedida = $this->filtrarInt($id);
        $this->_unidadmedida->elimina();
        $this->redireccionar('unidadmedida');
    }
    
}

?>
