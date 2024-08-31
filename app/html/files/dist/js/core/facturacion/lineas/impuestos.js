/**Abrir o cerrar el collapse de una linea de impuesto */
function exonerar_impuesto(boton = null) {
    if (boton != null) {
        linea_activa = boton.closest(".detail");

        var linea = $(boton).closest(".taxLine");

        //Abrir o cerrar el collapse de la linea
        if (linea.find(".collapse_impuesto").hasClass("show")) {
            linea.find(".collapse_impuesto").collapse("hide");
        }
        else {
            linea.find(".collapse_impuesto").collapse("show");
        }
    }//Fin del if
}//Fin del metodo exonerar_impuesto

/**Agregar una linea de impuesto a la linea activa */
function agregar_impuesto(boton = null, linea = null) {
    if (boton != null) {
        //Obtener la linea activa
        linea = $(boton).closest(".detail");
    } else if (linea != null) {
        linea = linea;
    }

    if (linea != null) {

        var taxesTable = linea.find(".taxesTable");

        //Obtener la ultima linea de impuesto
        var taxLine = taxesTable.find(".taxLine").last();

        //Si el taxPercentage de la ultima .taxLine no esta vacio ni es 0
        if ((taxLine.find(".taxTypes").val() != "" && taxLine.find(".taxPercentage").val() != "" && taxLine.find(".taxPercentage").val() != 0) || taxesTable.find(".taxRates").val() != "") {

            //Clonar la ultima linea de impuesto
            var nueva_linea = taxLine.clone();

            nueva_linea = limpiar_linea_impuesto(nueva_linea);

            taxesTable.find(".btn-elm").attr("disabled", false);

            //Agregar la nueva linea a la tabla
            taxesTable.append(nueva_linea);

            contar_lineas_impuestos(linea);

            return nueva_linea;
        } else {
            notificacion('No se puede agregar un impuesto si el anterior no se ha definido.', '', 'warning');
            return;
        }
    } else {
        notificacion('No se ha definido la linea de detalle.', '', 'warning');
        return;
    }
}

function limpiar_linea_impuesto(taxLine) {
    //Vaciar los campos .impuesto_txt de la nueva linea input
    taxLine.find(".impuesto_txt").val("");

    //Colocar '' en los select
    taxLine.find("select").val("");

    //Vaciar los campos .impuesto_number
    taxLine.find(".impuesto_number").val(0);

    //Colocar 0 en los campos hide_num
    taxLine.find(".hide_num").val(0);

    //Colocar un 0 con formato en .money_value
    taxLine.find(".money_value").val(formato_moneda(0));

    taxLine.find(".taxRates").attr("disabled", true);

    campos_exoneracion(taxLine, false);

    taxLine.find(".collapse_impuesto").collapse("hide");

    return taxLine;
}

/**Contar la cantidad de lineas de impuestos */
function contar_lineas_impuestos(linea_activa) {
    var taxLines = 0;

    //Obtener la tabla de impuestos
    linea_activa.find(".taxesTable").find(".taxLine").each(function () {

        var inputs = $(this).find("input, select");

        //Recorrer los inputs de la nueva linea
        inputs.each(function (index, input) {
            //Validar si el input tiene nombre
            if ($(input).attr("name") != undefined) {
                //Obtener el nombre del input
                const name = $(input).attr("name");

                const newLineNumber = taxLines;

                const newFieldName = name.replace(/\[taxes\]\[\d+\]/, `[taxes][${newLineNumber}]`);

                //Asignar el nuevo nombre al input
                $(input).attr("name", newFieldName);
            }
        });

        taxLines++;
    });

    return taxLines;
}

/**
 * Elminar los todos los impuestos de una linea de detalle
 * @var linea
 */
function eliminar_impuestos(linea) {
    //Validar si hay mas de una linea de descuento
    if (linea.find(".taxesTable").find(".taxLine").length > 1) {
        //Eliminar las lineas de descuento
        linea.find(".taxesTable").find(".taxLine").not(":first").remove();
    }

    //Limpiar los campos de la linea
    limpiar_linea_impuesto(linea.find(".taxesTable").find(".taxLine").first());
}

/**Activar el porcentaje de una linea de impuesto */
function activar_porcentajes(select) {
    //Obtener la linea de impuesto
    var taxLine = $(select).parents(".taxLine");

    //Obtener el valor data-code del select
    var code = $(select).find("option:selected").data("code");

    //Si el valor del select es '01' o '07' activar el select de taxRates
    if (code == "01" || code == "07") {
        taxLine.find(".taxRates").attr("disabled", false);

        //Activar el campo del porcentaje
        taxLine.find(".taxPercentage").attr("disabled", true);
    } else {
        taxLine.find(".taxRates").attr("disabled", true);
        taxLine.find(".taxRates").val("");

        //Activar el campo del porcentaje
        taxLine.find(".taxPercentage").attr("disabled", false);
    }

    taxLine.find(".taxPercentage").val("");
}

