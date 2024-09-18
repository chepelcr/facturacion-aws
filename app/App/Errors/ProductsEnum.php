<?php

namespace App\Errors;

use Core\Errors\BaseEnum;
use Core\Errors\ApiError;

class ProductsEnum extends BaseEnum {
    const CODE_FOUND = new ApiError("001", "Código encontrado");
    const TAXPAYER_NOT_FOUND = new ApiError("003", "Contribuyente no encontrado");
    const STATUS_NOT_FOUND = new ApiError("005", "Estado no encontrado");
    const DATA_SERVICE_NOT_AVAILABLE = new ApiError("006", "Servicio de datos no disponible");
    const AWS_APP_CONFIG_ERROR = new ApiError("007", "Error al obtener la configuración de AWS");
    const CACHE_NOT_FOUND = new ApiError("008", "La cache solicitada no fue encontrada");
    const CABYS_NOT_FOUND = new ApiError("007", "No se encuentran resultados disponibles");
    const MEASUREMENT_UNIT_NOT_FOUND = new ApiError("013", "La unidad de medida no se encuentra registrada");
    const CATEGORY_NOT_FOUND = new ApiError("015", "La categoría no se encuentra registrada");
    const UPLOAD_IMAGE_ERROR = new ApiError("016", "Error al subir la imagen del producto");
    const CODE_TYPE_NOT_FOUND = new ApiError("017", "El tipo de código no se encuentra registrado");
    const API_CONSUMER_NOT_AVAILABLE = new ApiError("018", "El servicio de API Consumer no se encuentra disponible");
    const PRODUCT_NOT_FOUND = new ApiError("019", "El producto no se encuentra registrado");
    const CODE_ALREADY_EXISTS = new ApiError("020", "El código ya se encuentra registrado");
    const TAX_TYPE_NOT_FOUND = new ApiError("022", "El tipo de impuesto no se encuentra registrado");
    const TAX_RATE_NOT_FOUND = new ApiError("023", "El código de tarifa no se encuentra registrado");
    const PRODUCT_FOUND = new ApiError("024", "El producto ya se encuentra registrado");
    const PRODUCT_TYPE_NOT_FOUND = new ApiError("025", "El tipo de producto no es valido");
    const CODE_TYPE_ALREADY_EXISTS = new ApiError("026", "El tipo de código ya se encuentra registrado");
    const TAXPAYERS_API_NOT_AVAILABLE = new ApiError("027", "El servicio de Taxpayers API no se encuentra disponible");
    const REMOVED_PRODUCT = new ApiError("028", "El producto fue eliminado");
    const MEASUREMENT_UNIT_EXCEPTION = new ApiError("029", "La unidad de medida no coincide con el servicio ingresado");
    const OTHER_CHARGE_NOT_FOUND = new ApiError("030", "El cargo no se encuentra registrado");
    const OTHER_CHARGE_FOUND = new ApiError("031", "El cargo se encuentra registrado");
    const REMOVED_OTHER_CHARGE = new ApiError("032", "El cargo se encuentra eliminado");
    const OTHER_CHARGE_TYPE_NOT_FOUND = new ApiError("033", "El tipo de cargo no se encuentra registrado");
    const OTHER_CHARGE_AMOUNT_REQUIRED = new ApiError("034", "El monto del cargo es requerido");
    const OTHER_CHARGE_PERCENTAGE_REQUIRED = new ApiError("035", "El porcentaje del cargo es requerido");
    const CATEGORY_REQUEST = new ApiError("036", "La categoría ingresada es incorrecta");
}
