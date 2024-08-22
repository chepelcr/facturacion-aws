$(document).ready(function () {
    //Cuando cambia el valor_unitario
    $(document).on('change keyup', '.valor_vX', function () {
        let valor = $(this).val();

        //Si el elemento tiene un simbolo de colones, eliminarlo
        if (valor.indexOf('₡') != -1) {
            valor = valor.replace('₡', '');
        }

        //Colocar el valor del elemento en .valor_unitario del form_activo
        $('#' + form_activo).find(".precio").val(valor);

        calcular_valor_producto(form_activo);
    });//Fin de cambiar el valor_unitario
});

function calcular_valor_producto(elemento = '') {
    /**Valor unitario del producto */
    let valor_unitario = $('#' + elemento).find(".precio").val();

    let valor_total = 0;
    let valor_impuesto = 0;

    if (valor_unitario != '' && valor_unitario != 0) {
        //Obtener porcentaje de impuesto
        var porcentaje_impuesto = $('#' + elemento).find(".category_suggestedTax").val();

        //Calcular el valor del impuesto
        valor_impuesto = (valor_unitario * porcentaje_impuesto) / 100;
        valor_impuesto = parseFloat(valor_impuesto);

        //Calcular el valor total (variable double, dos decimales)
        valor_total = parseFloat(valor_unitario) + parseFloat(valor_impuesto);
        valor_total = parseFloat(valor_total);
    }

    //Mostrar el valor total
    $('#' + elemento).find(".salePrice").val(formato_moneda(valor_total, 2));

    //Colocar el valor total en el elemento precioVenta (sin formato)
    $('#' + elemento).find(".precioVenta").val(valor_total);

    //Mostrar el valor impuesto
    $('#' + elemento).find(".taxValue").val(formato_moneda(valor_impuesto, 2));

    //Colocar el valor unitario en el elemento valor_vX
    $('#' + elemento).find(".valor_vX").val(formato_moneda(valor_unitario, 2));
}