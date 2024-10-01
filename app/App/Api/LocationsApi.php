<?php

namespace App\Api;

/**
 * Clase para consumir el API de ubicaciones de IVOIS
 * @author jcampos
 * @version 1.0
 * @package App\Api
 * @subpackage LocationsApi
 */
class LocationsApi extends IvoisApi {

    const STATES_URL = "/states/";

    const COUNTIES_URL = "/counties/";

    const DISTRICTS_URL = "/districts/";

    const NEIGHBORHOODS_URL = "/neighborhoods/";


    /**
     * Constructor de la clase
     */
    public function __construct() {
        parent::__construct(getEnt("ivois.api.countries.url"));
    }

    /**
     * Obtener los paises desde la API de IVOIS
     * @return array
     */
    public function get_countries() {
        $countries_url = getEnt("ivois.api.url.all");

        return $this->makeGetRequestUrl($countries_url);
    }

    /**
     * Obtener las provincias de un país.
     * @param string $iso_code Código del país
     * @return array
     */
    public function get_states_by_iso_code($iso_code) {

        $states_url = $iso_code . self::STATES_URL;

        return $this->makeGetRequestUrl($states_url);
    }

    /**
     * Obtener los cantones de una provincia por su id y el pais.
     * @param int $state_id Id de la provincia
     * @param string $iso_code Código del país
     * @return array
     */
    public function get_counties_by_state_id_and_iso_code($state_id, $iso_code) {
        $states_url = $iso_code . self::STATES_URL . $state_id . self::COUNTIES_URL;

        return $this->makeGetRequestUrl($states_url);
    }

    /**
     * Obtener las obtener los distritos de un canton por provincia, canton y pais.
     * @param int $county_id Id del canton
     * @param int $state_id Id de la provincia
     * @param string $iso_code Código del país
     * @return array
     */
    public function get_districts_by_county_id_and_state_id_and_iso_code($county_id, $state_id, $iso_code) {
        $states_url = $iso_code . self::STATES_URL . $state_id . self::COUNTIES_URL . $county_id . self::DISTRICTS_URL;

        return $this->makeGetRequestUrl($states_url);
    }

    /**
     * Obtener las obtener los barrios de un distrito por provincia, canton, distrito y pais.
     * @param int $district_id Id del distrito
     * @param int $county_id Id del canton
     * @param int $state_id Id de la provincia
     * @param string $iso_code Código del país
     * @return array
     */
    public function get_neighborhoods_by_district_id_and_county_id_and_state_id_and_iso_code($district_id, $county_id, $state_id, $iso_code) {
        $states_url = $iso_code . self::STATES_URL . $state_id . self::COUNTIES_URL . $county_id . self::DISTRICTS_URL . $district_id . self::NEIGHBORHOODS_URL;

        return $this->makeGetRequestUrl($states_url);
    }
}
