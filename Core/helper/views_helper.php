<?php
use PHPBook\View as View;

View\Configuration\View::setViewsPathRoot('main', '../App/Views');

View\Configuration\View::setDefaultPathRoot('main');

/**Renderizar una vista */
function view($nombreVista, $data=null)
{
    $view = new View\View;
    $view->setView($nombreVista);

    if($data!=null)
    {
        if(is_object($data))
        {
            $data = (array) $data;
        }
        $view->setData($data);
    }

    //$ds = DIRECTORY_SEPARATOR;
    //$base_dir = realpath(dirname(__FILE__)  . $ds . '..'. $ds . '..') . $ds;

    //include_once 'App/views/'.$nombreVista.'.php';

    return $view->render();
}//Fin de la funcion

/**
 * Carga un script en la aplicacion
 * 
 * @param string $script Script a cargar
 */
function cargar($script = '')
{
    return "<!-- Cargar funcion -->
                        <script type:text/javascript>
                            function cargar() {
                                    if (estado_app != 'ready') {
                                        setTimeout(function(){
                                            cargar();
                                        }, 1000);
                                    } else {
                                        $script
                                    }
                                }
                                cargar();
                        </script>";
}


/**Obtener el nombre de un archivo almacenado en el servidor */
function getFile($name = '')
{
    if($name!='') {
        return baseUrl('files/'.$name);
    }

    return false;
}//Fin de la funcion

/**Obtener un script */
function getScript($name = '')
{
    if($name!='') {
        //Validar si es una url
        if(strpos($name, 'http') !== false) {
            return '<script src="'.$name.'.js"></script>';
        } else {
            return '<script src="'.getFile('dist/js/'.$name.'.js').'"></script>';
        }
    }

    return '';
}//Fin de la funcion

function createScript($content = '')
{
    return '<script>'.$content.'</script>';
}//Fin de la funcion

/**Obtener una variable desde una solicitud POST */
function post($name = null)
{
    if(!empty($_POST))
    {
        if($name)
        {
            if(isset($_POST[$name]))
                return $_POST[$name];

            return false;
        }
                
        $data = json_encode($_POST);

        return json_decode($data);
    }//Fin de la validacion

    return false;
}//Fin del metodo

/**Obtener una variable desde una solicitud GET */
function get($name = null)
{
    if(!empty($_GET))
    {
        if($name)
        {
            if(isset($_GET[$name]))
                return $_GET[$name];

            return false;
        }
                
        $data = json_encode($_GET);

        return json_decode($data);
    }//Fin de la validacion

    return false;
}//Fin del metodo
