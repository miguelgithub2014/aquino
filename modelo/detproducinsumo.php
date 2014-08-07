<?php

class detproducinsumo extends Main{
    
    public $id_produccion;
    public $id_insumo;
    public $cantidadum;
    public $id_unidadmedida;
    public $cantidadub;

    public function selecciona() {
        if (is_null($this->id_produccion)) {
            $this->id_produccion = 0;
        }
        if (is_null($this->id_insumo)) {
            $this->id_insumo = 0;
        }
        $datos = array($this->id_produccion, $this->id_insumo);
//        echo '<pre>';print_r($datos);exit;
        $r = $this->get_consulta("sel_detproducinsumo", $datos);
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
        $datos = array($this->id_produccion, $this->id_insumo, $this->cantidadum, $this->id_unidadmedida,
            $this->cantidadub);
//        print_r($datos);exit;
        $r = $this->get_consulta("ins_detproducinsumo", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }

}

?>
