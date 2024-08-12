<?php
namespace App\Controllers;

use App\Api\LocationsApi;

/**
 * Clase controladora para la ubicacion
 */
class Ubicacion extends BaseController {
    private const ERROR_400 = "No se han enviado los parametros necesarios";

    /**Obtener todas las provincias */
    public function provincias() {
        if(isset($_GET['countryCode'])){
            $countryCode = $_GET['countryCode'];

            $locationsApi = new LocationsApi();
            $states = $locationsApi->get_states_by_iso_code($countryCode);
            
            return json_encode($states);
        } else {
            return $this->object_error(400, self::ERROR_400);
        }
    }//Fin de la funcion provincias

    /**Obtener los cantones para una provincia */
    public function cantones() {
        if(isset($_GET['countryCode']) && isset($_GET['stateId'])) {
            $countryCode = $_GET['countryCode'];
            $stateId = $_GET['stateId'];

            $locationsApi = new LocationsApi();
            $counties = $locationsApi->get_counties_by_state_id_and_iso_code($stateId, $countryCode);
            
            return json_encode($counties);
        } else {
            return $this->object_error(400, self::ERROR_400);
        }
    }//Fin de la funcion

    /**Obtener todos los distritos para un canton */
    public function distritos() {
        if(isset($_GET["countryCode"]) && isset($_GET["stateId"]) && isset($_GET["countyId"])){
            $countryCode = $_GET["countryCode"];
            $state = $_GET["stateId"];
            $county = $_GET["countyId"];

            $locationsApi = new LocationsApi();

            $districts = $locationsApi->get_districts_by_county_id_and_state_id_and_iso_code($county, $state, $countryCode);

            return json_encode($districts);
            
        } else {
            return $this->object_error(400, self::ERROR_400);
        }
    }//Fin de validacion

    /**Obtener todos los distritos para un canton */
    public function barrios() {
        if(isset($_GET["countryCode"]) && isset($_GET["stateId"]) && isset($_GET["countyId"]) && isset($_GET["districtId"])){
            $countryCode = $_GET["countryCode"];
            $state = $_GET["stateId"];
            $county = $_GET["countyId"];
            $district = $_GET["districtId"];

            $locationsApi = new LocationsApi();

            $neighborhoods = $locationsApi->get_neighborhoods_by_district_id_and_county_id_and_state_id_and_iso_code($district, $county, $state, $countryCode);

            return json_encode($neighborhoods);
            
        } else {
            return $this->object_error(400, self::ERROR_400);
        }
    }//Fin de la funcion
}//Fin de la clase
