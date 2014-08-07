<?php

class informacion extends Main{
    
    public $conocenos;
    public $mision;
    public $vision;
    
    public function selecciona() {
        $datos = array();
        $r = $this->get_consulta("pa_sel_informacion", $datos);
        if ($r[1] == '') {
            $stmt = $r[0];
        } else {
            die($r[1]);
        }
        $r = null;
            $stmt->setFetchMode(PDO::FETCH_ASSOC);       
            return $stmt->fetchall();
    }

    public function actualiza() {
        $datos = array($this->conocenos, $this->mision, $this->vision, $this->historia);
        $r = $this->get_consulta("pa_act_informacion", $datos);
        $error = $r[1];
        $r = null;
        return $error;
    }
    
}

?>
