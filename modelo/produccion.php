<?php

class produccion extends Main{
    
    public $id_produccion;
    public $id_venta;
    public $id_empleado;
    public $fecha_programada;
    public $estadoproduccion;
    public $nrodoc;

    public function selecciona() {
        if (is_null($this->id_produccion)) {
            $this->id_produccion = 0;
        }
        if (is_null($this->estadoproduccion)) {
            $this->estadoproduccion = 0;
        }
        if (is_null($this->nrodoc)) {
            $this->nrodoc = '';
        }
        $datos = array($this->id_produccion, $this->estadoproduccion, $this->nrodoc);
//        echo '<pre>';print_r($datos);exit;
        $r = $this->get_consulta("sel_produccion", $datos);
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
        $datos = array($this->id_venta, $this->id_empleado, $this->fecha_programada);
//        print_r($datos);exit;
        $r = $this->get_consulta("ins_produccion", $datos);
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
    
    public function act_fecha_programada() {
        $datos = array($this->id_produccion, $this->cantidadub);
        $r = $this->get_consulta("act_fecha_programada", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }

    public function entregar() {
        $datos = array($this->id_produccion);
//        echo '<pre>';print_r($datos);exit;
        $r = $this->get_consulta("act_entregaproduccion", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }
    
    public function elimina() {
        $datos = array($this->id_produccion);
//        echo '<pre>';print_r($datos);exit;
        $r = $this->get_consulta("elim_produccion", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }
}

?>
