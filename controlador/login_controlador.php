<?php

class login_controlador extends controller {
    
    private $_empleado;
    
    public function __construct() {
        parent::__construct();
        $this->_empleado=  $this->cargar_modelo('empleado');
    }

    public function index() {
        if($_POST['usuario'] == '' || $_POST['clave'] == ''){
            echo "<script>alert('Ingrese usuario y clave')</script>";
            $this->redireccionar();
        }
        $datos=$this->_empleado->seleccionar($_POST['usuario'],$_POST['clave']);
        $search  = array('á', 'é', 'í', 'ó', 'ú', 'ñ');
        $replace = array('Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ');
        foreach ($_POST as $key => $value) {
            $_POST[$key]=str_replace($search, $replace, strtoupper($value) );
        }
//        echo '<pre>';print_r($datos);exit;
        if($datos[0]['USUARIO']==$_POST['usuario'] && $datos[0]['CLAVE']==$_POST['clave'] && $datos[0]['ID_EMPLEADO']!=''){
            session::set('autenticado', true);
            session::set('empleado', $datos[0]['NOMBRE'].' '.$datos[0]['APELLIDO']);
            session::set('idempleado', $datos[0]['ID_EMPLEADO']);
            session::set('perfil', $datos[0]['DESCRIPCION']);
            session::set('idperfil', $datos[0]['ID_PERFIL']);
            $this->redireccionar();
        }else{
            echo '<script>alert("usuario o clave incorrecta")</script>';
            $this->redireccionar();
        }
    }
    
    public function mostrar() {
        echo 'Empleado: ' . session::get('empleado') . '<br>';
        echo 'Perfil: ' . session::get('perfil') . '<br>';
    }

    public function cerrar() {
        session::destroy();
        echo '<script>alert("Sesion finalizada")</script>';
        $this->redireccionar();
    }

}

?>
