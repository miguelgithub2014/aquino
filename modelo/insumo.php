<?php

class insumo extends Main{
    
    public $id_insumo;
    public $id_almacen;
    public $descripcion;
    public $stock;
    public $id_unidadmedida;
    public $precioc;
    public $almacen;

    public function selecciona() {
        if (is_null($this->id_insumo)) {
            $this->id_insumo = 0;
        }
        if (is_null($this->descripcion)) {
            $this->descripcion = '';
        }
        if (is_null($this->almacen)) {
            $this->almacen = '';
        }
        $datos = array($this->id_insumo, $this->descripcion, $this->almacen);
//        echo '<pre>';print_r($datos);exit;
        $r = $this->get_consulta("sel_insumo", $datos);
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
        $datos = array($this->id_almacen, $this->descripcion, $this->id_unidadmedida);
//        print_r($datos);exit;
        $r = $this->get_consulta("ins_insumo", $datos);
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
        $datos = array($this->id_insumo, $this->id_almacen, $this->descripcion, $this->id_unidadmedida);
//        echo '<pre>';print_r($datos);exit;
        $r = $this->get_consulta("act_insumo", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }
    
    public function act_stock() {
        $datos = array($this->id_insumo, $this->cantidadub);
        $r = $this->get_consulta("act_stock", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }

    public function elimina() {
        $datos = array($this->id_insumo);
//        echo '<pre>';print_r($datos);exit;
        $r = $this->get_consulta("elim_insumo", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }
    
    public function selecciona_android() {
        $datos = array(0);
//        echo '<pre>';print_r($datos);exit;
        $r = $this->get_consulta("sel_insumo_android", $datos);
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
    //get_insumo
}

?>
