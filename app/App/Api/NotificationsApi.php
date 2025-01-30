<?php

namespace App\Api;

use App\Enums\NotificationsEnum;

/**
 * Api para la enviar documentos electrónicos al API de IVOIS
 * @version 1.0
 * @package App\Api
 * @subpackage NotificationsApi
 * @author jcampos
 */
class NotificationsApi extends IvoisApi {
    /**
     * Constructor de la clase
     * 
     * @param string $taxpayerId Identificación del contribuyente
     */
    public function __construct($taxpayerId) {
        parent::__construct(getEnt('ivois.api.taxpayers.url') . $taxpayerId . getEnt('ivois.api.documents.url')); //, "http://172.18.0.3:8089");
    }

    /**
     * Obtener el nombre del error
     * 
     * @param string $error Código del error
     * @return string Nombre del error
     */
    public function getErrorName($error) {
        $error = NotificationsEnum::tryFrom($error);

        if ($error == null) {
            return 'Ha ocurrido un error al realizar la solicitud';
        } else {
            return $error->getName();
        }
    }

    /**
     * Reenviar notificación de un documento
     * @param string $documentId Identificador del documento
     * @return array Notificaciones enviadas
     */
    public function resendDocumentNotification($documentId) {
        $url = "/$documentId/notifications/resend";

        return $this->makeGetRequestUrl($url);
    }

    /**
     * Enviar notificación de un documento a un correo
     * @param string $documentId Identificador del documento
     * @param string $email Correo electrónico
     * @return array Notificaciones enviadas
     */
    public function sendDocumentNotification($documentId, $email) {
        $url = "/$documentId/notifications/send?email=$email";

        return $this->makeGetRequestUrl($url);
    }
}
