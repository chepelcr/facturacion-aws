<?php

namespace App\Enums;

enum DocumentTypesEnum: string
{
    case ELECTRONIC_BILL = '01';
    case DEBIT_NOTE = '02';
    case CREDIT_NOTE = '03';
    case ELECTRONIC_TICKET = '04';
    case RECEIVER_ACCEPTANCE = '05';
    case RECEIVER_PARTIAL_ACCEPTANCE = '06';
    case RECEIVER_REJECTION = '07';
    case PURCHASE_INVOICE = '08';
    case EXPORT_BILL = '09';
    case HACIENDA_MESSAGE = '99';
    case PAYMENT_RECEIPT = '10';

    public function getXmlRoot(): string
    {
        return match($this) {
            self::ELECTRONIC_BILL => 'FacturaElectronica',
            self::DEBIT_NOTE => 'NotaDebitoElectronica',
            self::CREDIT_NOTE => 'NotaCreditoElectronica',
            self::ELECTRONIC_TICKET => 'TiqueteElectronico',
            self::PURCHASE_INVOICE => 'FacturaCompra',
            self::EXPORT_BILL => 'FacturaElectronicaExportacion',
            default => throw new \InvalidArgumentException('Unsupported document type')
        };
    }

    public function getXmlns(bool $useNewVersion = false): string
    {
        $version = $useNewVersion ? 'v4.4' : 'v4.3';
        return match($this) {
            self::ELECTRONIC_BILL => "https://cdn.comprobanteselectronicos.go.cr/xml-schemas/$version/facturaElectronica",
            self::DEBIT_NOTE => "https://cdn.comprobanteselectronicos.go.cr/xml-schemas/$version/notaDebitoElectronica",
            self::CREDIT_NOTE => "https://cdn.comprobanteselectronicos.go.cr/xml-schemas/$version/notaCreditoElectronica",
            self::ELECTRONIC_TICKET => "https://cdn.comprobanteselectronicos.go.cr/xml-schemas/$version/tiqueteElectronico",
            self::PURCHASE_INVOICE => $useNewVersion ? "https://cdn.comprobanteselectronicos.go.cr/xml-schemas/v4.4/facturaElectronicaCompra" : "https://cdn.comprobanteselectronicos.go.cr/xml-schemas/v4.3/facturaCompra",
            self::EXPORT_BILL => "https://cdn.comprobanteselectronicos.go.cr/xml-schemas/$version/facturaElectronicaExportacion",
            default => throw new \InvalidArgumentException('Unsupported document type')
        };
    }
}