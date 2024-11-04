<?php

namespace App\Services;

use App\Api\CategoriesApi;
use App\Api\HaciendaTaxpayersApi;

class DataService {
    private $categoriesApi;

    private $taxpayersApi;

    public function __construct() {
        $this->categoriesApi = new CategoriesApi();

        $this->taxpayersApi = new HaciendaTaxpayersApi();
    }

    /**
     * Obtener los códigos CABYS por nombre o código
     * 
     * @param string $search Nombre o código de la categoría
     * @param string $productType Tipo de producto
     */
    public function getCabysByCodeOrName($search, $productType) {
        return $this->categoriesApi->searchCategoriesByCountryCode(getCountryCode(), $search, $productType);
    }

    /**
     * Obtener un contribuyente por su id
     * 
     * @param string $country_code Código del país
     * @param string $taxpayerId Identificador del contribuyente
     */
    public function getTaxpayerByCountryCode($country_code, $taxpayerId) {
        return $this->taxpayersApi->getTaxpayerByCountryCode($country_code, $taxpayerId);
    }
}
