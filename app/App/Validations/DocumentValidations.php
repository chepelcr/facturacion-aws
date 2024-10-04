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
        //$document = json_encode($document);

        //$document = json_decode($document, true);

        //Validar la estructura de los pagos
        if (isset($document['payments'])) {
            $document['payments'] = self::validateDocumentPayments($document['payments']);
        }

        $documentTypeCode = $document['documentTypeCode'];

        //Si el tipo de documento no es una nota de credito o debito, se debe agregar al menos un pago
        if (empty($document['payments']) && $documentTypeCode != '02' && $documentTypeCode != '03') {
            return array(
                'error' => 'No se ha ingresado ningún tipo de pago',
                'status' => '400',
            );
        }

        unset($document['documentTypeCode']);

        if (isset($document['details']) && !empty($document['details'])) {
            $document['details'] = self::validateDocumentDetails($document['details']);
        }

        if (empty($document['details'])) {
            return array(
                'error' => 'No se han ingresado detalles o se encuentran con campos incompletos',
                'status' => '400',
            );
        }

        // Validar si existen referencias en el documento y luego validar cada linea
        if (isset($document['references'])) {
            $document['references'] = self::validateDocumentReferences($document['references']);
        }

        //Validar la estructura de otros campos (otherFields)
        if (isset($document['otherFields'])) {
            $otherFields = $document['otherFields'];

            foreach ($otherFields as $key => $otherField) {
                if ($otherField['code'] == '' && $otherField['otherText'] == '') {
                    unset($otherFields[$key]);
                }
            }

            $document['otherFields'] = $otherFields;
        }

        //unset el documentTypeCode para que no se envie en el documento
        unset($document['documentTypeCode']);

        return $document;
    }

    private static function validateDocumentDetails($details) {
        $newDetails = array();

        //Recorrer los detalles del documento
        foreach ($details as $detail) {
            if ($detail['productId'] != "" && $detail['quantity'] != "0" && $detail['description'] != "" && $detail['salePrice'] != "0") {
                //Recorrer los descuentos de la linea si existen y validar que existan los campos o eliminar la linea
                if (isset($detail['discounts'])) {
                    $detail['discounts'] = ProductValidations::validateDiscounts($detail['discounts']);
                }

                //Recorrer los impuestos de la linea si existen y validar que existan los campos o eliminar la linea
                if (isset($detail['taxes'])) {
                    $detail['taxes'] = ProductValidations::validateTaxes($detail['taxes']);
                }

                $newDetails[] = $detail;
            }
        }

        return $newDetails;
    }

    private static function validateDocumentReferences($references) {
        $newReferences = array();

        foreach ($references as $reference) {
            if ($reference['referenceType'] != '' && $reference['referenceCode'] != '' && $reference['referenceNumber'] != '' && $reference['referenceReason'] != '' && $reference['referenceDate'] != '') {
                $newReferences[] = $reference;
            }
        }

        return $newReferences;
    }
}