/**Colocar el porcentaje de impuesto en el campo .taxPercentage de la linea de impuesto */
function colocar_tarifa(select = null) {
    if (select != null) {
        //Obtener la linea de impuesto
        var taxLine = $(select).parents(".taxLine");
        var linea_activa = $(select).parents(".detail");

        //Obtener el data-porcentaje del select
        var porcentaje = $(select).find("option:selected").data("percentage");

        //Colocar el porcentaje en el campo .taxPercentage
        taxLine.find(".taxPercentage").val(porcentaje);

        // Desactivar el campo del porcentaje
        taxLine.find(".taxPercentage").attr("disabled", true);

        //Habilitar el boton de eliminar
        taxLine.find(".btn-elm").attr("disabled", false);

        //Calcular la linea activa
        calcular(linea_activa);
    }
}

function agregar_impuesto_linea(taxLine, impuesto) {
    //Obtener el tipo de impuesto
    var type = impuesto.type;

    var taxPercentage = 0;

    //Recorrer los option de .taxTypes
    const taxTypes = taxLine.find(".taxTypes option");

    console.log(taxTypes);

    $.each(taxTypes, function (i, option) {
        //Obtener el data-code del option
        var code = $(option).data("code");

        console.log(code);

        //Si el valor del select es igual al tipo de impuesto
        if (code == type.code) {
            //Marcar el select como seleccionado
            option.selected = true;

            console.log("Seleccionado");

            activar_porcentajes(taxLine.find(".taxTypes"));
        } else {
            option.selected = false;
        }
    });

    if (impuesto.taxRate != null) {
        //Obtener el select de .taxRates
        const taxRates = taxLine.find(".taxRates option");

        //Recorrer los option de .taxRates
        $.each(taxRates, function (i, option) {
            //Obtener el data-code del option
            var value = $(option).data("code");

            //Si el valor del select es igual al tipo de impuesto
            if (value == impuesto.taxRate.code) {
                //Marcar el select como seleccionado
                option.selected = true;

                colocar_tarifa(taxLine.find(".taxRates"));

                taxPercentage = impuesto.taxRate.percentage;
            } else {
                option.selected = false;
            }
        });
    } else {
        taxPercentage = impuesto.taxPercentage;

        //Colocar '' en el taxRates
        taxLine.find(".taxRates").val("");

        //Colocar el porcentaje en el campo .taxPercentage
        taxLine.find(".taxPercentage").val(taxPercentage);
    }

    return taxPercentage;
}

function agregar_impuestos_api(linea_activa, impuestos) {
    //Obtener la tabla de impuestos
    var taxesTable = linea_activa.find(".taxesTable");

    //Obtener la primera linea de impuesto
    var taxLine = taxesTable.find(".taxLine").first();

    var taxPercentage = 0;

    //Recorrer todos los impuestos
    for (var i = 0; i < impuestos.length; i++) {
        var impuesto = impuestos[i];

        if (i == 0) {
            taxPercentage += agregar_impuesto_linea(taxLine, impuesto);
        } else {
            taxLine = agregar_impuesto(null, linea_activa);
            taxPercentage += agregar_impuesto_linea(taxLine, impuesto);
        }
    }

    return taxPercentage;
}

/**Eliminar una linea de impuesto */
function eliminar_impuesto(boton) {
    //Obtener la linea de impuesto
    var taxLine = $(boton).closest(".taxLine");
    var linea_activa = $(taxLine).closest(".detail");

    /*taxLine = $(taxLine);
    linea_activa = $(linea_activa);*/

    //Si es la ultima linea de descuento en la taxes padre, deshabilitar el boton
    if (taxLine.siblings(".taxLine").length == 0) {
        //Colocar los input y select en empty
        limpiar_linea_impuesto(taxLine);

        //Desactivar el boton de eliminar
        taxLine.closest(".taxesTable").find(".btn-elm").attr("disabled", true);
    } else {
        taxLine.remove();
    }

    contar_lineas_impuestos(linea_activa);
    calcular(linea_activa);
}//Fin del metodo eliminar_impuesto

/**Calcular impuestos de una linea de detalle */
function calcular_impuestos(linea_detalle = null) {
    var impuestoTotal = 0;

    if (linea_detalle != null) {
        linea_detalle = $(linea_detalle);

        var subtotal = linea_detalle.find(".subtotal").val();

        //Obtener la tabla de impuestos
        var taxesTable = linea_detalle.find(".taxesTable");

        //Obtener todas las lineas de impuestos
        var lineas_impuestos = taxesTable.find(".taxLine");

        //Recorrer todas las lineas de impuestos
        lineas_impuestos.each(function (index, taxLine) {
            //Calcular el impuesto de la linea
            var impuesto = calcular_impuesto(taxLine, subtotal);

            //Sumar el impuesto a la variable impuestoTotal
            impuestoTotal += impuesto;
        });
    }

    //Colocar el impuesto total en el campo .ivNeto y .ivNetoVL
    linea_detalle.find(".ivNeto").val(impuestoTotal);
    linea_detalle.find(".ivNetoVL").val(formato_moneda(impuestoTotal, 2));

    return impuestoTotal;
}

