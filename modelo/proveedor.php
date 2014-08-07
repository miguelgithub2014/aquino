<?php

class proveedor extends Main{
    
    public $id_proveedor;
    public $nombre;
    public $direccion;
    public $telefmovil;
    public $razonsocial;
    public $email;
    public $ciudad;
    public $ruc;

    public function selecciona() {
        if (is_null($this->id_proveedor)) {
            $this->id_proveedor = 0;
        }
        if (is_null($this->nombre)) {
            $this->nombre = '';
        }
        if (is_null($this->razonsocial)) {
            $this->razonsocial = '';
        }
        if (is_null($this->ruc)) {
            $this->ruc = '';
        }
        $datos = array($this->id_proveedor, $this->nombre, $this->razonsocial,$this->ruc);
//        echo '<pre>';print_r($datos);exit;
        $r = $this->get_consulta("sel_proveedor", $datos);
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
        $datos = array($this->nombre, $this->direccion, $this->razonsocial, $this->email, $this->ciudad,
            $this->ruc, $this->telefmovil);
        $r = $this->get_consulta("ins_proveedor", $datos);
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

    public function actualiza() {
        $datos = array($this->id_proveedor, $this->nombre, $this->direccion, $this->razonsocial, $this->email, $this->ciudad,
            $this->ruc, $this->telefmovil);
        $r = $this->get_consulta("act_proveedor", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }

    public function elimina() {
        $datos = array($this->id_proveedor);
        $r = $this->get_consulta("elim_proveedor", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }
    
    public function selecciona_android() {

        $datos = array(0);
//        echo '<pre>';print_r($datos);exit;
        $r = $this->get_consulta("sel_proveedor_android", $datos);
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


}

?>
