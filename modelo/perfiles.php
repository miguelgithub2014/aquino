<?php

class perfiles extends Main{

    public $idperfil;
    public $descripcion;

    public function selecciona() {
        if(is_null($this->idperfil)){
            $this->idperfil=0;
        }
        if(is_null($this->descripcion)){
            $this->descripcion='';
        }
        $datos = array($this->idperfil, $this->descripcion);
        $r = $this->get_consulta("pa_selecciona_perfil", $datos);
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
        $datos = array($this->idperfil);
        $r = $this->get_consulta("pa_elimina_perfil", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }

    public function inserta() {
        $datos = array(0, $this->descripcion);
        $r = $this->get_consulta("pa_inserta_actualiza_perfil", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }

    public function actualiza() {
        $datos = array($this->idperfil, $this->descripcion);
        $r = $this->get_consulta("pa_inserta_actualiza_perfil", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }

}

?>
