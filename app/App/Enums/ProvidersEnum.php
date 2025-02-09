<?php

namespace App\Enums;

enum ProvidersEnum: string {
    case ApiConsumerNotAvailable = "001";
    case ProviderNotFound = "002";
    case ProviderFound = "003";
    case TaxpayerNotFound = "004";
    case BadLocation = "005";
    case RemovedProvider = "006";
    case CountryNotFound = "007";
    case TaxpayersApiNotAvailable = "008";
    case LocationsServiceNotAvailable = "009";
    case StatusNotFound = "010";
    case ProviderServiceError = "011";
    case CacheNotFound = "012";
    case InvalidPhoneNumber = "014";

    public function getName(): string {
        return match($this) {
            self::ApiConsumerNotAvailable => "El servicio de API-Consumer no se encuentra disponible",
            self::ProviderNotFound => "El proveedor no se encuentra registrado",
            self::ProviderFound => "El proveedor ya esta registrado",
            self::TaxpayerNotFound => "El contribuyente no se encuentra registrado",
            self::BadLocation => "La ubicación no es correcta",
            self::RemovedProvider => "El proveedor fue eliminado",
            self::CountryNotFound => "El código de pais no fue encontrado",
            self::TaxpayersApiNotAvailable => "El servicio de API-Taxpayer-Information no se encuentra disponible",
            self::LocationsServiceNotAvailable => "El servicio de ubicaciónes no se encuentra disponible.",
            self::StatusNotFound => "El estado solicitado no existe",
            self::ProviderServiceError => "Ha ocurrido un error en el servicio de proveedors.",
            self::CacheNotFound => "No se ha encontrado la cache solicitada.",
            self::InvalidPhoneNumber => "El número de teléfono no es válido",
            default => "Ha ocurrido un error al realizar la solicitud"
        };
    }
}
