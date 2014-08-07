<?php

class tipomovimiento extends Main{

    public $id_tipomovimiento;
    public $descripcion;

    public function selecciona() {
        if(is_null($this->id_tipomovimiento)){
            $this->id_tipomovimiento=0;
        }
        if(is_null($this->descripcion)){
            $this->descripcion='';
        }
        $datos = array($this->id_tipomovimiento, $this->descripcion);
        $r = $this->get_consulta("sel_tipomovimiento", $datos);
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

}

?>
