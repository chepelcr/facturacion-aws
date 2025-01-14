$(document).ready(function () {
    //Cuando cambia el netValue
    $(document).on("change keyup", ".netValue", function () {
        //Validar si el netValue es un numero
        if (isNaN($(this).val()) || $(this).val() == "") {
            $(this).val(0);
        }

        //Si el netValue tiene un 0 a la izquierda, quitarlo
        if ($(this).val() != 0) {
            let netValue = $(this).val();

            if (netValue.charAt(0) == "0") {
                netValue = netValue.substring(1);
                $(this).val(netValue);
            }
        }

        calcular_valor_producto(form_activo);
    }); //Fin de cambiar el netValue

    //Cuando cambia el netValue
    $(document).on("change keyup", ".baseAmount", function () {
        //Validar si el netValue es un numero
        if (isNaN($(this).val()) || $(this).val() == "") {
            $(this).val(0);
        }

        //Si el baseAmount tiene un 0 a la izquierda, quitarlo
        if ($(this).val() != 0) {
            let baseAmount = $(this).val();

            if (baseAmount.charAt(0) == "0") {
                baseAmount = baseAmount.substring(1);
                $(this).val(baseAmount);
            }
        }

        calcular_valor_producto(form_activo);
    }); //Fin de cambiar el baseAmount

    //Cuando cambia el precio de venta
    $(document).on("change keyup", ".totalValue", function () {
        //Validar si el salePrice es un numero
        if (isNaN($(this).val()) || $(this).val() == "") {
            $(this).val(0);
        }

        if ($(this).val() != 0) {
            let salePrice = $(this).val();

            console.log("Precio de venta: " + salePrice);

            if (salePrice.charAt(0) == "0") {
                salePrice = salePrice.substring(1);
                $(this).val(salePrice);
            }

            console.log("Precio de venta: " + salePrice);
        }

        calcular_con_precio_venta(form_activo);
    }); //Fin de cambiar el precio de venta

    //Cuando cambia la cantidad
    $(document).on("change keyup", ".quantity", function () {
        //Validar si la cantidad es un numero
        if (isNaN($(this).val()) || $(this).val() == "") {
            $(this).val(1);
        }

        //Si el quantity tiene un 0 a la izquierda, quitarlo
        if ($(this).val() != 0) {
            let quantity = $(this).val();

            if (quantity.charAt(0) == "0") {
                quantity = quantity.substring(1);
            }

            //Convertir la cantidad a entero
            quantity = parseInt(quantity);

            //Si la cantidad es mayor que 2048, colocar 2048
            if (quantity > 99999) {
                quantity = 99999;
            }

            $(this).val(quantity);
        }

        //Calcular el valor unitario
        calcular_con_unitario(form_activo);
    }); //Fin de cambiar la cantidad

    //Cuando cambia el valor unitario
    $(document).on("change keyup", ".unitPrice", function () {
        //Validar si el unitPrice es un numero
        if (isNaN($(this).val()) || $(this).val() == "") {
            $(this).val(0);
        }

        //Si el unitPrice tiene un 0 a la izquierda, quitarlo
        if ($(this).val() != 0) {
            let unitPrice = $(this).val();

            if (unitPrice.charAt(0) == "0") {
                unitPrice = unitPrice.substring(1);
                $(this).val(unitPrice);
            }
        }

        //Calcular el valor del producto
        calcular_con_unitario(form_activo);
    }); //Fin de cambiar el valor unitario
});

function calcular_valor_producto(elemento = "", isBiller = false) {
    const form = $("#" + elemento);

    let netValue = 0;

    if (isBiller == true) {
        netValue = form.find(".netPrice").val();
    } else {
        netValue = form.find(".netValue").val();
    }

    //Si el netValue no son numeros, colocar 0
    if (isNaN(netValue) || netValue == "") {
        netValue = 0;
    }

    //Calcular el valor del descuento
    const discounts = calcular_descuentos_producto(netValue, isBiller);

    const subtotal = new Decimal(netValue).minus(discounts).toDecimalPlaces(5).toNumber();

    //Calcular el valor del impuesto
    const impuestoTotal = calcular_impuestos_producto(subtotal, isBiller);

    const total = new Decimal(subtotal).plus(impuestoTotal).toDecimalPlaces(2).toNumber();

    if (isBiller == true) {
        //Colocar el total en el campo .detail_total_value
        form.find(".detail_total_value").val(total);
    } else {
        //Colocar el total en el campo .totalValue
        form.find(".totalValue").val(total);
    }

    if (isBiller == false) {
        //Calcular el valor unitario
        calcular_valor_unitario(elemento);
    }
}

