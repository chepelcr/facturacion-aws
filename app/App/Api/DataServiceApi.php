<?php

namespace App\Api;

use App\Enums\DataServiceEnum;

/**
 * Clase que contiene los métodos para obtener los datos de los servicios de la API de Ivois
 * @package App\Api
 * @version 1.0.0
 * @author jcampos
 * @subpackage DataServiceApi
 */
class DataServiceApi extends IvoisApi {

    /**
     * Obtener los tipos de identificación por país
     * @param string $countryCode Código del país
     * @return array Tipos de identificación
     */
    public function getIdentificationTypesByCountry($countryCode) {
        $url = getEnt("ivois.api.countries.url") . $countryCode . getEnt("ivois.api.identifications.url");

        return $this->makeGetRequestUrl($url);
    }

    /**
     * Obtener un tipo de identificación por país y el id
     * @param string $countryCode Código del país
     * @param int $id Id del tipo de identificación
     * @return object Tipo de identificación
     */
    public function getIdentificationTypeById($countryCode, $id) {
        $url = getEnt("ivois.api.countries.url") . $countryCode . getEnt("ivois.api.identifications.id.url") . $id;

        return $this->makeGetRequestUrl($url);
    }

    public function getIdentificationTypeByCode($countryCode, $code) {
        $url = getEnt("ivois.api.countries.url") . $countryCode . getEnt("ivois.api.identifications.code.url") . $code;

        return $this->makeGetRequestUrl($url);
    }

    /**
     * Obtener los tipos de pago por país
     * @param string $countryCode Código del país
     * @return array Tipos de pago
     */
    public function getPaymentTypesByCountry($countryCode) {
        $url = getEnt("ivois.api.countries.url") . $countryCode . getEnt("ivois.api.payments.url");

        return $this->makeGetRequestUrl($url);
    }

    /**
     * Obtener las unidades de medida
     * @return array
     */
    public function getMeasurementUnits() {
        $url = getEnt("ivois.api.measurementUnits.url");

        return $this->makeGetRequestUrl($url);
    }

    /**
     * Obtener los tipos de documentos por país
     * @param string $countryCode Código del país
     * @return array Tipos de documentos
     */
    public function getDocumentTypesByCountry($countryCode) {
        $url = getEnt("ivois.api.countries.url") . $countryCode . getEnt("ivois.api.documentTypes.all.url");

        return $this->makeGetRequestUrl($url);
    }

    /**
     * Obtener un tipo de documento por país y el id
     * @param string $countryCode Código del país
     * @param int $id Id del tipo de documento
     * @return object Tipo de documento
     */
    public function getDocumentTypeById($countryCode, $id) {
        $url = getEnt("ivois.api.countries.url") . $countryCode . getEnt("ivois.api.documentTypes.url") . $id;

        return $this->makeGetRequestUrl($url);
    }

    /**
     * Obtener los medios de pago para un país
     * @param string $countryCode Código del país
     * @return array Medios de pago
     */
    public function getPaymentMethodsByCountry($countryCode) {
        $url = getEnt("ivois.api.countries.url") . $countryCode . getEnt("ivois.api.paymentMethods.url");

        return $this->makeGetRequestUrl($url);
    }

    /**
     * Obtener los tipos de referencia por país
     * @param string $countryCode Código del país
     * @return array Tipos de referencia
     */
    public function getReferenceTypesByCountry($countryCode) {
        $url = getEnt("ivois.api.countries.url") . $countryCode . getEnt("ivois.api.references.url");

        return $this->makeGetRequestUrl($url);
    }

    /**
     * Obtener los codigos de referencia por país
     * @param string $countryCode Código del país
     * @return array Codigos de referencia
     */
    public function getReferenceCodesByCountry($countryCode) {
        $url = getEnt("ivois.api.countries.url") . $countryCode . getEnt("ivois.api.referenceCodes.url");

        return $this->makeGetRequestUrl($url);
    }

    /**
     * Obtener los tipos de impuestos por país
     * @param string $countryCode Código del país
     * @return array Tipos de impuestos
     */
    public function getTaxTypesByCountry($countryCode) {
        $url = getEnt("ivois.api.countries.url") . $countryCode . getEnt("ivois.api.taxTypes.url");

        return $this->makeGetRequestUrl($url);
    }

    /**
     * Obtener las tarifas de impuestos por país
     * @param string $countryCode Código del país
     * @return array Tarifas de impuestos
     */
    public function getTaxRatesByCountry($countryCode) {
        $url = getEnt("ivois.api.countries.url") . $countryCode . getEnt("ivois.api.taxRates.url");

        return $this->makeGetRequestUrl($url);
    }

    /**
     * Obtener los tipos de exoneración por país
     * @param string $countryCode Código del país
     * @return array Tipos de exoneración
     */
    public function getExonerationTypesByCountry($countryCode) {
        $url = getEnt("ivois.api.countries.url") . $countryCode . getEnt("ivois.api.exemptions.url");

        return $this->makeGetRequestUrl($url);
    }

    /**
     * Obtener los tipos de códigos de productos por país
     * @param string $countryCode Código del país
     * @return array Tipos de códigos de productos
     */
    public function getCodesByCountry($countryCode) {
        $url = getEnt("ivois.api.countries.url") . $countryCode . getEnt("ivois.api.codes.url");

        return $this->makeGetRequestUrl($url);
    }

    /**
     * Obtener los tipos de productos
     * @return array Tipos de productos
     */
    public function getProductTypes() {
        $url = getEnt("ivois.api.products.url");

        return $this->makeGetRequestUrl($url);
    }

    /**
     * Obtener las condiciones de venta por país
     * @param string $countryCode Código del país
     * @return array Condiciones de venta
     */
    public function getSaleConditionsByCountry($countryCode) {
        $url = getEnt("ivois.api.countries.url") . $countryCode . getEnt("ivois.api.saleConditions.url");

        return $this->makeGetRequestUrl($url);
    }

    /**
     * Obtener las versiones de documentos por país
     * @param string $countryCode Código del país
     * @return array Versiones de documentos
     */
    public function getDocumentVersionsByCountry($countryCode) {
        $url = getEnt("ivois.api.countries.url") . $countryCode . getEnt("ivois.api.documentVersions.url");

        return $this->makeGetRequestUrl($url);
    }

    public function getErrorName($error) {
        $error = DataServiceEnum::tryFrom($error);

        if ($error == null) {
            return 'Ha ocurrido un error al realizar la solicitud';
        } else {
            return $error->getName();
        }
    }
}
