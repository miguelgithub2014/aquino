<?php

class empleado_controlador extends controller{

    private $_empleado;
    private $_perfil;

    public function __construct() {
        if (!$this->acceso()) {
            $this->redireccionar('error/access/5050');
        }
        parent::__construct();
        $this->_empleado=  $this->cargar_modelo('empleado');
        $this->_perfil = $this->cargar_modelo('perfiles');
    }

    public function index() {
        $this->_vista->titulo = 'Lista de Empleados';
        $this->_vista->datos = $this->_empleado->selecciona();
        $this->_vista->setJs(array('funcion'));
        $this->_vista->setJs_Foot(array('scriptgrilla'));
        $this->_vista->renderizar('index');
    }
    
    public function ver(){
        $this->_empleado->id_empleado=$_POST['id'];
        echo json_encode($this->_empleado->selecciona());
    }
    
    public function buscador(){
        if($_POST['filtro']==0){
            $this->_empleado->nombre=$_POST['cadena'];
        }
        if($_POST['filtro']==1){
            $this->_empleado->apellido=$_POST['cadena'];
        }
        if($_POST['filtro']==2){
            $this->_empleado->usuario=$_POST['cadena'];
        }
        if($_POST['filtro']==3){
            $this->_empleado->perfil=$_POST['cadena'];
        }
        echo json_encode($this->_empleado->selecciona());
    }

    public function nuevo() {
//        echo '<pre>';print_r($_POST);exit;
        if ($_POST['guardar'] == 1) {
            $this->_empleado->nombre = $_POST['nombre'];
            $this->_empleado->apellido = $_POST['apellido'];
            $this->_empleado->direccion = $_POST['direccion'];
            $this->_empleado->telefono = $_POST['telefono'];
            $this->_empleado->dni = $_POST['dni'];
            $this->_empleado->fechanacimiento = $_POST['fechanacimiento'];
            $this->_empleado->usuario = $_POST['usuario'];
            $this->_empleado->clave = $_POST['clave'];
            $this->_empleado->id_perfil = $_POST['id_perfil'];
            $this->_empleado->estadocivil = $_POST['estadocivil'];
            $this->_empleado->inserta();
            $this->redireccionar('empleado');
        }
        $this->_vista->datos_perfil = $this->_perfil->selecciona();
        $this->_vista->titulo = 'Registrar Empleado';
        $this->_vista->action = BASE_URL . 'empleado/nuevo';
        $this->_vista->setJs(array('funciones_form','jquery-ui.min'));
        $this->_vista->renderizar('form');
    }

    public function editar($id) {
        if (!$this->filtrarInt($id)) {
            $this->redireccionar('empleado');
        }

        $this->_empleado->id_empleado = $this->filtrarInt($id);
        $this->_vista->datos = $this->_empleado->selecciona();

        if ($_POST['guardar'] == 1) {
            $this->_empleado->id_empleado = $_POST['codigo'];
            $this->_empleado->nombre = $_POST['nombre'];
            $this->_empleado->apellido = $_POST['apellido'];
            $this->_empleado->direccion = $_POST['direccion'];
            $this->_empleado->telefono = $_POST['telefono'];
            $this->_empleado->dni = $_POST['dni'];
            $this->_empleado->fechanacimiento = $_POST['fechanacimiento'];
            $this->_empleado->usuario = $_POST['usuario'];
            $this->_empleado->clave = $_POST['clave'];
            $this->_empleado->id_perfil = $_POST['id_perfil'];
            $this->_empleado->estadocivil = $_POST['estadocivil'];
            $this->_empleado->actualiza();
            $this->redireccionar('empleado');
        }
        $this->_vista->datos_perfil = $this->_perfil->selecciona();
        $this->_vista->titulo = 'Actualizar Empleado';
        $this->_vista->setJs(array('funciones_form','jquery-ui.min'));
        $this->_vista->renderizar('form');
    }

    public function eliminar($id) {
        if (!$this->filtrarInt($id)) {
            $this->redireccionar('empleado');
        }
        $this->_empleado->id_empleado = $this->filtrarInt($id);
        $this->_empleado->elimina();
        $this->redireccionar('empleado');
    }
    
}

?>
