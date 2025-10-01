package io.ivois.api.billing.hacienda.documents.enums;

import lombok.AllArgsConstructor;
import lombok.Getter;

/**
 * Enumeracion para los tipos de impuestos permitidos por el Ministerio de Hacienda
 *
 * @author jcampos
 * @version 1.0
 * @since 10/01/2023
 */
@Getter
@AllArgsConstructor
public enum TaxRates {
    /**
     * Tarifa 0% (Artículo 32, num 1, RLIVA)
     * <p>
     * 01
     * <p>
     * La tarifa 0% se utilizará únicamente cuando las transacciones que se realicen correspondan a las transacciones definidas en el artículo 32, numeral 1 del Reglamento de la Ley sobre el Impuesto al Valor Agregado, que otorga derecho a crédito pleno, como por ejemplo ventas a la CCSS o a municipalidades, entre otros.
     * <p>
     * Tarifa reducida 1%
     * <p>
     * 02
     * <p>
     * <p>
     * <p>
     * Tarifa reducida 2%
     * <p>
     * 03
     * <p>
     * <p>
     * <p>
     * Tarifa reducida 4%
     * <p>
     * 04
     * <p>
     * <p>
     * <p>
     * Transitorio 0%
     * <p>
     * 05
     * <p>
     * Transitorio 0% se utilizará únicamente para efectos de las Notas de Crédito y Notas de Débito que lo requieran.
     * <p>
     * Transitorio 4%
     * <p>
     * 06
     * <p>
     * Transitorio 4% se utilizará únicamente para efectos de las Notas de Crédito y Notas de Débito que lo requieran.
     * <p>
     * Tarifa transitoria 8%
     * <p>
     * 07
     * <p>
     * Transitorio 8% se utilizará únicamente para efectos de las Notas de Crédito y Notas de Débito que lo requieran.
     * <p>
     * Tarifa general 13%
     * <p>
     * 08
     * <p>
     * <p>
     * <p>
     * Tarifa reducida 0.5%
     * <p>
     * 09
     * <p>
     * <p>
     * <p>
     * Tarifa Exenta
     * <p>
     * 10
     * <p>
     * Tarifa Exenta Ley 9635, Artículo 8
     * <p>
     * Tarifa 0% sin derecho a crédito
     * <p>
     * 11
     * <p>
     * Se utilizará únicamente en aquellos casos en los que se registre la transacción de un bien o servicio no sujeto pero que no otorga derecho a crédito
     */

    RATE_0("01", "Tarifa 0%", 0.0, false),
    REDUCED_RATE_1("02", "Tarifa reducida 1%", 0.01, false),
    REDUCED_RATE_2("03", "Tarifa reducida 2%", 0.02, false),
    REDUCED_RATE_4("04", "Tarifa reducida 4%", 0.04, false),
    TRANSITORY_0("05", "Transitorio 0%", 0.0, true),
    TRANSITORY_4("06", "Transitorio 4%", 0.04, true),
    TRANSITORY_8("07", "Transitorio 8%", 0.08, true),
    GENERAL_RATE_13("08", "Tarifa general 13%", 0.13, false),
    REDUCED_RATE_0_5("09", "Tarifa reducida 0.5%", 0.005, false),
    EXEMPT("10", "Tarifa Exenta", 0.0, false),
    EXEMPT_9635("11", "Tarifa Exenta Ley 9635, Artículo 8", 0.0, false);


    /**
     * Código del tipo de impuesto
     */
    private final String code;

    /**
     * Descripción del tipo de impuesto
     */
    private final String description;

    /**
     * Tarifa de impuesto
     */
    private final Double rate;

    /**
     * Indica si solo es para notas
     */
    private final boolean forNotes;


    /**
     * Obtiene el tipo de impuesto por su código
     *
     * @param taxCode Código del tipo de impuesto
     *
     * @return Tipo de impuesto
     */
    public static TaxRates getRateByCode(String taxCode) {
        for (TaxRates taxType : TaxRates.values()) {
            if (taxType.getCode().equals(taxCode)) {
                return taxType;
            }
        }

        return null;
    }
}
