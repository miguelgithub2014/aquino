<?php

class caja_controlador extends controller{
    
    private $_caja;
    private $_pdf;

    public function __construct() {
        if (!$this->acceso()) {
            $this->redireccionar('error/access/5050');
        }
        parent::__construct();
        $this->get_Libreria('fpdf/fpdf2');
        $this->_pdf = new FPDF('L','mm','A4');
        $this->_caja = $this->cargar_modelo('caja');
        $this->_movimiento = $this->cargar_modelo('movimiento');
    }

    public function index(){
        $this->_vista->titulo = 'Administrar Caja';
        $datos=  $this->_caja->selecciona();
        if($datos[0]['ESTADO']==1){
            $this->_vista->lbl_boton = 'Cerrar';
            $this->_vista->action = 'cerrar';
        }else{
            if(new DateTime((substr($datos[0]['A_FECHA'],0,10)),new DateTimeZone('America/Lima'))==new DateTime(date("d-m-Y"),new DateTimeZone('America/Lima'))){
                $this->_vista->lbl_boton = 'Reaperturar';
                $this->_vista->action = 'reaperturar';
            }else{
                $this->_vista->lbl_boton = 'Aperturar';
                $this->_vista->action = 'aperturar';
            }
        }
        $this->_vista->datos=$datos;
        $this->_vista->setJs(array('funcion','jquery-ui'));
        $this->_vista->setCss(array('jquery-ui'));
        $this->_vista->setJs_Foot(array('scriptgrilla'));
        $this->_vista->renderizar('index');
    }
    
    public function buscador(){
        if($_POST['filtro']==0){
            $this->_caja->empleado=$_POST['descripcion'];
        }
        echo json_encode($this->_caja->selecciona());
    }
    
    public function aperturar(){
        $this->_caja->estado=1;
        $this->_caja->fecha_ap=date("Y-m-d H:i:s");
        $this->_caja->idempleado=session::get('idempleado');
        $this->_caja->inserta();
        $this->redireccionar('caja');
    }
    
    public function reaperturar(){
        $this->_caja->estado=1;
        $this->_caja->fecha_ap=date("Y-m-d H:i:s");
        $this->_caja->idempleado=session::get('idempleado');
        $this->_caja->inserta();
        $this->redireccionar('caja');
    }
    
    public function cerrar(){
        $datos_caja=$this->_caja->selecciona();
        if($datos_caja[0]['ID_EMPLEADO']!=session::get('idempleado')){
            echo '<script>alert("Usted No es es el Empleado que aperturo Caja")</script>';
            $this->redireccionar('caja');
        }
        $this->_caja->idempleado=session::get('idempleado');
        $this->_caja->fecha_ci=date("Y-m-d H:i:s");
        $this->_caja->estado=0;
        $this->_caja->actualiza();
        $this->redireccionar('caja');
    }
    
