<?php

class reportes_controlador extends controller {
    
    private $_reportes;
    private $_almacen;
    private $_venta;
    private $_detventa;
    private $_cronogcobro;
    private $_movimiento;
    private $_pdf;
    
    public function __construct() {
        if (!$this->acceso()) {
            $this->redireccionar('error/access/5050');
        }
        parent::__construct();
        $this->get_Libreria('fpdf/fpdf');
        $this->_pdf = new FPDF;
        $this->_reportes = $this->cargar_modelo('reportes');
        $this->_almacen = $this->cargar_modelo('almacenes');
        $this->_venta = $this->cargar_modelo('venta');
        $this->_detventa = $this->cargar_modelo('detventa');
        $this->_cronogcobro = $this->cargar_modelo('cronogcobro');
        $this->_movimiento = $this->cargar_modelo('movimiento');
    }
    
    public function index(){
        $this->_vista->renderizar('index');
    }
        
    public function stock_actual_almacen(){
        $Y_table_position = 41;
        
        $almacenes = $this->_almacen->selecciona();
//        echo "<pre>";
//        print_r($almacenes);
//        echo "</pre>";exit;
        $n_almacenes = count($almacenes);
        $opp = 47;
        $contapag = 1;
        $abs = 1;
        for ($x = 0; $x < $n_almacenes; $x++) {
            $this->_reportes->idalmacen = $almacenes[$x]['ID_ALMACEN'];
            $datos = $this->_reportes->selecciona_stock_total();
            $datacount = count($datos);
            $contaobj = 0;
            $c_codigo[$contapag] = "";
            $c_descripcion[$contapag] = "";
            $c_tipo_producto[$contapag] = "";
            $c_almacen[$contapag] = "";
            $c_unidad_medida[$contapag] = "";
            $c_stock[$contapag] = "";
            for ($i = 0; $i < $datacount; $i++) {
                $c_codigo[$contapag] = $c_codigo[$contapag] . ($i+1) . "\n";
                $c_descripcion[$contapag] = $c_descripcion[$contapag] . substr(utf8_decode($datos[$i]['XINSUMO']), 0, 45) . "\n";
                $c_unidad_medida[$contapag] = $c_unidad_medida[$contapag] . substr($datos[$i]['UNIDAD_MEDIDA'], 0, 30) . "\n";
                $c_stock[$contapag] = $c_stock[$contapag] . number_format($datos[$i]['XSTOCK'],0) . "\n";
                $contaobj = $contaobj + 1;
                if ($contaobj == $opp) {
                    $contaobj = 0;
                    $contapag = $contapag + 1;
                }
            }
            if ($contaobj == 0) {
                $contapag = $contapag - 1;
            }
            for ($i = $abs; $i <= $contapag; $i++) {
                $this->_pdf->AddPage();
                //ENCABEZADO TITULO DE REPORTE
                $this->_pdf->SetFont('Arial','B',12);
                $this->_pdf->SetY(24);
                $this->_pdf->SetX(0);
                $this->_pdf->Cell(210,5, utf8_decode('REGISTRO DEL STOCK ACTUAL POR ALMACEN'),0,0,'C');
                $this->_pdf->SetFillColor(96,197,253);
                $this->_pdf->SetFont('Arial','B',10);
                $this->_pdf->SetY(35);
                $this->_pdf->SetX(15);
                $this->_pdf->Cell(13,6,utf8_decode('Item'),'BT',0,'L',1);
                $this->_pdf->SetX(28);
                $this->_pdf->Cell(92,6,utf8_decode('Insumo'),'BT',0,'L',1);
                $this->_pdf->SetX(120);
                $this->_pdf->Cell(50,6,utf8_decode('Unidad Medidad'),'BT',0,'L',1);
                $this->_pdf->SetX(170);
                $this->_pdf->Cell(25,6,utf8_decode('Stock'),'BT',0,'R',1);
                //MARGEN TOTAL: HASTA=195 (ULTIMO SETX + ANCHO DE ULTIMO CELL)
                //UBICACIÓN:
                $this->_pdf->SetFont('Arial', '', 11);
                $this->_pdf->SetFillColor(255, 255, 255);
                $this->_pdf->SetY(29);
                $this->_pdf->SetX(15);
                $this->_pdf->Cell(30, 5, utf8_decode('Almacen :   ' . $almacenes[$x]['DESCRIPCION']) , 0, 'L', 1);
                $this->_pdf->SetFont('Arial', '', 10);
                $this->_pdf->SetY($Y_table_position);
                $this->_pdf->SetX(15);
                $this->_pdf->MultiCell(13, 5, $c_codigo[$i], 1);
                $this->_pdf->SetY($Y_table_position);
                $this->_pdf->SetX(28);
                $this->_pdf->MultiCell(92, 5, $c_descripcion[$i], 1);
                $this->_pdf->SetY($Y_table_position);
                $this->_pdf->SetX(120);
                $this->_pdf->MultiCell(50, 5, $c_unidad_medida[$i], 1);
                $this->_pdf->SetY($Y_table_position);
                $this->_pdf->SetX(170);
                $this->_pdf->MultiCell(25, 5, $c_stock[$i], 1, 'R');
                $abs = $abs + 1;
            }
            $abs = 1;
            $contapag = 1;
        }
        $this->_pdf->Output();
    }
    
