<?php

class cronogpago extends Main{
    
    public $id_cronogpago;
    public $id_compra;
    public $proveedor;
    public $fecha;
    public $monto;
    public $nrocuota;
    public $id;
    public $estadopago;

    public function selecciona() {
        if (is_null($this->id_compra)) {
            $this->id_compra = 0;
        }
        if (is_null($this->proveedor)) {
            $this->proveedor = '';
        }
        $datos = array($this->id_compra, $this->proveedor);
        $r = $this->get_consulta("sel_cronogpago", $datos);
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
        if (is_null($this->id_compra)) {
            $this->id_compra = 0;
        }
        $datos = array($this->id_compra);
        $r = $this->get_consulta("sel_cuotapago", $datos);
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
        $datos = array($this->id_compra, $this->fecha, $this->monto, $this->nrocuota);
        $r = $this->get_consulta("ins_cronogpago", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }

    public function actualiza() {
        $datos = array($this->id_cronogpago, $this->id_compra, $this->monto, $this->nrocuota);
        $r = $this->get_consulta("act_cronogpago", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }
    
    public function estadopago(){
        $this->id_compra = 1;
        $datos = array($this->id, $this->id_compra, $this->estadopago);
        $r = $this->get_consulta("act_estadocv", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }

}

?>
