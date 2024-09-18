<?php

namespace App\Services;

use App\Api\CategoriesApi;

class DataService {
    private $categoriesApi;

    public function __construct() {
        $this->categoriesApi = new CategoriesApi();
    }

    /**
     * Obtener los códigos CABYS por nombre o código
     */
    public function getCabysByCodeOrName($search) {

        //Validar si el parametro de busqueda es un código numérico
        if (is_numeric($search)) {
            $data = $this->categoriesApi->getCategoriesByCountryCodeAndCode(getCountryCode(), $search);
        } else {
            $data = $this->categoriesApi->getCategoriesByCountryCodeAndName(getCountryCode(), $search);
        }

        return $data;
    }
}
