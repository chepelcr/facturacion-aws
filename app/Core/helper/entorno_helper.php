<?php

use Dotenv\Dotenv;

/**Obtener una variable de entorno */
function getEnt($name = false)
{
    return Entorno::getEnt($name);
} //Fin de la funcion

/**Obtener el ambiente de la aplicacion */
function getEnviroment()
{
    return Entorno::getEnt();
}

/**
 * Crear un entorno de la aplicacion
 */
class Entorno
{
    /**
     * Entorno de la aplicacion
     */
    private static $entorno = null;

    private static function setEnt()
    {
        if (!isset(self::$entorno)) {
            $dotEnv = Dotenv::createImmutable('../');
            $dotEnv->load();

            //Si existe la variable de entorno app.environment
            if (isset($_ENV['app.environment'])) {
                self::$entorno = $_ENV['app.environment'];
            } else {
                self::$entorno = 'dev';
            }

            //Vamos a validar si existe un archivo de entorno que se llame .env-$entorno
            if (file_exists('../.env-' . self::$entorno)) {
                $dotEnv = Dotenv::createImmutable('.', '.env-' . self::$entorno);
                $dotEnv->load();
            }
        }
    }

    public static function getEnt($variableName = false)
    {
        if (!isset(self::$entorno)) {
            self::setEnt();
        }

        if (!$variableName || !isset($_ENV[$variableName])) {
            if (!$variableName) {
                return self::$entorno;
            } else {
                return null;
            }
        }

        return $_ENV[$variableName];
    }
}
