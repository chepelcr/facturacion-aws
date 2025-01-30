<?php

namespace App\Enums;

/**
 * Enumeración de errores de la API de Ivois para contribuyentes
 * @author jcampos
 * @version 1.0
 * @package App\Enums
 * @since 23/09/2024
 */
enum NotificationsEnum: string {
    public function getName(): string {
        return match ($this) {
            default => "No definido",
        };
    }
}
