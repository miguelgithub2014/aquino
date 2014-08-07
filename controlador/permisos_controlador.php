<?php

class permisos_controlador extends controller {

    private $_permisos;
    private $_perfiles;
    private $_modulos;

    public function __construct() {
        if (!$this->acceso()) {
            $this->redireccionar('error/access/5050');
        }
        parent::__construct();
        $this->_permisos = $this->cargar_modelo('permisos');
        $this->_perfiles= $this->cargar_modelo('perfiles');
        $this->_modulos= $this->cargar_modelo('modulos');
    }

    public function index() {
        $this->_vista->titulo = 'Permisos';
        $this->_perfiles->idperfil=0;
        $this->_vista->datos_perfiles=$this->_perfiles->selecciona();
        $this->_modulos->idmodulo=0;
        $this->_modulos->descripcion='';
        $this->_modulos->modulo_padre='';
        $this->_vista->datos_modulos=$this->_modulos->selecciona();
        $this->_vista->setJs(array('funcion'));
        $this->_vista->setCss(array('estilos'));
        $this->_vista->renderizar('index');
    }

    public function get_permisos() {
        $this->_permisos->idperfil=$_POST['idperfil'];
        $this->_permisos->idmodulo=0;
        echo json_encode($this->_permisos->selecciona());
    }
    
    public function inserta_permiso() {
        $this->_permisos->idperfil=$_POST['idperfil'];
        $this->_permisos->idmodulo=$_POST['idmodulo'];
        $this->_permisos->estado=1;
        $this->_permisos->inserta();
    }
    
    public function elimina_permiso(){
        $this->_permisos->idperfil=$_POST['idperfil'];
        $this->_permisos->idmodulo=$_POST['idmodulo'];
        $this->_permisos->elimina();
    }

}

?>
