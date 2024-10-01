<?php

namespace App\Api;

use App\Enums\CategoriesEnum;

class CategoriesApi extends IvoisApi {
    /**
     * Constructor de la clase
     */
    public function __construct() {
        parent::__construct(getEnt("ivois.api.countries.url"));
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
     * Obtener las categorias de un país por nombre
     * 
     * @param string $country_code Código del país
     * @param string $name Nombre de la categoría
     * 
     * @return array Lista de categorias
     */
    public function getCategoriesByCountryCodeAndName($country_code, $name) {
        $categories_url = getEnt("ivois.api.categories.url");
        $url = $country_code . $categories_url . "all?name=" . $name;

        return $this->makeGetRequestUrl($url);
    }

    /**
     * Obtener las categorias de un país por código
     * @param string $country_code Código del país
     * @param string $code Código de la categoría
     * @return array Lista de categorias
     */
    public function getCategoriesByCountryCodeAndCode($country_code, $code) {
        $categories_url = getEnt("ivois.api.categories.url");
        $url = $country_code . $categories_url . "all?code=" . $code;

        return $this->makeGetRequestUrl($url);
    }
}
