<?php

class cronogcobro_controlador extends controller {

    private $_venta;
    private $_cronogcobro;
    private $_caja;
    private $_movimiento;
    private $_detventa;
    private $_pdf;

    public function __construct() {
        if (!$this->acceso()) {
            $this->redireccionar('error/access/5050');
        }
        parent::__construct();
        $this->get_Libreria('fpdf/fpdf');
        $this->_pdf = new FPDF;
        $this->_cronogcobro = $this->cargar_modelo('cronogcobro');
        $this->_caja = $this->cargar_modelo('caja');
        $this->_movimiento = $this->cargar_modelo('movimiento');
        $this->_venta= $this->cargar_modelo('venta');
        $this->_detventa= $this->cargar_modelo('detventa');
    }

    public function index() {
        $this->_vista->titulo = 'Lista de Cronograma de Cobro';
        $this->_vista->datos = $this->_cronogcobro->selecciona();
        $this->_vista->datos_cuota = $this->_cronogcobro->selecciona_cuota();
        $this->_vista->setJs(array('funciones_index'));
        $this->_vista->setJs_Foot(array('scriptgrilla'));
        $this->_vista->renderizar('index');
    }
    
    public function buscador(){
        if($_POST['filtro']==0){
            $this->_cronogcobro->cliente=$_POST['cadena'];
        }
        echo json_encode($this->_cronogcobro->selecciona());
    }

    public function cronograma($idventa, $monto_restante) {
        $this->_cronogcobro->id_venta= $idventa;
        $this->_vista->datos = $this->_cronogcobro->selecciona_cuota();
        $this->_vista->titulo = 'Cronograma de Cobros';
        $this->_vista->btn_action = BASE_URL . 'cronogcobro/amortizar/' . $idventa . '/' . $monto_restante;
        $this->_vista->renderizar('cronograma');
    }

    public function amortizar($idventa, $monto_restante) {
        error_reporting(E_ALL);
        $this->_vista->titulo = 'Amortizar Cobro';
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
            $this->redireccionar('cronogcobro');
        }
        if ($_POST['guardar'] == 1) {

            $this->_cronogcobro->id_venta= $idventa;
            $datos_cronogcobro = $this->_cronogcobro->selecciona_cuota();
//            echo '<pre>';print_r($datos_cronogcobro);exit;
            /*
             * Disminuímos el stock
             */
            $monto_amortizado = $_POST['monto'];
            $c='';
            for ($i = 0; $i < count($datos_cronogcobro); $i++) {
                $c=$i;
                if ($datos_cronogcobro[$i]['MONTO_CUOTA'] > $datos_cronogcobro[$i]['MONTO_COBRADO']) {
                    $monto_restantexcuota = $datos_cronogcobro[$i]['MONTO_CUOTA'] - $datos_cronogcobro[$i]['MONTO_COBRADO'];
                    if ($monto_amortizado != 0) {
                        if ($monto_restantexcuota >= $monto_amortizado) {
                            //actualiza monto_pagado en cuota_pago
                            $this->_cronogcobro->id_cronogcobro = $datos_cronogcobro[$i]['ID_CRONOGCOBRO'];
                            $this->_cronogcobro->id_venta= $idventa;
                            $this->_cronogcobro->monto = $monto_amortizado + $datos_cronogcobro[$i]['MONTO_COBRADO'];
                            $this->_cronogcobro->nrocuota = $datos_cronogcobro[$i]['NROCUOTA'];
                            $this->_cronogcobro->actualiza();
                            $monto_amortizado = 0;
                        } else {
                            //actualiza monto_pagado en cuota_pago
                            $this->_cronogcobro->id_cronogcobro = $datos_cronogcobro[$i]['ID_CRONOGCOBRO'];
                            $this->_cronogcobro->id_venta= $idventa;
                            $this->_cronogcobro->monto = $datos_cronogcobro[$i]['MONTO_CUOTA'];
                            $this->_cronogcobro->nrocuota = $datos_cronogcobro[$i]['NROCUOTA'];
                            $this->_cronogcobro->actualiza();
                            $monto_amortizado = $monto_amortizado - $monto_restantexcuota;
                        }
                    }
                }
            }
            
            //Datos venta
            $this->_venta->id_venta = $idventa;
            $venta = $this->_venta->selecciona();
            
            //insertar movimiento caja
            $this->_movimiento->idconcepto = 1;
            $this->_movimiento->idcaja = $datos_caja[0]['ID_CAJA'];
            $this->_movimiento->id_formapago = 1;
            $this->_movimiento->monto = $_POST['monto'];
            $this->_movimiento->fecha=date("Y-m-d H:i:s");
            $this->_movimiento->referencia = 'COBRO A CLIENTE: "'.$venta[0]['NCLIENTE'].' '.$venta[0]['ACLIENTE'].'" POR VENTA NRO. DOC: '.$venta[0]['NRODOC'];
            $this->_movimiento->inserta();

            //actualiza saldo caja
            $this->_caja->idcaja = $datos_caja[0]['ID_CAJA'];
            $this->_caja->saldo = $_POST['monto'];
            $this->_caja->aumenta = 1;
            $this->_caja->actualiza();
            
            $dato_venta = $this->_cronogcobro->selecciona();
            if(($dato_venta[0]['IGV']+1*$dato_venta[0]['SUBTOTAL'])==$dato_venta[0]['XMONTO_COBRADO']){
                $this->_cronogcobro->id=$idventa;
                $this->_cronogcobro->estadopago=2;
                $this->_cronogcobro->estadopago();
            }else {
                $this->_cronogcobro->id=$idventa;
                $this->_cronogcobro->estadopago=1;
                $this->_cronogcobro->estadopago();
            }
            
            $this->redireccionar('cronogcobro');
        }

