<?php

class insumo_controlador extends controller{

    private $_insumo;
    private $_almacen;
    private $_unidadmedida;
    private $_detinsumoum;
//    private $_kardex_insumo;

    public function __construct() {
        if (!$this->acceso()) {
            $this->redireccionar('error/access/5050');
        }
        parent::__construct();
        $this->_insumo=  $this->cargar_modelo('insumo');
        $this->_almacen=  $this->cargar_modelo('almacenes');
        $this->_unidadmedida=  $this->cargar_modelo('unidadmedida');
        $this->_detinsumoum=  $this->cargar_modelo('detinsumoum');
//        $this->_kardex_insumo=  $this->cargar_modelo('kardex_insumo');
    }

    public function index() {
        $this->_vista->titulo = 'Lista de Insumos';
        $this->_vista->datos = $this->_insumo->selecciona();
        $this->_vista->setJs(array('funcion'));
        $this->_vista->setJs_Foot(array('scriptgrilla'));
        $this->_vista->renderizar('index');
    }
    
    public function buscador(){
        if($_POST['filtro']==0){
            $this->_insumo->descripcion=$_POST['cadena'];
        }
        if($_POST['filtro']==1){
            $this->_insumo->almacen=$_POST['cadena'];
        }
        echo json_encode($this->_insumo->selecciona());
    }

    public function nuevo() {
//        echo '<pre>';print_r($_POST);exit;
        if ($_POST['guardar'] == 1) {
            $this->_insumo->id_almacen = $_POST['id_almacen'];
            $this->_insumo->descripcion = $_POST['descripcion'];
            $this->_insumo->id_unidadmedida = $_POST['id_unidadmedida'];
            $datos = $this->_insumo->inserta();
            //Insertamos unidad de medida x insumo
            $this->_detinsumoum->id_insumo = $datos[0]['INS_INSUMO'];
            $this->_detinsumoum->id_unidadmedida = $_POST['id_unidadmedida'];
            $this->_detinsumoum->inserta();
            
            $this->redireccionar('insumo');
        }
        $this->_vista->datos_almacen = $this->_almacen->selecciona();
        $this->_vista->datos_unidadmedida = $this->_unidadmedida->selecciona_unidadbase();
        $this->_vista->titulo = 'Registrar Insumo';
        $this->_vista->action = BASE_URL . 'insumo/nuevo';
        $this->_vista->setJs(array('funciones_form'));
        $this->_vista->renderizar('form');
    }

    public function editar($id) {
        if (!$this->filtrarInt($id)) {
            $this->redireccionar('insumo');
        }

        $this->_insumo->id_insumo = $this->filtrarInt($id);
        $datos = $this->_insumo->selecciona();
//        echo '<pre>';print_r($datos);exit;
        $this->_vista->datos = $datos;

        if ($_POST['guardar'] == 1) {
            $this->_insumo->id_insumo = $_POST['codigo'];
            $this->_insumo->id_almacen = $_POST['id_almacen'];
            $this->_insumo->descripcion = $_POST['descripcion'];
            $this->_insumo->id_unidadmedida = $_POST['id_unidadmedida'];
            $this->_insumo->actualiza();
            
            $this->redireccionar('insumo');
        }
        $this->_vista->datos_almacen = $this->_almacen->selecciona();
        $this->_vista->datos_unidadmedida = $this->_unidadmedida->selecciona_unidadbase();
       $this->_vista->titulo = 'Actualizar Insumo';
        $this->_vista->setJs(array('funciones_form'));
        $this->_vista->renderizar('form');
    }

    public function eliminar($id) {
        if (!$this->filtrarInt($id)) {
            $this->redireccionar('insumo');
        }
        $this->_insumo->id_insumo = $this->filtrarInt($id);
        $this->_insumo->elimina();
        $this->redireccionar('insumo');
    }
    
    public function asignarunidades($id){
        if (!$this->filtrarInt($id)) {
            $this->redireccionar('insumo');
        }
        $this->_insumo->id_insumo = $this->filtrarInt($id);
        $this->_vista->id_insumo = $this->filtrarInt($id);
        $insumo = $this->_insumo->selecciona();
        $this->_unidadmedida->id_unidadmedida = $insumo[0]['ID_UNIDADMEDIDA'];
        $this->_vista->datos_detinsumoum = $this->_unidadmedida->selecciona_unidadbase();
        $this->_detinsumoum->id_insumo = $this->filtrarInt($id);
        $this->_vista->datos = $this->_detinsumoum->selecciona();
        $this->_vista->titulo = 'Asignar Unidades Equivalentes';
        $this->_vista->action = BASE_URL . 'insumo/asignarunidades';
        $this->_vista->setJs(array('funciones_asignarunidades'));
        $this->_vista->renderizar('formasignarunidades');
    }
    
    public function getUnidadMedida(){
        $this->_detinsumoum->id_insumo = $_POST['codigo'];
        $this->_detinsumoum->id_unidadmedida = $_POST['id_unidadmedida'];
        echo json_encode($this->_detinsumoum->selecciona());
    }
    
    public function addUnidadMedida(){
        $this->_detinsumoum->id_insumo = $_POST['codigo'];
        $this->_detinsumoum->id_unidadmedida = $_POST['id_unidadmedida'];
        $this->_detinsumoum->inserta();
        echo json_encode(array('code'=>'ok'));
    }
    
    public function delUnidadMedida(){
        $this->_detinsumoum->id_insumo = $_POST['id_insumo'];
        $this->_detinsumoum->id_unidadmedida = $_POST['id_unidadmedida'];
        $this->_detinsumoum->elimina();
        echo json_encode(array('code'=>'ok'));
    }
    
    public function getUnidadesInsumo(){
        $this->_detinsumoum->id_insumo = $_POST['id_insumo'];
        echo json_encode($this->_detinsumoum->selecciona());
    }
    
    public function kardex($id){
        if (!$this->filtrarInt($id)) {
            $this->redireccionar('insumo');
        }
        $this->_kardex_insumo->id_insumo = $this->filtrarInt($id);
        $this->_vista->datos = $this->_kardex_insumo->selecciona();
        $this->_vista->titulo = 'Movimiento de Insumo';
        $this->_vista->action = BASE_URL . 'insumo/kardex';
        $this->_vista->renderizar('kardex');
    }
    
}

?>
