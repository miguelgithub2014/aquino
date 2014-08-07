<?php

class almacenes_controlador extends controller {

    private $_almacenes;

    public function __construct() {
        if (!$this->acceso()) {
            $this->redireccionar('error/access/5050');
        }
        parent::__construct();
        $this->_almacenes = $this->cargar_modelo('almacenes');
    }

    public function index() {
        $this->_vista->titulo = 'Lista de Almacenes';
        $this->_vista->datos = $this->_almacenes->selecciona();
        $this->_vista->setJs(array('funcion'));
        $this->_vista->setJs_Foot(array('scriptgrilla'));
        $this->_vista->renderizar('index');
    }
    
    public function buscador(){
        if($_POST['filtro']==0){
            $this->_almacenes->descripcion=$_POST['descripcion'];
        }
        if($_POST['filtro']==1){
            $this->_almacenes->ubicacion=$_POST['descripcion'];
        }
        if($_POST['filtro']==2){
            $this->_almacenes->sucursal=$_POST['descripcion'];
        }
        echo json_encode($this->_almacenes->selecciona());
    }
    
    public function nuevo() {
        if ($_POST['guardar'] == 1) {
            $this->_almacenes->descripcion = $_POST['descripcion'];
            $this->_almacenes->ubicacion = $_POST['ubicacion'];
            $this->_almacenes->id_sucursal = $_POST['id_sucursal'];
            $datos = $this->_almacenes->inserta();
            //Insertamos productos x almacenes
            $datos_producto = $this->_producto->selecciona();
            for($i=0;$i<count($datos_producto);$i++){
                $this->_detprodalm->id_almacen = $datos[0]['INS_ALMACEN'];
                $this->_detprodalm->id_producto = $datos_producto[$i]['ID_PRODUCTO'];
                $this->_detprodalm->stock = 0;
                $this->_detprodalm->inserta();
            }
            $this->redireccionar('almacenes');
        }
        $this->_vista->titulo = 'Registrar Almacen';
        $this->_vista->action = BASE_URL . 'almacenes/nuevo';
        $this->_vista->setJs(array('funciones_form'));
        $this->_vista->renderizar('form');
    }

    public function editar($id) {
        if (!$this->filtrarInt($id)) {
            $this->redireccionar('almacenes');
        }

        $this->_almacenes->idalmacen = $this->filtrarInt($id);
        $this->_vista->datos = $this->_almacenes->selecciona();

        if ($_POST['guardar'] == 1) {
            $this->_almacenes->idalmacen = $_POST['codigo'];
            $this->_almacenes->descripcion = $_POST['descripcion'];
            $this->_almacenes->ubicacion = $_POST['ubicacion'];
            $this->_almacenes->id_sucursal = $_POST['id_sucursal'];
            $this->_almacenes->actualiza();
            $this->redireccionar('almacenes');
        }
        $this->_vista->titulo = 'Actualizar Almacen';
        $this->_vista->setJs(array('funciones_form'));
        $this->_vista->renderizar('form');
    }

    public function eliminar($id) {
        if (!$this->filtrarInt($id)) {
            $this->redireccionar('almacenes');
        }
        $this->_almacenes->idalmacen = $this->filtrarInt($id);
        $this->_almacenes->elimina();
        $this->redireccionar('almacenes');
    }

}

?>
