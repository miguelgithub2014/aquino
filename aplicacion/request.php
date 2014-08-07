<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of request
 *
 * @author pedro
 */
class request {
    //put your code here
     //declaramos variables internas
    private $_controlador;
    private $_metodo;
    private $_argumentos;

    public function __construct() {
        //preguntamos si hay parametros en la url
        if (isset($_GET['url'])) {
            
            //die($_GET['controller']);
            //toma el parametro url por get lo pasa por el filtro y devuelve filtrado.
            $url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);
            //cada ves que encuentra '/' en $url, lo divide en un array
            $url = explode('/', $url);
            //$accion= filter_input(INPUT_GET, 'accion', FILTER_SANITIZE_URL);
            //$argumentos= filter_input(INPUT_GET, 'param', FILTER_SANITIZE_URL);
            //die($accion);
            $url = array_filter($url);
            $this->_controlador= strtolower(array_shift($url));
            $this->_metodo = strtolower(array_shift($url));
            $this->_argumentos = $url;           
            
        }
        //si no existe parametro controlador lo establecemos por el default
        if (!$this->_controlador) {
            $this->_controlador = DEFAULT_CONTROLLER;
        }
        //si no hay parametro metodo lo ponemos index
        if (!$this->_metodo) {
            $this->_metodo = 'index';
        }
        //si no hay argumentos ponemos un array vacio
        if (!isset($this->_argumentos)) {
            $this->_argumentos = array();
        }
    }

    //********************************************
    //funciones de retorno de parametros del controlador, modelo y argumentos
    public function get_controlador() {
        return $this->_controlador;
    }

    public function get_metodo() {
        return $this->_metodo;
    }

    public function get_argumentos() {
        return $this->_argumentos;
    }
    //*********************************************
}

?>
