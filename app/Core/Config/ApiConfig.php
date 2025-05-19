<?php

namespace Core\Config;

use Core\Aws\AwsSecretsService;

/**
 * Clase para manejar los servicios de AppConfig de AWS
 * @package Core\Aws
 * @subpackage AwsAppConfig
 * @version 1.0
 * @author jcampos
 */
class ApiConfig {

    /**
     * Configuraciones de AppConfig
     */
    private static $ivoisApiKey;

    /**
     * Obtiene un valor de AppConfig
     * @param string $key Llave del valor
     * @return string Valor de la llave
     */
    public static function getIvoisApiKey() {
        if (!isset(self::$ivoisApiKey)) {
            self::setIvoisApiKey();
        }

        return self::$ivoisApiKey;
    }

    /**
     * Obtiene todas las configuraciones de AppConfig
     * @return array Configuraciones
     */
    private static function setIvoisApiKey() {
        $api_key_info = AwsSecretsService::getSecret(getEnt('app.config.ivoisApikey'));

        $apiKey = $api_key_info['ApiKey'];

        self::$ivoisApiKey = $apiKey;
    }
}
