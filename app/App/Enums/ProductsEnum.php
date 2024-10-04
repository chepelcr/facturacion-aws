<?php

namespace App\Enums;

/**
 * Enumeración para los errores de productos
 * 
 * @package App\Enums
 * @version 1.0
 * @since 23/09/2024
 * @subpackage ProductsEnum
 * @author jcampos
 */
enum ProductsEnum: string {
    case Success = "000";
    case Failed = "001";
    case CodeFound = "002";
    case TaxpayerNotFound = "003";
    case StatusNotFound = "004";
    case DataServiceNotAvailable = "005";
    case AwsAppConfigError = "006";
    case CacheNotFound = "007";
    case CabysNotFound = "008";
    case MeasurementUnitNotFound = "009";
    case CategoryNotFound = "010";
    case UploadImageError = "011";
    case CodeTypeNotFound = "012";
    case ApiConsumerNotAvailable = "013";
    case ProductNotFound = "014";
    case CodeAlreadyExists = "015";
    case TaxTypeNotFound = "016";
    case TaxRateNotFound = "017";
    case ProductFound = "018";
    case ProductTypeNotFound = "019";
    case CodeTypeAlreadyExists = "020";
    case TaxpayersApiNotAvailable = "021";
    case RemovedProduct = "022";
    case MeasurementUnitException = "023";
    case OtherChargeNotFound = "024";
    case OtherChargeFound = "025";
    case RemovedOtherCharge = "026";
    case OtherChargeTypeNotFound = "027";
    case OtherChargeAmountRequired = "028";
    case OtherChargePercentageRequired = "029";
    case CategoryRequest = "030";
    case TaxAlreadyExists = "031";
    case BaseAmountNotFound = "032";
    case TaxIvaFound = "033";
    case TaxRateFound = "034";
    case TaxRateRequired = "035";

    public function getName(): string {
        return match($this) {
            self::Success => "Operación completada con éxito",
            self::Failed => "La operación fallo",
            self::CodeFound => "Código encontrado",
            self::TaxpayerNotFound => "Contribuyente no encontrado",
            self::StatusNotFound => "Estado no encontrado",
            self::DataServiceNotAvailable => "Servicio de datos no disponible",
            self::AwsAppConfigError => "Error al obtener la configuración de AWS",
            self::CacheNotFound => "La cache solicitada no fue encontrada",
            self::CabysNotFound => "No se encuentran resultados disponibles",
            self::MeasurementUnitNotFound => "La unidad de medida no se encuentra registrada",
            self::CategoryNotFound => "La categoría no se encuentra registrada",
            self::UploadImageError => "Error al subir la imagen del producto",
            self::CodeTypeNotFound => "El tipo de código no se encuentra registrado",
            self::ApiConsumerNotAvailable => "El servicio de API Consumer no se encuentra disponible",
            self::ProductNotFound => "El producto no se encuentra registrado",
            self::CodeAlreadyExists => "El código ya se encuentra registrado",
            self::TaxTypeNotFound => "El tipo de impuesto no se encuentra registrado",
            self::TaxRateNotFound => "El código de tarifa no se encuentra registrado",
            self::ProductFound => "El producto ya se encuentra registrado",
            self::ProductTypeNotFound => "El tipo de producto no es valido",
            self::CodeTypeAlreadyExists => "El tipo de código ya se encuentra registrado",
            self::TaxpayersApiNotAvailable => "El servicio de Taxpayers API no se encuentra disponible",
            self::RemovedProduct => "El producto fue eliminado",
            self::MeasurementUnitException => "La unidad de medida no coincide con el servicio ingresado",
            self::OtherChargeNotFound => "El cargo no se encuentra registrado",
            self::OtherChargeFound => "El cargo se encuentra registrado",
            self::RemovedOtherCharge => "El cargo se encuentra eliminado",
            self::OtherChargeTypeNotFound => "El tipo de cargo no se encuentra registrado",
            self::OtherChargeAmountRequired => "El monto del cargo es requerido",
            self::OtherChargePercentageRequired => "El porcentaje del cargo es requerido",
            self::CategoryRequest => "La categoría ingresada es incorrecta",
            self::TaxAlreadyExists => "El impuesto ya se encuentra registrado",
            self::BaseAmountNotFound => "El monto base imponible es requerido",
            self::TaxIvaFound => "Solo se permite un impuesto IVA",
            self::TaxRateFound => "La tarifa de impuesto no es requerida",
            self::TaxRateRequired => "La tarifa de impuesto es requerida",
            default => "No definido",
        };
    }
}
