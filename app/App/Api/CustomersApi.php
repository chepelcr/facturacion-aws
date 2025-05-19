<?php

namespace App\Api;

use App\Enums\CustomersEnum;

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
        parent::__construct(getEnt("ivois.api.taxpayers.url") . $taxpayerId . getEnt("ivois.api.customers.url")); //, "http://172.0.0.0:8085");
    }

    /**
     * Obtiene el nombre del error para el modulo de clientes
     */
    public function getErrorName($error) {
        $error = CustomersEnum::tryFrom($error);

        if ($error == null) {
            return 'Ha ocurrido un error al realizar la solicitud';
        } else {
            return $error->getName();
        }
    }

    /**
     * Obtiene un cliente por su id
     * @param $id Identificador del cliente
     * @return object Cliente
     */
    public function getCustomerById($id) {
        $url = "/$id";
        return $this->makeGetRequestUrl($url);
    }

    /**
     * Obtener todos los clientes de un contribuyente por su estado
     * @param $search Filtro de busqueda
     * @return array Lista de clientes
     */
    public function getCustomers($search = "") {
        try {
            $url = "/all";

            if ($search != null && $search != "") {
                $url = "$url?page=0&size=999999&search=$search";
            }

            return $this->makeGetRequestUrl($url);
        } catch (\Exception $e) {
            var_dump($e->getMessage());

            return null;
        }
    }

    /**
     * Cambiar el estado de un cliente
     * @param $id Identificador del cliente
     * @param $data Datos a actualizar
     * @return object Cliente actualizado
     */
    public function changeCustomerStatus($id, $data) {
        $url = "/$id";
        return $this->makePatchRequest($data, $url);
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
        $url = "/exists?nationality=$nationality&idNumber=$idNumber";

        return $this->makeGetRequestUrl($url);
    }
}
