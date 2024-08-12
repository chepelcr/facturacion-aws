<?php
    /**Cargar archivos de ayuda de la aplicacion */
    function load_helpers($helpers = array(), $tipo = 'Core')
    {
        if(is_array($helpers))
        {
            foreach ($helpers as $helper) 
            {
                load_helper($helper, $tipo);
            }//Fin de la inclusion de los helpers
        }//Fin de la validacion
    }//Fin de la funcion para cargar los archivos de ayuda de la aplicacion

    /**Cargar un archivo de ayuda en la aplicacion */
    function load_helper($name ='', $tipo ='Core')
    {
        /**Si es un archivo de la app */
        if($tipo =='Core') {
            $file = 'Core/helper/'.$name.'_helper.php';
        } else {
            $file = 'App/helper/'.$name.'_helper.php';
        }

        require_once($file);
    }//Fin de la funcion
    