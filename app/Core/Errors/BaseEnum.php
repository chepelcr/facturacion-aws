<?php

namespace Core\Errors;


abstract class BaseEnum {
    const SUCCESS = new ApiError("000", "Operación completada con éxito");
    const FAILED = new ApiError("100", "La operación fallo");

    public static function getMessageFromCode($code) {
        $reflection = new \ReflectionClass(__CLASS__);
        $constants = $reflection->getConstants();

        if ($constants == null) {
            return null;
        }

        $message = null;
        foreach ($constants as $value) {
            if ($value->getCode() == $code) {
                $message = $value->getMessage();
                break;
            }
        }
        return $message;
    }

    /**
     * Retornar una instancia de la misma clase
     */
    public static function getClassInstance() {
        return new static();
    }
}
