<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FrontController
 *
 * @author pedro
 */
class FrontController {
    //put your code here
    public static function main(request $peticion) {
        // Obtenemos el controlador y la accion
        $controlador_ = $peticion->get_controlador() . '_controlador'; //recuperamos el nombre del controlador enviado por get
        $metodo = $peticion->get_metodo(); //recuperamos el metodo(accion)
        $argumentos = $peticion->get_argumentos(); //recuperamos los argumentos en un array
        //revisamos si el archivo(controlador) existe y es legible DEL CONTROLADOR
        $ruta_controlador = ROOT . 'controlador' . DS . $controlador_ . '.php'; //aqui concatenamos la ruta del controlador
        //die($ruta_controlador);
        if (is_readable($ruta_controlador)) {

            //requerimos al archivo
            require_once $ruta_controlador;

            //instanciamos la clase
            $controlador_ = new $controlador_;

            //comprobamos si el metodo es valido
            if (is_callable(array($controlador_, $metodo))) {
                $metodo = $peticion->get_metodo();
            } else {
                //si no lo es 
                $metodo = 'index';
            }
            //comprobamos si hay argumentos
            if (isset($argumentos)) {

                //enviamos en un arreglo la instancia de la clase
                //el metodo de esa clase
                //y los parametros que queremos pasarle a ese metodo
                call_user_func_array(array($controlador_, $metodo), $argumentos);
            } else {
                //me llama a la clase y el metodo que solicitamos
                call_user_func(array($controlador_, $metodo));
            }
        } else {
            //instanciamos una excepcion 
            throw new Exception('El archivo no está o no es legible');
        }
    }
}

?>
