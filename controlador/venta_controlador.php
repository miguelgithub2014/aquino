<?php

class venta_controlador extends controller {

    private $_venta;
    private $_detventa;
    private $_cronogcobro;
    private $_seriecomprobante;
    private $_cliente;
    private $_regiones;
    private $_provincias;
    private $_ubigeos;
    private $_profesiones;
    private $_servicio;
    private $_param;

    public function __construct() {
        if (!$this->acceso()) {
            $this->redireccionar('error/access/5050');
        }
        parent::__construct();
        $this->get_Libreria('fpdf/fpdf');
        $this->_venta = $this->cargar_modelo('venta');
        $this->_detventa = $this->cargar_modelo('detventa');
        $this->_cronogcobro = $this->cargar_modelo('cronogcobro');
        $this->_seriecomprobante = $this->cargar_modelo('seriecomprobante');
        $this->_regiones = $this->cargar_modelo('regiones');
        $this->_provincias = $this->cargar_modelo('provincias');
        $this->_ubigeos = $this->cargar_modelo('ubigeos');
        $this->_profesiones = $this->cargar_modelo('profesiones');
        $this->_cliente = $this->cargar_modelo('cliente');
        $this->_servicio=  $this->cargar_modelo('servicio');
        $this->_param=  $this->cargar_modelo('param');
    }

    public function index() {
        $this->_vista->titulo = 'Lista de Ventas';
        $this->_vista->datos = $this->_venta->selecciona();
        $this->_vista->setJs(array('funcion'));
        $this->_vista->setJs_Foot(array('scriptgrilla'));
        $this->_vista->renderizar('index');
    }
    
    public function inserta_cli(){  
        $fecha = '';
        $this->_cliente->nombres = $_POST['nombres'];
        if(isset ($_POST['apellidos'])){
            $this->_cliente->apellidos = $_POST['apellidos'];
        }else{
            $this->_cliente->apellidos = null;
        }
        $this->_cliente->documento = $_POST['documento'];
        if(isset ($_POST['fecha_nacimiento']) && $_POST['fecha_nacimiento']!=""){
            $fecha = substr($_POST['fecha_nacimiento'], 6, 4) . '-';
            $fecha .= substr($_POST['fecha_nacimiento'], 3, 2) . '-';
            $fecha .= substr($_POST['fecha_nacimiento'], 0, 2);
            $this->_cliente->fecha_nacimiento = $fecha;
        }else{
            $this->_cliente->fecha_nacimiento = '1990-01-01 00:00:00';
        }
        if(isset ($_POST['sexo'])){
            $this->_cliente->sexo = $_POST['sexo'];
        }else{
            $this->_cliente->sexo = 1;
        }
        $this->_cliente->telefono=$_POST['telefono'];
        $this->_cliente->email= $_POST['email'];
        if(isset ($_POST['estado_civil'])){
            $this->_cliente->estado_civil = $_POST['estado_civil'];
        }else{
            $this->_cliente->estado_civil = null;
        }
        if(isset ($_POST['profesion'])){
            $this->_cliente->idprofesion = $_POST['profesion'];
        }else{
            $this->_cliente->idprofesion = 67;
        }
        if(isset ($_POST['ubigeo']) && $_POST['ubigeo']!=""){
            $this->_cliente->idubigeo = $_POST['ubigeo'];
        }else{
            $this->_cliente->idubigeo = 0;
        }
        $this->_cliente->direccion = $_POST['direccion'];
        $this->_cliente->tipo = $_POST['tipo_cliente'];
        $datos = $this->_cliente->inserta();
        echo json_encode(array('x_idcliente'=>$datos[0]['X_IDCLIENTE']));
    }
    
    public function buscador(){
        if($_POST['filtro']==0){
            $this->_venta->nrodoc=$_POST['descripcion'];
        }
        if($_POST['filtro']==3){
            $this->_venta->fechaventa=$_POST['descripcion'];
        }
        if($_POST['filtro']==1){
            $this->_venta->cliente=$_POST['descripcion'];
        }
        if($_POST['filtro']==2){
            $this->_venta->empleado=$_POST['descripcion'];
        }
        echo json_encode($this->_venta->selecciona());
    }
    
    public function ver(){
        $this->_detventa->id_venta=$_POST['idventa'];
        echo json_encode($this->_detventa->selecciona());
    }
    
