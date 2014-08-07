<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * 
 */

class inicio_controlador extends controller {

    function __construct() {
    //llamamos al metodo constructor de la clase padre
        parent::__construct();
    }

    function index() {
        //enviamos el parametro a la vista index.phtml
        //$this->_vista->titulo = 'Portada';
        //llamamos al metodo renderizar para que muestre la vista enviada
        //por parametro
        if(session::get('autenticado')){
            $this->_vista->renderizar('index');
        }
        else{
            header('location:' . BASE_URL );
            exit;
        }
    }

}

?>
