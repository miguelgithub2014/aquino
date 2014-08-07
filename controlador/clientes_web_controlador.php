<?php

class clientes_web_controlador extends controller {
    
    private $_servicios;
    
    public function __construct() {
        if (!$this->acceso()) {
            $this->redireccionar('error/access/5050');
        }
        parent::__construct();
        $this->_clientes = $this->cargar_modelo('clientes_web');
    }

    public function index() {
        $this->_vista->titulo = 'Clientes de la Web';
        $this->_vista->datos = $this->_clientes->selecciona();
        $this->_vista->setJs_Foot(array('scriptgrilla'));
        $this->_vista->setJs(array('funcion'));
        $this->_vista->renderizar('index');
    }
    
    public function nuevo(){
        $imagen = "";   
        if ($_POST['guardar'] == 1) {
	    set_time_limit(0);
            $this->get_Libreria('upload' . DS . 'class.upload');
            $dir_dest = ROOT . 'lib' . DS . 'img' . DS . 'clientes' . DS;
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
                $this->redireccionar('clientes_web');
            }
            $this->_clientes->titulo = $_POST['titulonot'];
            $this->_clientes->url = $_POST['url'];
            $this->_clientes->imagen = $imagen;
            $this->_clientes->inserta();   
            echo "<script>alert('Informacion Guardada')</script>";
            $this->redireccionar('clientes_web');
        }
        $this->_vista->titulo = 'Registrar Clientes de la Web';
        $this->_vista->setJs(array('funcionesform'));
        $this->_vista->renderizar('form');
    }
    
    public function editar($id){
        if (!$this->filtrarInt($id)) {
            $this->redireccionar('clientes_web');
        }
        $this->_clientes->id = $this->filtrarInt($id);
        $datos = $this->_clientes->selecciona();
//        echo '<pre>';print_r($datos);exit;
        $this->_vista->datos = $datos;
        $imagen="";
        if ($_POST['guardar'] == 1) {
            if($_POST['modificar_imagen'] == 1){
                $this->get_Libreria('upload' . DS . 'class.upload');
                $dir_dest = ROOT . 'lib' . DS . 'img' . DS . 'clientes' . DS;
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
            $this->_clientes->id = $_POST['codigo'];
            $this->_clientes->titulo = $_POST['titulonot'];
            $this->_clientes->url = $_POST['url'];
            $this->_clientes->imagen = $imagen;
            $this->_clientes->actualiza();
            echo "<script>alert('Informacion Guardada')</script>";
            $this->redireccionar('clientes_web');
        }
        $this->_vista->titulo = 'Actualizar Cliente de la Web';
        $this->_vista->setJs(array('funcionesform'));
        $this->_vista->renderizar('form');
    }
    
    public function buscar(){
        if($_POST['filtro']==0){
            $this->_clientes->titulo=$_POST['cadena'];
        }
        echo json_encode($this->_clientes->selecciona());
    }
    
    public function ver(){
        $this->_clientes->id=$_POST['id'];
       echo json_encode($this->_clientes->selecciona());
    }
        
    public function eliminar($id) {
        if (!$this->filtrarInt($id)) {
            $this->redireccionar('clientes_web');
        }
        $this->_clientes->id= $this->filtrarInt($id);
        $this->_clientes->elimina();
        echo "<script>alert('Informacion Eliminada')</script>";
        $this->redireccionar('clientes_web');
    }
    
}
?>