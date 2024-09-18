<?php

namespace App\Errors;

use Core\Errors\BaseEnum;
use Core\Errors\ApiError;

class CustomersEnum extends BaseEnum {
    const API_CONSUMER_NOT_AVAILABLE = new ApiError("001", "El servicio de API-Consumer no se encuentra disponible");
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
    const CACHE_NOT_FOUND = new ApiError("014", "No se ha encontrado la cache solicitada.");
}
