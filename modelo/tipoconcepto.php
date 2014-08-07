<?php

class tipoconcepto extends Main{

    public $idtipoconcepto;
    public $descripcion;

    public function selecciona() {
        if(is_null($this->idtipoconcepto)){
            $this->idtipoconcepto=0;
        }
        if(is_null($this->descripcion)){
            $this->descripcion='';
        }
//        $datos = array($this->idtipoconcepto, $this->descripcion);
        $datos = array();
        $r = $this->get_consulta("sel_tipoconcepto", $datos);
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
        };
    }

    public function elimina() {
        $datos = array($this->idtipoconcepto);
        $r = $this->get_consulta("pa_elimina_tipoconcepto", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }

    public function inserta() {
        $datos = array(0, $this->descripcion);
        $r = $this->get_consulta("pa_inserta_actualiza_tipoconcepto", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }

    public function actualiza() {
        $datos = array($this->idtipoconcepto, $this->descripcion);
        $r = $this->get_consulta("pa_inserta_actualiza_tipoconcepto", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }

}

?>
