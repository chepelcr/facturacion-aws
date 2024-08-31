<?php

namespace App\Services;

use App\Api\LocationsApi;
use App\Api\TaxpayersApi;

class TaxpayersService
{
    private $taxpayersApi;

    private $locationsApi;

    public function __construct()
    {
        $this->taxpayersApi = new TaxpayersApi();
        $this->locationsApi = new LocationsApi();

    }

    /**
     * Obtener la empresa del usuario que ha iniciado sesión para mostrarla en la vista.
     */
    public function getEmpresaData() {
        if (getSession('empresa')) {
            $empresa = json_decode(getSession('empresa'));
        } else {
            $empresa = $this->taxpayersApi->getTaxpayerById(getTaxpayerId());
        }
    
        $datos_personales = array(
            'businessName' => $empresa->businessName,
            'identification' => $empresa->identification,
            'nationality' => $empresa->nationality,
            'identificaciones' => array(
                (object) array(
                    'typeId' => $empresa->identification->typeId,
                    'description' => $empresa->identification->description
                ),
            ),
            'countries' => array(
                $empresa->nationality,
            ),
        );
    
        $countries = $this->locationsApi->get_countries();
    
        $datos_contacto = array(
            'personalPhone' => $empresa->personalPhone,
            'fax' => $empresa->fax ?? null,
            'businessPhone' => $empresa->businessPhone,
            'email' => $empresa->email,
            'countries' => $countries,
        );
    
        $residenceCountry = $empresa->residence->countryCode;
    
        $provincias = $this->locationsApi->get_states_by_iso_code($residenceCountry);
        $cantones = $this->locationsApi->get_counties_by_state_id_and_iso_code($empresa->residence->stateId, $residenceCountry);
        $distritos = $this->locationsApi->get_districts_by_county_id_and_state_id_and_iso_code($empresa->residence->countyId, $empresa->residence->stateId, $residenceCountry);
        $barrios = $this->locationsApi->get_neighborhoods_by_district_id_and_county_id_and_state_id_and_iso_code($empresa->residence->districtId, $empresa->residence->countyId, $empresa->residence->stateId, $residenceCountry);
    
        $dataProvincias = array(
            #'cod_provincia' => $empresa->residence->stateId,
            'countries' => $countries,
            'states' => $provincias,
            #'cod_canton' => $empresa->residence->countyId,
            #'canton' => $empresa->residence->countyName,
            'counties' => $cantones,
            #'cod_distrito' => $empresa->residence->districtId,
            #'distrito' => $empresa->residence->districtName,
            'districts' => $distritos,
            #'cod_barrio' => $empresa->residence->neighborhoodId,
            #'barrio' => $empresa->residence->neighborhoodName,
            'neighborhoods' => $barrios,
            'residence' => $empresa->residence
            #'otras_senas'=>$empresa->residence->address
        );
    
        $datos_empresa = array(
            'tradeName' => $empresa->tradeName,
        );
    
        $datos_empresa = array(
            'taxpayerId' => $empresa->taxpayerId,
            'datos_personales' => $datos_personales,
            'datos_contacto' => $datos_contacto,
            'dataProvincias' => $dataProvincias,
            'datos_empresa' => $datos_empresa,
            'activities' => $empresa->activities,
        );
    
        return $datos_empresa;
    } //Fin de la funcion para obtener la empresa del usuario que ha iniciado sesión
}