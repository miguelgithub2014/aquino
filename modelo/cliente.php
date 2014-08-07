<?php

class cliente extends Main {

    public $idcliente;
    public $nombres;
    public $apellidos;
    public $documento;
    public $fecha_nacimiento;
    public $sexo;
    public $telefono;
    public $email;
    public $estado_civil;
    public $idprofesion;
    public $idubigeo;
    public $direccion;
    public $tipo;
    public $nombresyapellidos;
    public $razonsocial;
    public $dni;
    public $ruc;
    public $nombresrs;
    public $dniruc;
    
    public function selecciona() {
        if (is_null($this->idcliente)) {
            $this->idcliente = 0;
        }
        if (is_null($this->nombresrs)) {
            $this->nombresrs = '';
        }
        if (is_null($this->dniruc)) {
            $this->dniruc = '';
        }
        if (is_null($this->dniyruc)) {
            $this->dniyruc = '';
        }
        $datos = array($this->idcliente, $this->nombresrs, $this->dniruc, $this->dniyruc);
        $r = $this->get_consulta("sel_cliente", $datos);
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
        $datos = array(0, $this->nombres, $this->apellidos, $this->documento, $this->fecha_nacimiento,
            $this->sexo, $this->telefono, $this->email, $this->estado_civil, $this->idprofesion, $this->idubigeo,
            $this->direccion, $this->tipo);
        $r = $this->get_consulta("ins_act_cliente", $datos);
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

    public function actualiza() {
        $datos = array($this->idcliente, $this->nombres, $this->apellidos, $this->documento, $this->fecha_nacimiento,
            $this->sexo, $this->telefono, $this->email, $this->estado_civil, $this->idprofesion, $this->idubigeo,
            $this->direccion, $this->tipo);

        $r = $this->get_consulta("ins_act_cliente", $datos);
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

}

?>
