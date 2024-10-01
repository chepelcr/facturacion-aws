<?php

namespace App\Enums;

use Core\Errors\BaseEnum;
use Core\Errors\ApiError;

enum CustomersEnum: string {
    /*const API_CONSUMER_NOT_AVAILABLE = new ApiError("001", "El servicio de API-Consumer no se encuentra disponible");
    const CUSTOMER_NOT_FOUND = new ApiError("002", "El cliente no se encuentra registrado");
    const CUSTOMER_FOUND = new ApiError("003", "El cliente ya esta registrado");
    const TAXPAYER_NOT_FOUND = new ApiError("004", "El contribuyente no se encuentra registrado");
    const BAD_LOCATION = new ApiError("006", "La ubicación no es correcta");
    const REMOVED_CUSTOMER = new ApiError("007", "El cliente fue eliminado");
    const COUNTRY_NOT_FOUND = new ApiError("008", "El código de pais no fue encontrado");
    const TAXPAYERS_API_NOT_AVAILABLE = new ApiError("009", "El servicio de API-Taxpayer-Information no se encuentra disponible");
    const LOCATIONS_SERVICE_NOT_AVAILABLE = new ApiError("010", "El servicio de ubicaciónes no se encuentra disponible.");
    const STATUS_NOT_FOUND = new ApiError("011", "El estado solicitado no existe");
    const CUSTOMER_SERVICE_ERROR = new ApiError("013", "Ha ocurrido un error en el servicio de clientes.");
    const CACHE_NOT_FOUND = new ApiError("014", "No se ha encontrado la cache solicitada.");*/
    case ApiConsumerNotAvailable = "001";
    case CustomerNotFound = "002";
    case CustomerFound = "003";
    case TaxpayerNotFound = "004";
    case BadLocation = "006";
    case RemovedCustomer = "007";
    case CountryNotFound = "008";
    case TaxpayersApiNotAvailable = "009";
    case LocationsServiceNotAvailable = "010";
    case StatusNotFound = "011";
    case CustomerServiceError = "013";
    case CacheNotFound = "014";

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
            self::CacheNotFound => "No se ha encontrado la cache solicitada."
        };
    }
}
