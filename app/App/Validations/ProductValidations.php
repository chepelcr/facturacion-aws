<?php

namespace App\Validations;

/**
 * Clase para validar la estructura de los productos y servicios
 * 
 * @package App\Validations
 * @subpackage ProductValidations
 * @version 1.0
 * @author jcampos
 */
class ProductValidations {

    /**
     * Validar la estructura de las lineas de impuesto de un producto o servicio
     * 
     * @param array $taxLines Lineas de impuesto del producto o servicio
     * @return array Lineas de impuesto validadas
     */
    public static function validateTaxes($taxLines) {

        $newTaxes = array();

        foreach ($taxLines as $tax) {
            if ($tax['taxTypeId'] != '' && ($tax['rate'] != '' && $tax['rate'] > 0)) {
                $newTaxes[] = $tax;
            }
        }

        return $newTaxes;
    }

    /**
     * Validar la estructura de los descuentos de un producto o servicio
     * 
     * @param array $discounts Descuentos del producto o servicio
     * @return array Descuentos validados
     */
    public static function validateDiscounts($discounts) {
        $newDiscounts = array();

        foreach ($discounts as $discount) {
            if ($discount['reason'] != '' && ($discount['percentage'] != '' && $discount['percentage'] > 0)) {
                $newDiscounts[] = $discount;
            }
        }

        return $newDiscounts;
    }

    public static function validateProductStructure($product){
        //Si el producto tiene impuestos
        if (isset($product['taxes'])) {
            $product['taxes'] = self::validateTaxes($product['taxes']);
        }

        //Si el producto tiene descuentos
        if (isset($product['discounts'])) {
            $product['discounts'] = self::validateDiscounts($product['discounts']);
        }

        return $product;
    }
}
