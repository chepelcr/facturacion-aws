<?php

namespace Core\Aws;

use Aws\SecretsManager\SecretsManagerClient;

/**
 * Clase para manejar los secretos de AWS
 * @package Core\Aws
 * @subpackage AwsSecretsService
 * @version 1.0
 * @author jcampos
 */
class AwsSecretsService
{
    /**
     * Obtiene un secreto de AWS
     * @param string $secretName Nombre del secreto
     * @return array Secretos
     */
    public static function getSecret($secretName)
    {
        $client = new SecretsManagerClient([
            'version' => 'latest',
            'region' => 'us-east-1'
        ]);

        $result = $client->getSecretValue([
            'SecretId' => $secretName,
        ]);

        return json_decode($result['SecretString'], true);
    }
}
