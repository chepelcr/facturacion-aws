<?php

namespace App\Api;

/**
 * Clase para consumir el API de clientes de IVOIS
 * @author jcampos
 * @version 1.0
 * @package App\Api
 * @subpackage CustomersApi
 */
class CustomersApi extends IvoisApi {

    /**
     * Constructor de la clase que recibe el id del contribuyente
     * @param $taxpayerId Identificador del contribuyente
     */
    public function __construct($taxpayerId) {
        parent::__construct(getEnt("ivois.api.taxpayers.url").$taxpayerId.getEnt("ivois.api.customers.url"));
    }

    /**
     * Obtiene un cliente por su id
     * @param $id Identificador del cliente
     * @return object Cliente
     */
    public function getCustomerById($id) {
        return $this->makeGetRequestUrl($id);
    }

    /**
     * Obtener todos los clientes de un contribuyente
     * @return array Lista de clientes
     */
    public function getCustomersByTaxpayerId() {
        return $this->makeGetRequestUrl('all');

    }

    /**
     * Obtener todos los clientes extranjeros de un contribuyente
     * @return array Lista de clientes extranjeros
     */
    public function getForeignCustomersByTaxpayerId() {
        return $this->makeGetRequestUrl('national?foreign=true');
    }

    /**
     * Obtener todos los clientes nacionales de un contribuyente
     * @return array Lista de clientes nacionales
     */
    public function getNationalCustomersByTaxpayerId() {
        return $this->makeGetRequestUrl('national?national=true');
    }

    /**
     * Obtener todos los clientes de un contribuyente por su estado
     * @param $status Estado del cliente
     * @return array Lista de clientes
     */
    public function getCustomersByStatus($status) {
        $url = "all?status=$status";

        return $this->makeGetRequestUrl($url);
    }

    /**
     * Cambiar el estado de un cliente
     * @param $id Identificador del cliente
     * @param $data Datos a actualizar
     * @return object Cliente actualizado
     */
    public function changeCustomerStatus($id, $data) {
        return $this->makePatchRequest($data, $id);
    }

    /**
     * Actualizar un cliente
     * @param $id Identificador del cliente
     * @param $data Datos a actualizar
     * @return object Cliente actualizado
     */
    public function updateCustomer($id, $data) {
        return $this->makePutRequest($data, $id);
    }

    /**
     * Almacenar un cliente en la aplicación
     * @param $data Datos del cliente
     * @return object Cliente almacenado
     */
    public function saveCustomer($data) {
        return $this->makePostRequest($data);
    }

    /**
     * Obtener un cliente por su nacionalidad y número de identificación
     * @param $nationality Nacionalidad del cliente
     * @param $idNumber Número de identificación del cliente
     * @return object Cliente
     */
    public function getCustomerByNationalityAndIdNumber($nationality, $idNumber) {
        $url = "exists?nationality=$nationality&idNumber=$idNumber";

        return $this->makeGetRequestUrl($url);
    }
}
