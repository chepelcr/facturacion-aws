<?php

namespace Core\Aws;

use Aws\S3\S3Client;

/**
 * Clase para manejar los servicios de S3 de AWS
 * @package Core\Aws
 * @subpackage AwsS3Service
 * @version 1.0
 * @author jcampos
 */
class AwsS3Service
{
    /**
     * Nombre del bucket
     */
    private $bucket;

    /**
     * Cliente de S3
     */
    private $client;

    public function __construct($bucket)
    {
        $this->bucket = $bucket;
        $this->client = new S3Client([
            'version' => 'latest',
            'region' => getEnt('app.aws.region'),
            'profile' => 'default'
        ]);
    }

    /**
     * Obtiene un archivo de S3
     * @param string $key Ruta del archivo
     * @return string Contenido del archivo en base64
     */
    public function getFile($key)
    {
        $client = $this->client;

        $result = $client->getObject([
            'Bucket' => $this->bucket,
            'Key' => $key
        ]);

        return base64_encode($result['Body']);
    }

    /**
     * Sube un archivo a S3
     * @param string $key Ruta del archivo
     * @param array $file Archivo a subir
     * @return bool Estado de la subida del archivo
     */
    public function putFile($file)
    {
        $client = $this->client;

        $key = $file['key'];
        $file = $file['data'];
        $contentType = $file['contentType'];
        $acl = $file['acl'];

        try {
            $client->putObject([
                'Bucket' => $this->bucket,
                'Key' => $key,
                'Body' => $file,
                'ContentType' => $contentType,
                'ACL' => $acl
            ]);

            return true;
        } catch (\Exception $e) {
            insertError($e->getMessage(), 'AWS S3 Service');
            return false;
        }
    }
}
