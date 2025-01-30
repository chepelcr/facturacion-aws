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
        parent::__construct(getEnt('ivois.api.taxpayers.url') . $taxpayerId . getEnt('ivois.api.documents.url')); //, "http://172.18.0.3:8089");
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
    public function getDocumentsByFilter($received, $documentType, $startDate, $endDate) {
        $url = "/all";
        $hasFilter = false;

        if ($received) {
            $url = $url . "?received=true";
            $hasFilter = true;
        }

        if ($documentType != null && $documentType != "all") {
            if ($hasFilter) {
                $url = $url . "&";
            } else {
                $url = $url . "?";
            }

            $url = $url . "documentType=$documentType";
            $hasFilter = true;
        }

        if ($startDate != null) {
            if ($hasFilter) {
                $url = $url . "&";
            } else {
                $url = $url . "?";
            }

            $startDate = date("Y-m-d 00:00:00", strtotime($startDate));

            //$url = $url."startDate=$startDate";
            $hasFilter = true;
        }

        if ($endDate != null) {
            if ($hasFilter) {
                $url = $url . "&";
            } else {
                $url = $url . "?";
            }

            $endDate = date("Y-m-d 23:59:59", strtotime($endDate));

            //$url = $url."endDate=$endDate";
            $hasFilter = true;
        }

        //var_dump($url);

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
