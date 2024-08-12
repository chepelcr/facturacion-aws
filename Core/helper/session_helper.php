<?php
session_start();

/**Obtener el estado de la sesion del usuario, o una variable de la sesion del usuario 
 * @param mixed $name
 * @return bool|mixed
*/
function getSession($name = false)
{
    if(isset($_SESSION[baseUrl()]))
    {
        if(!$name)
            return $_SESSION[baseUrl()];

        if(isset($_SESSION[baseUrl($name)]))
            return $_SESSION[baseUrl($name)];
    }

    return false;
}//Fin del metodo para obtener la sesion de la aplicacion

function setSession($name, $value)
{
    if(!isset($_SESSION[baseUrl()]))
        $_SESSION[baseUrl()] = true;

    $_SESSION[baseUrl($name)] = $value;
}//Fin del metodo para setear la un valor de la sesion de la aplicacion

function setDataSession($data)
{
    $_SESSION[baseUrl()] = true;

    foreach ($data as $campo => $valor) {
        setSession($campo, $valor);
    }//Fin del ciclo para crear la sesion con data
}//Fin del metodo para setear la sesion de la aplicacion

function destroy()
{
    $_SESSION[baseUrl()] = null;

    session_destroy();
}//Fin del metodo para destruir una sesion
