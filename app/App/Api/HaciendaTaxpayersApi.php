<?php

namespace App\Api;

use App\Enums\CategoriesEnum;

class HaciendaTaxpayersApi extends IvoisApi {
    /**
     * Constructor de la clase
     */
    public function __construct() {
        parent::__construct(getEnt("ivois.api.countries.url")); //, "http://172.18.0.3:8082");
    }

    /**
     * Obtiene el nombre del error para el modulo de productos
     */
    public function getErrorName($error) {
        $error = CategoriesEnum::tryFrom($error);

        if ($error == null) {
            return 'Ha ocurrido un error al realizar la solicitud';
        } else {
            return $error->getName();
        }
    }

    /**
     * Obtener un contribuyente por su id
     * 
     * @param string $country_code Código del país
     * @param string $taxpayerId Identificador del contribuyente
     * 
     * @return object Contribuyente
     */
    public function getTaxpayerByCountryCode($country_code, $taxpayerId) {
        $taxpayers_url = getEnt("ivois.api.haciendaTaxpayers.url");
        $url = $country_code . $taxpayers_url . $taxpayerId;

        return $this->makeGetRequestUrl($url);
    }
}
