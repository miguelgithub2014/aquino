<?php

class servicios_web extends Main{

    public $id;
    public $descripcion;

    public function selecciona() {
        if(is_null($this->id)){
            $this->id=0;
        }
        if(is_null($this->titulo)){
            $this->titulo='';
        }
        $datos = array($this->id, $this->titulo);
        $r = $this->get_consulta("sel_servicio_web", $datos);
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
        $datos = array($this->id);
        $r = $this->get_consulta("elim_servicio_web", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }

    public function inserta() {
        $datos = array(0, $this->titulo, $this->imagen);
        $r = $this->get_consulta("insact_servicioweb", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }

    public function actualiza() {
        $datos = array($this->id, $this->titulo, $this->imagen);
        $r = $this->get_consulta("insact_servicioweb", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }

}

?>
