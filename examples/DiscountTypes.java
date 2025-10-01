package io.ivois.api.billing.hacienda.documents.enums;

import io.ivois.api.billing.hacienda.documents.dtos.json.DiscountDTO;
import lombok.AllArgsConstructor;
import lombok.Getter;

import java.util.List;

/**
 * Enumeracion para los tipos de descuentos permitidos por el Ministerio de Hacienda
 *
 * @author tthornton
 * @version 1.0
 * @since 26/03/2025
 */
@Getter
@AllArgsConstructor
public enum DiscountTypes {
    OTHER("99", "Otros"),
    COMMERCIALLY("07", "Descuento comercial"),
    BONIFICATION("03", "Descuento por bonificación"),
    FREQUENCY("08", "Descuento por frecuencia"),
    REGALIA("01", "Descuento por regalía"),
    REGALIA_IVA("02", "Descuento por regalía (IVA cobrado al cliente)"),
    SEASONAL("05", "Descuento por temporada"), VOLUME("04", "Descuento por volumen"),
    PROMOTIONAL("06", "Descuento promocional"),
    SUSTAINED("09", "Descuento sostenido");


    /**
     * Código del tipo de impuesto
     */
    private final String code;

    /**
     * Descripción del tipo de impuesto
     */
    private final String description;


    /**
     * Obtiene el tipo de descuento por su código
     *
     * @param Code Código del tipo de descuento
     *
     * @return Tipo de descuento
     */
    public static DiscountTypes getDiscountTypeByCode(String Code) {
        for (DiscountTypes discountType : DiscountTypes.values()) {
            if (discountType.getCode().equals(Code)) {
                return discountType;
            }
        }
        return null;
    }

    /**
     * Validar si la lista de descuentos tiene tipo 01 o 03
     *
     * @param discountsList Lista de descuentos
     *
     * @return boolean
     */
    public static boolean isDiscountTypeRegaliaOrBonification(List<DiscountDTO> discountsList) {
        if (discountsList == null) {
            return false;
        }

        for (DiscountDTO discountDTO : discountsList) {
            if (discountDTO.getDiscountType().equals(DiscountTypes.REGALIA.getCode()) || discountDTO.getDiscountType().equals(DiscountTypes.BONIFICATION.getCode())) {
                return true;
            }
        }
        return false;
    }
}