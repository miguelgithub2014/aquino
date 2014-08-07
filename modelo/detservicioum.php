<?php

class detservicioum extends Main{
    
    public $id_servicio;
    public $id_unidadmedida;
    public $preciov;

    public function selecciona() {
        if (is_null($this->id_unidadmedida)) {
            $this->id_unidadmedida = 0;
        }
        if (is_null($this->id_servicio)) {
            $this->id_servicio = 0;
        }
        $datos = array($this->id_unidadmedida, $this->id_servicio);
//        echo '<pre>';print_r($datos);exit;
        $r = $this->get_consulta("sel_detservicioum", $datos);
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
        $datos = array($this->id_servicio, $this->id_unidadmedida, $this->preciov);
//        print_r($datos);exit;
        $r = $this->get_consulta("ins_detservicioum", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }
    
    public function actualiza() {
        $datos = array($this->id_servicio, $this->id_unidadmedida, $this->preciov);
//        print_r($datos);exit;
        $r = $this->get_consulta("act_detservicioum", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }

    public function elimina() {
        $datos = array($this->id_servicio, $this->id_unidadmedida);
//        print_r($datos);exit;
        $r = $this->get_consulta("elim_detservicioum", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }

}

?>
