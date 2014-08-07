<?php

Class alerta {

    protected $_datos;

    public function __construct($datos) {
        $this->_datos = $datos;
        $this->newalertas();
    }

    function newalertas() {
        if(isset($this->_datos) && count($this->_datos)){
                echo '<li class="grey">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="icon-bell-alt icon-only icon-animated-bell"style="color: #ddd"></i>';
                                $cantidad = 0;
                                for($i=0; $i< count($this->_datos); $i++){
                                    $cantidad = $cantidad + $this->_datos[$i]['CANTIDAD'];
                                }
                                echo '<span class="badge badge-important">'.$cantidad.'</span>
                                </a>
                            <ul class="pull-right dropdown-navbar navbar-green dropdown-menu dropdown-caret dropdown-closer">
                                <li class="nav-header">
                                    <i class="icon-warning-sign"></i>
                                    Tienes '.$cantidad.' notificaciones
                                </li>';
                for($i=0; $i< count($this->_datos); $i++){
                echo '<li>
                            <a href="'.BASE_URL . strtolower($this->_datos[$i]['MODULO']).'">
                                <div class="clearfix">
                                    <span class="pull-left">
                                        <span class="badge badge-success">'.$this->_datos[$i]['CANTIDAD'].'</span>
                                        '.ucwords(strtolower($this->_datos[$i]['DESCRIPCION'])).'
                                    </span>
                                </div>                                
                            </a>
                        </li>';
                }
                                            
                    echo '</ul>
                 </li>';
        } 
        else {
                echo '<li class="grey">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="icon-ok"></i>
                                <span class="badge badge-green">0</span>
                            </a>
                            <ul class="dropdown-menu extended notification">
                                <li>
                                    <p>No hay nuevas notificaciones</p>
                                </li>
                            </ul>
                    </li>';
        }
    }
}
?>