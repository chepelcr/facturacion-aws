<?php

namespace App\Validations;

class DocumentValidations {

    /**
     * Validar la estructura de los pagos de un documento
     * 
     * @param array $payments Pagos del documento
     * @return array Pagos validados
     */
    private static function validateDocumentPayments($payments) {
        $newPayments = array();

        foreach ($payments as $payment) {
            if ($payment['type'] != '') {
                $newPayments[] = $payment;
            }
        }

        return $newPayments;
    }

    /**
     * Validar la estructura de un documento
     * 
     * @param array $document Documento a validar
     * @return array Documento validado
     */
    public static function validateDocumentStructure($document) {
        //Validar la estructura de los pagos
        if (isset($document['payments'])) {
            $document['payments'] = self::validateDocumentPayments($document['payments']);
        }

        $documentTypeCode = $document['documentTypeCode'];

        //Validar si el documento tiene un receptor
        if ((!isset($document['receiver']) || empty($document['receiver'])) && ($documentTypeCode == '01' && $documentTypeCode == '08' && $documentTypeCode == '09')) {
            return array(
                'message' => 'No se ha ingresado el receptor del documento',
                'status' => '400',
                'error' => "Bad Request",
            );
        }

        //Si el tipo de documento no es una nota de credito o debito, se debe agregar al menos un pago
        if (empty($document['payments']) && $documentTypeCode != '02' && $documentTypeCode != '03') {
            return array(
                'message' => 'No se ha ingresado ningún tipo de pago',
                'status' => '400',
                'error' => "Bad Request",
            );
        }

        if (isset($document['details']) && !empty($document['details'])) {
            $document['details'] = self::validateDocumentDetails($document['details']);

            if (isset($document['details']['error'])) {
                return $document['details'];
            }
        }

        if (empty($document['details'])) {
            return array(
                'message' => 'No se han ingresado detalles o se encuentran con campos incompletos',
                'status' => '400',
                'error' => "Bad Request",
            );
        }

        // Validar si existen referencias en el documento y luego validar cada linea
        if (isset($document['references'])) {
            $document['references'] = self::validateDocumentReferences($document['references']);

            if (isset($document['references']['error'])) {
                return $document['references'];
            }
        }

        //Validar la estructura de otros campos (otherFields)
        if (isset($document['otherFields'])) {
            $document['otherFields'] = self::validateOtherFields($document['otherFields']);

            if (isset($document['otherFields']['error'])) {
                return $document['otherFields'];
            }
        }

        //Eliminar el campo documentTypeCode
        unset($document['documentTypeCode']);

        return $document;
    }

    /**
     * Validar la estructura de los campos adicionales de un documento
     * 
     * @param array $otherFields Campos adicionales del documento
     * @return array Campos adicionales validados
     */
    private static function validateOtherFields($otherFields) {
        $newOtherFields = array();

        foreach ($otherFields as $otherField) {
            if ($otherField['code'] != '' && $otherField['otherText'] != '') {
                $newOtherFields[] = $otherField;
            } elseif ($otherField['code'] != '' && $otherField['otherText'] == '') {
                return array(
                    'message' => 'No se ha ingresado la información del proveedor',
                    'status' => '400',
                    'error' => "Bad Request",
                );
            }
        }

        return $newOtherFields;
    }

    /**
     * Validar la estructura de los detalles de un documento
     * 
     * @param array $details Detalles del documento
     * @return array Detalles validados
     */
    private static function validateDocumentDetails($details) {
        $newDetails = array();

        //Recorrer los detalles del documento
        foreach ($details as $detail) {
            if ($detail['productId'] != "") {
                if ($detail['quantity'] != "0" && $detail['description'] != "" && $detail['salePrice'] != "0") {
                    //Recorrer los descuentos de la linea si existen y validar que existan los campos o eliminar la linea
                    if (isset($detail['discounts'])) {
                        $detail['discounts'] = ProductValidations::validateDiscounts($detail['discounts']);

                        if (isset($detail['discounts']['message'])) {
                            return $detail['discounts'];
                        }
                    }

                    //Recorrer los impuestos de la linea si existen y validar que existan los campos o eliminar la linea
                    if (isset($detail['taxes'])) {
                        $detail['taxes'] = self::validateTaxes($detail['taxes']);

                        if (isset($detail['taxes']['message'])) {
                            return $detail['taxes'];
                        }
                    }

                    $newDetails[] = $detail;
                } else {
                    return array(
                        'message' => 'No se han ingresado todos los campos de la linea',
                        'status' => '400',
                        'error' => "Bad Request",
                    );
                }
            }
        }

        return $newDetails;
    }

    /**
     * Validar la estructura de las lineas de impuesto de un producto o servicio
     * 
     * @param array $taxLines Lineas de impuesto del producto o servicio
     * @return array Lineas de impuesto validadas
     */
    private static function validateTaxes($taxLines) {

        $newTaxes = array();

        foreach ($taxLines as $tax) {
            if ($tax['taxTypeId'] != '' && ($tax['rate'] != '')) {
                //Validar si el impuesto tiene una exoneración
                if (isset($tax['exemption'])) {
                    if ($tax['exemption']['documentType'] == '' && $tax['exemption']['documentNumber'] == '' && $tax['exemption']['institutionName'] == '' && $tax['exemption']['issueDate'] == '' && $tax['exemption']['percentage'] == 0) {
                        unset($tax['exemption']);
                    } elseif ($tax['exemption']['documentType'] == '' || $tax['exemption']['documentNumber'] == '' || $tax['exemption']['institutionName'] == '' || $tax['exemption']['issueDate'] == '' || $tax['exemption']['percentage'] == 0) {
                        return array(
                            'message' => 'No se han ingresado todos los campos de la exoneración',
                            'status' => '400',
                            'error' => "Bad Request",
                        );
                    }
                }

                $newTaxes[] = $tax;
            } elseif ($tax['taxTypeId'] != '' && ($tax['rate'] == '')) {
                return array(
                    'message' => 'No se han ingresado los campos del impuesto',
                    'status' => '400',
                    'error' => "Bad Request",
                );
            }
        }

        return $newTaxes;
    }

    /**
     * Validar la estructura de las referencias de un documento
     * 
     * @param array $references Referencias del documento
     * @return array Referencias validadas
     */
    private static function validateDocumentReferences($references) {
        $newReferences = array();

        foreach ($references as $reference) {
            if ($reference['referenceType'] != '' && $reference['referenceCode'] != '' && $reference['referenceNumber'] != '' && $reference['referenceReason'] != '' && $reference['referenceDate'] != '') {
                $newReferences[] = $reference;
            } elseif ($reference['referenceType'] != '' && ($reference['referenceCode'] == '' || $reference['referenceNumber'] == '' || $reference['referenceReason'] == '' || $reference['referenceDate'] == '')) {
                return array(
                    'message' => 'No se han ingresado todos los campos de la referencia',
                    'status' => '400',
                    'error' => "Bad Request",
                );
            }
        }

        return $newReferences;
    }
}
