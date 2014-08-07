<?php

//require_once '../modelo/empleados.php';
class ws_controlador extends controller {

    public function __construct() {
        parent::__construct();
        $this->_empleado = $this->cargar_modelo('empleado');
        $this->_producto = $this->cargar_modelo('producto');
        
        $this->_almacenes = $this->cargar_modelo('almacenes');
        $this->_reportes = $this->cargar_modelo('reportes');
        $this->_cronogcobro = $this->cargar_modelo('cronogcobro');
        $this->_movimiento = $this->cargar_modelo('movimiento');
        $this->_caja = $this->cargar_modelo('caja');
    }

    public function index() {
        echo "hola soy tu web service";
    }

    public function loginAndroid() {
        $usuario = urldecode($_POST['usuario']);
        $clave = urldecode($_POST['clave']);
        $datos = $this->_empleado->seleccionar($usuario, $clave);
        $outputArr = array();
        $outputArr['Android'] = $datos;
        print_r(json_encode($outputArr));
    }

    public function seleccionaAlmacenes() {
        $datos = $this->_almacenes->selecciona();
        $outputArr = array();
        $outputArr['Android'] = $datos;
        print_r(json_encode($outputArr));
    }

    public function movimientosDinero() {
        $fecha = urldecode($_POST['fecha']);
        $this->_movimiento->fecha = $fecha;
        $datos = $this->_movimiento->seleccionaXfecha();
        $outputArr = array();
        $outputArr['Android'] = $datos;
        print_r(json_encode($outputArr));
    }

    public function productosxAlmacen() {
        
        $almacen = urldecode($_POST['almacen']);
        $this->_reportes->idalmacen = $almacen;
        $datos = $this->_reportes->selecciona_stock_total();
        $outputArr = array();
        $outputArr['Android'] = $datos;
        print_r(json_encode($outputArr));
    }

}

?>
