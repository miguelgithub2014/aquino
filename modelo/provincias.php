<?php

class provincias extends Main{
    
    public $idubigeo;
    public $codigo_region;
    public $codigo_provincia;
    public $codigo_distrito;
    public $idpais;
    
    public function selecciona() {
        if(is_null($this->codigo_provincia)){
            $this->codigo_provincia=0;
        }
        $datos = array($this->codigo_provincia,  $this->codigo_region);
        $r = $this->get_consulta("sel_provincia", $datos);
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