    public function movimientos_fecha($fecha){
        
        $datos = $this->_movimiento->selecciona();
        $datos_caja = $this->_caja->selecciona();
        
//        echo "<pre>";print_r($datos);exit;
        
        $datacount = count($datos);
        $datacountcaja = count($datos_caja); 
        
        $a=0;
        $b=0;
        $monto_a = 0;
        $monto_b = 0;
        for ($i = 0; $i < $datacountcaja; $i++) {
            if(substr($datos_caja[$i]['FECHA_HORA_AP'],0,10)==$fecha){
                $c_concepto_i[$a] = substr(utf8_decode('CAJA AGRICOLA DE LA SELVA'), 0, 35);
                $c_formapago_i[$a] = '';
                $c_monto_i[$a] = substr($datos_caja[$i]['SALDO_AP'], 0, 7);
                $c_fecha_i[$a] = substr($datos_caja[$i]['FECHA_HORA_AP'],11,8);
                $monto_a = $datos_caja[$i]['SALDO_AP'];
            }
        }
        $a++;
        for ($i = ($datacount-1); $i >= 0; $i--) {
            if(substr($datos[$i]['FECHA'],0,10)==$fecha && $datos[$i]['ID_TIPOCONCEPTO']==1){
                $c_concepto_i[$a] = substr(utf8_decode($datos[$i]['XCONCEPTO']), 0, 35);
                $c_formapago_i[$a] = substr(utf8_decode($datos[$i]['FFORMAPAGO']), 0, 20);
                $c_monto_i[$a] = substr($datos[$i]['MONTO'], 0, 7);
                $c_fecha_i[$a] = substr($datos[$i]['FECHA'],11,8);
                $monto_a = $monto_a + $datos[$i]['MONTO'];
                $a++;
            }
            if(substr($datos[$i]['FECHA'],0,10)==$fecha && $datos[$i]['ID_TIPOCONCEPTO']==2){
                $c_concepto_e[$b] = substr(utf8_decode($datos[$i]['XCONCEPTO']), 0, 35);
                $c_formapago_e[$b] = substr(utf8_decode($datos[$i]['FFORMAPAGO']), 0, 20);
                $c_monto_e[$b] = substr($datos[$i]['MONTO'], 0, 7);
                $c_fecha_e[$b] = substr($datos[$i]['FECHA'],11,8);
                $monto_b = $monto_b + $datos[$i]['MONTO'];
                $b++;
            }
        }
        $dia = substr($fecha, 8, 2);
        $mes = substr($fecha, 5, 2);
        $anio = substr($fecha, 0, 4);
        $this->_pdf->AddPage();
        //ENCABEZADO DE REGISTRO
        $this->_pdf->SetFont('Arial', 'B', 12);
        $this->_pdf->SetY(27);
        $this->_pdf->SetX(15);
        $this->_pdf->Cell(270, 5, utf8_decode('MOVIMIENTOS DE LA FECHA: '.$dia.'-'.$mes.'-'.$anio), 0, 0, 'C');
        $this->_pdf->SetFillColor(96,197,253);
        $this->_pdf->SetFont('Arial', 'B', 10);
        $this->_pdf->SetY(35);
        $this->_pdf->SetX(15);
        $this->_pdf->Cell(135, 6, utf8_decode('INGRESOS'), 'BTLR', 0, 'C', 1);
        $this->_pdf->SetX(150);
        $this->_pdf->Cell(135, 6, utf8_decode('EGRESOS'), 'BTLR', 0, 'C', 1);
        $this->_pdf->SetY(41);
        $this->_pdf->SetX(15);
        $this->_pdf->Cell(20, 6, utf8_decode('Hora'), 'BTLR', 0, 'R', 1);
        $this->_pdf->SetX(35);
        $this->_pdf->Cell(55, 6, utf8_decode('Concepto'), 'BTLR', 0, 'L', 1);
        $this->_pdf->SetX(90);
        $this->_pdf->Cell(40, 6, utf8_decode('Forma de Pago'), 'BTLR', 0, 'L', 1);
        $this->_pdf->SetX(130);
        $this->_pdf->Cell(20, 6, utf8_decode('Monto'), 'BTLR', 0, 'R', 1);
        $this->_pdf->SetX(150);
        $this->_pdf->Cell(20, 6, utf8_decode('Hora'), 'BTLR', 0, 'R', 1);
        $this->_pdf->SetX(170);
        $this->_pdf->Cell(55, 6, utf8_decode('Concepto'), 'BTLR', 0, 'L', 1);
        $this->_pdf->SetX(225);
        $this->_pdf->Cell(40, 6, utf8_decode('Forma de Pago'), 'BTLR', 0, 'L', 1);
        $this->_pdf->SetX(265);
        $this->_pdf->Cell(20, 6, utf8_decode('Monto'), 'BTLR', 0, 'R', 1);
        //DATOS DE TABLA
        $this->_pdf->SetFont('Arial', '', 8);
        $Y_table_position = 47;
        $c = 0;
        if($a > b){
            $c = $a;
        }else{
            $c = $b;
        }
        for ($i = 0; $i < $c; $i++) {
            $this->_pdf->SetY($Y_table_position);
            $this->_pdf->SetX(15);
            $this->_pdf->Cell(20, 5, $c_fecha_i[$i],'BTLR', 1, 'R',0);
            $this->_pdf->SetY($Y_table_position);
            $this->_pdf->SetX(35);
            $this->_pdf->Cell(55, 5, $c_concepto_i[$i], 1);
            $this->_pdf->SetY($Y_table_position);
            $this->_pdf->SetX(90);
            $this->_pdf->Cell(40, 5, $c_formapago_i[$i], 1);
            $this->_pdf->SetY($Y_table_position);
            $this->_pdf->SetX(130);
            $this->_pdf->Cell(20, 5, $c_monto_i[$i],'BTLR', 1, 'R',0);
            $Y_table_position = $Y_table_position + 5;
        }
        $this->_pdf->SetY($Y_table_position);
        $this->_pdf->SetX(120);
        $this->_pdf->Cell(10, 5, "Total", 0, 'R');
        $this->_pdf->SetY($Y_table_position);
        $this->_pdf->SetX(130);
        $this->_pdf->Cell(20, 5, number_format($monto_a,2),'BTLR', 1, 'R',0);
        
        $Y_table_position=47;
        for ($j = 0; $j < $c; $j++) {
            $this->_pdf->SetY($Y_table_position);
            $this->_pdf->SetX(150);
            $this->_pdf->Cell(20, 5, $c_fecha_e[$j],'BTLR', 1, 'R',0);
            $this->_pdf->SetY($Y_table_position);
            $this->_pdf->SetX(170);
            $this->_pdf->Cell(55, 5, $c_concepto_e[$j], 1);
            $this->_pdf->SetY($Y_table_position);
            $this->_pdf->SetX(225);
            $this->_pdf->Cell(40, 5, $c_formapago_e[$j], 1);
            $this->_pdf->SetY($Y_table_position);
            $this->_pdf->SetX(265);
            $this->_pdf->Cell(20, 5, $c_monto_e[$j],'BTLR', 1, 'R',0);
            $Y_table_position = $Y_table_position + 5;
        }
        $this->_pdf->SetY($Y_table_position);
        $this->_pdf->SetX(255);
        $this->_pdf->Cell(10, 5, "Total", 0, 'R');
        $this->_pdf->SetY($Y_table_position);
        $this->_pdf->SetX(265);
        $this->_pdf->Cell(20, 5, number_format($monto_b,2),'BTLR', 1, 'R',0);
        
        $Y_table_position = $Y_table_position + 20;
        $this->_pdf->SetY($Y_table_position);
        $this->_pdf->SetX(85);
        $this->_pdf->Cell(45, 5, "CAJA AGRICOLA DE LA SELVA:", 0, 'R');
        $this->_pdf->SetY($Y_table_position);
        $this->_pdf->SetX(130);
        $this->_pdf->Cell(20, 5, number_format($monto_a-$monto_b,2),'B', 1, 'R',0);
        
        $this->_pdf->Output();
    }
  
}

?>
