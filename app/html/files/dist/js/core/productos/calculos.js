$(document).ready(function () {
    //Cuando cambia el netValue
    $(document).on("change keyup", ".netValue", function () {
        let valor = $(this).val();

        //Si el elemento tiene un simbolo de colones, eliminarlo
        /*if (valor.indexOf('₡') != -1) {
            valor = valor.replace('₡', '');
        }*/

        //Colocar el valor del elemento en .netValue del form_activo
        //$('#' + form_activo).find(".precio").val(valor);

        calcular_valor_producto(form_activo);
    }); //Fin de cambiar el netValue

    //Cuando cambia calcular-producto
    $(document).on("change keyup", ".calcular-producto", function () {
        calcular_con_precio_venta(form_activo);
    }); //Fin de cambiar calcular-producto

    //Cuando cambia el precio de venta
    $(document).on("change keyup", ".salePrice", function () {
        calcular_con_precio_venta(form_activo);
    }); //Fin de cambiar el precio de venta
});

function calcular_valor_producto(elemento = "") {
    /**Valor unitario del producto */
    let netValue = $("#" + elemento)
        .find(".netValue")
        .val();

    let valor_total = 0;

    let valor_descuento = 0;

    let valor_impuesto = 0;

    if (netValue != "" && netValue != 0) {
        //Obtener el descuento
        valor_descuento = calcular_descuentos_producto();

        //Calcular el valor del impuesto
        valor_impuesto = calcular_impuestos_producto();
        valor_impuesto = parseFloat(valor_impuesto);

        //Calcular el valor total (variable double, dos decimales)
        valor_total = parseFloat(netValue) + parseFloat(valor_impuesto);
        valor_total = parseFloat(valor_total);

        var quantity = $("#" + elemento)
            .find(".quantity")
            .val();
        var unitPrice = valor_total / quantity;
        unitPrice = parseFloat(unitPrice);

        //Colocar el valor unitario en el elemento unitPrice
        $("#" + elemento)
            .find(".unitPrice")
            .val(formato_moneda(unitPrice, 2));
    }

    //Mostrar el valor total
    $("#" + elemento)
        .find(".salePrice")
        .val(valor_total);

    //Mostrar el valor impuesto
    $("#" + elemento)
        .find(".taxValue")
        .val(formato_moneda(valor_impuesto, 2));
}

function calcular_con_precio_venta(elemento = "", salePrice = 0) {
    if (salePrice != null && salePrice > 0) {
        //Colocar el valor de venta en el elemento salePrice
        $("#" + elemento)
            .find(".salePrice")
            .val(salePrice);
    } else {
        //Obtener el valor de venta del elemento salePrice
        salePrice = $("#" + elemento)
            .find(".salePrice")
            .val();
    }

    console.log(salePrice);

    salePrice = parseFloat(salePrice);

    let porcentaje_impuesto = contar_porcentaje_impuesto();

    console.log(porcentaje_impuesto);

    var valorImpuesto = salePrice - salePrice / (porcentaje_impuesto / 100 + 1);

    var netValue = salePrice - valorImpuesto;

    let valor_total = 0;

    let valor_impuesto = 0;

    if (netValue != "" && netValue != 0) {
        //Poner el valor neto solo con dos decimales
        netValue = parseFloat(netValue);
        
        //Eliminar los decimales hasta dos
        netValue = netValue.toFixed(2);

        //Mostrar el valor neto
        $("#" + elemento)
            .find(".netValue")
            .val(netValue);

        //Obtener el descuento
        calcular_descuentos_producto();

        //Calcular el valor del impuesto
        valor_impuesto = calcular_impuestos_producto();
        valor_impuesto = parseFloat(valor_impuesto);

        //Calcular el valor total (variable double, dos decimales)
        valor_total = parseFloat(netValue) + parseFloat(valor_impuesto);
        valor_total = parseFloat(valor_total);

        var quantity = $("#" + elemento)
            .find(".quantity")
            .val();
        var unitPrice = valor_total / quantity;
        unitPrice = parseFloat(unitPrice);

        //Colocar el valor unitario en el elemento unitPrice
        $("#" + elemento)
            .find(".unitPrice")
            .val(formato_moneda(unitPrice, 2));
    }

    //Mostrar el valor impuesto
    $("#" + elemento)
        .find(".taxValue")
        .val(formato_moneda(valor_impuesto, 2));
}