/**Calcular una linea de impuesto */
function calcular_impuesto(taxLine = null, subtotal = 0) {
    if (taxLine != null) {
        taxLine = $(taxLine);

        var taxPercentage = taxLine.find(".taxPercentage").val();

        var impuesto = subtotal * taxPercentage / 100;

        var porcentajeExoneracion = 0;

        //Buscar si la linea tiene .excemption_percentage y si tiene valor
        if (taxLine.find(".excemption_percentage").length > 0 && taxLine.find(".excemption_percentage").val() != "") {
            porcentajeExoneracion = taxLine.find(".excemption_percentage").val();
        }

        //Si el porcentaje de exoneracion es mayor a 0
        if (porcentajeExoneracion > 0) {
            //Calcular el monto de exoneracion
            var montoExoneracion = subtotal * porcentajeExoneracion / 100;

            //Calcular el impuesto
            impuesto_neto = impuesto - montoExoneracion;

            montoExoneracion = parseFloat(montoExoneracion);
            taxLine.find(".excemption_amount").val(montoExoneracion);
            taxLine.find(".excemption_amount_money").val(formato_moneda(montoExoneracion, 2));

        } else {
            impuesto_neto = impuesto;
        }

        taxLine.find(".tax_amount").val(impuesto);
        taxLine.find(".tax_amount_money").val(formato_moneda(impuesto, 2));

        return impuesto_neto;
    }//Fin de validacion de taxLine
}//Fin del calculo de la linea de impuesto

/**Buscar un numero de exoneracion en el ministerio de hacienda 
 * Formato: AL-00000000-20
*/
function buscar_exoneracion(exoneracion = "", taxLine = null) {
    if (exoneracion != '') {
        //La exoneracion debe tener el formato ^[aA]{1}[lL]{1}-\d{8}-\d{2}$ (AL-00000000-00)
        var patron = /^[aA]{1}[lL]{1}-\d{8}-\d{2}$/;

        if (patron.test(exoneracion)) {
            url = "https://api.hacienda.go.cr/fe/ex?autorizacion=" + exoneracion;

            Pace.track(function () {
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "json",
                }).done(function (data) {
                    //Colocar la fechaEmision en formato yyyy-MM-dd (2020-03-30T00:00:00)
                    var fechaEmision = data.fechaEmision.split("T")[0];

                    //Colocar los datos en los campos correspondientes
                    taxLine.find(".excemption_issueDate").val(fechaEmision);

                    taxLine.find(".excemption_institutionName").val(data.nombreInstitucion);
                    taxLine.find(".excemption_percentage").val(data.porcentajeExoneracion);

                    campos_exoneracion(taxLine, true);
                    activarBotonExoneracion(false, taxLine);

                    calcular(taxLine.parents(".detail"));

                    return;
                }).fail(function (xhr, textStatus, errorThrown) {
                    //Mostrar la respuesta
                    notificacion("No se ha encontrado la autorizacion solicitada", '', 'warning');

                    campos_exoneracion(taxLine, false);
                    activarBotonExoneracion(false, taxLine);
                });
            });
        } else {
            //Habilitar los campos
            campos_exoneracion(taxLine, false);
            activarBotonExoneracion(false, taxLine);
        }
    } else {
        //Habilitar los campos
        campos_exoneracion(taxLine);
        activarBotonExoneracion(true, taxLine);
    }
}

/**Activar o desactivar los campos de exoneracion */
function campos_exoneracion(taxLine = null, existe = false) {
    if (taxLine != null) {
        taxLine = $(taxLine);

        //Activar los campos
        taxLine.find(".excemption_issueDate").attr("readonly", existe);
        taxLine.find(".excemption_institutionName").attr("readonly", existe);
        taxLine.find(".excemption_percentage").attr("readonly", existe);

        taxLine.find(".excemption_issueDate").attr("disabled", existe);
        taxLine.find(".excemption_institutionName").attr("disabled", existe);
        taxLine.find(".excemption_percentage").attr("disabled", existe);
    }
}

function activarBotonExoneracion(estado = false, taxLine = null) {
    if (taxLine != null) {
        taxLine = $(taxLine);

        taxLine.find(".btn-elm-excemption").attr("disabled", estado);
    }
}

function vaciarExoneracion(botonEliminar) {
    taxLine = $(botonEliminar).parents(".taxLine");

    taxLine.find(".excemption_issueDate").val("");
    taxLine.find(".excemption_institutionName").val("");
    taxLine.find(".excemption_percentage").val(0);
    taxLine.find(".excemption_amount").val(0);
    taxLine.find(".excemption_amount_money").val(formato_moneda(0));
    taxLine.find(".excemption_number").val("");

    campos_exoneracion(taxLine, true);
    activarBotonExoneracion(true, taxLine);

    calcular(taxLine.parents(".detail"));
}

//Document Ready
$(document).ready(function () {
    //Cuando sale del campo .excemption_number
    $(document).on("blur", ".excemption_number", function () {
        buscar_exoneracion($(this).val(), $(this).parents(".taxLine"));
    });


    //Cuando cambia el campo .excemption_percentage
    $(document).on("change keyup", ".excemption_percentage", function () {
        //Colocar la fecha en el campo .excemption_percentage

        //Calcular la linea activa
        calcular($(this).parents(".detail"));
    });
});