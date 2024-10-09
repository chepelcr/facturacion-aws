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
    $(document).on("change keyup", ".salePrice", function () {
        //Validar si el salePrice es un numero
        if (isNaN($(this).val()) || $(this).val() == "") {
            $(this).val(0);
        }

        if ($(this).val() != 0) {
            let salePrice = $(this).val();

            if (salePrice.charAt(0) == "0") {
                salePrice = salePrice.substring(1);
                $(this).val(salePrice);
            }
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
        calcular_valor_unitario(form_activo);
    }); //Fin de cambiar la cantidad
});

function calcular_valor_producto(elemento = "") {
    const form = $("#" + elemento);
    /**Valor unitario del producto */
    let netValue = form.find(".netValue").val();

    //Si el netValue no son numeros, colocar 0
    if (isNaN(netValue) || netValue == "") {
        netValue = 0;
    }

    let valor_total = 0;

    //Calcular el valor del impuesto
    const valor_impuesto = calcular_impuestos_producto();
    //valor_impuesto = parseFloat(valor_impuesto);

    //Calcular el valor total (variable double, dos decimales)
    /*valor_total = parseFloat(netValue) + parseFloat(valor_impuesto);
    valor_total = parseFloat(valor_total);*/

    valor_total = new Decimal(netValue).plus(valor_impuesto).toDecimalPlaces(3).toNumber();

    //valor_total = valor_total.toFixed(2);

    //Mostrar el valor total
    form.find(".salePrice").val(valor_total);

    //Calcular el valor unitario
    calcular_valor_unitario(elemento);

    //Calcular el valor final
    calcular_valor_final(elemento);
}

function calcular_con_precio_venta(elemento = "", salePrice = 0) {
    const form = $("#" + elemento);

    let taxValue = 0;

    if (salePrice != null && salePrice > 0) {
        //Colocar el valor de venta en el elemento salePrice
        form.find(".salePrice").val(salePrice);
    } else {
        //Obtener el valor de venta del elemento salePrice
        salePrice = form.find(".salePrice").val();
    }

    if (isNaN(salePrice) || salePrice == "") {
        salePrice = 0;

        form.find(".salePrice").val(salePrice);
    }

    let taxPercentage = contar_porcentaje_impuesto(elemento);

    console.log("Porcentaje de impuesto: " + taxPercentage);

    /*var valorImpuesto = salePrice - salePrice / (porcentaje_impuesto / 100 + 1);

    var netValue = salePrice - valorImpuesto;

    //Colocar el valor neto
    netValue = parseFloat(netValue);
    netValue = netValue.toFixed(2);*/

    salePrice = new Decimal(salePrice);

    if (taxPercentage > 0) {
        taxPercentage = new Decimal(taxPercentage).dividedBy(100).plus(1).toDecimalPlaces(3).toNumber();

        console.log("Porcentaje de impuesto total: " + taxPercentage);

        taxValue = salePrice.minus(salePrice.dividedBy(taxPercentage)).toDecimalPlaces(3).toNumber();
    }

    console.log("Valor del impuesto total: " + taxValue);
    //new Decimal(salePrice).dividedBy(new Decimal(porcentaje_impuesto).dividedBy(100).plus(1)).toNumber();

    const netValue = new Decimal(salePrice).minus(taxValue).toDecimalPlaces(3).toNumber();

    form.find(".netValue").val(netValue);

    //Calcular el valor del impuesto
    calcular_impuestos_producto();

    //Calcular el valor unitario
    calcular_valor_unitario(elemento);

    //Calcular el valor final
    calcular_valor_final(elemento);
}

function calcular_valor_unitario(elemento = "") {
    const form = $("#" + elemento);

    let quantity = form.find(".quantity").val();

    if (quantity == "" || quantity == 0) {
        quantity = 1;

        form.find(".quantity").val(quantity);
    }

    let salePrice = form.find(".salePrice").val();

    if (isNaN(salePrice) || salePrice == "") {
        salePrice = 0;
    }

    /*salePrice = parseFloat(salePrice);

    let unitPrice = salePrice / quantity;

    unitPrice = parseFloat(unitPrice);*/

    let unitPrice = new Decimal(salePrice).dividedBy(quantity).toDecimalPlaces(3).toNumber();

    //Colocar el valor unitario en el elemento unitPrice
    form.find(".unitPrice").val(formato_moneda(unitPrice, 3));
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

    //Calcular el valor del impuesto
    /*valor_impuesto = (subtotal * porcentaje_impuesto) / 100;

    valor_impuesto = parseFloat(valor_impuesto);*/

    valor_impuesto = new Decimal(subtotal).times(porcentaje_impuesto).dividedBy(100).toDecimalPlaces(3).toNumber();

    //valor_impuesto = valor_impuesto.toFixed(2);

    //Colocar el valor del impuesto en el campo .taxValue
    form.find(".taxValue").val(formato_moneda(valor_impuesto, 3));

    //Calcular el valor total (variable double, dos decimales)
    /*valor_total = parseFloat(subtotal) + parseFloat(valor_impuesto);
    valor_total = parseFloat(valor_total);*/

    valor_total = new Decimal(subtotal).plus(valor_impuesto).toDecimalPlaces(3).toNumber();

//    valor_total = valor_total.toFixed(2);

    //Colocar el valor total en el campo .totalValue
    form.find(".totalValue").val(formato_moneda(valor_total, 3));
}
