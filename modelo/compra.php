<?php

class compra extends Main{
    
    public $id_compra;
    public $id_proveedor;
    public $id_tipopago;
    public $fechacompra;
    public $monto;
    public $nrodoc;
    public $igv;
    public $estadopago;
    public $proveedor;

    public function selecciona() {
        if (is_null($this->id_compra)) {
            $this->id_compra = 0;
        }
        if (is_null($this->nrodoc)) {
            $this->nrodoc = '';
        }
        if (is_null($this->fechacompra)) {
            $this->fechacompra = '';
        }
        if (is_null($this->proveedor)) {
            $this->proveedor = '';
        }
        $datos = array($this->id_compra, $this->nrodoc, $this->fechacompra, $this->proveedor);
//        echo '<pre>';print_r($datos);exit;
        $r = $this->get_consulta("sel_compra", $datos);
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
        $datos = array($this->id_proveedor, $this->id_tipopago, $this->fechacompra, $this->monto, $this->nrodoc, $this->igv);
        $r = $this->get_consulta("ins_compra", $datos);
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
        $datos = array($this->id_compra);
        $r = $this->get_consulta("elim_compra", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }

}

?>
