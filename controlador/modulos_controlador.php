<?php

class modulos_controlador extends controller{

    private $_modulos;

    public function __construct() {
        if (!$this->acceso()) {
            $this->redireccionar('error/access/5050');
        }
        parent::__construct();
        $this->_modulos = $this->cargar_modelo('modulos');
    }

    public function index() {
        $this->_vista->titulo = 'Lista de Modulos';
        $this->_vista->datos = $this->_modulos->selecciona();
        $this->_vista->setJs(array('funcion'));
        $this->_vista->setJs_Foot(array('scriptgrilla'));
        $this->_vista->renderizar('index');
    }
    
    public function buscador(){
        if($_POST['filtro']==0){
            $this->_modulos->descripcion=$_POST['cadena'];
            $this->_modulos->modulo_padre='';
        }else{
            $this->_modulos->descripcion='';
            $this->_modulos->modulo_padre=$_POST['cadena'];
        }
        
        echo json_encode($this->_modulos->selecciona());
    }

    public function nuevo() {
        if ($_POST['guardar'] == 1) {
            $this->_modulos->descripcion = $_POST['descripcion'];
            $this->_modulos->url = $_POST['url'];
            $this->_modulos->icono = $_POST['icono'];
            if(isset ($_POST['modulo_padre'])){
                $this->_modulos->idmodulo_padre = $_POST['modulo_padre'];
            }else{
                $this->_modulos->idmodulo_padre = 0;
            }
            $this->_modulos->estado = $_POST['estado'];
            $this->_modulos->inserta();
            $this->redireccionar('modulos');
        }
        $this->_vista->modulos_padre = $this->_modulos->seleccionar(0);
        $this->_vista->titulo = 'Registrar Modulo';
        $this->_vista->action = BASE_URL . 'modulos/nuevo';
        $this->_vista->setJs(array('funciones_form'));
        $this->_vista->renderizar('form');
    }

    public function editar($id) {
        if (!$this->filtrarInt($id)) {
            $this->redireccionar('modulos');
        }

        $this->_modulos->idmodulo = $this->filtrarInt($id);
        $this->_vista->datos = $this->_modulos->selecciona();

        if ($_POST['guardar'] == 1) {
            $this->_modulos->idmodulo = $_POST['codigo'];
            $this->_modulos->descripcion = $_POST['descripcion'];
            $this->_modulos->url = $_POST['url'];
            $this->_modulos->idmodulo_padre = $_POST['modulo_padre'];
            $this->_modulos->estado = $_POST['estado'];
            $this->_modulos->icono = $_POST['icono'];
            $this->_modulos->actualiza();
            $this->redireccionar('modulos');
        }
        $this->_vista->modulos_padre = $this->_modulos->seleccionar(0);
        $this->_vista->titulo = 'Actualizar Modulo';
        $this->_vista->setJs(array('funciones_form'));
        $this->_vista->renderizar('form');
    }

    public function eliminar($id) {
        if (!$this->filtrarInt($id)) {
            $this->redireccionar('modulos');
        }
        $this->_modulos->idmodulo = $this->filtrarInt($id);
        $this->_modulos->elimina();
        $this->redireccionar('modulos');
    }
    
}

?>
