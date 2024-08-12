<?php

namespace App\Api;

class ConfigurationsApi extends IvoisApi {
    
    /**
    * Constructor de la clase
    */
    public function __construct() {
        parent::__construct(getEnt("ivois.api.taxpayers.url"));
    }
        
    /**
     * Obtener las configuraciones de un contribuyente.
    */
    public function get_configurations_by_taxpayer_id($taxpayer_id) {
        $configurations_url = $taxpayer_id . getEnt("ivois.api.configurations.url");
    
        return $this->makeGetRequestUrl($configurations_url);
    }

    /**
     * Actualizar las configuraciones de un contribuyente.
     */
    public function update_configurations_by_taxpayer_id($taxpayer_id, $configurations) {
        $configurations_url = $taxpayer_id . getEnt("ivois.api.configurations.url");
    
        return $this->makePutRequest($configurations, $configurations_url);
    }

    /**
     * Validar si la llave criptográfica es correcta.
     */
    public function validate_cryptographic_key($taxpayer_id, $cryptographic_key) {
        $cryptographic_key_url = $taxpayer_id . getEnt("ivois.api.configurations.url") . "/validate-cryptographic-key";
    
        return $this->makePostRequest($cryptographic_key, $cryptographic_key_url);
    }
}