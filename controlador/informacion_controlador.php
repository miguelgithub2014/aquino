<?php

class informacion_controlador extends controller {
    
    private $_informacion;

    public function __construct() {
        if (!$this->acceso()) {
            $this->redireccionar('error/access/5050');
        }
        parent::__construct();
        $this->_informacion = $this->cargar_modelo('informacion');
    }

    public function index() {
        $this->_vista->titulo = 'Información de Aquinos Grafica Integral';
        $this->_vista->setJs(array('js'));
        $this->_vista->datos = $this->_informacion->selecciona();
        $this->_vista->renderizar('index');
    }
    
    public function editar(){
        $this->_vista->datos = $this->_informacion->selecciona();
        if ($_POST['guardar'] == 1) {
            $this->_informacion->conocenos = $_POST['conocenos'];
            $this->_informacion->mision = $_POST['mision'];
            $this->_informacion->vision = $_POST['vision'];
            $this->_informacion->historia = $_POST['historia'];
            $this->_informacion->actualiza();
            echo "<script>alert('Datos Guardados');</script>";
            $this->redireccionar('informacion');
        }
        $this->_vista->titulo = 'Actualizar Datos';
        $this->_vista->setJs(array('formjs'));
        $this->_vista->renderizar('form');
    }
    
    public function ver(){
        $this->_informacion->id=$_POST['id'];
       echo json_encode($this->_informacion->selecciona());
    }
    
}
?>
