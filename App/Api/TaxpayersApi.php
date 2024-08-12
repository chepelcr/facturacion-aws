<?php

namespace App\Api;

class TaxpayersApi extends IvoisApi {


    /**
     * Obtener un contribuyente por su nacionalidad y número de identificación
     */
    public function getTaxpayerByNationalityAndIdNumber($nationality, $idNumber) {
        $url = getEnt("ivois.api.countries.url").$nationality.getEnt("ivois.api.taxpayers.url").$idNumber;

        return $this->makeGetRequestUrl($url);
    }
    
    /**
     * Obtener un contribuyente por su id
     */
    public function getTaxpayerById($id) {
        $url = getEnt("ivois.api.taxpayers.url").$id;

        return $this->makeGetRequestUrl($url);
    }

    public function getAllTaxpayers() {
        $url = getEnt("ivois.api.taxpayers.url").'all';
        return $this->makeGetRequestUrl($url);
    }
}