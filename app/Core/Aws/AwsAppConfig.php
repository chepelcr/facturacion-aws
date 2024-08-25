<?php

namespace Core\Aws;

use Aws\AppConfigData\AppConfigDataClient;

/**
 * Clase para manejar los servicios de AppConfig de AWS
 * @package Core\Aws
 * @subpackage AwsAppConfig
 * @version 1.0
 * @author jcampos
 */
class AwsAppConfig
{

    /**
     * Configuraciones de AppConfig
     */
    private static $configurations;

    /**
     * Obtiene un valor de AppConfig
     * @param string $key Llave del valor
     * @return string Valor de la llave
     */
    public static function getValue($key)
    {
        if(!isset(self::$configurations)){
            self::setConfigurations();
        }

        if(!isset(self::$configurations[$key])){
            return null;
        }

        return self::$configurations[$key];
    }

    /**
     * Obtiene todas las configuraciones de AppConfig
     * @return array Configuraciones
     */
    public static function setConfigurations(){
        $client = new AppConfigDataClient([
            'version' => 'latest',
            'region' => getEnt('app.aws.region')
        ]);

        $result = $client->getConfiguration([
            'Application' => getEnt('app.config.name'),
            'Environment' => getEnt('app.config.environment'),
            'Configuration' => getEnt('app.config.stage')
        ]);

        self::$configurations = json_decode($result['Content'], true);
    }
}