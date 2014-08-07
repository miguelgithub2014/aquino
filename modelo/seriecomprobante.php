<?php

class seriecomprobante extends Main{

    public $id_seriecomprobante;
    public $serie;
    public $correlativo;
    public $id_tipocomprobante;
    public $maxcorrelativo;
    public $tipocomprobante;

    public function selecciona() {
        if(is_null($this->id_seriecomprobante)){
            $this->id_seriecomprobante=0;
        }
         if(is_null($this->tipocomprobante)){
            $this->tipocomprobante='';
        }
         if(is_null($this->id_tipocomprobante)){
            $this->id_tipocomprobante=0;
        }
        $datos = array($this->id_seriecomprobante, $this->tipocomprobante, $this->id_tipocomprobante);
//        print_r($datos);exit;
        $r = $this->get_consulta("sel_seriecomprobante", $datos);
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
        $datos = array($this->id_seriecomprobante);
        $r = $this->get_consulta("elim_sercomprob", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }

    public function inserta() {
        $datos = array($this->serie, $this->id_tipocomprobante, $this->maxcorrelativo);
        $r = $this->get_consulta("ins_seriecomprb", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }

    public function actualiza() {
        $datos = array($this->id_seriecomprobante, $this->serie, $this->id_tipocomprobante, 
            $this->maxcorrelativo);
        $r = $this->get_consulta("act_seriecomprb", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }
    
    public function act_correlativo(){
        $datos = array($this->id_seriecomprobante, $this->correlativo);
        $r = $this->get_consulta("act_correlativo", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }

}

?>
