<?php

class cronogpago_controlador extends controller {

    private $_compra;
    private $_cronogpago;
    private $_caja;
    private $_movimiento;

    public function __construct() {
        if (!$this->acceso()) {
            $this->redireccionar('error/access/5050');
        }
        parent::__construct();
        $this->_cronogpago = $this->cargar_modelo('cronogpago');
        $this->_caja = $this->cargar_modelo('caja');
        $this->_movimiento = $this->cargar_modelo('movimiento');
        $this->_compra = $this->cargar_modelo('compra');
    }

    public function index() {
        $this->_vista->titulo = 'Lista de Cronograma de Pago';
        $this->_vista->datos = $this->_cronogpago->selecciona();
//        echo '<pre>';print_r($this->_cronogpago->selecciona());exit;
        $this->_vista->datos_cuota = $this->_cronogpago->selecciona_cuota();
        $this->_vista->setJs(array('funciones_index'));
        $this->_vista->setJs_Foot(array('scriptgrilla'));
        $this->_vista->renderizar('index');
    }
    
    public function buscador(){
        if($_POST['filtro']==0){
            $this->_cronogpago->proveedor=$_POST['cadena'];
        }
        echo json_encode($this->_cronogpago->selecciona());
    }

    public function cronograma($idcompra, $monto_restante) {
        $this->_cronogpago->id_compra = $idcompra;
        $this->_vista->datos = $this->_cronogpago->selecciona_cuota();
        $this->_vista->titulo = 'Cronograma de Pagos';
        $this->_vista->btn_action = BASE_URL . 'cronogpago/amortizar/' . $idcompra . '/' . $monto_restante;
        $this->_vista->renderizar('cronograma');
    }

    public function amortizar($idcompra, $monto_restante) {
        $this->_vista->titulo = 'Amortizar Deuda';
        $datos_caja = $this->_caja->selecciona();
        if ($datos_caja[0]['ESTADO'] == 0) {
            echo '<script>alert("Aperture la caja antes de cualquier movimiento")</script>';
            $this->redireccionar('caja');
        }
        if (new DateTime((substr($datos_caja[0]['A_FECHA'],0,10)),new DateTimeZone('America/Lima')) != new DateTime(date('d-m-Y'),new DateTimeZone('America/Lima'))) {
            echo '<script>alert("Cierre la caja de fecha pasada y aperture la caja para el dia de hoy")</script>';
            $this->redireccionar('caja');
        }
        if($datos_caja[0]['ID_EMPLEADO']!=session::get('idempleado')){
            echo '<script>alert("Usted No es es el Empleado que aperturo Caja")</script>';
            $this->redireccionar('cronogpago');
        }
        if ($_POST['guardar'] == 1) {
            if ($datos_caja[0]['SALDO_CI'] < $_POST['monto']) {
                echo '<script>alert("No hay suficiente saldo para ejecutar el pago")</script>';
                $this->redireccionar('caja');
            }

            $this->_cronogpago->id_compra = $idcompra;
            $datos_cronogpago = $this->_cronogpago->selecciona_cuota();
//            echo '<pre>';print_r($datos_cronogpago);exit;
            
            $monto_amortizado = $_POST['monto'];
            $c='';
            for ($i = 0; $i < count($datos_cronogpago); $i++) {
                $c=$i;
                if ($datos_cronogpago[$i]['MONTO_CUOTA'] > $datos_cronogpago[$i]['MONTO_PAGADO']) {
                    $monto_restantexcuota = $datos_cronogpago[$i]['MONTO_CUOTA'] - $datos_cronogpago[$i]['MONTO_PAGADO'];
                    if ($monto_amortizado != 0) {
                        if ($monto_restantexcuota >= $monto_amortizado) {
                            //actualiza monto_pagado en cuota_pago
                            $this->_cronogpago->id_cronogpago = $datos_cronogpago[$i]['ID_CRONOGPAGO'];
                            $this->_cronogpago->id_compra = $idcompra;
                            $this->_cronogpago->monto = $monto_amortizado + $datos_cronogpago[$i]['MONTO_PAGADO'];
                            $this->_cronogpago->nrocuota = $datos_cronogpago[$i]['NROCUOTA'];
                            $this->_cronogpago->actualiza();

                            $monto_amortizado = 0;
                        } else {
                            //actualiza monto_pagado en cuota_pago
                            $this->_cronogpago->id_cronogpago = $datos_cronogpago[$i]['ID_CRONOGPAGO'];
                            $this->_cronogpago->id_compra = $idcompra;
                            $this->_cronogpago->monto = $datos_cronogpago[$i]['MONTO_CUOTA'];
                            $this->_cronogpago->nrocuota = $datos_cronogpago[$i]['NROCUOTA'];
                            $this->_cronogpago->actualiza();

                            $monto_amortizado = $monto_amortizado - $monto_restantexcuota;
                        }
                    }
                }
            }
            
            //Datos compra
            $this->_compra->id_compra = $idcompra;
            $compra = $this->_compra->selecciona();
            
            //insertar movimiento caja
            $this->_movimiento->idconcepto = 5;
            $this->_movimiento->idcaja = $datos_caja[0]['ID_CAJA'];
            $this->_movimiento->monto = $_POST['monto'];
            $this->_movimiento->id_formapago = 1;
            $this->_movimiento->fecha=date("Y-m-d H:i:s");
            $this->_movimiento->referencia = 'PAGO A PROVEEDOR: "'.$compra[0]['PPROVEEDOR'].'" POR COMPRA NRO. DOC: '.$compra[0]['NRODOC'];
            $this->_movimiento->inserta();

            //actualiza saldo caja
            $this->_caja->idcaja = $datos_caja[0]['ID_CAJA'];
            $this->_caja->saldo = $_POST['monto'];
            $this->_caja->aumenta = 0;
            $this->_caja->actualiza();
            
            $dato_compra = $this->_cronogpago->selecciona();
            if(($dato_compra[0]['IGV']+1*$dato_compra[0]['MONTO'])==$dato_compra[0]['XMONTO_PAGADO']){
                $this->_cronogpago->id=$idcompra;
                $this->_cronogpago->estadopago=2;
                $this->_cronogpago->estadopago();
            }  else {
                $this->_cronogpago->id=$idcompra;
                $this->_cronogpago->estadopago=1;
                $this->_cronogpago->estadopago();
            }

            $this->redireccionar('cronogpago');
        }

        $this->_vista->monto_restante=$monto_restante;
        $this->_vista->setJs(array('funciones_amortizar'));
        $this->_vista->renderizar('amortizar');
    }

}

?>