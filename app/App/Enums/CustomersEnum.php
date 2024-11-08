<?php

namespace App\Enums;

use Core\Errors\BaseEnum;
use Core\Errors\ApiError;

enum CustomersEnum: string {
    case ApiConsumerNotAvailable = "001";
    case CustomerNotFound = "002";
    case CustomerFound = "003";
    case TaxpayerNotFound = "004";
    case BadLocation = "005";
    case RemovedCustomer = "006";
    case CountryNotFound = "007";
    case TaxpayersApiNotAvailable = "008";
    case LocationsServiceNotAvailable = "009";
    case StatusNotFound = "010";
    case CustomerServiceError = "011";
    case CacheNotFound = "012";
    case InvalidPhoneNumber = "014";

    public function getName(): string {
        return match($this) {
            self::ApiConsumerNotAvailable => "El servicio de API-Consumer no se encuentra disponible",
            self::CustomerNotFound => "El cliente no se encuentra registrado",
            self::CustomerFound => "El cliente ya esta registrado",
            self::TaxpayerNotFound => "El contribuyente no se encuentra registrado",
            self::BadLocation => "La ubicación no es correcta",
            self::RemovedCustomer => "El cliente fue eliminado",
            self::CountryNotFound => "El código de pais no fue encontrado",
            self::TaxpayersApiNotAvailable => "El servicio de API-Taxpayer-Information no se encuentra disponible",
            self::LocationsServiceNotAvailable => "El servicio de ubicaciónes no se encuentra disponible.",
            self::StatusNotFound => "El estado solicitado no existe",
            self::CustomerServiceError => "Ha ocurrido un error en el servicio de clientes.",
            self::CacheNotFound => "No se ha encontrado la cache solicitada.",
            self::InvalidPhoneNumber => "El número de teléfono no es válido",
            default => "Ha ocurrido un error al realizar la solicitud"
        };
    }
}
