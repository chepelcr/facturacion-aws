<?php

namespace App\Enums;

enum TaxRatesEnum: string
{
    case RATE_0 = '01';
    case REDUCED_RATE_1 = '02';
    case REDUCED_RATE_2 = '03';
    case REDUCED_RATE_4 = '04';
    case TRANSITORY_0 = '05';
    case TRANSITORY_4 = '06';
    case TRANSITORY_8 = '07';
    case GENERAL_RATE_13 = '08';
    case REDUCED_RATE_0_5 = '09';
    case EXEMPT = '10';
    case EXEMPT_9635 = '11';

    public function getDescription(): string
    {
        return match($this) {
            self::RATE_0 => 'Tarifa 0%',
            self::REDUCED_RATE_1 => 'Tarifa reducida 1%',
            self::REDUCED_RATE_2 => 'Tarifa reducida 2%',
            self::REDUCED_RATE_4 => 'Tarifa reducida 4%',
            self::TRANSITORY_0 => 'Transitorio 0%',
            self::TRANSITORY_4 => 'Transitorio 4%',
            self::TRANSITORY_8 => 'Transitorio 8%',
            self::GENERAL_RATE_13 => 'Tarifa general 13%',
            self::REDUCED_RATE_0_5 => 'Tarifa reducida 0.5%',
            self::EXEMPT => 'Tarifa Exenta',
            self::EXEMPT_9635 => 'Tarifa Exenta Ley 9635, Artículo 8'
        };
    }

    public function getRate(): float
    {
        return match($this) {
            self::RATE_0 => 0.0,
            self::REDUCED_RATE_1 => 0.01,
            self::REDUCED_RATE_2 => 0.02,
            self::REDUCED_RATE_4 => 0.04,
            self::TRANSITORY_0 => 0.0,
            self::TRANSITORY_4 => 0.04,
            self::TRANSITORY_8 => 0.08,
            self::GENERAL_RATE_13 => 0.13,
            self::REDUCED_RATE_0_5 => 0.005,
            self::EXEMPT => 0.0,
            self::EXEMPT_9635 => 0.0
        };
    }
}