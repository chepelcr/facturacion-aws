var lineas_referencia_activas = 1;

function aumentar_linea_referencia(linea_actual) {
    //Incrementar el numero de lineas activas
    linea_actual++;

    //Obtener la ultima linea de referencia del documento activo
    referenceLine = $("#" + factura_activa).find(".referenceLine").last();

    //Agregar el valor a los botones de acciones
    $(referenceLine).find(".eliminarLinea").val(linea_actual);

    return referenceLine;
}

/**Eliminar una linea de referencia */
function eliminar_referencia(boton_eliminar) {
    var linea = $(boton_eliminar).parents(".referenceLine");

    $(linea).remove();

    //Si solamente queda una linea de referencia
    if ($("#" + factura_activa).find(".referenceLine").length == 1) {
        $('#' + factura_activa).find(".btn-dlt").attr('disabled', true);
    }

    contarReferencias();
}

/** Agregar una linea de referencia */
function agregar_referencia() {
    //Contar la cantidad de lineas de referencia en el documento
    var lineas_referencia_activas = $('#' + factura_activa).find(".referenceLine").length;

    if (lineas_referencia_activas < 10) {
        //Agregar un clone de la ultima linea de la factura, en la tabla de detalles del documento
        $('#' + factura_activa).find('.documentReferences').append(
            $('#' + factura_activa).find(".referenceLine").last().clone());

        //Aumentar el numero de lineas
        linea = aumentar_linea_referencia(lineas_referencia_activas);

        //Vaciar todos los campos de la linea
        $(linea).find("input, select").prop('value', "");

        /**Colocar los valores en '' */
        $(linea).find(".key").val('');
        $(linea).find(".reason").val('');
        $(linea).find(".date").val('');
        $(linea).find(".documentType").val('');
        $(linea).find(".code").val('');

        //Activar el boton de eliminar de todas las lineas
        $('#' + factura_activa).find(".btn-dlt").prop('disabled', false);

        contarReferencias();
    }

    else {
        mensajeAutomatico('Atencion', 'Solo se pueden agregar 10 referencias', 'info');
    }
}


function contarReferencias() {
    var cantidad_referencias = 0;

    $('#' + factura_activa).find('.documentReferences').find('.referenceLine').each(function () {
        var inputs = $(this).find('input, select');

        inputs.each(function (index, input) {
            if ($(input).attr('name') != undefined) {
                //Obtener el nombre del input
                const name = $(input).attr("name");

                const newLineNumber = cantidad_referencias;

                const newFieldName = name.replace(/references\[\d+\]/, `references[${newLineNumber}]`);

                //Asignar el nuevo nombre al input
                $(input).attr("name", newFieldName);
            }
        });

        cantidad_referencias++;
    });

    return cantidad_referencias;
}