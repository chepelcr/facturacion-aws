$(document).ready(function () {
    //Cuando cambia el valor_unitario
    $(document).on('change keyup', '.valor_unitario', function () {
        calcular_valor_producto(form_activo);
    });//Fin de cambiar el valor_unitario
});

function calcular_valor_producto(elemento = '')
{
    if(elemento == '')
    {
        elemento = form_activo;
    }

    //Obtener el valor unitario
    var valor_unitario = $('#' + elemento).find(".valor_unitario").val();

    //Activa el campo de impuesto
    activar_campo_clase('impuesto', false, elemento);

    //Obtener porcentaje de impuesto
    var porcentaje_impuesto = $('#' + elemento).find(".impuesto").val();

    //Desactivar el campo de impuesto
    activar_campo_clase('impuesto', true, elemento);

    //Calcular el valor del impuesto
    var valor_impuesto = (valor_unitario * porcentaje_impuesto) / 100;

    valor_impuesto = Math.round(valor_impuesto);

    //Calcular el valor total (variable double, dos decimales)
    var valor_total = parseFloat(valor_unitario) + parseFloat(valor_impuesto);

    valor_total = Math.round(valor_total);

    //Mostrar el valor total
    $('#' + elemento).find(".valor_total").val(valor_total);

    //Mostrar el valor impuesto
    $('#' + elemento).find(".valor_impuesto").val(valor_impuesto);
}