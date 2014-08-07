<?php

class empleado extends Main{
    
    public $id_empleado;
    public $nombre;
    public $apellido;
    public $direccion;
    public $telefono;
    public $dni;
    public $fechanacimiento;
    public $usuario;
    public $clave;
    public $id_perfil;
    public $perfil;
    public $estadocivil;

    public function selecciona() {
        if (is_null($this->id_empleado)) {
            $this->id_empleado = 0;
        }
        if (is_null($this->nombre)) {
            $this->nombre = '';
        }
        if (is_null($this->apellido)) {
            $this->apellido = '';
        }
        if (is_null($this->usuario)) {
            $this->usuario = '';
        }
        if (is_null($this->perfil)) {
            $this->perfil = '';
        }
        $datos = array($this->id_empleado, $this->nombre, $this->apellido,$this->usuario, $this->perfil);
//        echo '<pre>';print_r($datos);exit;
        $r = $this->get_consulta("sel_empleado", $datos);
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
        $datos = array($this->nombre, $this->apellido, $this->direccion, $this->telefono, $this->dni, $this->fechanacimiento, 
            $this->usuario, $this->clave, $this->id_perfil, $this->estadocivil);
        $r = $this->get_consulta("ins_empleado", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }

    public function actualiza() {
        $datos = array($this->id_empleado, $this->nombre, $this->apellido, $this->direccion, $this->telefono, $this->dni, 
            $this->fechanacimiento, $this->usuario, $this->clave, $this->id_perfil, $this->estadocivil);
        $r = $this->get_consulta("act_empleado", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }

    public function seleccionar($usuario,$clave) {
        $datos = array($usuario,$clave);
        $r = $this->get_consulta("pa_selecciona_login", $datos);
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
//            echo '<pre>';
//            print_r($stmt->fetchall());
//            die();
        }
    }

    public function elimina() {
        $datos = array($this->id_empleado);
        $r = $this->get_consulta("elim_empleado", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }
    
    public function login_android($usuario, $clave) {
        $datos = array($usuario, $clave);
        $r = $this->get_consulta("pa_login_android", $datos);
        if ($r[1] == '') {
            $stmt = $r[0];
        } else {
            die($r[1]);
        }
        $r = null;
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetch();
    }

}

?>
