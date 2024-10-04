<?php

namespace App\Api;

use App\Enums\ApiLocationsExceptions;

/**
 * Clase para consumir el API de ubicaciones de IVOIS
 * @author jcampos
 * @version 1.0
 * @package App\Api
 * @subpackage LocationsApi
 */
class LocationsApi extends IvoisApi {

    /**
     * URL de las provincias
     */
    private $statesUrl;

    /**
     * Url de los cantones
     */
    private $countiesUrl;

    /**
     * Url de los distritos
     */
    private $districtsUrl;

    /**
     * Url de los barrios
     */
    private $neighborhoodsUrl;


    public function __construct() {
        parent::__construct(getEnt("ivois.api.countries.url"));

        $this->statesUrl = getEnt("ivois.api.countries.states.url");
        $this->countiesUrl = getEnt("ivois.api.countries.counties.url");
        $this->districtsUrl = getEnt("ivois.api.countries.districts.url");
        $this->neighborhoodsUrl = getEnt("ivois.api.countries.neighborhoods.url");
    }

    /**
     * Obtener el nombre del error
     * @param string $error Código del error
     * @return string Nombre del error
     */
    public function getErrorName($error)
    {
        $error = ApiLocationsExceptions::tryFrom($error);

        if ($error == null) {
            return 'Ha ocurrido un error al realizar la solicitud';
        } else {
            return $error->getName();
        }
    }

    /**
     * Obtener los paises desde la API de IVOIS
     * @return array
     */
    public function get_countries($status = 0) {
        $countries_url = getEnt("ivois.api.url.all");

        if ($status > 0) {
            $countries_url .= getEnt("ivois.api.countries.status.url") . $status;
        }

        return $this->makeGetRequestUrl($countries_url);
    }

    /**
     * Obtener las provincias de un país.
     * @param string $iso_code Código del país
     * @return array
     */
    public function get_states_by_iso_code($iso_code) {

        $states_url = $iso_code . $this->statesUrl;

        return $this->makeGetRequestUrl($states_url);
    }

    /**
     * Obtener los cantones de una provincia por su id y el pais.
     * @param int $state_id Id de la provincia
     * @param string $iso_code Código del país
     * @return array
     */
    public function get_counties_by_state_id_and_iso_code($state_id, $iso_code) {
        $states_url = $iso_code . $this->statesUrl . $state_id . $this->countiesUrl;

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
        $states_url = $iso_code . $this->statesUrl . $state_id . $this->countiesUrl . $county_id . $this->districtsUrl;

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
        $states_url = $iso_code . $this->statesUrl . $state_id . $this->countiesUrl . $county_id . $this->districtsUrl . $district_id . $this->neighborhoodsUrl;

        return $this->makeGetRequestUrl($states_url);
    }
}
