<?php

namespace App\Api;

use Core\RestApi;
use Core\Auditorias\Auditorias;

abstract class IvoisApi extends RestApi {

    /**
     * Constructor de la clase que recibe la url base de la API
     */
    public function __construct($base_url = "") {
        $url = getEnt("ivois.api.url");

        if($base_url) {
            $url = $url.$base_url;
        }

        parent::__construct($url, "application/json");
    }
}
