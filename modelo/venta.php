<?php

class venta extends Main{
    
    public $id_venta;
    public $id_cliente;
    public $id_empleado;
    public $id_tipopago;
    public $fechaventa;
    public $subtotal;
    public $igv;
    public $id_tipocomprobante;
    public $nrodoc;
    public $estadopago;
    public $cliente;
    public $empleado;

    public function selecciona() {
        if (is_null($this->id_venta)) {
            $this->id_venta = 0;
        }
        if (is_null($this->nrodoc)) {
            $this->nrodoc = '';
        }
        if (is_null($this->fechaventa)) {
            $this->fechaventa = '';
        }
        if (is_null($this->cliente)) {
            $this->cliente = '';
        }
        if (is_null($this->empleado)) {
            $this->empleado = '';
        }
        $datos = array($this->id_venta, $this->nrodoc, $this->fechaventa, $this->cliente, $this->empleado);
//        echo '<pre>';print_r($datos);exit;
        $r = $this->get_consulta("sel_venta", $datos);
        if ($r[1] == '') {
            $stmt = $r[0];
        } else {
            die($r[1]);
        }
        $r = null;
        if (conexion::$_servidor == 'oci') {
            oci_fetch_all($stmt, $data, null, null, OCI_FETCHSTATEMENT_BY_ROW);
            return $data;
        } else {
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            return $stmt->fetchall();
        }
    }
    
    public function selVentaSinProduccion() {
        if (is_null($this->id_venta)) {
            $this->id_venta = 0;
        }
        if (is_null($this->nrodoc)) {
            $this->nrodoc = '';
        }
        if (is_null($this->fechaventa)) {
            $this->fechaventa = '';
        }
        if (is_null($this->cliente)) {
            $this->cliente = '';
        }
        if (is_null($this->empleado)) {
            $this->empleado = '';
        }
        $datos = array($this->id_venta, $this->nrodoc, $this->fechaventa, $this->cliente, $this->empleado);
//        echo '<pre>';print_r($datos);exit;
        $r = $this->get_consulta("sel_ventasinproduccion", $datos);
        if ($r[1] == '') {
            $stmt = $r[0];
        } else {
            die($r[1]);
        }
        $r = null;
        if (conexion::$_servidor == 'oci') {
            oci_fetch_all($stmt, $data, null, null, OCI_FETCHSTATEMENT_BY_ROW);
            return $data;
        } else {
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            return $stmt->fetchall();
        }
    }

    public function inserta() {
        $datos = array($this->id_cliente, $this->id_empleado, $this->id_tipopago, $this->fechaventa, $this->subtotal, 
            $this->igv, $this->id_tipocomprobante, $this->nrodoc);
        $r = $this->get_consulta("ins_venta", $datos);
//        echo '<pre>';print_r($datos);exit;
        if ($r[1] == '') {
            $stmt = $r[0];
        } else {
            die($r[1]);
        }
        $r = null;
        if (conexion::$_servidor == 'oci') {
            oci_fetch_all($stmt, $data, null, null, OCI_FETCHSTATEMENT_BY_ROW);
            return $data;
        } else {
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            return $stmt->fetchall();
        }
    }

    public function elimina() {
        $datos = array($this->id_venta);
        $r = $this->get_consulta("elim_venta", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }

}

?>
