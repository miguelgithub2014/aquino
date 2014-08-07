<?php

class unidadmedida extends Main{
    
    public $id_unidadmedida;
    public $descripcion;
    public $prefijo;
    public $cant_unidad;
    public $equivalenteunidad;

    public function selecciona() {
        if (is_null($this->id_unidadmedida)) {
            $this->id_unidadmedida = 0;
        }
        if (is_null($this->descripcion)) {
            $this->descripcion = '';
        }
        if (is_null($this->prefijo)) {
            $this->prefijo = '';
        }
        $datos = array($this->id_unidadmedida, $this->descripcion, $this->prefijo);
//        echo '<pre>';print_r($datos);exit;
        $r = $this->get_consulta("sel_unidadmedida", $datos);
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
    
    public function selecciona_unidadbase() {
        if (is_null($this->id_unidadmedida)) {
            $this->id_unidadmedida = 0;
        }
        $datos = array($this->id_unidadmedida);
//        echo '<pre>';print_r($datos);exit;
        $r = $this->get_consulta("sel_unidadbase", $datos);
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
        $datos = array($this->descripcion, $this->prefijo, $this->cant_unidad, $this->equivalenteunidad);
        $r = $this->get_consulta("ins_unidadmedida", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }

    public function actualiza() {
        $datos = array($this->id_unidadmedida, $this->descripcion, $this->prefijo, $this->cant_unidad, $this->equivalenteunidad);
        $r = $this->get_consulta("act_unidadmedid", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }

    public function elimina() {
        $datos = array($this->id_unidadmedida);
        $r = $this->get_consulta("elim_unidmedida", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }

}

?>
