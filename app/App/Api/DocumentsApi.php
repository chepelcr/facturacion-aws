<?php

namespace App\Api;

/**
 * Api para la enviar documentos electrónicos al API de IVOIS
 * @version 1.0
 * @package App\Api
 * @subpackage DocumentsApi
 * @author jcampos
 */
class DocumentsApi extends IvoisApi {
    /**
     * Constructor de la clase
     * 
     * @param string $taxpayerId Identificación del contribuyente
     */
    public function __construct($taxpayerId) {
        parent::__construct(getEnt('ivois.api.taxpayers.url') . $taxpayerId . getEnt('ivois.api.documents.url'));
    }

    /**
     * Enviar documento electrónico para almacenar
     * 
     * @param array $data Datos del documento
     * @return object Documento en proceso
     */
    public function sendDocument($data) {
        return $this->makePostRequest($data);
    }

    /**
     * Reenviar notificación de un documento
     * @param string $documentId Identificador del documento
     * @return array Notificaciones enviadas
     */
    public function resendDocumentNotification($documentId) {
        $url = $documentId . '/notifications/resend';

        return $this->makeGetRequestUrl($url);
    }

    /**
     * Enviar notificación de un documento a un correo
     * @param string $documentId Identificador del documento
     * @param string $email Correo electrónico
     * @return array Notificaciones enviadas
     */
    public function sendDocumentNotification($documentId, $email) {
        $url = $documentId . '/notifications/send?email=' . $email;

        return $this->makeGetRequestUrl($url);
    }

    /**
     * Obtener un documento por clave
     * 
     * @param string $clave Clave del documento
     * @return object Documento electrónico
     */
    public function getDocumentByKey($clave) {
        return $this->makeGetRequestUrl($clave);
    }

    /**
     * Obtener los documentos de un contribuyente con un filtro
     * 
     * @param string $filter Filtro de busqueda
     * @return array Lista de documentos electrónicos
     */
    public function getDocumentsByFilter($filter = '') {
        if (empty($filter)) {
            return $this->makeGetRequestUrl('all');
        } else {
            return $this->makeGetRequestUrl('all?search=' . $filter);
        }
    }
}
