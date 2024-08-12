<?php

namespace App\Api;

/**
 * Clase que contiene los métodos para obtener los datos de los servicios de la API de Ivois
 * @package App\Api
 * @version 1.0.0
 * @author jcampos <jcampos@interfaz.io>
 */
class DataServiceApi extends IvoisApi {

    /**
     * Obtener los tipos de identificación por país
     * @param string $countryCode Código del país
     */
    public function getIdentificationTypesByCountry($countryCode){
        $url = getEnt("ivois.api.countries.url").$countryCode.getEnt("ivois.api.identifications.url");

        return $this->makeGetRequestUrl($url);
    }

    public function getPaymentTypesByCountry($countryCode){
        $url = getEnt("ivois.api.countries.url").$countryCode.getEnt("ivois.api.payments.url");

        return $this->makeGetRequestUrl($url);
    }

    /**
     * Obtener las unidades de medida
     * @return array
     */
    public function getMeasurementUnits(){
        $url = getEnt("ivois.api.measurementUnits.url");

        return $this->makeGetRequestUrl($url);
    }

    /**
     * Obtener los tipos de documentos por país
     * @param string $countryCode Código del país
     * @return array
     */
    public function getDocumentTypesByCountry($countryCode){
        $url = getEnt("ivois.api.countries.url").$countryCode.getEnt("ivois.api.documentTypes.all.url");

//        var_dump($url);
        return $this->makeGetRequestUrl($url);
    }

    /**
     * Obtener un tipo de documento por país y el id
     * @param string $countryCode Código del país
     * @param int $id Id del tipo de documento
     * @return object
     */
    public function getDocumentTypeById($countryCode, $id){
        $url = getEnt("ivois.api.countries.url").$countryCode.getEnt("ivois.api.documentTypes.url").$id;

        return $this->makeGetRequestUrl($url);
    }

    /**
     * Obtener los medios de pago para un país
     * @param string $countryCode Código del país
     * @return array
     */
    public function getPaymentMethodsByCountry($countryCode){
        $url = getEnt("ivois.api.countries.url").$countryCode.getEnt("ivois.api.paymentMethods.url");

        return $this->makeGetRequestUrl($url);
    }

    /**
     * Obtener los tipos de referencia por país
     * @param string $countryCode Código del país
     * @return array
     */
    public function getReferenceTypesByCountry($countryCode){
        $url = getEnt("ivois.api.countries.url").$countryCode.getEnt("ivois.api.references.url");

        return $this->makeGetRequestUrl($url);
    }

    /**
     * Obtener los codigos de referencia por país
     * @param string $countryCode Código del país
     * @return array
     */
    public function getReferenceCodesByCountry($countryCode){
        $url = getEnt("ivois.api.countries.url").$countryCode.getEnt("ivois.api.referenceCodes.url");

        return $this->makeGetRequestUrl($url);
    }

    /**
     * Obtener los tipos de impuestos por país
     * @param string $countryCode Código del país
     * @return array
     */
    public function getTaxTypesByCountry($countryCode){
        $url = getEnt("ivois.api.countries.url").$countryCode.getEnt("ivois.api.taxTypes.url");

        return $this->makeGetRequestUrl($url);
    }

    /**
     * Obtener las tarifas de impuestos por país
     * @param string $countryCode Código del país
     * @return array
     */
    public function getTaxRatesByCountry($countryCode){
        $url = getEnt("ivois.api.countries.url").$countryCode.getEnt("ivois.api.taxRates.url");

        return $this->makeGetRequestUrl($url);
    }

    /**
     * Obtener los tipos de exoneración por país
     * @param string $countryCode Código del país
     * @return array
     */
    public function getExonerationTypesByCountry($countryCode){
        $url = getEnt("ivois.api.countries.url").$countryCode.getEnt("ivois.api.exemptions.url");

        return $this->makeGetRequestUrl($url);
    }

    /**
     * Obtener los tipos de códigos de productos por país
     * @param string $countryCode Código del país
     * @return array
     */
    public function getCodesByCountry($countryCode){
        $url = getEnt("ivois.api.countries.url").$countryCode.getEnt("ivois.api.codes.url");

        return $this->makeGetRequestUrl($url);
    }

    /**
     * Obtener los tipos de productos
     * @return array
     */
    public function getProductTypes(){
        $url = getEnt("ivois.api.products.url");

        return $this->makeGetRequestUrl($url);
    }

    /**
     * Obtener las condiciones de venta por país
     * @param string $countryCode Código del país
     * @return array
     */
    public function getSaleConditionsByCountry($countryCode){
        $url = getEnt("ivois.api.countries.url").$countryCode.getEnt("ivois.api.saleConditions.url");

        return $this->makeGetRequestUrl($url);
    }

    /**
     * Obtener las versiones de documentos por país
     * @param string $countryCode Código del país
     * @return array
     */
    public function getDocumentVersionsByCountry($countryCode){
        $url = getEnt("ivois.api.countries.url").$countryCode.getEnt("ivois.api.documentVersions.url");

        return $this->makeGetRequestUrl($url);
    }
}
