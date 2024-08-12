<?php

namespace App\Api;

class CustomersApi extends IvoisApi {

    public function __construct($taxpayerId) {
        parent::__construct(getEnt("ivois.api.taxpayers.url").$taxpayerId.getEnt("ivois.api.customers.url"));
    }

    /**
     * Obtiene un cliente por su id
     */
    public function getCustomerById($id) {
        return $this->makeGetRequestUrl($id);
    }

    /**
     * Obtener todos los clientes de un contribuyente
     */
    public function getCustomersByTaxpayerId() {
        return $this->makeGetRequestUrl('all');

    }

    /**
     * Obtener todos los clientes extranjeros de un contribuyente
     */
    public function getForeignCustomersByTaxpayerId() {
        return $this->makeGetRequestUrl('national?foreign=true');
    }

    /**
     * Obtener todos los clientes nacionales de un contribuyente
     */
    public function getNationalCustomersByTaxpayerId() {
        return $this->makeGetRequestUrl('national?national=true');
    }

    /**
     * Obtener todos los clientes de un contribuyente por su estado
     */
    public function getCustomersByStatus($status) {
        $url = "all?status=$status";

        return $this->makeGetRequestUrl($url);
    }

    /**
     * Cambiar el estado de un cliente
     */
    public function changeCustomerStatus($id, $data) {
        return $this->makePatchRequest($data, $id);
    }

    /**
     * Actualizar un cliente
     */
    public function updateCustomer($id, $data) {
        return $this->makePutRequest($data, $id);
    }

    /**
     * Almacenar un cliente
     */
    public function saveCustomer($data) {
        return $this->makePostRequest($data);
    }

    public function getCustomerByNationalityAndIdNumber($nationality, $idNumber) {
        $url = "exists?nationality=$nationality&idNumber=$idNumber";

        return $this->makeGetRequestUrl($url);
    }
}
