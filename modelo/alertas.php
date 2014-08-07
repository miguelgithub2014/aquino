<?php

class alertas extends Main{

    public $idalerta;
    public $descripcion;
    public $idmodulo;
    public $estado;
    public $idperfil;
    
    public function selecciona() {
        if(is_null($this->idalerta)){
            $this->idalerta=0;
        }
        if(session::get('autenticado')){
            $this->idperfil=session::get('idperfil');
        }else{
            $this->idperfil=0;
        }
        $datos = array($this->idalerta,$this->idperfil);
        $r = $this->get_consulta("sel_alertas", $datos);
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
    
    public function activa_alerta() {
        $datos = array($this->idalerta);
        $r = $this->get_consulta("pa_activa_alertas", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }
    
    public function desactiva_alerta() {
        $r = $this->get_consulta("pa_desactiva_alertas");
        $error = $r[1];
        $r = null;
        return $error;
    }
        
}

?>
