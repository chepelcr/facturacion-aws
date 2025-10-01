package io.ivois.api.billing.hacienda.documents.enums;

import lombok.AllArgsConstructor;
import lombok.Getter;

/**
 * Tipos de documento electrónico
 *
 * @author jcampos
 */
@Getter
@AllArgsConstructor
public enum DocumentTypes {
    /**
     * Factura electronica
     */
    ELECTRONIC_BILL(1, "01", "electronic.invoice", "xml.electronic.invoice",
            "https://cdn.comprobanteselectronicos.go.cr/xml-schemas/v4.3/facturaElectronica", "https://cdn.comprobanteselectronicos.go.cr/xml-schemas/v4.4/facturaElectronica", false, "4.4", false),

    /**
     * Nota de debito
     */
    DEBIT_NOTE(2, "02", "debit.note", "xml.debit.note",
            "https://cdn.comprobanteselectronicos.go.cr/xml-schemas/v4.3/notaDebitoElectronica", "https://cdn.comprobanteselectronicos.go.cr/xml-schemas/v4.4/notaDebitoElectronica", false, "4.4", true),

    /**
     * Nota de crédito
     */
    CREDIT_NOTE(3, "03", "credit.note", "xml.credit.note",
            "https://cdn.comprobanteselectronicos.go.cr/xml-schemas/v4.3/notaCreditoElectronica", "https://cdn.comprobanteselectronicos.go.cr/xml-schemas/v4.4/notaCreditoElectronica", false, "4.4", true),

    /**
     * Tiquete electrónico
     */
    ELECTRONIC_TICKET(4, "04", "electronic.ticket", "xml.electronic.ticket",
            "https://cdn.comprobanteselectronicos.go.cr/xml-schemas/v4.3/tiqueteElectronico", "https://cdn.comprobanteselectronicos.go.cr/xml-schemas/v4.4/tiqueteElectronico", false, "4.4", false),

    /**
     * Confirmación de aceptación del comprobante electrónico
     */
    RECEIVER_ACCEPTANCE(5, "05", "receiver.acceptance", "xml.receiver.message",
            "https://cdn.comprobanteselectronicos.go.cr/xml-schemas/v4.3/mensajeReceptor", "https://cdn.comprobanteselectronicos.go.cr/xml-schemas/v4.4/mensajeReceptor", true, "4.4", false),

    /**
     * Confirmación de aceptación parcial del comprobante electrónico
     */
    RECEIVER_PARTIAL_ACCEPTANCE(6, "06", "receiver.partial.acceptance", "xml.receiver.message",
            "https://cdn.comprobanteselectronicos.go.cr/xml-schemas/v4.3/mensajeReceptor", "https://cdn.comprobanteselectronicos.go.cr/xml-schemas/v4.4/mensajeReceptor", true, "4.4", false),

    /**
     * Confirmación de rechazo del comprobante electrónico
     */
    RECEIVER_REJECTION(7, "07", "receiver.rejected", "xml.receiver.message",
            "https://cdn.comprobanteselectronicos.go.cr/xml-schemas/v4.3/mensajeReceptor", "https://cdn.comprobanteselectronicos.go.cr/xml-schemas/v4.4/mensajeReceptor", true, "4.4", false),

    /**
     * Factura electronica de compra
     */
    PURCHASE_INVOICE(8, "08", "purchase.invoice", "xml.purchase.invoice",
            "https://cdn.comprobanteselectronicos.go.cr/xml-schemas/v4.3/facturaElectronicaCompra", "https://cdn.comprobanteselectronicos.go.cr/xml-schemas/v4.4/facturaElectronicaCompra", false, "4.4", false),

    /**
     * Factura electronica de exportación
     */
    EXPORT_BILL(9, "09", "export.invoice", "xml.export.invoice",
            "https://cdn.comprobanteselectronicos.go.cr/xml-schemas/v4.3/facturaElectronicaExportacion", "https://cdn.comprobanteselectronicos.go.cr/xml-schemas/v4.4/facturaElectronicaExportacion", false, "4.4", false),

    /**
     * Mensaje de validación del Ministerio de Hacienda
     */
    HACIENDA_MESSAGE(10, "99", "hacienda.message", "xml.hacienda.message",
            "https://cdn.comprobanteselectronicos.go.cr/xml-schemas/v4.3/mensajeHacienda", "https://cdn.comprobanteselectronicos.go.cr/xml-schemas/v4.4/mensajeHacienda", true, "4.4", false),

    //Recibo Electrónico
    //de Pago Recibo Electrónico Pago https://cdn.comprobanteselectronicos.go.cr/xml-schemas/v4.4/reciboElectronicoPago
    PAYMENT_RECEIPT(11, "10", "payment.receipt", "xml.payment.receipt", null, "https://cdn.comprobanteselectronicos.go.cr/xml-schemas/v4.4/reciboElectronico", false, "4.4", false);


    /**
     * Id del tipo de documento electrónico
     */
    private final int documentTypeId;

    /**
     * Tipo de documento electrónico
     */
    private final String code;

    /**
     * Nombre del documento electrónico
     */
    private final String documentName;

    /**
     * Nombre del XML del documento electrónico
     */
    private final String documentXmlName;

    /**
     * Ruta donde se encuentra la información del cuerpo del documento electrónico
     */
    private final String oldXmlns;

    /**
     * Ruta donde se encuentra la información del cuerpo del documento electrónico
     */
    private final String xmlns;

    /**
     * Indica si el documento electrónico es de respuesta
     */
    private final boolean response;

    /**
     * Versión del documento electrónico
     */
    private final String version;

    /**
     * Es nota
     */
    private final boolean note;

    /**
     * Obtiene el tipo de documento electrónico
     *
     * @param documentType - Tipo de documento electrónico
     *
     * @return DocumentTypes
     */
    public static DocumentTypes getDocumentType(String documentType) {
        for (DocumentTypes type : DocumentTypes.values()) {
            if (type.getCode().equals(documentType)) {
                return type;
            }
        }
        return null;
    }// Fin del método getDocumentType

    /**
     * Obtener el tipo de documento electrónico por xmlns
     *
     * @param xmlns - xmlns del documento electrónico
     *
     * @return DocumentTypes
     */
    public static DocumentTypes getDocumentTypeByXmlns(String xmlns) {
        for (DocumentTypes type : DocumentTypes.values()) {
            if (type.getOldXmlns().equals(xmlns)) {
                return type;
            }
        }
        return null;
    }// Fin del método getDocumentTypeByXmlns

    /**
     * Obtener tipo de Mensaje de receptor por estado
     *
     * @param state - Estado del mensaje de receptor
     *
     * @return DocumentTypes
     */
    public static DocumentTypes getReceiverMessageTypeByState(int state) {
        return switch (state) {
            case 1 -> DocumentTypes.RECEIVER_ACCEPTANCE;
            case 2 ->
                    DocumentTypes.RECEIVER_PARTIAL_ACCEPTANCE;
            case 3 -> DocumentTypes.RECEIVER_REJECTION;
            default -> null;
        };
    }
}
