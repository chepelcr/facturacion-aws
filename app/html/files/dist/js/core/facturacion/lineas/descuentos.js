/**Contar las lineas de descuento de la linea activa */
function contar_lineas_descuento(linea) {
    var lineas = 0;

    if (linea != null) {
        linea.find(".discounts").find(".discountLine").each(function () {
            
            var inputs = $(this).find("input");

            //Recorrer los inputs de la nueva linea
            inputs.each(function (index, input) {
                if ($(input).attr("name") != undefined) {

                    //Obtener el nombre del input
                    const name = $(input).attr("name");

                    const newLineNumber = lineas;

                    const newFieldName = name.replace(/\[discounts\]\[\d+\]/, `[discounts][${newLineNumber}]`);

                    //Asignar el nuevo nombre al input
                    $(input).attr("name", newFieldName);
                }
            });

            //Incrementar la cantidad de lineas
            lineas++;
        });
    }

    return lineas;
}

/**Agregar una linea de descuento en la linea activa */
function agregar_descuento(boton = null, linea = null) {
    if (boton != null) {
        linea = $(boton).closest(".detail");
    } else if (linea != null) {
        linea = linea;
    }

    var cantidad_lineas = $(linea).find(".discounts").find(".discountLine").length;

    //Si ya hay 5 lineas de descuento, mostrar un mensaje de error
    if (cantidad_lineas >= 5) {
        notificacion('Solo se pueden agregar 5 descuentos por linea de detalle.', '', 'warning');
        return;
    }

    //Obtener la tabla de descuentos de la linea activa
    var table_descuentos = $(linea).find(".discounts");

    //Obtener la ultima linea de descuento de la tabla
    var ultima_linea = table_descuentos.find(".discountLine").last();

    //Si la ultima linea tiene un descuento de 0, no se puede agregar otra linea
    if (ultima_linea.find(".discount_amount").val() == 0) {
        notificacion('No se puede agregar un descuento si el anterior es 0.', '', 'warning');
        return;
    }

    //Clonar la ultima linea de descuento
    var nueva_linea = ultima_linea.clone();

    nueva_linea = limpiar_linea_descuento(nueva_linea);

    //Agregar la nueva linea a la tabla
    table_descuentos.append(nueva_linea);

    contar_lineas_descuento(linea);

    //Activar los btn-dlt de la tabla
    table_descuentos.find(".btn-dlt").attr("disabled", false);

    return nueva_linea;

}//Fin del metodo agregar_descuento

function limpiar_linea_descuento(linea) {
    //Limpiar los campos de la linea de descuento
    linea.find(".discount_reason").val("");
    linea.find(".discount_percentage").val(0);
    linea.find(".discount_amount_money").val(formato_moneda(0));
    linea.find(".discount_amount").val(0);

    return linea;

}

/**Eliminar un descuento de la tabla */
function eliminar_descuento(boton) {
    var discountLine = $(boton).closest(".discountLine");
    var linea_activa = $(boton).closest(".detail");

    //Si es la ultima linea de descuento en la discounts padre, deshabilitar el boton
    if (discountLine.siblings(".discountLine").length == 0) {
        discountLine.closest(".discounts").find(".btn-dlt").attr("disabled", true);

        limpiar_linea_descuento(discountLine);
    } else {
        discountLine.remove();
    }

    contar_lineas_descuento(linea_activa);

    calcular(linea_activa);
}//Fin del metodo eliminar_descuento

/**
 * Elmiminar los descuentos de una linea
 * @param {*} linea 
 */
function eliminarDescuentosLinea(linea) {
    //Validar si hay mas de una linea de descuento
    if (linea.find(".discounts").find(".discountLine").length > 1) {
        //Eliminar las lineas de descuento
        linea.find(".discounts").find(".discountLine").not(":first").remove();
    }

    //Limpiar la linea de descuento
    limpiar_linea_descuento(linea.find(".discounts").find(".discountLine").first());
}

/**
 * Agregar un descuento a una linea de descuento
 * @param {*} discountLine 
 * @param {*} descuento 
 */
function agregar_descuento_linea(discountLine, descuento = null) {
    if (descuento != null) {
        discountLine.find(".discount_reason").val(descuento.reason);
        discountLine.find(".discount_percentage").val(descuento.percentage);
    }
}

function agregar_descuentos(linea_detalle = null, descuentos = []) {
    if (linea_detalle != null) {
        var table_descuentos = linea_detalle.find(".discounts");
        var discountLine = table_descuentos.find(".discountLine").first();

        //Eliminar las lineas de descuento
        //table_descuentos.find(".discountLine").not(":first").remove();

        for (var i = 0; i < descuentos.length; i++) {
            var descuento = descuentos[i];

            if (i == 0) {
                agregar_descuento_linea(discountLine, descuento);
            } else {
                discountLine = agregar_descuento(discountLine);
                agregar_descuento_linea(discountLine, descuento);
            }
        }
    }
}



/** Calcular el valor de los descuentos de una linea de detalle */
function calcular_descuentos(linea_detalle = null) {
    var descuento_total = 0;

    if (linea_detalle != null) {
        var descuento = 0;

        var neto = linea_detalle.find(".neto").val();
        var discounts = linea_detalle.find(".discounts");

        discounts.find(".discountLine").each(function (i, discountLine) {
            descuento = calcular_descuento(discountLine, neto - descuento_total);
            descuento_total += descuento;
        });

        //Si el descuento es 0 y solo hay una linea de descuento, desactivar el btn-dlt
        if (descuento_total == 0 && discounts.find(".discountLine").length == 1) {
            discounts.find(".btn-dlt").attr("disabled", true);
        }
        else {
            discounts.find(".btn-dlt").attr("disabled", false);
        }

        //Colocar el valor total de los descuentos
        $(linea_detalle).find(".total_discount").val(descuento_total);
        $(linea_detalle).find(".total_discount_money").val(formato_moneda(descuento_total, 2));
    }//Fin de validacion de linea

    return descuento_total;
}//Fin del metodo calcular_descuento

/**Calcular el descuento de una linea */
function calcular_descuento(discountLine = null) {
    var descuento = 0;
    var total_descuento = 0;

    if (discountLine != null) {
        var discount_percentage = parseInt($(discountLine).find(".discount_percentage").val());

        if (discount_percentage > 0) {
            //Obtener el valor neto de la linea
            var neto = linea_activa.find(".neto").val();

            //Calcular el descuento
            descuento = (discount_percentage * neto) / 100;

            //Redondear el descuento
            descuento = parseFloat(descuento);
        }

        //Colocar el descuento en la linea de descuento
        $(discountLine).find(".discount_amount_money").val(formato_moneda(descuento, 2));
        $(discountLine).find(".discount_amount").val(descuento);

        //Obtener el total de los descuentos
        total_descuento = $(linea_activa).find(".total_discount").val();

        //Si el total de los descuentos es 0 o esta vacio
        if (total_descuento == 0 || total_descuento == "") {
            //Colocar el total de los descuentos
            $(linea_activa).find(".total_discount").val(descuento);
            $(linea_activa).find(".total_discount_money").val(formato_moneda(descuento, 2));
        } else {
            //Sumar el total de los descuentos
            total_descuento = parseFloat(total_descuento + descuento);

            //Colocar el total de los descuentos
            $(linea_activa).find(".total_discount").val(total_descuento);
            $(linea_activa).find(".total_discount_money").val(formato_moneda(total_descuento, 2));
        }
    }//Fin de validacion de linea

    return descuento;
}//Fin del metodo calcular_descuento