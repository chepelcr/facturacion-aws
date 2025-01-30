<?php

namespace App\Api;

use App\Enums\ValidationsEnum;

/**
 * Api para la enviar documentos electrónicos al API de IVOIS
 * @version 1.0
 * @package App\Api
 * @subpackage DocumentsApi
 * @author jcampos
 */
class ValidationsApi extends IvoisApi {
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
        $error = ValidationsEnum::tryFrom($error);

        if ($error == null) {
            return 'Ha ocurrido un error al realizar la solicitud';
        } else {
            return $error->getName();
        }
    }

    /**
     * Obtener la validación de un documento electrónico
     * 
     * @param string $documentId Identificador del documento
     * @return object Validación del documento
     */
    public function getDocumentValidation($documentId) {
        ///taxpayers/{taxpayerId}/documents/{documentKey}/invoice-validation
        $url = "/$documentId/invoice-validation";

        return $this->makeGetRequestUrl($url);
    }
}
