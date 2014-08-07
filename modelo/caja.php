<?php

class caja extends Main{

    public $idcaja;
    public $estado;
    public $fecha;
    public $saldo;
    public $idempleado;
    public $empleado;
    public $aumenta;
    
    public function selecciona() {
        if(is_null($this->idcaja)){
            $this->idcaja=0;
        }
        if(is_null($this->empleado)){
            $this->empleado='';
        }
        $datos = array($this->idcaja, $this->empleado);
            $r = $this->get_consulta("sel_caja", $datos);
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
    
    public function inserta() {
        $datos = array(0, $this->idempleado, $this->fecha_ap, $this->estado);
//        print_r($datos);exit;
        $r = $this->get_consulta("insact_caja", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }

    public function actualiza() {
        $this->id_sucursal=session::get('idsucursal');
        if(is_null($this->saldo)){
            $datos = array(1, $this->idempleado, $this->fecha_ci, $this->estado);
//            print_r($datos);exit;
            $r = $this->get_consulta("insact_caja", $datos);
        }else{
            $datos = array($this->saldo, $this->aumenta);
            $r = $this->get_consulta("act_saldocaja", $datos);
        }
        $error = $r[1];
        $r = null;
        return $error;
    }
    
    public function selecciona_android(){
         $datos = array(0);
//        echo '<pre>';print_r($datos);exit;
        $r = $this->get_consulta("sel_caja_android", $datos);
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
