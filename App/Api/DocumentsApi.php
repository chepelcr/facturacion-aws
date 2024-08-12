<?php

namespace App\Api;

/**
 * Api para la enviar documentos electrónicos
 */
class DocumentsApi extends IvoisApi
{
    /**
     * Constructor de la clase
     * 
     * @param string $taxpayerId Identificación del contribuyente
     */
    public function __construct($taxpayerId)
    {
        parent::__construct(getEnt('ivois.api.taxpayers.url') . $taxpayerId . getEnt('ivois.api.documents.url'));
    }

    /**
     * Enviar documento
     * 
     * @param array $data Datos del documento
     * 
     * @return object
     */
    public function sendDocument($data)
    {
        return $this->makePostRequest($data);
    }

    public function resendDocumentNotification($documentId){
        $url = $documentId . '/notifications/resend';

        return $this->makeGetRequestUrl($url);
    }

    public function sendDocumentNotification($documentId, $email){
        $url = $documentId . '/notifications/send?email=' . $email;

        return $this->makeGetRequestUrl($url);
    }

    /**
     * Obtener un documento por clave
     * 
     * @param string $clave Clave del documento
     * 
     * @return object
     */
    public function getDocumentByKey($clave)
    {
        return $this->makeGetRequestUrl($clave);
    }

    /**
     * Obtener los documentos de un contribuyente con un filtro
     * 
     * @param string $filter Filtro de busqueda
     * 
     * @return object
     */
    public function getDocumentsByFilter($filter = '')
    {
        if (empty($filter)) {
            return $this->makeGetRequestUrl('all');
        } else {
            return $this->makeGetRequestUrl('all?search=' . $filter);
        }
    }
}
