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
        } else {
            salePrice = 0;
        }

        calcular_con_precio_venta(form_activo, $(this).val());
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

function calcular_valor_producto(elemento = "", netValue = 0, unit = false) {
    const form = $("#" + elemento);

    if (netValue == null || netValue == "" || isNaN(netValue)) {
        netValue = form.find(".netValue").val();
    }

    //Si el netValue no son numeros, colocar 0
    if (isNaN(netValue) || netValue == "") {
        netValue = 0;
    }

    //Calcular el valor del descuento
    calcular_descuentos_producto();

    const subtotal = form.find(".subtotal").val();

    //Calcular el valor del impuesto
    const impuestoTotal = calcular_impuestos_producto();

    const total = new Decimal(subtotal).plus(impuestoTotal).toDecimalPlaces(5).toNumber();

    //Colocar el total en el campo .totalValue
    form.find(".totalValue").val(total);

    if (unit == false) {
        //Calcular el valor unitario
        calcular_valor_unitario(elemento);
    }
}

function calcular_con_precio_venta(elemento = "", salePrice = 0) {
    const form = $("#" + elemento);

    let taxValue = 0;

    console.log("Precio de venta: " + salePrice);

    if (salePrice != null && salePrice > 0) {
        //Colocar el valor de venta en el elemento salePrice
        form.find(".totalValue").val(salePrice);
    } else {
        //Obtener el valor de venta del elemento salePrice
        salePrice = form.find(".totalValue").val();
    }

    if (isNaN(salePrice) || salePrice == "") {
        salePrice = 0;

        form.find(".totalValue").val(salePrice);
    }

    let taxPercentage = contar_porcentaje_impuesto(elemento);

    console.log("Porcentaje de impuesto: " + taxPercentage);

    salePrice = new Decimal(salePrice);

    if (taxPercentage > 0) {
        taxPercentage = new Decimal(taxPercentage).dividedBy(100).plus(1).toDecimalPlaces(5).toNumber();

        console.log("Porcentaje de impuesto total: " + taxPercentage);

        taxValue = salePrice.minus(salePrice.dividedBy(taxPercentage)).toDecimalPlaces(5).toNumber();
    }

    console.log("Valor del impuesto total: " + taxValue);

    const subtotal = new Decimal(salePrice).minus(taxValue).toDecimalPlaces(5).toNumber();

    form.find(".subtotal").val(subtotal);

    let discountPercentage = contarPorcentajeDescuentos(elemento);

    console.log("Porcentaje de descuento: " + discountPercentage);

    let netValue = subtotal;

    if (discountPercentage > 0) {
        discountPercentage = new Decimal(discountPercentage).dividedBy(100).toDecimalPlaces(5).toNumber();

        console.log("Porcentaje de descuento total: " + discountPercentage);

        const totalDiscount = new Decimal(subtotal).times(discountPercentage).toDecimalPlaces(5).toNumber();

        netValue = new Decimal(subtotal).minus(totalDiscount).toDecimalPlaces(5).toNumber();
    }

    form.find(".netValue").val(netValue);

    calcular_descuentos_producto();

    //Calcular el valor del impuesto
    calcular_impuestos_producto();

    //Calcular el valor unitario
    calcular_valor_unitario(elemento);
}

function calcular_con_unitario(elemento = "") {
    const form = $("#" + elemento);

    const quantity = form.find(".quantity").val();
    const unitPrice = form.find(".unitPrice").val();

    let netValue = new Decimal(quantity).times(unitPrice).toDecimalPlaces(5).toNumber();

    form.find(".netValue").val(netValue);

    calcular_valor_producto(elemento, netValue, true);
}

function calcular_valor_unitario(elemento = "") {
    const form = $("#" + elemento);

    let quantity = form.find(".quantity").val();

    if (quantity == "" || quantity == 0) {
        quantity = 1;

        form.find(".quantity").val(quantity);
    }

    if (quantity > 1) {
        form.find(".isPackaged").prop("checked", true);

        showPackagingInfo(form.find(".isPackaged"));
    }

    let salePrice = form.find(".netValue").val();

    if (isNaN(salePrice) || salePrice == "") {
        salePrice = 0;
    }

    let unitPrice = new Decimal(salePrice).dividedBy(quantity).toDecimalPlaces(5).toNumber();

    //Colocar el valor unitario en el elemento unitPrice
    form.find(".unitPrice").val(unitPrice, 5);
}

function calcular_valor_final(elemento = "") {
    const form = $("#" + elemento);

    let subtotal = 0;

    let valor_total = 0;

    let valor_impuesto = 0;

    let porcentaje_impuesto = 0;

    //Calcular el valor del descuento
    calcular_descuentos_producto();

    subtotal = form.find(".subtotal").val();

    porcentaje_impuesto = contar_porcentaje_impuesto(elemento);

    valor_impuesto = new Decimal(subtotal).times(porcentaje_impuesto).dividedBy(100).toDecimalPlaces(5).toNumber();

    //valor_impuesto = valor_impuesto.toFixed(2);

    //Colocar el valor del impuesto en el campo .taxValue
    form.find(".taxValue").val(formato_moneda(valor_impuesto, 5));

    valor_total = new Decimal(subtotal).plus(valor_impuesto).toDecimalPlaces(5).toNumber();

    //    valor_total = valor_total.toFixed(2);

    //Colocar el valor total en el campo .totalValue
    form.find(".totalValue").val(valor_total, 5);
}
