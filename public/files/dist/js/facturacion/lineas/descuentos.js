/**Contar las lineas de descuento de la linea activa */
function contar_lineas_descuento(linea = null) {
    var lineas = 0;
    
    if(linea_activa!=null)
    {
        lineas = linea.find(".tabla_descuentos").find(".linea_descuento").length;
    }

    return lineas;
}

/**Agregar una linea de descuento en la linea activa */
function agregar_descuento(boton) {
    var linea_activa = $(boton).closest(".linea");

    var cantidad_lineas = contar_lineas_descuento(linea_activa);



    //Si ya hay 5 lineas de descuento, mostrar un mensaje de error
    if (cantidad_lineas >= 5) {
        notificacion('Solo se pueden agregar 5 descuentos por linea de detalle.','', 'warning');
        return;
    }

    //Obtener la tabla de descuentos de la linea activa
    var table_descuentos = linea_activa.find(".tabla_descuentos");

    //Obtener la ultima linea de descuento de la tabla
    var ultima_linea = table_descuentos.find(".linea_descuento").last();

    //Si la ultima linea tiene un descuento de 0, no se puede agregar otra linea
    if (ultima_linea.find(".descuento").val() == 0) {
        notificacion('No se puede agregar un descuento si el anterior es 0.','', 'warning');
        return;
    }

    //Clonar la ultima linea de descuento
    var nueva_linea = ultima_linea.clone();

    nueva_linea.find(".motivo").val("");
    nueva_linea.find(".descP").val(0);
    nueva_linea.find(".descVL").val(formato_moneda(0));
    nueva_linea.find(".descuento").val(0);

    //Agregar la nueva linea a la tabla
    table_descuentos.append(nueva_linea);

    //Activar los btn-dlt de la tabla
    table_descuentos.find(".btn-dlt").attr("disabled", false);
    
}//Fin del metodo agregar_descuento

/**Eliminar un descuento de la tabla */
function eliminar_descuento(boton) {
    var linea_descuento = $(boton).closest(".linea_descuento");

    //Si es la ultima linea de descuento en la tabla_descuentos padre, deshabilitar el boton
    if (linea_descuento.siblings(".linea_descuento").length == 0) {
        linea_descuento.closest(".tabla_descuentos").find(".btn-dlt").attr("disabled", true);

        //Colocar el valor de los descuentos a cero
        linea_descuento.find(".descuento").val(0);
        linea_descuento.find(".descVL").val(formato_moneda(0));

        linea_descuento.find(".motivo").val("");
        linea_descuento.find(".descP").val(0);
    }//Fin de la validacion de si es la ultima linea

    //Eliminar la linea de descuento
    else
        linea_descuento.remove();

    calcular(linea_activa);
}//Fin del metodo eliminar_descuento

/** Calcular el valor de los descuentos de una linea de detalle */
function calcular_descuentos(linea_detalle = null) {
    var descuento_total = 0;

    if (linea_detalle != null) {
        var descuento = 0;

        var neto = linea_detalle.find(".neto").val();
        var tabla_descuentos = linea_detalle.find(".tabla_descuentos");

        tabla_descuentos.find(".linea_descuento").each(function (i, linea_descuento) {
            descuento = calcular_descuento(linea_descuento, neto - descuento_total);
            descuento_total += descuento;
        });

        //Si el descuento es 0 y solo hay una linea de descuento, desactivar el btn-dlt
        if (descuento_total == 0 && tabla_descuentos.find(".linea_descuento").length == 1) {
            tabla_descuentos.find(".btn-dlt").attr("disabled", true);
        }
        else {
            tabla_descuentos.find(".btn-dlt").attr("disabled", false);
        }

        //Colocar el valor total de los descuentos
        $(linea_detalle).find(".descM").val(descuento_total);
        $(linea_detalle).find(".descuentoVL").val(formato_moneda(descuento_total));
    }//Fin de validacion de linea

    return descuento_total;
}//Fin del metodo calcular_descuento

/**Calcular el descuento de una linea */
function calcular_descuento(linea_descuento = null) {
    var descuento = 0;
    var total_descuento = 0;

    if (linea_descuento != null) {
        var descP = parseInt($(linea_descuento).find(".descP").val());;

        if (descP > 0) {
            //Obtener el valor neto de la linea
            var neto = linea_activa.find(".neto").val();

            //Calcular el descuento
            descuento = (descP * neto) / 100;

            //Redondear el descuento
            descuento = Math.round(descuento);
        }

        //Colocar el descuento en la linea de descuento
        $(linea_descuento).find(".descVL").val(formato_moneda(descuento));
        $(linea_descuento).find(".descuento").val(descuento);

        //Obtener el total de los descuentos
        total_descuento = $(linea_activa).find(".descM").val();

        //Si el total de los descuentos es 0 o esta vacio
        if (total_descuento == 0 || total_descuento == "") {
            //Colocar el total de los descuentos
            $(linea_activa).find(".descM").val(descuento);
            $(linea_activa).find(".descuentoVL").val(formato_moneda(descuento));
        } else {
            //Sumar el total de los descuentos
            total_descuento = parseInt(total_descuento + descuento);

            //Colocar el total de los descuentos
            $(linea_activa).find(".descM").val(total_descuento);
            $(linea_activa).find(".descuentoVL").val(formato_moneda(total_descuento));
        }
    }//Fin de validacion de linea

    return descuento;
}//Fin del metodo calcular_descuento