    public function stock_menor(){
        $Y_table_position = 41;
        
        $almacenes = $this->_almacen->selecciona();
//        echo "<pre>";
//        print_r($almacenes);
//        echo "</pre>";exit;
        $n_almacenes = count($almacenes);
        $opp = 47;
        $contapag = 1;
        $abs = 1;
        for ($x = 0; $x < $n_almacenes; $x++) {
            $this->_reportes->idalmacen = $almacenes[$x]['ID_ALMACEN'];
            $datos = $this->_reportes->selecciona_stock_menor();
            $datacount = count($datos);
            $contaobj = 0;
            $c_codigo[$contapag] = "";
            $c_descripcion[$contapag] = "";
            $c_tipo_producto[$contapag] = "";
            $c_almacen[$contapag] = "";
            $c_unidad_medida[$contapag] = "";
            $c_stock[$contapag] = "";
            for ($i = 0; $i < $datacount; $i++) {
                $c_codigo[$contapag] = $c_codigo[$contapag] . ($i+1) . "\n";
                $c_descripcion[$contapag] = $c_descripcion[$contapag] . substr(utf8_decode($datos[$i]['XINSUMO']), 0, 45) . "\n";
                $c_unidad_medida[$contapag] = $c_unidad_medida[$contapag] . substr($datos[$i]['UNIDAD_MEDIDA'], 0, 30) . "\n";
                $c_stock[$contapag] = $c_stock[$contapag] . number_format($datos[$i]['XSTOCK'],0) . "\n";
                $contaobj = $contaobj + 1;
                if ($contaobj == $opp) {
                    $contaobj = 0;
                    $contapag = $contapag + 1;
                }
            }
            if ($contaobj == 0) {
                $contapag = $contapag - 1;
            }
            for ($i = $abs; $i <= $contapag; $i++) {
                $this->_pdf->AddPage();
                //ENCABEZADO TITULO DE REPORTE
                $this->_pdf->SetFont('Arial','B',12);
                $this->_pdf->SetY(24);
                $this->_pdf->SetX(0);
                $this->_pdf->Cell(210,5, utf8_decode('PRODUCTOS CON STOCK MENOR O IGUAL A CINCO(5) POR ALMACEN'),0,0,'C');
                $this->_pdf->SetFillColor(96,197,253);
                $this->_pdf->SetFont('Arial','B',10);
                $this->_pdf->SetY(35);
                $this->_pdf->SetX(15);
                $this->_pdf->Cell(13,6,utf8_decode('Item'),'BT',0,'L',1);
                $this->_pdf->SetX(28);
                $this->_pdf->Cell(92,6,utf8_decode('Insumo'),'BT',0,'L',1);
                $this->_pdf->SetX(120);
                $this->_pdf->Cell(50,6,utf8_decode('Unidad Medida'),'BT',0,'L',1);
                $this->_pdf->SetX(170);
                $this->_pdf->Cell(25,6,utf8_decode('Stock'),'BT',0,'R',1);
                //MARGEN TOTAL: HASTA=195 (ULTIMO SETX + ANCHO DE ULTIMO CELL)
                //UBICACIÓN:
                $this->_pdf->SetFont('Arial', '', 11);
                $this->_pdf->SetFillColor(255, 255, 255);
                $this->_pdf->SetY(29);
                $this->_pdf->SetX(15);
                $this->_pdf->Cell(30, 5, utf8_decode('Almacen :   ' . $almacenes[$x]['DESCRIPCION']) , 0, 'L', 1);
                $this->_pdf->SetFont('Arial', '', 10);
                $this->_pdf->SetY($Y_table_position);
                $this->_pdf->SetX(15);
                $this->_pdf->MultiCell(13, 5, $c_codigo[$i], 1);
                $this->_pdf->SetY($Y_table_position);
                $this->_pdf->SetX(28);
                $this->_pdf->MultiCell(92, 5, $c_descripcion[$i], 1);
                $this->_pdf->SetY($Y_table_position);
                $this->_pdf->SetX(120);
                $this->_pdf->MultiCell(50, 5, $c_unidad_medida[$i], 1);
                $this->_pdf->SetY($Y_table_position);
                $this->_pdf->SetX(170);
                $this->_pdf->MultiCell(25, 5, $c_stock[$i], 1, 'R');
                $abs = $abs + 1;
            }
            $abs = 1;
            $contapag = 1;
        }
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
        $this->_pdf->Cell($ancho,$ancho_celda_datos,utf8_decode('*** AGRICOLA DE LA SELVA ***'),0,0,'C',1);
        $espac = $espac + $ancho_celda_datos;
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,utf8_decode('Jr. Antonio Raymondi #285'),0,0,'C',1);
        $espac = $espac + $ancho_celda_datos;
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,utf8_decode('TELEF.964 584817'),0,0,'C',1);
        $espac = $espac + $ancho_celda_datos;
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,utf8_decode('R.U.C. 10336748076 S/N:FF9F014776'),0,0,'C',1);
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
        if($datos[0]['ESTADOPAGO']==1){
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
        $this->_pdf->Cell($ancho,$ancho_celda_datos,utf8_decode('*** AGRICOLA DE LA SELVA ***'),0,0,'C',1);
        $espac = $espac + $ancho_celda_datos;
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,utf8_decode('Jr. Antonio Raymondi #285'),0,0,'C',1);
        $espac = $espac + $ancho_celda_datos;
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,utf8_decode('TELEF.964 584817'),0,0,'C',1);
        $espac = $espac + $ancho_celda_datos;
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,utf8_decode('R.U.C. 10336748076 S/N:FF9F014776'),0,0,'C',1);
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
        if($datos[0]['ESTADOPAGO']==1){
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
        $this->_pdf->Cell($ancho,$ancho_celda_datos,utf8_decode('*** AGRICOLA DE LA SELVA ***'),0,0,'C',1);
        $espac = $espac + $ancho_celda_datos;
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,utf8_decode('Jr. Antonio Raymondi #285'),0,0,'C',1);
        $espac = $espac + $ancho_celda_datos;
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,utf8_decode('TELEF.964 584817'),0,0,'C',1);
        $espac = $espac + $ancho_celda_datos;
        $this->_pdf->SetY($espac);
        $this->_pdf->SetX(0);
        $this->_pdf->Cell($ancho,$ancho_celda_datos,utf8_decode('R.U.C. 10336748076 S/N:FF9F014776'),0,0,'C',1);
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
        $this->_pdf->Cell($ancho, $ancho_celda_datos, substr(utf8_decode('  ' . $datos[0]['NCLIENTE'] . ' ' . $datos[0]['ACLIENTE']), 0, 36), 0, 0, 'L', 1);


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
    
}

?>