function calcular_con_precio_venta(elemento, isBiller = false) {
    const form = $("#" + elemento);

    let taxValue = 0;
    let discountAmount = 0;
    let salePrice = 0;
    let netValue;

    if (!isBiller) {
        salePrice = form.find(".totalValue").val();
    } else {
        salePrice = form.find(".detail_total_value").val();
    }

    console.log("Precio de venta: " + salePrice);

    const ivaTax = contar_porcentaje_impuesto(elemento, "iva");

    let ivaTaxPercentage = ivaTax["taxPercentage"];
    const ivatTaxType = ivaTax["taxType"];

    //Usar el baseAmount
    let baseAmount = form.find(".base_imponible").val();

    baseAmount = new Decimal(baseAmount);

    let hasIvaCE = ivatTaxType != null && ivatTaxType == "07";

    if (!hasIvaCE) {
        form.find(".base_imponible").val(0);
        baseAmount = 0;
    }

    let otherTaxPercentage = contar_porcentaje_impuesto(elemento, "other");

    salePrice = new Decimal(salePrice);

    if (ivaTaxPercentage > 0) {
        if (!hasIvaCE) {
            ivaTaxPercentage = new Decimal(ivaTaxPercentage).dividedBy(100).plus(1).toDecimalPlaces(5).toNumber();

            taxValue += salePrice.minus(salePrice.dividedBy(ivaTaxPercentage)).toDecimalPlaces(5).toNumber();

            console.log("Usando precio de venta");
        } else {
            ivaTaxPercentage = new Decimal(ivaTaxPercentage).dividedBy(100).toDecimalPlaces(5).toNumber();

            taxValue += baseAmount.times(ivaTaxPercentage).toDecimalPlaces(5).toNumber();

            console.log("Usando base imponible");
        }

        console.log("Valor de impuesto: " + taxValue);

        if (isBiller) {
            //Colocar el valor de impuesto total en detail_tax_total
            form.find(".detail_tax_total").val(taxValue);
        }

        //col-iva
        form.find(".col-iva").show();
    } else {
        if(isBiller) {
            form.find(".detail_tax_total").val(0);
        }

        //col-iva
        form.find(".col-iva").hide();
    }

    let subtotal = new Decimal(salePrice).minus(taxValue).toDecimalPlaces(5).toNumber();

    console.log("Subtotal: " + subtotal);

    if (otherTaxPercentage > 0) {
        subtotal = new Decimal(subtotal);

        form.find(".col-other-taxes").show();

        console.log("Porcentaje de impuesto total: " + otherTaxPercentage);

        let otherTaxValue;

        if (hasIvaCE) {
            otherTaxPercentage = new Decimal(otherTaxPercentage).dividedBy(100).toDecimalPlaces(5).toNumber();
            otherTaxValue = baseAmount.times(otherTaxPercentage).toDecimalPlaces(5).toNumber();
        } else {
            otherTaxPercentage = new Decimal(otherTaxPercentage).dividedBy(100).plus(1).toDecimalPlaces(5).toNumber();
            otherTaxValue = subtotal.minus(subtotal.dividedBy(otherTaxPercentage)).toDecimalPlaces(5).toNumber();
        }

        //other_taxes
        if (isBiller) {
            form.find(".other_taxes").val(formato_moneda(otherTaxValue, 2, monedaDocumento));
        } else {
            form.find(".other_taxes").val(formato_moneda(otherTaxValue, 5));
        }

        taxValue += otherTaxValue;

        subtotal = subtotal.minus(otherTaxValue).toDecimalPlaces(5).toNumber();
    } else {
        form.find(".col-other-taxes").hide();
    }

    let discountPercentage = contarPorcentajeDescuentos(elemento);

    if (discountPercentage > 0) {
        discountPercentage = new Decimal(discountPercentage).dividedBy(100).toDecimalPlaces(5).toNumber();

        discountAmount = new Decimal(subtotal)
            .dividedBy(1 - discountPercentage)
            .minus(subtotal)
            .toDecimalPlaces(5)
            .toNumber();

        console.log("Descuento: " + discountAmount);

        //Sumar el descuento al subtotal para obtener el netValue
        netValue = new Decimal(subtotal).plus(discountAmount).toDecimalPlaces(5).toNumber();

        console.log("Valor neto: " + netValue);
    } else {
        netValue = subtotal;
    }

    if (!isBiller) {
        form.find(".netValue").val(netValue);

        calcular_descuentos_producto(netValue);

        //Calcular el valor del impuesto
        calcular_impuestos_producto(subtotal);

        //Calcular el valor unitario
        calcular_valor_unitario(elemento);
    } else {
        const tipoCambio = tipoCambioDocumento;

        if (tipoCambio != 1) {
            netValue = netValue / tipoCambio;
        } else {
            form.find(".originalSalePrice").val(netValue);
        }

        form.find(".netPrice").val(netValue);

        //Colocar el valor de descuento en detail_discount_total
        form.find(".detail_discount_total").val(discountAmount);
    }
}

function calcular_con_unitario(elemento = "") {
    const form = $("#" + elemento);

    const quantity = form.find(".quantity").val();
    const unitPrice = form.find(".unitPrice").val();

    let netValue = new Decimal(quantity).times(unitPrice).toDecimalPlaces(5).toNumber();

    form.find(".netValue").val(netValue);

    calcular_valor_producto(elemento);
}

function calcular_valor_unitario(elemento = "", show = true) {
    const form = $("#" + elemento);

    let quantity = form.find(".quantity").val();

    if (quantity == "" || quantity == 0) {
        quantity = 1;

        form.find(".quantity").val(quantity);
    }

    const isPackaged = form.find(".isPackaged");

    if (quantity > 1) {
        isPackaged.prop("checked", true);
    } else {
        isPackaged.prop("checked", false);
    }

    if (show == true) {
        showPackagingInfo(isPackaged);
    }

    let salePrice = form.find(".netValue").val();

    if (isNaN(salePrice) || salePrice == "") {
        salePrice = 0;
    }

    let unitPrice = new Decimal(salePrice).dividedBy(quantity).toDecimalPlaces(5).toNumber();

    //Colocar el valor unitario en el elemento unitPrice
    form.find(".unitPrice").val(unitPrice, 5);
}