        $this->_vista->monto_restante=$monto_restante;
        $this->_vista->setJs(array('funciones_amortizar'));
        $this->_vista->renderizar('amortizar');
    }
    
    
    public function ticket_pago($idventa){
        $this->_venta->id_venta = $idventa;
        $venta = $this->_venta->selecciona();
        
        $ancho_celda_datos = 3.8;
        $alto = 80 + ($ancho_celda_datos);
        $ancho = 73;
        $espac = 8;
        $this->_pdf = new FPDF('P', 'mm', array($ancho, $alto));
        $this->_pdf->SetAutoPageBreak(false);
        $this->_pdf->AddPage();
        $this->_pdf->SetFont('Courier', '', 9);
        $this->_pdf->SetFillColor(255, 255, 255);
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,utf8_decode(''),0,0,'C',1);
        $espac = $espac + $ancho_celda_datos;
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,utf8_decode('*** AQUINOS GRAFICA INTEGRAL ***'),0,0,'C',1);
        $espac = $espac + $ancho_celda_datos;
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,utf8_decode('Jr. San Martin #1205'),0,0,'C',1);
        $espac = $espac + $ancho_celda_datos;
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,utf8_decode('TELEF. (042) 525207'),0,0,'C',1);
        $espac = $espac + $ancho_celda_datos;
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,utf8_decode('R.U.C. 10123456782 S/N:FF9F014776'),0,0,'C',1);
        $espac = $espac + $ancho_celda_datos;
        
        $this->_cronogcobro->id_venta = $idventa;
        $datos = $this->_cronogcobro->selecciona();
        $horafecha = array(
            substr(date("Y-m-d H:i:s"),8,2),
            substr(date("Y-m-d H:i:s"),5,2),
            substr(date("Y-m-d H:i:s"),0,4),
            substr(date("Y-m-d H:i:s"),11,2),
            substr(date("Y-m-d H:i:s"),14,2),
            substr(date("Y-m-d H:i:s"),17,2)
            );
        
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,utf8_decode('  FECHA:'.$horafecha[0].'/'.$horafecha[1].'/'.$horafecha[2].'    '.'HORA:'.
                $horafecha[3].':'.$horafecha[4].':'.$horafecha[5]),0,0,'L',1);
        $espac = $espac + $ancho_celda_datos;
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho, $ancho_celda_datos, utf8_decode('  CLIENTE:           ' .$datos[0]['NRODOC']), 0, 0, 'L', 1);
        $espac = $espac + $ancho_celda_datos;
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho, $ancho_celda_datos, substr(utf8_decode('  ' . $datos[0]['XCLIENTE'] ), 0, 36), 0, 0, 'L', 1);


        $espac = $espac + $ancho_celda_datos + 2;
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,1,utf8_decode('  ----------------------------------'),0,0,'L',1);
        $espac = $espac  + 1;
        
        
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(5);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,substr(utf8_decode('MONTO TOTAL PAGADO'),0,25),0,0,'L',1);
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(50);
        $this->_pdf->Cell(10,$ancho_celda_datos,utf8_decode('S/.'),0,0,'L',1);
        //PARSEAR OBJETO NUMERIC HACIA DOUBLE CON 2 DECIMALES
        $prec = number_format($monto, 2);
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(55);
        $this->_pdf->Cell(15.5,$ancho_celda_datos,utf8_decode($datos[0]['XMONTO_COBRADO']),0,0,'R',1);
        $espac = $espac + $ancho_celda_datos;
        
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(5);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,substr(utf8_decode('MONTO RESTANTE'),0,25),0,0,'L',1);
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(50);
        $this->_pdf->Cell(10,$ancho_celda_datos,utf8_decode('S/.'),0,0,'L',1);
        //PARSEAR OBJETO NUMERIC HACIA DOUBLE CON 2 DECIMALES
        $prec = number_format(($datos[0]['SUBTOTAL']+$datos[0]['IGV']*$datos[0]['SUBTOTAL'])-$datos[0]['XMONTO_COBRADO'], 2);
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(55);
        $this->_pdf->Cell(15.5,$ancho_celda_datos,utf8_decode(''.$prec),0,0,'R',1);
        $espac = $espac + $ancho_celda_datos;
        
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(5);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,substr(utf8_decode('MONTO TOTAL'),0,25),0,0,'L',1);
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(50);
        $this->_pdf->Cell(10,$ancho_celda_datos,utf8_decode('S/.'),0,0,'L',1);
        //PARSEAR OBJETO NUMERIC HACIA DOUBLE CON 2 DECIMALES
        $prec = number_format(($datos[0]['SUBTOTAL']+$datos[0]['IGV']*$datos[0]['SUBTOTAL']), 2);
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(55);
        $this->_pdf->Cell(15.5,$ancho_celda_datos,utf8_decode(''.$prec),0,0,'R',1);

        $espac = $espac + $ancho_celda_datos;
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,1,utf8_decode('  ----------------------------------'),0,0,'L',1);
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $espac = $espac + $ancho_celda_datos;
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,substr(utf8_decode(' VENDEDOR: '.$venta[0]['NEMPLEADO'].' '.$venta[0]['AEMPLEADO']),0,36),0,0,'C',1);
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $espac = $espac + $ancho_celda_datos;
        
        $espac = $espac + 3;
        
        //PIE DE PÁGINA
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,utf8_decode('BIENES TRANSFER. EN LA AMAZONIA'),0,0,'C',1);
        $espac = $espac + $ancho_celda_datos;
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,utf8_decode('PARA SER CONSUMIDOS EN LA MISMA'),0,0,'C',1);
        $espac = $espac + $ancho_celda_datos;
        
        $this->_pdf->Output();
    }
    
    public function ticket_factura($idventa){
        $this->_detventa->id_venta = $idventa;
        $venta = $this->_detventa->selecciona();
        $items = count($venta);
        
        $ancho_celda_datos = 3.8;
        $alto = 110 + ($ancho_celda_datos*($items));
        $ancho = 73;
        $espac = 8;
        $this->_pdf = new FPDF('P', 'mm', array($ancho, $alto));
        $this->_pdf->SetAutoPageBreak(false);
        $this->_pdf->AddPage();
        $this->_pdf->SetFont('Courier', '', 9);
        $this->_pdf->SetFillColor(255, 255, 255);
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,utf8_decode(''),0,0,'C',1);
        $espac = $espac + $ancho_celda_datos;
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,utf8_decode('*** AQUINOS GRAFICA INTEGRAL ***'),0,0,'C',1);
        $espac = $espac + $ancho_celda_datos;
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,utf8_decode('Jr. San Martin #1205'),0,0,'C',1);
        $espac = $espac + $ancho_celda_datos;
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,utf8_decode('TELEF. (042) 525207'),0,0,'C',1);
        $espac = $espac + $ancho_celda_datos;
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,utf8_decode('R.U.C. 10123456782 S/N:FF9F014776'),0,0,'C',1);
        $espac = $espac + $ancho_celda_datos;
        
        $this->_venta->id_venta = $idventa;
        $datos = $this->_venta->selecciona();
        $horafecha = array(
            substr($datos[0]['FECHAVENTA'],8,2),
            substr($datos[0]['FECHAVENTA'],5,2),
            substr($datos[0]['FECHAVENTA'],0,4),
            substr($datos[0]['FECHAVENTA'],11,2),
            substr($datos[0]['FECHAVENTA'],14,2),
            substr($datos[0]['FECHAVENTA'],17,2)
            );
        
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,utf8_decode('  FECHA:'.$horafecha[0].'/'.$horafecha[1].'/'.$horafecha[2].'    '.'HORA:'.
                $horafecha[3].':'.$horafecha[4].':'.$horafecha[5]),0,0,'L',1);
        $espac = $espac + $ancho_celda_datos;
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,utf8_decode('*** TICKET FACTURA ***'),0,0,'C',1);
        $espac = $espac + $ancho_celda_datos;
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        //$this->_pdf->Cell($ancho,$ancho_celda_datos,utf8_decode('  CLIENTE:           '.$datos[0]['abreviatura'].'/'.$datos[0]['serie'].'-'.$datos[0]['nro_documento']),0,0,'L',1);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,utf8_decode('TF/'.$datos[0]['NRODOC']),0,0,'C',1);
        $espac = $espac + $ancho_celda_datos + 2;
        
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,1,utf8_decode('  ----------------------------------'),0,0,'L',1);
        $espac = $espac + $ancho_celda_datos-2;
        $this->_pdf->SetY($espac-1);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,utf8_decode('  PRODUCTO                   IMPORTE'),0,0,'L',1);
        $espac = $espac + $ancho_celda_datos-1;
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,1,utf8_decode('  ----------------------------------'),0,0,'L',1);
        $espac = $espac  + 1;
        
        $sbtotal = 0;
        
        for($i=0;$i<$items;$i++){
            $this->_pdf->SetY($espac);
            $this->_pdf->SetX(0);
            if($venta[$i]['ID_PRODUCTO']!=0){
                $this->_pdf->Cell($ancho,$ancho_celda_datos,substr(utf8_decode('  '.$venta[$i]['CANTIDADUM'].$venta[$i]['UUM'].' '.
                        $venta[$i]['PPRODUCTO']),0,25),0,0,'L',1);
            }
            $this->_pdf->SetY($espac);
            $this->_pdf->SetX(50);
            $this->_pdf->Cell(10,$ancho_celda_datos,utf8_decode('S/.'),0,0,'L',1);
            //PARSEAR OBJETO NUMERIC HACIA DOUBLE CON 2 DECIMALES
            $prec = $venta[$i]['PRECIOUB']*$venta[$i]['CANTIDADUB'];
            $this->_pdf->SetY($espac);
            $this->_pdf->SetX(55);
            $this->_pdf->Cell(15.5,$ancho_celda_datos,number_format($prec,2),0,0,'R',1);
            //SUMAR LOS VALORES DEL PRECIO PARA OBTENER EL TOTAL:
            $sbtotal = $sbtotal + $prec;
            
            $espac = $espac + $ancho_celda_datos;
        }
        
        if($items==0){
            $this->_pdf->SetY($espac+1.2);
            $this->_pdf->SetX(0);
            $this->_pdf->Cell($ancho,1,utf8_decode('  >>NO SE REGISTRARON ITEMS'),0,0,'L',1);
            $espac = $espac + $ancho_celda_datos;
        }
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,1,utf8_decode('  ----------------------------------'),0,0,'L',1);
        $espac = $espac + $ancho_celda_datos;
        
        $espac = $espac - 3;
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,utf8_decode('          *    SUBTOTAL S/.'),0,0,'L',1);
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(55);
        $this->_pdf->Cell(15.5,$ancho_celda_datos,utf8_decode(''.  number_format($sbtotal, 2)),0,0,'R',1);
        $espac = $espac + $ancho_celda_datos;
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,utf8_decode("          **   IGV(".  number_format($datos[0]['IGV']*100, 0)."%)  S/."),0,0,'L',1);
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(55);
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(55);
        $this->_pdf->Cell(15.5,$ancho_celda_datos,utf8_decode(''.  number_format(($datos[0]['IGV']*$sbtotal), 2)),0,0,'R',1);
        $total = $sbtotal + ($datos[0]['IGV']*$sbtotal);
        $espac = $espac + $ancho_celda_datos;
        
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,utf8_decode('          ***  TOTAL    S/.'),0,0,'L',1);
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(55);
        $this->_pdf->Cell(15.5,$ancho_celda_datos,utf8_decode(''.  number_format($total, 2)),0,0,'R',1);
        $espac = $espac + $ancho_celda_datos;
        
        $espac = $espac + $ancho_celda_datos - 3;
        //necesito: vendedor, items, condicion (contado, credito), campo obsrevaciones (si estado = 0: observacion = anulado)
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,utf8_decode(' ITEMS: '.($items)),0,0,'L',1);
        $espac = $espac + $ancho_celda_datos;
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,substr(utf8_decode(' RAZON SOCIAL: '),0,36),0,0,'L',1);
        $espac = $espac + $ancho_celda_datos;
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,substr(utf8_decode(' '.$datos[0]['NCLIENTE']),0,36),0,0,'L',1);
        $espac = $espac + $ancho_celda_datos;
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,substr(utf8_decode(' DIRECCION: '),0,36),0,0,'L',1);
        $espac = $espac + $ancho_celda_datos;
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,substr(utf8_decode(' '.$datos[0]['DIRCLIENTE']),0,36),0,0,'L',1);
        $espac = $espac + $ancho_celda_datos;
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,substr(utf8_decode(' RUC: '.$datos[0]['DOCCLIENTE']),0,36),0,0,'L',1);
        $espac = $espac + $ancho_celda_datos;
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,substr(utf8_decode(' VENDEDOR: '.$datos[0]['NEMPLEADO'].' '.
                $datos[0]['AEMPLEADO']),0,36),0,0,'L',1);
        $espac = $espac + $ancho_celda_datos;
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        /*DETERMINAR EL TIPO DE TRANSACCION*/
        if($datos[0]['ESTADOPAGO']<>0){
            if($datos[0]['ID_TIPOPAGO']==1){
                $datos[0]['ID_TIPOPAGO']='CONTADO';
            } else {
                $datos[0]['ID_TIPOPAGO']='CREDITO, * CANCELADO *';
            }
        } else {
            $datos[0]['ID_TIPOPAGO']='* SIN PAGAR *';
        } 
        $this->_pdf->Cell($ancho,$ancho_celda_datos,substr(utf8_decode(' CONDICION: '.$datos[0]['ID_TIPOPAGO']),0,36),0,0,'L',1);
        $espac = $espac + $ancho_celda_datos;
        /*DETERMINAR LA OBSERVACION O SI ESTUVIERA VENTA ANULADA*/
        if($datos[0]['ESTADO'] == 0){
            $this->_pdf->SetY($espac);
            $this->_pdf->SetX(0);
            $this->_pdf->Cell($ancho,$ancho_celda_datos,substr(utf8_decode('*** ANULADO ***'),0,36),0,0,'C',1);
            $espac = $espac + $ancho_celda_datos;
        }
        
        $espac = $espac + 3;
        
        //PIE DE PÁGINA
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,utf8_decode('BIENES TRANSFER. EN LA AMAZONIA'),0,0,'C',1);
        $espac = $espac + $ancho_celda_datos;
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,utf8_decode('PARA SER CONSUMIDOS EN LA MISMA'),0,0,'C',1);
        $espac = $espac + $ancho_celda_datos;
        
        $this->_pdf->Output();
    }
    
    public function ticket_simple($idventa){
        $this->_detventa->id_venta = $idventa;
        $venta = $this->_detventa->selecciona();
        $items = count($venta);
        
        $ancho_celda_datos = 3.8;
        $alto = 95 + ($ancho_celda_datos*($items));
        $ancho = 73;
        $espac = 8;
        $this->_pdf = new FPDF('P', 'mm', array($ancho, $alto));
        $this->_pdf->SetAutoPageBreak(false);
        $this->_pdf->AddPage();
        $this->_pdf->SetFont('Courier', '', 9);
        $this->_pdf->SetFillColor(255, 255, 255);
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,utf8_decode(''),0,0,'C',1);
        $espac = $espac + $ancho_celda_datos;
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,utf8_decode('*** AQUINOS GRAFICA INTEGRAL ***'),0,0,'C',1);
        $espac = $espac + $ancho_celda_datos;
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,utf8_decode('Jr. San Martin #1205'),0,0,'C',1);
        $espac = $espac + $ancho_celda_datos;
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,utf8_decode('TELEF. (042) 525207'),0,0,'C',1);
        $espac = $espac + $ancho_celda_datos;
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,utf8_decode('R.U.C. 10123456782 S/N:FF9F014776'),0,0,'C',1);
        $espac = $espac + $ancho_celda_datos;
        
        $this->_venta->id_venta = $idventa;
        $datos = $this->_venta->selecciona();
        $horafecha = array(
            substr($datos[0]['FECHAVENTA'],8,2),
            substr($datos[0]['FECHAVENTA'],5,2),
            substr($datos[0]['FECHAVENTA'],0,4),
            substr($datos[0]['FECHAVENTA'],11,2),
            substr($datos[0]['FECHAVENTA'],14,2),
            substr($datos[0]['FECHAVENTA'],17,2)
            );
        
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,utf8_decode('  FECHA:'.$horafecha[0].'/'.$horafecha[1].'/'.$horafecha[2].'    '.'HORA:'.
                $horafecha[3].':'.$horafecha[4].':'.$horafecha[5]),0,0,'L',1);
        $espac = $espac + $ancho_celda_datos;
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho, $ancho_celda_datos, utf8_decode('  CLIENTE:           TS/' .$datos[0]['NRODOC']), 0, 0, 'L', 1);
        $espac = $espac + $ancho_celda_datos;
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho, $ancho_celda_datos, substr(utf8_decode('  ' . $datos[0]['NCLIENTE'] . ' ' .
                                $datos[0]['ACLIENTE']), 0, 36), 0, 0, 'L', 1);


        $espac = $espac + $ancho_celda_datos + 2;
        
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,1,utf8_decode('  ----------------------------------'),0,0,'L',1);
        $espac = $espac + $ancho_celda_datos-2;
        $this->_pdf->SetY($espac-1);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,utf8_decode('  PRODUCTO                   IMPORTE'),0,0,'L',1);
        $espac = $espac + $ancho_celda_datos-1;
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,1,utf8_decode('  ----------------------------------'),0,0,'L',1);
        $espac = $espac  + 1;
        
        $sbtotal = 0;
        
        for($i=0;$i<$items;$i++){
            $this->_pdf->SetY($espac);
            $this->_pdf->SetX(0);
            if($venta[$i]['ID_PRODUCTO']!=0){
                $this->_pdf->Cell($ancho,$ancho_celda_datos,substr(utf8_decode('  '.$venta[$i]['CANTIDADUM'].$venta[$i]['UUM'].' '.
                        $venta[$i]['PPRODUCTO']),0,25),0,0,'L',1);
            }
            $this->_pdf->SetY($espac);
            $this->_pdf->SetX(50);
            $this->_pdf->Cell(10,$ancho_celda_datos,utf8_decode('S/.'),0,0,'L',1);
            //PARSEAR OBJETO NUMERIC HACIA DOUBLE CON 2 DECIMALES
            $prec = number_format($venta[$i]['PRECIOUB']*$venta[$i]['CANTIDADUB'], 2);
            $this->_pdf->SetY($espac);
            $this->_pdf->SetX(55);
            $this->_pdf->Cell(15.5,$ancho_celda_datos,utf8_decode(''.$prec),0,0,'R',1);
            //SUMAR LOS VALORES DEL PRECIO PARA OBTENER EL TOTAL:
            $sbtotal = $sbtotal + $prec;
            
            $espac = $espac + $ancho_celda_datos;
        }
        
        if($items==0){
            $this->_pdf->SetY($espac+1.2);
            $this->_pdf->SetX(0);
            $this->_pdf->Cell($ancho,1,utf8_decode('  >>NO SE REGISTRARON ITEMS'),0,0,'L',1);
            $espac = $espac + $ancho_celda_datos;
        }
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,1,utf8_decode('  ----------------------------------'),0,0,'L',1);
        $espac = $espac + $ancho_celda_datos;
        
        $espac = $espac - 3;
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,utf8_decode('          *    SUBTOTAL S/.'),0,0,'L',1);
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(55);
        $this->_pdf->Cell(15.5,$ancho_celda_datos,utf8_decode(''.  number_format($sbtotal, 2)),0,0,'R',1);
        $espac = $espac + $ancho_celda_datos;
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,utf8_decode("          **   IGV(".  number_format($datos[0]['IGV']*100, 0)."%)  S/."),0,0,'L',1);
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(55);
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(55);
        $this->_pdf->Cell(15.5,$ancho_celda_datos,utf8_decode(''.  number_format(($datos[0]['IGV']*$sbtotal), 2)),0,0,'R',1);
        $total = $sbtotal + ($datos[0]['IGV']*$sbtotal);
        $espac = $espac + $ancho_celda_datos;
        
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,utf8_decode('          ***  TOTAL    S/.'),0,0,'L',1);
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(55);
        $this->_pdf->Cell(15.5,$ancho_celda_datos,utf8_decode(''.  number_format($total, 2)),0,0,'R',1);
        $espac = $espac + $ancho_celda_datos;
        
        $espac = $espac + $ancho_celda_datos - 3;
        //necesito: vendedor, items, condicion (contado, credito), campo obsrevaciones (si estado = 0: observacion = anulado)
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,utf8_decode(' ITEMS: '.($items)),0,0,'L',1);
        $espac = $espac + $ancho_celda_datos;
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,substr(utf8_decode(' VENDEDOR: '.$datos[0]['NEMPLEADO'].' '.
                $datos[0]['AEMPLEADO']),0,36),0,0,'L',1);
        $espac = $espac + $ancho_celda_datos;
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        /*DETERMINAR EL TIPO DE TRANSACCION*/
        if($datos[0]['ESTADOPAGO']<>0){
            if($datos[0]['ID_TIPOPAGO']==1){
                $datos[0]['ID_TIPOPAGO']='CONTADO';
            } else {
                $datos[0]['ID_TIPOPAGO']='CREDITO, * CANCELADO *';
            }
        } else {
            $datos[0]['ID_TIPOPAGO']='* SIN PAGAR *';
        } 
        $this->_pdf->Cell($ancho,$ancho_celda_datos,substr(utf8_decode(' CONDICION: '.$datos[0]['ID_TIPOPAGO']),0,36),0,0,'L',1);
        $espac = $espac + $ancho_celda_datos;
        /*DETERMINAR LA OBSERVACION O SI ESTUVIERA VENTA ANULADA*/
        if($datos[0]['ESTADO'] == 0){
            $this->_pdf->SetY($espac);
            $this->_pdf->SetX(0);
            $this->_pdf->Cell($ancho,$ancho_celda_datos,substr(utf8_decode('*** ANULADO ***'),0,36),0,0,'C',1);
            $espac = $espac + $ancho_celda_datos;
        }
        
        $espac = $espac + 3;
        
        //PIE DE PÁGINA
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,utf8_decode('BIENES TRANSFER. EN LA AMAZONIA'),0,0,'C',1);
        $espac = $espac + $ancho_celda_datos;
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,utf8_decode('PARA SER CONSUMIDOS EN LA MISMA'),0,0,'C',1);
        $espac = $espac + $ancho_celda_datos;
        
        $this->_pdf->Output();
    }
    


}

?>