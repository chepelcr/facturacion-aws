<?php

namespace App\Api;

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
     */
    public function __construct($base_url = "") {
        $url = getEnt("ivois.api.url");

        if($base_url) {
            $url = $url.$base_url;
        }

        parent::__construct($url, "application/json");
    }
}
