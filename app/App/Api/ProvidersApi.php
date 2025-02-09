<?php

namespace App\Api;

use App\Enums\ProvidersEnum;

/**
 * Clase para consumir el API de clientes de IVOIS
 * @author jcampos
 * @version 1.0
 * @package App\Api
 * @subpackage ProvidersApi
 */
class ProvidersApi extends IvoisApi {

    /**
     * Constructor de la clase que recibe el id del contribuyente
     * @param $taxpayerId Identificador del contribuyente
     */
    public function __construct($taxpayerId) {
        parent::__construct(getEnt("ivois.api.taxpayers.url") . $taxpayerId . getEnt("ivois.api.providers.url")); //, "http://172.0.0.0:8085");
    }

    /**
     * Obtiene el nombre del error para el modulo de clientes
     */
    public function getErrorName($error) {
        $error = ProvidersEnum::tryFrom($error);

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
    public function getProviderById($id) {
        $url = "/$id";
        return $this->makeGetRequestUrl($url);
    }

    /**
     * Obtener todos los clientes de un contribuyente por su estado
     * @param $search Filtro de busqueda
     * @return array Lista de clientes
     */
    public function getProviders($search = "") {
        $url = "/all";

        if($search != null && $search != "") {
            $url = "$url?search=$search";
        }

        return $this->makeGetRequestUrl($url);
    }

    /**
     * Cambiar el estado de un cliente
     * @param $id Identificador del cliente
     * @param $data Datos a actualizar
     * @return object Cliente actualizado
     */
    public function changeProviderStatus($id, $data) {
        $url = "/$id";
        return $this->makePatchRequest($data, $url);
    }



    /**
     * Almacenar un cliente en la aplicación
     * @param $data Datos del cliente
     * @return object Cliente almacenado
     */
    public function saveProvider($data) {
        return $this->makePostRequest($data);
    }
}
