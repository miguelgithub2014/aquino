<?php

class servicios_web_controlador extends controller {
    
    private $_servicios;
    
    public function __construct() {
        if (!$this->acceso()) {
            $this->redireccionar('error/access/5050');
        }
        parent::__construct();
        $this->_servicios = $this->cargar_modelo('servicios_web');
    }

    public function index() {
        $this->_vista->titulo = 'Servicios de la Web';
        $this->_vista->datos = $this->_servicios->selecciona();
        $this->_vista->setJs_Foot(array('scriptgrilla'));
        $this->_vista->setJs(array('funcion'));
        $this->_vista->renderizar('index');
    }
    
    public function nuevo(){
        $imagen = "";   
        if ($_POST['guardar'] == 1) {
//	    echo "<pre>"; print_r($_FILES);exit;
	    if($_FILES['archivo']['name']!=''){
		set_time_limit(0);
		$this->get_Libreria('upload' . DS . 'class.upload');
		$dir_dest = ROOT . 'lib' . DS . 'img' . DS . 'servicios' . DS;
		$handle = new Upload($_FILES['archivo'], 'es_ES');
		if ($handle->uploaded) {
		    $handle->file_new_name_body = 'upl_' . uniqid();
		    $handle->image_resize = true;
		    $handle->image_x = 500;
		    $handle->image_y = 383;
		    $handle->Process($dir_dest);
		    $imagen = $handle->file_dst_name;
		}else {
		    die('Error al Subir Imagen');
		    $this->redireccionar('servicios_web');
		}
	    }
            $this->_servicios->titulo = $_POST['titulonot'];
            $this->_servicios->imagen = $imagen;
            $this->_servicios->inserta();   
            echo "<script>alert('Informacion Guardada')</script>";
            $this->redireccionar('servicios_web');
        }
        $this->_vista->titulo = 'Registrar Servicios de la Web';
        $this->_vista->setJs(array('funcionesform'));
        $this->_vista->renderizar('form');
    }
    
    public function editar($id){
        if (!$this->filtrarInt($id)) {
            $this->redireccionar('servicios_web');
        }
        $this->_servicios->id = $this->filtrarInt($id);
        $datos = $this->_servicios->selecciona();
//        echo '<pre>';print_r($datos);exit;
        $this->_vista->datos = $datos;
        $imagen="";
        if ($_POST['guardar'] == 1) {
            if($_POST['modificar_imagen'] == 1){
                $this->get_Libreria('upload' . DS . 'class.upload');
                $dir_dest = ROOT . 'lib' . DS . 'img' . DS . 'servicios' . DS;
                $handle = new Upload($_FILES['archivo'], 'es_ES');
                if ($handle->uploaded) {
                    $handle->file_new_name_body = 'upl_' . uniqid();
                    $handle->image_resize = true;
                    $handle->image_x = 250;
                    $handle->image_y = 250;
                    $handle->Process($dir_dest);
                    $imagen = $handle->file_dst_name;
                }else {
                    die('Error al Subir Imagen');
                }
            }else{
                $imagen = $_POST['imagen_existe'];
            }
            $this->_servicios->id = $_POST['codigo'];
            $this->_servicios->titulo = $_POST['titulonot'];
            $this->_servicios->imagen = $imagen;
            $this->_servicios->actualiza();
            echo "<script>alert('Informacion Guardada')</script>";
            $this->redireccionar('servicios_web');
        }
        $this->_vista->titulo = 'Actualizar Servicio de la Web';
        $this->_vista->setJs(array('funcionesform'));
        $this->_vista->renderizar('form');
    }
    
    public function buscar(){
        if($_POST['filtro']==0){
            $this->_servicios->titulo=$_POST['cadena'];
        }
        echo json_encode($this->_servicios->selecciona());
    }
    
    public function ver(){
        $this->_servicios->id=$_POST['id'];
       echo json_encode($this->_servicios->selecciona());
    }
        
    public function eliminar($id) {
        if (!$this->filtrarInt($id)) {
            $this->redireccionar('servicios_web');
        }
        $this->_servicios->id= $this->filtrarInt($id);
        $this->_servicios->elimina();
        echo "<script>alert('Informacion Eliminada')</script>";
        $this->redireccionar('servicios_web');
    }
    
}
?>