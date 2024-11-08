<?php

namespace App\Enums;

/**
 * Enumeración de errores de los contribuyentes de Hacienda
 * @package App\Enums
 * @subpackage HaciendaTaxpayersEnum
 * @version 1.0
 * @author jcampos
 */
enum HaciendaTaxpayersEnum: string {
    case Success = "000";
    case Failed = "100";
    case HaciendaNotAvailable = "001";
    case TaxpayerNotFound = "002";
    case TaxpayerFormat = "003";
    case TaxpayerFound = "004";
    case DataServiceNotAvailable = "005";
    case RegimeNotFound = "006";
    case BadLocation = "007";
    case LocationsServiceNotAvailable = "008";
    case CountryNotFound = "009";
    case IdTypeNotFound = "010";
    case InvalidIdNumber = "011";


    public function getName(): string {
        return match ($this) {
            self::Success => "Operación completada con éxito",
            self::Failed => "La operación fallo",
            self::HaciendaNotAvailable => "El servicio del Ministerio de Hacienda no se encuentra disponible",
            self::TaxpayerNotFound => "El contribuyente no se encuentra registrado",
            self::TaxpayerFormat => "El numero de identificación debe tener mínimo 9 dígitos",
            self::TaxpayerFound => "El contribuyente ya se encuentra registrado",
            self::DataServiceNotAvailable => "El servicio de tablas de información no se encuentra disponible",
            self::RegimeNotFound => "El regimen no se encuentra registrado",
            self::BadLocation => "La ubicación no es correcta",
            self::LocationsServiceNotAvailable => "No se encuentra disponible el servicio de aplicaciones.",
            self::CountryNotFound => "El código de pais no fue encontrado",
            self::IdTypeNotFound => "No se encuentra el tipo de identificación",
            self::InvalidIdNumber => "El número de identificación no es válido",
            default => "Ha ocurrido un error al realizar la solicitud",
        };
    }
}
