<?php

class modulos extends Main{

    public $idmodulo;
    public $descripcion;
    public $url;
    public $estado;
    public $idmodulo_padre;
    public $modulo_padre;
    public $idperfil;
    public $icono;

    public function selecciona() {
        if (is_null($this->idmodulo)) {
            $this->idmodulo = 0;
        }
        if (is_null($this->descripcion)) {
            $this->descripcion = '';
        }
        if (is_null($this->modulo_padre)) {
            $this->modulo_padre = '';
        }
        if(is_null($this->idperfil)){
            $this->idperfil=0;
        }
        $datos = array($this->idmodulo, $this->descripcion, $this->modulo_padre,$this->idperfil);
//        echo '<pre>';print_r($datos);exit;
        $r = $this->get_consulta("pa_selecciona_modulos", $datos);
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
    
    public function seleccionaxurl() {
        if (is_null($this->url)) {
            $this->url= '';
        }
        $datos = array($this->url);
//        echo '<pre>';print_r($datos);exit;
        $r = $this->get_consulta("selModuoloxUrl", $datos);
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
        $datos = array(0, $this->descripcion, $this->url, 1, $this->idmodulo_padre, $this->icono);
        $r = $this->get_consulta("pa_inserta_actualiza_modulos", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }

    public function actualiza() {
        $datos = array($this->idmodulo, $this->descripcion, $this->url, 1,
            $this->idmodulo_padre, $this->icono);
        $r = $this->get_consulta("pa_inserta_actualiza_modulos", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }

    public function seleccionar($idmodulo_padre) {
        $datos = array($idmodulo_padre);
        $r = $this->get_consulta("pa_selecciona_modulos_p", $datos);
        if ($r[1] == '') {
            $stmt = $r[0];
        } else {
            die($r[1]);
        }
         if (conexion::$_servidor == 'oci') {
            oci_fetch_all($stmt, $data, null, null, OCI_FETCHSTATEMENT_BY_ROW);
            return $data;
        } else {
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            return $stmt->fetchall();
        }
    }

    public function elimina() {
        $datos = array($this->idmodulo);
        $r = $this->get_consulta("pa_elimina_modulos", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }

}

?>