    public function nuevo() {
        if ($_POST['guardar'] == 1) {
//            echo '<pre>';print_r($_POST);exit;
            $this->_venta->id_cliente = $_POST['id_cliente'];
            $this->_venta->id_empleado = session::get('idempleado');
            $this->_venta->id_tipopago = $_POST['id_tipopago'];
            $this->_venta->fechaventa = date("Y-m-d H:i:s");
            $this->_venta->subtotal = $_POST['subtotal'];
            $this->_venta->igv = $_POST['igv'];
            $this->_venta->id_tipocomprobante = $_POST['id_tipocomprobante'];
            $this->_venta->nrodoc = $_POST['nrodoc'];
            $dato_venta = $this->_venta->inserta();
//            print_r($dato_venta);exit;
            //inserta detalle venta
            for($i=0;$i<count($_POST['id_servicio']);$i++){
                $this->_detventa->id_venta=$dato_venta[0]['INS_VENTA'];
                $this->_detventa->id_servicio= $_POST['id_servicio'][$i];
                $this->_detventa->cantidad= $_POST['cantidad'][$i];
                $this->_detventa->precio= $_POST['precio'][$i];
                $this->_detventa->id_unidadmedida= $_POST['id_unidadmedida'][$i];
                
                $this->_detventa->inserta();
            }
            //actualizamos el correlativo
            $this->_seriecomprobante->id_tipocomprobante=$_POST['id_tipocomprobante'];
            $datos=$this->_seriecomprobante->selecciona();
//            echo '<pre>';print_r($datos);exit;
            if($datos[0]['CORRELATIVO']==$datos[0]['MAXCORRELATIVO']){
                $this->_seriecomprobante->id_seriecomprobante=$datos[0]['ID_SERIECOMPROBANTE'];
                $this->_seriecomprobante->elimina();
                $this->_seriecomprobante->serie=$datos[0]['SERIE']+1;
                $this->_seriecomprobante->id_sucursal=session::get('idsucursal');
                $this->_seriecomprobante->id_tipocomprobante=$datos[0]['ID_TIPOCOMPROBANTE'];
                $this->_seriecomprobante->maxcorrelativo=$datos[0]['MAXCORRELATIVO'];
                $this->_seriecomprobante->inserta();
            }else{
                $this->_seriecomprobante->id_seriecomprobante=$datos[0]['ID_SERIECOMPROBANTE'];
                $this->_seriecomprobante->correlativo=$datos[0]['CORRELATIVO']+1;
                $this->_seriecomprobante->act_correlativo();
            }
            
            //insertamos cronograma de pago
            if($_POST['id_tipopago']==2){
                $fecha_venta = date("Y-m-d");
                $fecha_vencimiento = $_POST['fecha_vencimiento'];
                $intervalo_dias = $_POST['intervalo_dias'];
                $monto = $_POST['total'];
                $c=0;
                $fecha_temp = $fecha_venta;
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
                $fecha_temp = date("Y-m-d", strtotime("$fecha_venta +$intervalo_dias day"));

                for($i=1;$i<=$c;$i++){
                    $this->_cronogcobro->id_venta=$dato_venta[0]['INS_VENTA'];
                    $this->_cronogcobro->fecha=$fecha_temp;
                    $this->_cronogcobro->monto=$cuota[$i];
                    $this->_cronogcobro->nrocuota=$i;
                    $this->_cronogcobro->inserta();
                    $fecha_temp = date("Y-m-d", strtotime("$fecha_temp +$intervalo_dias day"));
                }
            }else{
                $this->_cronogcobro->id_venta = $dato_venta[0]['INS_VENTA'];
                $this->_cronogcobro->fecha = date("Y-m-d");
                $this->_cronogcobro->monto = $_POST['total'];
                $this->_cronogcobro->nrocuota = 1;
                $this->_cronogcobro->inserta();
            }
            $this->redireccionar('venta');
        }
        $this->_regiones->idpais = 193;
        $this->_vista->datos_regiones = $this->_regiones->selecciona();
        
        $this->_provincias->codigo_region = 1901;
        $this->_vista->datos_provincias = $this->_provincias->selecciona();
        
        $this->_ubigeos->codigo_provincia = 1968;
        $this->_vista->datos_ubigeos = $this->_ubigeos->selecciona();
        
        
        $this->_vista->datos_profesiones = $this->_profesiones->selecciona();
        $this->_vista->titulo = 'Registrar Ventas';
        $this->_vista->action = BASE_URL . 'venta/nuevo';
        $this->_vista->setJs(array('funciones_form','jquery-ui.min'));
        $this->_vista->renderizar('form');
    }

    public function eliminar($id) {
        if (!$this->filtrarInt($id)) {
            $this->redireccionar('venta');
        }
        $this->_venta->id_venta = $this->filtrarInt($id);
        $this->_venta->elimina();
        $this->redireccionar('venta');
    }
    
    public function getCorrelativo() {
        if($_POST['id_tipocomprobante']==1||$_POST['id_tipocomprobante']==2){
            $this->_seriecomprobante->id_tipocomprobante=$_POST['id_tipocomprobante'];
            $datos=$this->_seriecomprobante->selecciona();
//            echo '<pre>';print_r($datos);exit;
            if($datos[0]['CORRELATIVO']==$datos[0]['MAXCORRELATIVO']){
                echo $this->number_code(intval($datos[0]['SERIE'])+1, 3).'-'.$this->number_code(1, 7);
            }else{
                echo $this->number_code(intval($datos[0]['SERIE']), 3).'-'.$this->number_code(intval($datos[0]['CORRELATIVO'])+1, 7);
            }
        }else{
            echo "";
        }
    }
    
    public function number_code($number,$tam=0){
        $data="";
        $comodin="0";
        for($i=0;$i<$tam-strlen($number);$i++){
            $data.=$comodin;
        }
        $data.=$number;
        return $data;
    }
    
    public function getParam(){
        $this->_param->id_param = $_POST['id_param'];
        echo json_encode($this->_param->selecciona());
    }
    
}

?>
