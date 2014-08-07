<?php

class servicio_controlador extends controller {
    
    private $_servicio;
    private $_tiposervicio;
    private $_unidadmedida;
    private $_detservicioum;

    public function __construct() {
        if (!$this->acceso()) {
            $this->redireccionar('error/access/5050');
        }
        parent::__construct();
        $this->_servicio = $this->cargar_modelo('servicio');
        $this->_tiposervicio = $this->cargar_modelo('tiposervicio');
        $this->_unidadmedida =  $this->cargar_modelo('unidadmedida');
        $this->_detservicioum =  $this->cargar_modelo('detservicioum');
    }

    public function index() {
        $this->_vista->titulo = 'Lista de Servicios';
        $this->_vista->datos = $this->_servicio->selecciona();
        $this->_vista->setJs(array('funcion'));
        $this->_vista->setJs_Foot(array('scriptgrilla'));
        $this->_vista->renderizar('index');
    }
    
    public function buscador(){
        if($_POST['filtro']==0){
            $this->_servicio->descripcion=$_POST['descripcion'];
        }
        if($_POST['filtro']==1){
            $this->_servicio->tiposervicio=$_POST['descripcion'];
        }
        echo json_encode($this->_servicio->selecciona());
    }
    
    public function nuevo() {
        if ($_POST['guardar'] == 1) {
            $this->_servicio->descripcion = $_POST['descripcion'];
            $this->_servicio->id_tiposervicio = $_POST['id_tiposervicio'];
            $this->_servicio->inserta();
            $this->redireccionar('servicio');
        }
        $this->_vista->datos_tiposervicio = $this->_tiposervicio->selecciona();
        $this->_vista->titulo = 'Registrar Servicio';
        $this->_vista->action = BASE_URL . 'servicio/nuevo';
        $this->_vista->setJs(array('funciones_form'));
        $this->_vista->renderizar('form');
    }
    
    public function asignarunidades($id){
        if (!$this->filtrarInt($id)) {
            $this->redireccionar('insumo');
        }
        $this->_servicio->id_servicio = $this->filtrarInt($id);
        $this->_vista->id_servicio = $this->filtrarInt($id);
        $this->_vista->datos_detservicioum = $this->_unidadmedida->selecciona();
        $this->_detservicioum->id_servicio = $this->filtrarInt($id);
        $this->_vista->datos = $this->_detservicioum->selecciona();
        $this->_vista->titulo = 'Asignar Unidades Equivalentes';
        $this->_vista->action = BASE_URL . 'servicio/asignarunidades';
        $this->_vista->setJs(array('funciones_asignarunidades'));
        $this->_vista->renderizar('formasignarunidades');
    }
    
    public function getUnidadMedida(){
        $this->_detservicioum->id_servicio = $_POST['codigo'];
        $this->_detservicioum->id_unidadmedida = $_POST['id_unidadmedida'];
        echo json_encode($this->_detservicioum->selecciona());
    }
    
    public function addUnidadMedida(){
        $this->_detservicioum->id_servicio = $_POST['codigo'];
        $this->_detservicioum->id_unidadmedida = $_POST['id_unidadmedida'];
        $this->_detservicioum->preciov = $_POST['preciov'];
        $this->_detservicioum->inserta();
        echo json_encode(array('code'=>'ok'));
    }
    
    public function delUnidadMedida(){
        $this->_detservicioum->id_servicio = $_POST['id_servicio'];
        $this->_detservicioum->id_unidadmedida = $_POST['id_unidadmedida'];
        $this->_detservicioum->elimina();
        echo json_encode(array('code'=>'ok'));
    }
    
    public function actPreciov(){
        $this->_detservicioum->id_servicio = $_POST['id_servicio'];
        $this->_detservicioum->id_unidadmedida = $_POST['id_unidadmedida'];
        $this->_detservicioum->preciov = $_POST['preciov'];
        $this->_detservicioum->actualiza();
        echo json_encode(array('code'=>'ok'));
    }
    
    public function getUnidadesServicio(){
        $this->_detservicioum->id_servicio = $_POST['id_servicio'];
        echo json_encode($this->_detservicioum->selecciona());
    }

    public function editar($id) {
        if (!$this->filtrarInt($id)) {
            $this->redireccionar('servicio');
        }

        $this->_servicio->id_servicio = $this->filtrarInt($id);
        $this->_vista->datos = $this->_servicio->selecciona();

        if ($_POST['guardar'] == 1) {
            $this->_servicio->id_servicio = $_POST['codigo'];
            $this->_servicio->descripcion = $_POST['descripcion'];
            $this->_servicio->id_tiposervicio = $_POST['id_tiposervicio'];
            $this->_servicio->actualiza();
            $this->redireccionar('servicio');
        }
        $this->_vista->datos_tiposervicio = $this->_tiposervicio->selecciona();
        $this->_vista->titulo = 'Actualizar Servicio';
        $this->_vista->setJs(array('funciones_form'));
        $this->_vista->renderizar('form');
    }

    public function eliminar($id) {
        if (!$this->filtrarInt($id)) {
            $this->redireccionar('servicio');
        }
        $this->_servicio->id_servicio = $this->filtrarInt($id);
        $this->_servicio->elimina();
        $this->redireccionar('servicio');
    }
    
}

?>
