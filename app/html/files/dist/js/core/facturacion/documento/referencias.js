var lineas_referencia_activas = 1;

function aumentar_linea_referencia(linea_actual) {
    //Incrementar el numero de lineas activas
    linea_actual++;
    const activeDocument = $("#" + factura_activa);

    //Obtener la ultima linea de referencia del documento activo
    const referenceLine = activeDocument.find(".referenceLine").last();

    //Agregar el valor a los botones de acciones
    $(referenceLine).find(".eliminarLinea").val(linea_actual);

    return referenceLine;
}

/**Eliminar una linea de referencia */
function eliminar_referencia(boton_eliminar) {
    var linea = $(boton_eliminar).parents(".referenceLine");
    const activeDocument = $("#" + factura_activa);

    $(linea).remove();

    //Si solamente queda una linea de referencia
    if (activeDocument.find(".referenceLine").length == 1) {
        activeDocument.find(".btn-dlt").attr("disabled", true);
    }

    contarReferencias();
}

/** Agregar una linea de referencia */
function agregar_referencia() {
    const activeDocument = $("#" + factura_activa);
    
    //Contar la cantidad de lineas de referencia en el documento
    lineas_referencia_activas = contarReferencias();

    if (lineas_referencia_activas < 10) {
        const documentReferences = activeDocument.find(".documentReferences");
        let lastReferenceLine = documentReferences.find(".referenceLine").last();

        //Agregar una nueva linea de referencia
        documentReferences.append(lastReferenceLine.clone());

        //Agregar un clone de la ultima linea de la factura, en la tabla de detalles del documento
        //activeDocument.find(".documentReferences").append(activeDocument.find(".referenceLine").last().clone());

        const newReferenceLine = activeDocument.find(".referenceLine").last();

        //Aumentar el numero de lineas
        //linea = aumentar_linea_referencia(lineas_referencia_activas);

        //Vaciar todos los campos de la linea
        $(newReferenceLine).find("input, select").prop("value", "");

        /**Colocar los valores en '' */
        $(newReferenceLine).find(".key").val("");
        $(newReferenceLine).find(".reason").val("");
        $(newReferenceLine).find(".date").val("");
        $(newReferenceLine).find(".documentType").val("");
        $(newReferenceLine).find(".code").val("");

        //Activar el boton de eliminar de todas las lineas
        //activeDocument.find(".btn-dlt").prop("disabled", false);

        contarReferencias();
    } else {
        mensajeAutomatico("Atencion", "Solo se pueden agregar 10 referencias", "info");
    }
}

function contarReferencias() {
    var cantidad_referencias = 0;
    const activeDocument = $("#" + factura_activa);

    activeDocument
        .find(".documentReferences")
        .find(".referenceLine")
        .each(function () {
            var inputs = $(this).find("input, select");

            inputs.each(function (index, input) {
                if ($(input).attr("name") != undefined) {
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

function validarReferencias() {
    const activeDocument = $("#" + factura_activa);
    const references = activeDocument
        .find(".documentReferences")
        .find(".referenceLine");

    let isComplete = true;

    //Recorrer las lineas de referencia
    references.each(function (index, reference) {
        let hasData = false;

        //Obtener los inputs de la linea
        const referenceType = $(reference).find(".referenceType");
        const referenceNumber = $(reference).find(".key");
        const referenceDate = $(reference).find(".date");
        const referenceCode = $(reference).find(".code");
        const referenceReason = $(reference).find(".reason");

        //Validar si todos estan vacios
        if (
            $(referenceType).val() == "" &&
            $(referenceNumber).val() == "" &&
            $(referenceDate).val() == "" &&
            $(referenceCode).val() == "" &&
            $(referenceReason).val() == ""
        ) {
            //isComplete = false;

            //Elminar el borde rojo de los inputs
            $(reference).find(".inp-fct-ref").removeClass("border border-danger");
        } else {
            //Validar si el tipo de referencia esta vacio
            if ($(referenceType).val() == "") {
                //Agregar borde rojo al input
                $(referenceType).addClass("border border-danger");

                isComplete = false;
            } else {
                //Eliminar borde rojo del input
                $(referenceType).removeClass("border border-danger");
            }

            //Validar si el numero de referencia esta vacio
            if ($(referenceNumber).val() == "") {
                //Agregar borde rojo al input
                $(referenceNumber).addClass("border border-danger");

                isComplete = false;
            } else {
                //Eliminar borde rojo del input
                $(referenceNumber).removeClass("border border-danger");
            }

            //Validar si la fecha de referencia esta vacia
            if ($(referenceDate).val() == "") {
                //Agregar borde rojo al input
                $(referenceDate).addClass("border border-danger");

                isComplete = false;
            } else {
                //Eliminar borde rojo del input
                $(referenceDate).removeClass("border border-danger");
            }

            //Validar si el codigo de referencia esta vacio
            if ($(referenceCode).val() == "") {
                //Agregar borde rojo al input
                $(referenceCode).addClass("border border-danger");

                isComplete = false;
            } else {
                //Eliminar borde rojo del input
                $(referenceCode).removeClass("border border-danger");
            }

            //Validar si la razon de referencia esta vacia
            if ($(referenceReason).val() == "") {
                //Agregar borde rojo al input
                $(referenceReason).addClass("border border-danger");

                isComplete = false;
            } else {
                //Eliminar borde rojo del input
                $(referenceReason).removeClass("border border-danger");
            }
        }
    });

    if(isComplete){
        activeDocument.find(".btt-aceptar-ref").prop("disabled", false);
    } else {
        activeDocument.find(".btt-aceptar-ref").prop("disabled", true);
    }
}

$(document).ready(function () {
    $(document).on("keyup change", ".inp-fct-ref", function () {
        validarReferencias();
    });
});
