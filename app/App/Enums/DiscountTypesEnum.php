<?php

namespace App\Enums;

enum DiscountTypesEnum: string
{
    case REGALIA = '01';
    case REGALIA_IVA = '02';
    case BONIFICATION = '03';
    case VOLUME = '04';
    case SEASONAL = '05';
    case PROMOTIONAL = '06';
    case COMMERCIALLY = '07';
    case FREQUENCY = '08';
    case SUSTAINED = '09';
    case OTHER = '99';

    public function getDescription(): string
    {
        return match($this) {
            self::REGALIA => 'Descuento por regalía',
            self::REGALIA_IVA => 'Descuento por regalía (IVA cobrado al cliente)',
            self::BONIFICATION => 'Descuento por bonificación',
            self::VOLUME => 'Descuento por volumen',
            self::SEASONAL => 'Descuento por temporada',
            self::PROMOTIONAL => 'Descuento promocional',
            self::COMMERCIALLY => 'Descuento comercial',
            self::FREQUENCY => 'Descuento por frecuencia',
            self::SUSTAINED => 'Descuento sostenido',
            self::OTHER => 'Otros'
        };
    }
}