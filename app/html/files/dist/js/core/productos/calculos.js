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

    //Cuando cambia calcular-producto
    $(document).on("change keyup", ".calcular-producto", function () {
        //Validar si el salePrice es un numero
        let salePrice = $("#" + form_activo)
            .find(".salePrice")
            .val();

        if (isNaN(salePrice) || salePrice == "") {
            $("#" + form_activo)
                .find(".salePrice")
                .val(0);
        }

        calcular_con_precio_venta(form_activo);
    }); //Fin de cambiar calcular-producto

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

    let valor_impuesto = 0;

    //Calcular el valor del impuesto
    valor_impuesto = calcular_impuestos_producto();
    valor_impuesto = parseFloat(valor_impuesto);

    //Calcular el valor total (variable double, dos decimales)
    valor_total = parseFloat(netValue) + parseFloat(valor_impuesto);
    valor_total = parseFloat(valor_total);

    valor_total = valor_total.toFixed(2);

    var quantity = form.find(".quantity").val();

    if (quantity == "" || quantity == 0) {
        quantity = 1;

        form.find(".quantity").val(quantity);
    }

    var unitPrice = valor_total / quantity;

    unitPrice = parseFloat(unitPrice);

    //Colocar el valor unitario en el elemento unitPrice
    form.find(".unitPrice").val(formato_moneda(unitPrice, 2));

    //Mostrar el valor total
    form.find(".salePrice").val(valor_total);

    calcular_valor_final(elemento);
}

function calcular_con_precio_venta(elemento = "", salePrice = 0) {
    const form = $("#" + elemento);
    if (salePrice != null && salePrice > 0) {
        //Colocar el valor de venta en el elemento salePrice
        form.find(".salePrice").val(salePrice);
    } else {
        //Obtener el valor de venta del elemento salePrice
        salePrice = form.find(".salePrice").val();
    }

    if (isNaN(salePrice) || salePrice == "") {
        salePrice = 0;
    }

    salePrice = parseFloat(salePrice);

    let porcentaje_impuesto = contar_porcentaje_impuesto(elemento);

    var valorImpuesto = salePrice - salePrice / (porcentaje_impuesto / 100 + 1);

    var netValue = salePrice - valorImpuesto;

    var quantity = form.find(".quantity").val();

    if (quantity == "" || quantity == 0) {
        quantity = 1;

        form.find(".quantity").val(quantity);
    }

    var unitPrice = salePrice / quantity;

    unitPrice = parseFloat(unitPrice);

    //Colocar el valor unitario en el elemento unitPrice
    form.find(".unitPrice").val(formato_moneda(unitPrice, 2));

    //Colocar el valor neto
    netValue = parseFloat(netValue);
    netValue = netValue.toFixed(2);

    form.find(".netValue").val(netValue);

    if (netValue != "" && netValue != 0) {
        //Calcular el valor del impuesto
        calcular_impuestos_producto();

        calcular_valor_final(elemento);
    }
}

function calcular_valor_final(elemento = "") {
    const form = $("#" + elemento);

    let subtotal = 0;

    let valor_total = 0;

    let valor_descuento = 0;

    let valor_impuesto = 0;

    let porcentaje_impuesto = 0;

    //Obtener el descuento
    valor_descuento = calcular_descuentos_producto();
    subtotal = form.find(".subtotal").val();

    porcentaje_impuesto = contar_porcentaje_impuesto(elemento);

    //Calcular el valor del impuesto
    valor_impuesto = (subtotal * porcentaje_impuesto) / 100;

    valor_impuesto = parseFloat(valor_impuesto);

    //Colocar el valor del impuesto en el campo .taxValue
    form.find(".taxValue").val(formato_moneda(valor_impuesto, 2, monedaDocumento));

    //Calcular el valor total (variable double, dos decimales)
    valor_total = parseFloat(subtotal) + parseFloat(valor_impuesto);
    valor_total = parseFloat(valor_total);

    //Colocar el valor total en el campo .totalValue
    form.find(".totalValue").val(formato_moneda(valor_total, 2, monedaDocumento));
}
