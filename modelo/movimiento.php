<?php

class movimiento extends Main{

    public $idmovimiento;
    public $idcaja;
    public $idconcepto;
    public $id_formapago;
    public $monto;
    public $fecha;
    public $descripcion;
    public $referencia;
    

    public function inserta() {
        $datos = array($this->idcaja, $this->idconcepto, $this->id_formapago, $this->monto, $this->fecha, $this->referencia);
        $r = $this->get_consulta("ins_movimiento", $datos);
        if ($r[1] == '') {
            $stmt = $r[0];
        } else {
            die($r[1]);
        }
        $r = null;
        return $stmt->fetchall(PDO::FETCH_ASSOC);
    }

    public function selecciona() {
        if(is_null($this->idmovimiento)){
            $this->idmovimiento=0;
        }
        if(is_null($this->descripcion)){
            $this->descripcion='';
        }
        $datos = array($this->idmovimiento, $this->descripcion);
        $r = $this->get_consulta("sel_movimiento", $datos);
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
    
    public function seleccionaXfecha() {
        if(is_null($this->idmovimiento)){
            $this->idmovimiento=0;
        }
        if(is_null($this->descripcion)){
            $this->descripcion='';
        }
        $datos = array($this->fecha);
        $r = $this->get_consulta("sel_movimiento_fecha", $datos);
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
        $datos = array($this->idmovimiento);
        $r = $this->get_consulta("elim_movimiento", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }

}

?>
