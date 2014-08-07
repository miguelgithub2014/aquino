<?php

Class menu {

//cargarmenu("0"); // Donde 0 es el Idpadre principal
    protected $_id;
    protected $_datos;
    protected $_id_modulopadre;
    private $_c = 0;

    public function __construct($datos, $id_modulopadre) {
        $this->_datos = $datos;
        $this->_id_modulopadre = $id_modulopadre;
        $this->unemenu();
    }

    function unemenu() {
        echo "<ul id='nav'>";
        $this->cargarmenu();
        echo "<li><a href='" . BASE_URL . "'><i class='icon-desktop'></i><span>Web</span></a></li>";
        echo "</ul>";
        echo '</div><div class="mainbar">';
    }

    function cargarmenu() {
        if(isset($this->_datos) && count($this->_datos)){
            for($i=0; $i< count($this->_datos); $i++){
                if($this->_c==0){
                    $descripcion= ucwords(strtolower($this->_datos[$i]['XMODULOS']));
                    if($this->_datos[$i]['IDMODULO']==$this->_id_modulopadre){
                            echo "<li class='has_sub'><a href='javascript:void' class='open'><i class='".strtolower($this->_datos[$i]['ICONO'])."'></i><span>$descripcion</span><span class='pull-right'><i class='icon-chevron-right'></i></span></a><ul>";
                    }else{
                        echo "<li class='has_sub'><a href='javascript:void'><i class='".strtolower($this->_datos[$i]['ICONO'])."'></i><span>$descripcion</span><span class='pull-right'><i class='icon-chevron-right'></i></span></a><ul>";
                    }
                    $this->_c = 1;
                }
                if (strtoupper($descripcion) == $this->_datos[$i]['XMODULOS']){
                    $url = BASE_URL . strtolower($this->_datos[$i]['URL']);
                    echo "<li><a href='$url' class='mh_".strtolower($this->_datos[$i]['URL'])."'>" . ucwords(strtolower($this->_datos[$i]['MODULOS_HIJOS'])) . "</a></li>";
                } else {
                    echo "</ul></li>";
                    $this->_c = 0;
                    $i = $i -1;
                }
            }
            echo "</ul></li>";
        }
    }
}
?>
<!--FIn menu-->