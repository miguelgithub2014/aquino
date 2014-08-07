<?php

class proveedor_controlador extends controller{

    private $_proveedor;

    public function __construct() {
        if (!$this->acceso()) {
            $this->redireccionar('error/access/5050');
        }
        parent::__construct();
        $this->_proveedor=  $this->cargar_modelo('proveedor');
    }

    public function index() {
        $this->_vista->titulo = 'Lista de Proveedores';
        $this->_vista->datos = $this->_proveedor->selecciona();
        $this->_vista->setJs(array('funcion'));
        $this->_vista->setJs_Foot(array('scriptgrilla'));
        $this->_vista->renderizar('index');
    }
    
    public function ver(){
        $this->_proveedor->id_proveedor=$_POST['id'];
        echo json_encode($this->_proveedor->selecciona());
    }
    
    public function buscador(){
        if($_POST['filtro']==0){
            $this->_proveedor->razonsocial=$_POST['cadena'];
        }
        if($_POST['filtro']==1){
            $this->_proveedor->nombre=$_POST['cadena'];
        }
        if($_POST['filtro']==2){
            $this->_proveedor->ruc=$_POST['cadena'];
        }
        echo json_encode($this->_proveedor->selecciona());
    }

    public function nuevo() {
//        echo '<pre>';print_r($_POST);exit;
        if ($_POST['guardar'] == 1) {
            $this->_proveedor->nombre = $_POST['nombre'];
            $this->_proveedor->direccion = $_POST['direccion'];
            $this->_proveedor->telefmovil = $_POST['telefmovil'];
            $this->_proveedor->razonsocial = $_POST['razonsocial'];
            $this->_proveedor->email = $_POST['email'];
            $this->_proveedor->ciudad = $_POST['ciudad'];
            $this->_proveedor->ruc = $_POST['ruc'];
            $this->_proveedor->inserta();
            $this->redireccionar('proveedor');
        }
        $this->_vista->titulo = 'Registrar Proveedor';
        $this->_vista->action = BASE_URL . 'proveedor/nuevo';
        $this->_vista->setJs(array('funciones_form'));
        $this->_vista->renderizar('form');
    }

    public function editar($id) {
        if (!$this->filtrarInt($id)) {
            $this->redireccionar('proveedor');
        }

        $this->_proveedor->id_proveedor = $this->filtrarInt($id);
        $this->_vista->datos = $this->_proveedor->selecciona();

        if ($_POST['guardar'] == 1) {
            $this->_proveedor->id_proveedor = $_POST['codigo'];
            $this->_proveedor->nombre = $_POST['nombre'];
            $this->_proveedor->direccion = $_POST['direccion'];
            $this->_proveedor->telefmovil = $_POST['telefmovil'];
            $this->_proveedor->razonsocial = $_POST['razonsocial'];
            $this->_proveedor->email = $_POST['email'];
            $this->_proveedor->ciudad = $_POST['ciudad'];
            $this->_proveedor->ruc = $_POST['ruc'];
            $this->_proveedor->actualiza();
            $this->redireccionar('proveedor');
        }
        $this->_vista->titulo = 'Actualizar Proveedor';
        $this->_vista->setJs(array('funciones_form'));
        $this->_vista->renderizar('form');
    }

    public function eliminar($id) {
        if (!$this->filtrarInt($id)) {
            $this->redireccionar('proveedor');
        }
        $this->_proveedor->id_proveedor = $this->filtrarInt($id);
        $this->_proveedor->elimina();
        $this->redireccionar('proveedor');
    }
    
}

?>
