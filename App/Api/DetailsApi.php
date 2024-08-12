<?php

namespace App\Api;

class DetailsApi extends IvoisApi {
    /**
     * @var string $taxpayerId Id del contribuyente
     */
    private $taxpayerId;

    /**
     * @var string $productsUrl Url de los detalles
     */
    private $productsUrl;

    /**
     * Constructor de la clase
     */
    public function __construct($taxpayerId) {
        parent::__construct(getEnt("ivois.api.taxpayers.url"));

        $this->productsUrl = getEnt("ivois.api.details.products.url");

        $this->taxpayerId = $taxpayerId;
    }

    /**
     * Obtiene un detalle por su id y el id del contribuyente
     */
    public function getProductById($id) {
        $url = $this->taxpayerId.$this->productsUrl.$id;

        return $this->makeGetRequestUrl($url);
    }

    /**
     * Obtiene todos los detalles de un contribuyente
     */
    public function getProductsByTaxpayerId() {
        $url = $this->taxpayerId.$this->productsUrl."all";

        return $this->makeGetRequestUrl($url);
    }

    /**
     * Obtiene todos los detalles de un contribuyente aplicando un filtro de busqueda
     */
    public function getProductsBySearchFilter($searchFilter) {
        $url = $this->taxpayerId.$this->productsUrl."all?search=".$searchFilter;

        return $this->makeGetRequestUrl($url);
    }

    /**
     * Almacena la información de un detalle
     */
    public function saveProduct($data) {
        $url = $this->taxpayerId.$this->productsUrl;

        return $this->makePostRequest($data, $url);
    }

    /**
     * Actualiza la información de un detalle
     */
    public function updateDetail($id, $data) {
        $url = $this->taxpayerId.$this->productsUrl.$id;

        return $this->makePutRequest($data, $url);
    }

    /**
     * Cambia el estado de un detalle
     */
    public function changeProductStatus($id, $data) {
        $url = $this->taxpayerId.$this->productsUrl.$id;

        return $this->makePatchRequest($data, $url);
    }
}
