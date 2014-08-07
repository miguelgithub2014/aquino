<?php

class servicio extends Main{

    public $id_servicio;
    public $id_tiposervicio;
    public $descripcion;
    public $tiposervicio;

    public function selecciona() {
        if(is_null($this->id_servicio)){
            $this->id_servicio=0;
        }
         if(is_null($this->descripcion)){
            $this->descripcion='';
        }
         if(is_null($this->tiposervicio)){
            $this->tiposervicio='';
        }
        $datos = array($this->id_servicio, $this->descripcion, $this->tiposervicio);
        $r = $this->get_consulta("sel_servicio", $datos);
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
        $datos = array($this->id_servicio);
        $r = $this->get_consulta("elim_servicio", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }

    public function inserta() {
        $datos = array($this->descripcion, $this->id_tiposervicio);
        $r = $this->get_consulta("ins_servicio", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }

    public function actualiza() {
        $datos = array($this->id_servicio, $this->descripcion, $this->id_tiposervicio);
        $r = $this->get_consulta("act_servicio", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }

}

?>
