<?php

namespace App\Enums;

/**
 * Enumeración de categorías de errores
 */
enum CategoriesEnum: string {
    case Success = "000";
    case Failed = "100";
    case HaciendaNotAvailable = "001";
    case CabysNotFound = "002";
    case NotValidCabys = "003";
    case CountryNotFound = "004";
    case DataServiceNotAvailable = "005";
    case InvalidCountry = "006";
    case InvalidCabys = "007";
    case DeletedCabys = "008";
    case LambdaNotAvailable = "009";

    public function getName(): string {
        return match ($this) {
            self::Success => "Operación completada con éxito",
            self::Failed => "La operación fallo",
            self::HaciendaNotAvailable => "El servicio del Ministerio de Hacienda no se encuentra disponible",
            self::CabysNotFound => "No se encuentran resultados disponibles",
            self::NotValidCabys => "El código CABYS no es valido.",
            self::CountryNotFound => "El código de país no es valido.",
            self::DataServiceNotAvailable => "El servicio de Common-Data-Services no se encuentra disponible",
            self::InvalidCountry => "El país indicado no coincide.",
            self::InvalidCabys => "El código indicado no es válido",
            self::DeletedCabys => "El código CABYS ha sido eliminado",
            self::LambdaNotAvailable => "El servicio de Lambda no se encuentra disponible",
        };
    }
}