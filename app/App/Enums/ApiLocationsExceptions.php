<?php

namespace App\Enums;

/**
 * Enumeración de excepciones de la API de ubicaciones
 * 
 * @package App\Enums
 * @subpackage ApiLocationsExceptions
 * @version 1.0
 * @author jcampos
 */
enum ApiLocationsExceptions: string {

    case SUCCESS = "000";
    case COUNTRY_FOUND = "001";
    case COUNTRY_NOT_FOUND = "002";
    case PROVINCE_NOT_FOUND = "003";
    case CANTON_NOT_FOUND = "004";
    case DISTRICT_NOT_FOUND = "005";
    case NEIGHBORHOOD_NOT_FOUND = "006";
    case CACHE_NOT_FOUND = "007";
    case STATUS_NOT_FOUND = "008";
    case AWS_APP_CONFIG_ERROR = "009";
    case LOCATION_FOUND = "010";
    case COUNTRY_REQUEST_ERROR = "011";
    case LOCATION_NOT_FOUND = "012";

    /**
     * Obtener el nombre de la excepción
     */
    public function getName(): string {
        return match ($this) {
            self::SUCCESS => "Success",
            self::COUNTRY_FOUND => "El código de pais ya se encuentra previamente registrado",
            self::COUNTRY_NOT_FOUND => "El código de pais no se encuentra registrado",
            self::PROVINCE_NOT_FOUND => "El código de provincia no se encuentra registrado",
            self::CANTON_NOT_FOUND => "El código de canton no se encuentra registrado",
            self::DISTRICT_NOT_FOUND => "El código de distrito no se encuentra registrado",
            self::NEIGHBORHOOD_NOT_FOUND => "El código de barrio no se encuentra registrado",
            self::CACHE_NOT_FOUND => "La cache no es valida",
            self::STATUS_NOT_FOUND => "El estado no se encuentra registrado",
            self::AWS_APP_CONFIG_ERROR => "Error al obtener las configuraciones de la aplicación",
            self::LOCATION_FOUND => "La ubicación ya se encuentra registrada",
            self::COUNTRY_REQUEST_ERROR => "Error en la solicitud de países",
            self::LOCATION_NOT_FOUND => "La ubicación no se encuentra registrada",
            default => "Error desconocido",
        };
    }
}
