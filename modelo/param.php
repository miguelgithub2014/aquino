<?php

class param extends Main{

    public $id_param;
    public $valor;
    public $descripcion;

    public function selecciona() {
        if(is_null($this->id_param)){
            $this->id_param='';
        }
        $datos = array($this->id_param);
        $r = $this->get_consulta("sel_param", $datos);
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
        $datos = array($this->id_param);
        $r = $this->get_consulta("elim_param", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }

    public function inserta() {
        $datos = array($this->id_param, $this->valor, $this->descripcion);
        $r = $this->get_consulta("ins_param", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }

    public function actualiza() {
        $datos = array($this->id_param, $this->valor, $this->descripcion);
        $r = $this->get_consulta("act_param", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }

}

?>
