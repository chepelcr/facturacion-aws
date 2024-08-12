var lineas_referencia_activas = 1;

function aumentar_linea_referencia(linea_actual) {
    //Incrementar el numero de lineas activas
    linea_actual++;

    //Obtener la ultima linea de referencia del documento activo
    linea_referencia = $("#" + factura_activa).find(".linea_referencia").last();

    //Agregar el valor a los botones de acciones
    $(linea_referencia).find(".eliminarLinea").val(linea_actual);

    return linea_referencia;
}

/**Eliminar una linea de referencia */
function eliminar_referencia(boton_eliminar) {
    var linea = $(boton_eliminar).parents(".linea_referencia");

    $(linea).remove();

    //Si solamente queda una linea de referencia
    if ($("#" + factura_activa).find(".linea_referencia").length == 1) {
        $('#' + factura_activa).find(".eliminarLineaReferencia").attr('disabled', true);
    }
}

/** Agregar una linea de referencia */
function agregar_referencia() {
    //Contar la cantidad de lineas de referencia en el documento
    var lineas_referencia_activas = $('#' + factura_activa).find(".linea_referencia").length;

    if (lineas_referencia_activas < 10) {
        //Agregar un clone de la ultima linea de la factura, en la tabla de detalles del documento
        $('#' + factura_activa).find('.tblDetalleReferencias').append(
            $('#' + factura_activa).find(".linea_referencia").last().clone());

        //Aumentar el numero de lineas
        linea = aumentar_linea_referencia(lineas_referencia_activas);

        //Vaciar todos los campos de la linea
        $(linea).find("input, select").prop('value', "");

        /**Colocar los valores en '' */
        $(linea).find(".clave").val('');
        $(linea).find(".razon").val('');
        $(linea).find(".fecha").val('');
        $(linea).find(".tipo_documento").val('01');
        $(linea).find(".codigo").val('');

        //Activar el boton de eliminar de todas las lineas
        $('#' + factura_activa).find(".eliminarLineaReferencia").prop('disabled', false);
    }

    else {
        mensajeAutomatico('Atencion', 'Solo se pueden agregar 10 referencias', 'info');
    }
}