<?php

namespace App\Enums;

enum TaxTypesEnum: string
{
    case IVA = '01';
    case ISC = '02';
    case IUC = '03';
    case ISEBA = '04';
    case ISEBEC = '05';
    case IPT = '06';
    case IVACE = '07';
    case IVARBU = '08';
    case ISEC = '12';
    case OTHERS = '99';

    public function getDescription(): string
    {
        return match($this) {
            self::IVA => 'Impuesto al Valor Agregado',
            self::ISC => 'Impuesto Selectivo de Consumo',
            self::IUC => 'Impuesto Único a los Combustibles',
            self::ISEBA => 'Impuesto específico de Bebidas Alcohólicas',
            self::ISEBEC => 'Impuesto Específico sobre las bebidas envasadas sin contenido alcohólico y jabones de tocador',
            self::IPT => 'Impuesto a los Productos de Tabaco',
            self::IVACE => 'IVA (cálculo especial)',
            self::IVARBU => 'IVA Régimen de Bienes Usados (Factor)',
            self::ISEC => 'Impuesto Específico al Cemento',
            self::OTHERS => 'Otros'
        };
    }

    public function isIva(): bool
    {
        return match($this) {
            self::IVA, self::IVACE, self::IVARBU => true,
            default => false
        };
    }

    public function requiresSpecialFields(): bool
    {
        return match($this) {
            self::IUC, self::ISEBA, self::ISEBEC, self::IPT, self::ISEC => true,
            default => false
        };
    }

    public function requiresRate(): bool
    {
        return match($this) {
            self::IVA, self::ISC, self::IVACE, self::IVARBU, self::OTHERS => true,
            default => false
        };
    }

    public function getFixedRate(): ?float
    {
        return match($this) {
            self::ISEC => 5.0,
            default => null
        };
    }

    public function isForBaseAmount(): bool
    {
        return match($this) {
            self::ISC, self::ISEBA, self::ISEBEC, self::ISEC => true,
            default => false
        };
    }

    public function isForFactoryTax(): bool
    {
        return match($this) {
            self::IUC, self::ISEBA, self::ISEBEC, self::IPT, self::ISEC => true,
            default => false
        };
    }
}