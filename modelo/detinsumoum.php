<?php

class detinsumoum extends Main{
    
    public $id_insumo;
    public $id_unidadmedida;

    public function selecciona() {
        if (is_null($this->id_unidadmedida)) {
            $this->id_unidadmedida = 0;
        }
        if (is_null($this->id_insumo)) {
            $this->id_insumo = 0;
        }
        $datos = array($this->id_unidadmedida, $this->id_insumo);
//        echo '<pre>';print_r($datos);exit;
        $r = $this->get_consulta("sel_detinsumoum", $datos);
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
        $datos = array($this->id_insumo, $this->id_unidadmedida);
//        print_r($datos);exit;
        $r = $this->get_consulta("ins_detinsumoum", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }

    public function elimina() {
        $datos = array($this->id_insumo, $this->id_unidadmedida);
        $r = $this->get_consulta("elim_detinsumoum", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }

}

?>
