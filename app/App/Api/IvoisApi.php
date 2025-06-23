<?php

namespace App\Api;

use Core\Config\ApiConfig;
use Core\RestApi;

/**
 * Clase abstacta para consumir el API REST de IVOIS
 * @package App\Api
 * @subpackage IvoisApi
 * @version 1.0
 * @author jcampos
 */
abstract class IvoisApi extends RestApi {

    /**
     * Constructor de la clase que recibe la url base de la API
     * @param $base_url Url base de la API
     * @param $errorEnum Enumeración de errores de la API
     */
    public function __construct($base_url = "", $ivoisUrl = "") {
        if ($ivoisUrl == "") {
            $ivoisUrl = getEnt("ivois.api.url");
        }

        if ($base_url) {
            $url = $ivoisUrl . $base_url;
        } else {
            $url = $ivoisUrl;
        }

        parent::__construct($url, "application/json");

        #$api_key = ApiConfig::getIvoisApiKey();

        #$this->setApiKey($api_key);
    }

    /**
     * Actualizar un cliente
     * @param $id Identificador del cliente
     * @param $data Datos a actualizar
     * @return object Datos actualizados
     */
    public function update($id, $data, $reinsert = false) {
        if ($reinsert) {
            $url = "/$id?reinsert=true";
        } else {
            $url = "/$id";
        }

        return $this->makePutRequest($data, $url);
    }
}
