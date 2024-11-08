<?php

namespace App\Enums;

/**
 * Enumeración de categorías de errores
 * 
 * @package App\Enums
 * @subpackage ConfigurationsEnum
 * @version 1.0
 * @author jcampos
 */
enum ConfigurationsEnum: string {
    case Success = "000";
    case Failed = "100";
    case TaxpayerNotFound = "003";
    case CertificateNotFound = "004";
    case CertificatePinError = "005";
    case TaxpayerNotAvailable = "006";
    case SecretsError = "007";
    case EncryptError = "008";
    case CertificateNotValid = "009";
    case TaxpayerRemoved = "010";
    case SerializationError = "011";
    case CacheNotFound = "012";
    case AwsAppConfigError = "013";


    public function getName(): string {
        return match ($this) {
            self::Success => "Operación completada con éxito",
            self::Failed => "La operación fallo",
            self::TaxpayerNotFound => "El contribuyente no se encuentra registrado",
            self::CertificateNotFound => "El certificado no ha sido encontrado",
            self::CertificatePinError => "El pin del certificado proporcionado no es correcto",
            self::TaxpayerNotAvailable => "El contribuyente no se encuentra disponible",
            self::SecretsError => "No se ha encontrado el secret consultado",
            self::EncryptError => "Se ha generado un error en la encriptación",
            self::CertificateNotValid => "El certificado proporcionado no es valido",
            self::TaxpayerRemoved => "El contribuyente fue eliminado",
            self::SerializationError => "Se produjo un error al decodificar la respuesta",
            self::CacheNotFound => "La cache no se encuentra disponible",
            self::AwsAppConfigError => "Error al obtener las configuraciones de la aplicación",
            default => "Ha ocurrido un error al realizar la solicitud",
        };
    }
}
