<?php

class perfiles_controlador extends controller {

    private $_perfiles;

    public function __construct() {
        if (!$this->acceso()) {
            $this->redireccionar('error/access/5050');
        }
        parent::__construct();
        $this->_perfiles = $this->cargar_modelo('perfiles');
    }

    public function index() {
        $this->_vista->titulo = 'Lista de Perfiles';
        $this->_vista->datos = $this->_perfiles->selecciona();
        $this->_vista->setJs(array('funcion'));
        $this->_vista->setJs_Foot(array('scriptgrilla'));
        $this->_vista->renderizar('index');
    }
    
    public function buscador(){
        if($_POST['filtro']==0){
            $this->_perfiles->descripcion=$_POST['descripcion'];
        }
        echo json_encode($this->_perfiles->selecciona());
    }
    
    public function nuevo() {
        if ($_POST['guardar'] == 1) {
            $this->_perfiles->descripcion = $_POST['descripcion'];
            $this->_perfiles->inserta();
            $this->redireccionar('perfiles');
        }
        $this->_vista->titulo = 'Registrar Perfil';
        $this->_vista->action = BASE_URL . 'perfiles/nuevo';
        $this->_vista->setJs(array('funciones_form'));
        $this->_vista->renderizar('form');
    }

    public function editar($id) {
        if (!$this->filtrarInt($id)) {
            $this->redireccionar('perfiles');
        }

        $this->_perfiles->idperfil = $this->filtrarInt($id);
        $this->_vista->datos = $this->_perfiles->selecciona();

        if ($_POST['guardar'] == 1) {
            $this->_perfiles->idperfil = $_POST['codigo'];
            $this->_perfiles->descripcion = $_POST['descripcion'];
            $this->_perfiles->actualiza();
            $this->redireccionar('perfiles');
        }
        $this->_vista->titulo = 'Actualizar Perfil';
        $this->_vista->setJs(array('funciones_form'));
        $this->_vista->renderizar('form');
    }

    public function eliminar($id) {
        if (!$this->filtrarInt($id)) {
            $this->redireccionar('perfiles');
        }
        $this->_perfiles->idperfil = $this->filtrarInt($id);
        $this->_perfiles->elimina();
        $this->redireccionar('perfiles');
    }

}

?>
