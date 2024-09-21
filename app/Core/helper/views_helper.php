<?php

use PHPBook\View as View;
use NumberFormatter;

View\Configuration\View::setViewsPathRoot('main', '../App/Views');

View\Configuration\View::setDefaultPathRoot('main');

/**Renderizar una vista */
function view($nombreVista, $data = null) {
    $view = new View\View;
    $view->setView($nombreVista);

    if ($data != null) {
        if (is_object($data)) {
            $data = (array) $data;
        }
        $view->setData($data);
    }

    //$ds = DIRECTORY_SEPARATOR;
    //$base_dir = realpath(dirname(__FILE__)  . $ds . '..'. $ds . '..') . $ds;

    //include_once 'App/views/'.$nombreVista.'.php';

    return $view->render();
} //Fin de la funcion

/**
 * Formatear un numero para mostrarlo en formato de moneda
 */
function formatMoney($number, $currency = "CRC") {
    $locale = getEnt('app.locale');

    // Seleccionar el signo de la moneda
    $numberFormat = new NumberFormatter($locale, NumberFormatter::CURRENCY);
    $numberFormat->setAttribute(NumberFormatter::FRACTION_DIGITS, 2);
    
    return $numberFormat->formatCurrency($number, $currency);   
}

/**
 * Carga un script en la aplicacion
 * 
 * @param string $script Script a cargar
 */
function cargar($script = '') {
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
function getFile($name = '') {
    if ($name != '') {
        return baseUrl('files/' . $name);
    }

    return false;
} //Fin de la funcion

/**
 * Obtener un listado de elementos con la lista base
 */
function listado($data) {
    return view('base/listado', $data);
}

/**Obtener un script de la aplicacion o externamente
 * @param string $name Nombre del script
 * @param bool $web Indica si el script es externo
 * @param string $crossorigin Codificacion del script
 * @param string $charset Indica si el script es externo
 * 
 * @return string Retorna el script generado
 */
function getScript($name = "", $web = false, $crossorigin = "", $charset = "") {
    if ($name != "") {
        $script = '<script src="';

        if (!$web) {
            $script .= getFile('dist/js/' . $name . '.js') . '"';
        } else {
            $script .= $name . '"';
        }

        if ($crossorigin != "") {
            $script .= ' crossorigin="' . $crossorigin . '"';
        }

        if ($charset != "") {
            $script .= ' charset="' . $charset . '"';
        }

        $script .= '></script>';

        return $script;
    }

    return '';
} //Fin de la funcion

/**Crear un script con data
 * @param string $data Data del script
 * @return string Retorna el script generado
 */
function setScriptData($data = "") {
    if ($data != "") {
        $script = '<script>';
        $script .= $data;
        $script .= '</script>';

        return $script;
    }

    return '';
} //Fin de la funcion

/**Obtener una variable desde una solicitud POST */
function post($name = null) {
    if (!empty($_POST)) {
        if ($name) {
            if (isset($_POST[$name]))
                return $_POST[$name];

            return false;
        }

        $data = json_encode($_POST);

        return json_decode($data);
    } //Fin de la validacion

    return false;
} //Fin del metodo

/**Obtener una variable desde una solicitud GET */
function get($name = null) {
    if (!empty($_GET)) {
        if ($name) {
            if (isset($_GET[$name])) {
                return $_GET[$name];
            }

            return false;
        } else {
            $data = json_encode($_GET);

            return json_decode($data);
        }
    } //Fin de la validacion

    return false;
}//Fin del metodo
