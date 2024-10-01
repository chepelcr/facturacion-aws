<?php

namespace App\Api;

use App\Enums\TaxpayersEnum;

/**
 * Clase para consumir el API de contribuyentes de IVOIS
 * @author jcampos
 * @version 1.0
 * @package App\Api
 * @subpackage TaxpayersApi
 */
class TaxpayersApi extends IvoisApi {

    /**
     * Obtener el nombre del error para el modulo de contribuyentes
     * @param $error Código del error
     */
    public function getErrorName($error) {
        $error = TaxpayersEnum::tryFrom($error);

        if ($error == null) {
            return 'Ha ocurrido un error al realizar la solicitud';
        } else {
            return $error->getName();
        }
    }

    /**
     * Obtener un contribuyente por su nacionalidad y número de identificación
     */
    public function getTaxpayerByNationalityAndIdNumber($nationality, $idNumber) {
        $url = getEnt("ivois.api.countries.url") . $nationality . getEnt("ivois.api.taxpayers.url") . $idNumber;

        return $this->makeGetRequestUrl($url);
    }

    /**
     * Obtener un contribuyente por su id
     */
    public function getTaxpayerById($id) {
        $url = getEnt("ivois.api.taxpayers.url") . $id;

        return $this->makeGetRequestUrl($url);
    }

    public function getAllTaxpayers() {
        $url = getEnt("ivois.api.taxpayers.url") . 'all';
        return $this->makeGetRequestUrl($url);
    }
}
