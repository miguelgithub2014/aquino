<?php

class concepto extends Main{

    public $idconcepto;
    public $descripcion;
    public $id_tipoconcepto;
    public $tipoconcepto;

    public function selecciona() {
        if(is_null($this->idconcepto)){
            $this->idconcepto=0;
        }
         if(is_null($this->descripcion)){
            $this->descripcion='';
        }
         if(is_null($this->tipoconcepto)){
            $this->tipoconcepto='';
        }
        $datos = array($this->idconcepto, $this->descripcion, $this->tipoconcepto);
        $r = $this->get_consulta("sel_concepto", $datos);
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
        $datos = array($this->idconcepto);
        $r = $this->get_consulta("elim_concepto", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }

    public function inserta() {
        $datos = array($this->descripcion, $this->id_tipoconcepto);
        $r = $this->get_consulta("ins_concepto", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }

    public function actualiza() {
        $datos = array($this->idconcepto, $this->descripcion, $this->id_tipoconcepto);
        $r = $this->get_consulta("act_concepto", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }

}

?>
