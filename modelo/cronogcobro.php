<?php

class cronogcobro extends Main{
    
    public $id_cronogcobro;
    public $id_venta;
    public $cliente;
    public $fecha;
    public $monto;
    public $nrocuota;
    public $id;
    public $estadopago;
    public $idcliente;

    public function selecciona() {
        if (is_null($this->id_venta)) {
            $this->id_venta = 0;
        }
        if (is_null($this->cliente)) {
            $this->cliente = '';
        }
        if (is_null($this->idcliente)) {
            $this->idcliente = 0;
        }
        $datos = array($this->id_venta, $this->cliente, $this->idcliente);
        $r = $this->get_consulta("sel_cronogcobro", $datos);
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
    
    public function selecciona_cuota() {
        if (is_null($this->id_venta)) {
            $this->id_venta = 0;
        }
        $datos = array($this->id_venta);
        $r = $this->get_consulta("sel_cuotacobro", $datos);
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
        $datos = array($this->id_venta, $this->fecha, $this->monto, $this->nrocuota);
//        print_r($datos);exit;
        $r = $this->get_consulta("ins_cronogcobro", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }

    public function actualiza() {
        $datos = array($this->id_cronogcobro, $this->id_venta, $this->monto, $this->nrocuota);
        $r = $this->get_consulta("act_cronogcobro", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }
    
    public function estadopago(){
        $this->id_venta = 2;
        $datos = array($this->id, $this->id_venta, $this->estadopago);
        $r = $this->get_consulta("act_estadocv", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }

}

?>
