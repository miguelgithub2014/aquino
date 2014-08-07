<?php

class movimiento_controlador extends controller{
    
    private $_movimiento;
    private $_caja;
    private $_concepto;
    private $_tipoconcepto;

    public function __construct() {
        if (!$this->acceso()) {
            $this->redireccionar('error/access/5050');
        }
        parent::__construct();
        $this->_movimiento=  $this->cargar_modelo('movimiento');
        $this->_caja=  $this->cargar_modelo('caja');
        $this->_concepto=  $this->cargar_modelo('concepto');
        $this->_tipoconcepto = $this->cargar_modelo('tipoconcepto');
    }

    public function index() {
        $this->_vista->titulo = 'Lista de Movimientos de Caja';
        $this->_vista->datos= $this->_movimiento->selecciona();
        $this->_vista->setJs(array('funcion'));
        $this->_vista->setJs_Foot(array('scriptgrilla'));
        $this->_vista->renderizar('index');
    }
    
    public function buscador(){
        if($_POST['filtro']==0){
            $this->_movimiento->descripcion=$_POST['descripcion'];
        }
        echo json_encode($this->_movimiento->selecciona());
    }
    
    public function nuevo(){
        $datos_caja=$this->_caja->selecciona();
        if($datos_caja[0]['ESTADO']==0){
            echo '<script>alert("Aperture la caja antes de cualquier movimiento")</script>';
            $this->redireccionar('caja');
        }
        if(new DateTime((substr($datos_caja[0]['A_FECHA'],0,10)),new DateTimeZone('America/Lima'))!=new DateTime(date('d-m-Y'),new DateTimeZone('America/Lima'))){
            echo '<script>alert("Cierre la caja de fecha pasada y aperture la caja para el dia de hoy")</script>';
            $this->redireccionar('caja');
        }
        if($datos_caja[0]['ID_EMPLEADO']!=session::get('idempleado')){
            echo '<script>alert("Usted No es es el Empleado que aperturo Caja")</script>';
            $this->redireccionar('movimiento');
        }
        if($_POST['guardar']==1){
//            print_r($_POST);exit;
            $datos_caja=$this->_caja->selecciona();
            if($_POST['id_tipoconcepto']==2){
                $monto = $_POST['monto'];
                if($datos_caja[0]['SALDO_CI']<$monto){
                    echo '<script>alert("No hay suficiente saldo para ejecutar el pago")</script>';
                    $this->redireccionar('movimiento');
                }
            }
            //insertar movimiento caja
            $this->_movimiento->idcaja=$datos_caja[0]['ID_CAJA'];
            if($_POST['id_formapago'] == 0){
                $this->_movimiento->id_formapago=1;
            }
            else{
                $this->_movimiento->id_formapago=$_POST['id_formapago'];
            }
            $this->_movimiento->idconcepto=$_POST['concepto'];
            $this->_movimiento->monto=$_POST['monto'];
            $this->_movimiento->fecha=date("Y-m-d H:i:s");
            $this->_movimiento->referencia=$_POST['referencia'];
            $this->_movimiento->inserta();

            //actualiza saldo caja
            if($_POST['id_tipoconcepto']==2){
                $this->_caja->aumenta=0;
            }else{
                $this->_caja->aumenta=1;
            }
            $this->_caja->idcaja=$datos_caja[0]['ID_CAJA'];
            $this->_caja->saldo=$_POST['monto'];
            $this->_caja->actualiza();
            $this->redireccionar('movimiento');
            
        }
        $this->_vista->datos_tipoconcepto = $this->_tipoconcepto->selecciona();
        $this->_vista->titulo='Registrar Movimiento Caja';
        $this->_vista->setJs(array('funciones_form'));
        $this->_vista->renderizar('form');
    }
    
    public function extornar($id){
        if (!$this->filtrarInt($id)) {
            $this->redireccionar('producto');
        }
        $this->_movimiento->idmovimiento = $this->filtrarInt($id);
        $datos_movimiento = $this->_movimiento->selecciona();
//        echo '<pre>'; print_r($datos_movimiento);exit;
        /*
         * Actualizamos saldo caja
         */
        if($datos_movimiento[0]['ID_TIPOCONCEPTO']==2){
            $this->_caja->saldo=$datos_movimiento[0]['MONTO'];
            $this->_caja->aumenta=1;
            $this->_caja->actualiza();
        }else{
            $this->_caja->saldo=$datos_movimiento[0]['MONTO'];
            $this->_caja->aumenta=0;
            $this->_caja->actualiza();
        }
        /*
         * Eliminamos movimiento
         */        
        $this->_movimiento->idmovimiento = $this->filtrarInt($id);
        $this->_movimiento->elimina();
        $this->redireccionar('movimiento');
    }
    
}

?>
