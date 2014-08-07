<?php

class compra_controlador extends controller {

    private $_compra;
    private $_detcomprainsumo;
    private $_cronogpago;
    private $_proveedor;
    private $_detinsumoum;
    private $_param;

    public function __construct() {
        if (!$this->acceso()) {
            $this->redireccionar('error/access/5050');
        }
        parent::__construct();
        $this->_compra = $this->cargar_modelo('compra');
        $this->_proveedor = $this->cargar_modelo('proveedor');
        $this->_detcomprainsumo = $this->cargar_modelo('detcomprainsumo');
        $this->_cronogpago = $this->cargar_modelo('cronogpago');
        $this->_detinsumoum=  $this->cargar_modelo('detinsumoum');
        $this->_param = $this->cargar_modelo('param');
    }

    public function index() {
        $this->_vista->titulo = 'Lista de Compras';
        $this->_vista->datos = $this->_compra->selecciona();
        $this->_vista->setJs(array('funcion'));
        $this->_vista->setJs_Foot(array('scriptgrilla'));
        $this->_vista->renderizar('index');
    }
    
    public function inserta_prov(){        
        $this->_proveedor->nombre=$_POST['nombre'];
        $this->_proveedor->direccion=$_POST['dir'];
        $this->_proveedor->razonsocial=$_POST['rs'];
        $this->_proveedor->email=$_POST['em'];
        $this->_proveedor->ciudad=$_POST['ciu'];
        $this->_proveedor->ruc=$_POST['ruc'];
        $this->_proveedor->telefmovil=$_POST['tel'];
        $datos = $this->_proveedor->inserta();
        echo json_encode(array('id_proveedor'=>$datos[0]['INS_PROVEEDOR']));
    }
    
    public function get_proveedor(){
        $this->_proveedor->id_proveedor=9999;
        echo json_encode($this->_proveedor->selecciona());
    }
    
    public function buscador(){
        if($_POST['filtro']==0){
            $this->_compra->nrodoc=$_POST['descripcion'];
        }
        if($_POST['filtro']==1){
            $this->_compra->fechacompra=$_POST['descripcion'];
        }
        if($_POST['filtro']==2){
            $this->_compra->proveedor=$_POST['descripcion'];
        }
        echo json_encode($this->_compra->selecciona());
    }
    
    public function ver(){
        $this->_detcomprainsumo->id_compra=$_POST['idcompra'];
        echo json_encode($this->_detcomprainsumo->selecciona());
    }
    
    public function nuevo() {
        if ($_POST['guardar'] == 1) {
//            echo '<pre>';print_r($_POST);exit;
            $this->_compra->id_proveedor = $_POST['id_proveedor'];
            $this->_compra->id_tipopago = $_POST['id_tipopago'];
            $this->_compra->fechacompra = $_POST['fechacompra'];
            $this->_compra->monto = $_POST['subtotal'];
            $this->_compra->nrodoc = $_POST['nrodoc'];
            $this->_compra->igv = $_POST['igv'];
            $dato_compra = $this->_compra->inserta();
//            print_r($dato_compra);exit;
            //inserta detalle compra
            for($i=0;$i<count($_POST['id_insumo']);$i++){
                $this->_detcomprainsumo->id_compra=$dato_compra[0]['INS_COMPRA'];
                $this->_detcomprainsumo->id_insumo= $_POST['id_insumo'][$i];
                $this->_detcomprainsumo->cantidadum= $_POST['cantidadum'][$i];
                $this->_detcomprainsumo->preciounitario= $_POST['preciounitario'][$i];
                $this->_detcomprainsumo->id_unidadmedida= $_POST['id_unidadmedida'][$i];
                $this->_detcomprainsumo->cantidadub= $_POST['cantidadub'][$i];
                $this->_detcomprainsumo->precioub= $_POST['precioub'][$i];
                $this->_detcomprainsumo->stockactual= $_POST['stockactual'][$i];
                $this->_detcomprainsumo->inserta();
            }
            //insertamos cronograma de pago
            if($_POST['id_tipopago']==2){
                $fecha_compra = $_POST['fechacompra'];
                $fecha_vencimiento = $_POST['fecha_vencimiento'];
                $intervalo_dias = $_POST['intervalo_dias'];
                $monto = $_POST['total'];
                $c=0;
                $fecha_temp = $fecha_compra;
                $mayor = true;
                $cuota = array();
                while($mayor){
                    $c++;
                    $fecha_temp =  date("Y-m-d", strtotime("$fecha_temp +$intervalo_dias day"));
                    if(new DateTime($fecha_temp,new DateTimeZone('America/Lima')) >= new DateTime($fecha_vencimiento,new DateTimeZone('America/Lima'))){
                        $mayor = false;
                    }
                }
                if(new DateTime($fecha_temp,new DateTimeZone('America/Lima')) > new DateTime($fecha_vencimiento,new DateTimeZone('America/Lima'))){
                    $c=$c-1;
                }
                $monto_pagado = 0;
                $pago_mensual = (int)($monto / $c);

                for($i=1;$i<=$c;$i++){
                    $cuota[$i]=$pago_mensual;
                    $monto_pagado = $monto_pagado + $pago_mensual;
                }
                if($monto_pagado != $monto){
                    $cuota[$c]=	$cuota[$c] + ($monto- $monto_pagado);
                }
                $fecha_temp = date("Y-m-d", strtotime("$fecha_compra +$intervalo_dias day"));

                for($i=1;$i<=$c;$i++){
                    $this->_cronogpago->id_compra=$dato_compra[0]['INS_COMPRA'];
                    $this->_cronogpago->fecha=$fecha_temp;
                    $this->_cronogpago->monto=$cuota[$i];
                    $this->_cronogpago->nrocuota=$i;
                    $this->_cronogpago->inserta();
                    $fecha_temp = date("Y-m-d", strtotime("$fecha_temp +$intervalo_dias day"));
                }
            }else{
                $this->_cronogpago->id_compra = $dato_compra[0]['INS_COMPRA'];
                $this->_cronogpago->fecha = $_POST['fechacompra'];
                $this->_cronogpago->monto = $_POST['total'];
                $this->_cronogpago->nrocuota = 1;
                $this->_cronogpago->inserta();
            }
            $this->redireccionar('compra');
        }
        $this->_vista->titulo = 'Registrar Compra';
        $this->_vista->action = BASE_URL . 'compra/nuevo';
        $this->_vista->setJs(array('funciones_form','jquery-ui.min'));
        $this->_vista->setJs_Foot(array('scriptgrilla'));
        $this->_vista->renderizar('form');
    }

    public function eliminar($id) {
        if (!$this->filtrarInt($id)) {
            $this->redireccionar('compra');
        }
        $this->_compra->id_compra = $this->filtrarInt($id);
        $this->_compra->elimina();
        $this->redireccionar('compra');
    }
    
    public function getParam(){
        $this->_param->id_param = $_POST['id_param'];
        echo json_encode($this->_param->selecciona());
    }
    
    public function getUnidadesInsumo(){
        $this->_detinsumoum->id_insumo = $_POST['id_insumo'];
        echo json_encode($this->_detinsumoum->selecciona());
    }

}

?>
