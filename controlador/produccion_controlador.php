<?php

class produccion_controlador extends controller {
    
    private $_produccion;
    private $_detproducinsumo;
    private $_venta;

    public function __construct() {
        if (!$this->acceso()) {
            $this->redireccionar('error/access/5050');
        }
        parent::__construct();
        $this->_produccion = $this->cargar_modelo('produccion');
        $this->_detproducinsumo = $this->cargar_modelo('detproducinsumo');
        $this->_venta = $this->cargar_modelo('venta');
    }

    public function index() {
        $this->_vista->titulo = 'Lista de Producciones';
        $this->_vista->datos = $this->_produccion->selecciona();
        $this->_vista->setJs(array('funcion'));
        $this->_vista->setJs_Foot(array('scriptgrilla'));
        $this->_vista->renderizar('index');
    }
    
    public function buscador(){
        if($_POST['filtro']==0){
            $this->_produccion->estadoproduccion=$_POST['descripcion'];
        }
        if($_POST['filtro']==1){
            $this->_produccion->nrodoc=$_POST['descripcion'];
        }
        echo json_encode($this->_produccion->selecciona());
    }
    
    public function buscadorVenta(){
        if($_POST['filtro']==0){
            $this->_venta->nrodoc=$_POST['descripcion'];
        }
        if($_POST['filtro']==3){
            $this->_venta->fechaventa=$_POST['descripcion'];
        }
        if($_POST['filtro']==1){
            $this->_venta->cliente=$_POST['descripcion'];
        }
        if($_POST['filtro']==2){
            $this->_venta->empleado=$_POST['descripcion'];
        }
        echo json_encode($this->_venta->selVentaSinProduccion());
    }
    
    public function nuevo() {
        if ($_POST['guardar'] == 1) {
//            echo '<pre>';print_r($_POST);exit;
            $this->_produccion->id_venta = $_POST['id_venta'];
            $this->_produccion->id_empleado = $_POST['id_empleado'];
            $this->_produccion->fecha_programada = $_POST['fecha_programada'];
            $dato_produccion = $this->_produccion->inserta();
//            echo '<pre>';print_r($dato_produccion);exit;
            
            for($i=0;$i<count($_POST['id_insumo']);$i++){
                $this->_detproducinsumo->id_produccion=$dato_produccion[0]['INS_PRODUCCION'];
                $this->_detproducinsumo->id_insumo= $_POST['id_insumo'][$i];
                $this->_detproducinsumo->cantidadum= $_POST['cantidadum'][$i];
                $this->_detproducinsumo->id_unidadmedida= $_POST['id_unidadmedida'][$i];
                $this->_detproducinsumo->cantidadub= $_POST['cantidadub'][$i];
                
                $this->_detproducinsumo->inserta();
            }
            $this->redireccionar('produccion');
        }
        $this->_vista->titulo = 'Registrar Produccion';
        $this->_vista->action = BASE_URL . 'produccion/nuevo';
        $this->_vista->setJs(array('funciones_form','jquery-ui.min'));
        $this->_vista->renderizar('form');
    }

    public function eliminar($id) {
        if (!$this->filtrarInt($id)) {
            $this->redireccionar('produccion');
        }
        $this->_produccion->idproduccion = $this->filtrarInt($id);
        $this->_produccion->elimina();
        $this->redireccionar('produccion');
    }
    
    public function ver(){
        $this->_produccion->id_produccion = $_POST['id_produccion'];
        $produccion = $this->_produccion->selecciona();
        
        $this->_detproducinsumo->id_produccion = $_POST['id_produccion'];
        $detproducinsumo = $this->_detproducinsumo->selecciona();
        
        echo json_encode(array('produccion'=>$produccion, 'detproducinsumo'=>$detproducinsumo));
    }
    
    public function entregar($id){
        $this->_produccion->id_produccion = $id;
        $this->_produccion->entregar();
        
        $this->redireccionar('produccion');
    }
    
}

?>
