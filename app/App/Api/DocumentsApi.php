<?php

namespace App\Api;

use App\Enums\DocumentsGeneratorEnum;

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
        parent::__construct(getEnt('ivois.api.taxpayers.url') . '2920eba1b03a7f13d518fd32d3819f11a4069c6fb559326e1847141bb804fa55' . getEnt('ivois.api.documents.url'), "http://172.18.0.5:8089");
    }

    /**
     * Obtener el nombre del error
     * 
     * @param string $error Código del error
     * @return string Nombre del error
     */
    public function getErrorName($error) {
        $error = DocumentsGeneratorEnum::tryFrom($error);

        if ($error == null) {
            return 'Ha ocurrido un error al realizar la solicitud';
        } else {
            return $error->getName();
        }
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
     * Obtener un documento por clave
     * 
     * @param string $clave Clave del documento
     * @return object Documento electrónico
     */
    public function getDocumentByKey($clave) {
        $url = "/$clave";
        return $this->makeGetRequestUrl($url);
    }

    /**
     * Obtener los documentos de un contribuyente con un filtro
     * 
     * @param string $filter Filtro de busqueda
     * @return array Lista de documentos electrónicos
     */
    public function getDocumentsByFilter($received, $documentType, $search="") {
        $url = "/all";
        //$hasFilter = false;

        if ($received) {
            $url = $url . "?received=true";
            //$hasFilter = true;
        } else {
            $url = $url . "?received=false";
        }
        
        $url = $url . "&documentTypes=$documentType&page=0&size=99999";

        if($search != "") {
            $url = $url . "&search=$search";
        }

        return $this->makeGetRequestUrl($url);
    }

    /**
     * Cargar un archivo XML en la plataforma
     */
    public function uploadDocument($data) {
        $url = "/upload-document";

        return $this->makePostRequest($data, $url);
    }

    /**
     * Cargar un archivo XML en la plataforma
     */
    public function uploadDocuments($data) {
        $url = "/upload-documents";

        return $this->makePostRequest($data, $url);
    }

    /**
     * Validar un documento electrónico
     *
     * @param array $data Datos del documento
     * @param string $documentKey Clave del documento
     * @return object Validación del documento
     */
    public function sendReceiverValidation($data, $documentKey) {
        //{documentKey}/validate-document
        $url = "/$documentKey/validate-document";

        return $this->makePatchRequest($data, $url);
    }
}
