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
public enum TaxTypes {
    /**
     * Impuesto al Valor Agregado
     */
    IVA("01", "Impuesto al Valor Agregado", true, false, true, null, false, false),

    /**
     * Impuesto Selectivo de Consumo
     */
    ISC("02", "Impuesto Selectivo de Consumo", false, false, true, null, true, false),

    /**
     * Impuesto Único a los Combustibles
     */
    IUC("03", "Impuesto Único a los Combustibles", false, true, false, null, false, true),

    /**
     * Impuesto específico de Bebidas Alcohólicas
     */
    ISEBA("04", "Impuesto específico de Bebidas Alcohólicas", false, true, false, null, true, true),

    /**
     * Impuesto Específico sobre las bebidas envasadas sin contenido alcohólico y jabones de tocador
     */
    ISEBEC("05", "Impuesto Específico sobre las bebidas envasadas sin contenido alcohólico y jabones de tocador", false, true, false, null, true, true),

    /**
     * Impuesto a los Productos de Tabaco
     */
    IPT("06", "Impuesto a los Productos de Tabaco", false, true, false, null, false, true),

    /**
     * IVA (cálculo especial)
     */
    IVACE("07", "IVA (cálculo especial)", true, false, true, null, false, false),

    /**
     * IVA Régimen de Bienes Usados (Factor)
     */
    IVARBU("08", "IVA Régimen de Bienes Usados (Factor)", true, false, true, null, false, false),

    /**
     * Impuesto Específico al Cemento
     */
    ISEC("12", "Impuesto Específico al Cemento", false, false, true, 5.0, true, true),

    /**
     * Otros
     */
    OTHERS("99", "Otros", false, false, true, null, false, false);

    /**
     * Código del tipo de impuesto
     */
    private final String taxCode;

    /**
     * Descripción del tipo de impuesto
     */
    private final String description;

    /**
     * Indica si el tipo de impuesto es un IVA
     */
    private final boolean iva;

    /**
     * Indica si requiere campos especiales
     */
    private boolean requiresSpecialFields;

    /**
     * Indica si requiere una tarifa manual
     */
    private boolean requireRate;

    /**
     * Indica la tarifa
     */
    private final Double rate;

    /**
     * Indica si se requiere para la base imponible
     */
    private final boolean forBaseAmount;

    /**
     * Indica si se toma en cuenta para impuestos cobrados a fábrica
     */
    private final boolean forFactoryTax;

    /**
     * Obtiene el tipo de impuesto por su código
     *
     * @param taxCode Código del tipo de impuesto
     *
     * @return Tipo de impuesto
     */
    public static TaxTypes getTaxTypeByCode(String taxCode) {
        for (TaxTypes taxType : TaxTypes.values()) {
            if (taxType.getTaxCode().equals(taxCode)) {
                return taxType;
            }
        }

        return IVA;
    }
}
