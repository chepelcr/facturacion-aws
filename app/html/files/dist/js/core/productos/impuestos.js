/**Agregar una linea de impuesto a la linea activa */
function agregar_impuesto_producto() {
    const form = $("#" + form_activo);
    var taxesTable = form.find(".taxesTable");

    //Obtener la ultima linea de impuesto
    var taxLine = taxesTable.find(".taxLine").last();

    //Si el taxPercentage de la ultima .taxLine no esta vacio ni es 0
    if (
        (taxLine.find(".taxTypes").val() != "" &&
            taxLine.find(".taxPercentage").val() != "" &&
            taxLine.find(".taxPercentage").val() != 0) ||
        taxesTable.find(".taxRates").val() != ""
    ) {
        //Clonar la ultima linea de impuesto
        var nueva_linea = taxLine.clone();

        nueva_linea = limpiar_impuesto_producto(nueva_linea);

        taxesTable.find(".btn-elm").attr("disabled", false);

        //Agregar la nueva linea a la tabla
        taxesTable.append(nueva_linea);

        contar_impuestos_producto();

        return nueva_linea;
    } else {
        notificacion("No se puede agregar un impuesto si el anterior no se ha definido.", "", "warning");
        return;
    }
}

function limpiar_impuesto_producto(taxLine) {
    //Colocar '' en los select
    taxLine.find("select").val("");

    //Vaciar los campos .taxPercentage
    taxLine.find(".taxPercentage").val(0);

    //Colocar 0 en los campos tax_amount
    taxLine.find(".tax_amount").val(0);

    //Colocar un 0 con formato en .tax_amount_money
    taxLine.find(".tax_amount_money").val(formato_moneda(0));

    activar_porcentajes_producto(taxLine.find(".taxTypes"));

    return taxLine;
}

/**Contar la cantidad de lineas de impuestos */
function contar_impuestos_producto() {
    var taxLines = 0;

    const form = $("#" + form_activo);

    //Obtener la tabla de impuestos
    form.find(".taxesTable")
        .find(".taxLine")
        .each(function () {
            var inputs = $(this).find("input, select");

            //Recorrer los inputs de la nueva linea
            inputs.each(function (index, input) {
                //Validar si el input tiene nombre
                if ($(input).attr("name") != undefined) {
                    //Obtener el nombre del input
                    const name = $(input).attr("name");

                    const newLineNumber = taxLines;

                    const newFieldName = name.replace(/taxes\[\d+\]/, `taxes[${newLineNumber}]`);

                    //Asignar el nuevo nombre al input
                    $(input).attr("name", newFieldName);
                }
            });

            taxLines++;
        });

    return taxLines;
}

/**
 * Elminar los todos los impuestos del formulario
 */
function eliminar_impuestos_producto() {
    const form = $("#" + form_activo);

    //Validar si hay mas de una linea de descuento
    if (form.find(".taxesTable").find(".taxLine").length > 1) {
        //Eliminar las lineas de descuento
        form.find(".taxesTable").find(".taxLine").not(":first").remove();
    }

    //Limpiar los campos de la linea
    limpiar_impuesto_producto(form.find(".taxesTable").find(".taxLine").first());
}

/**Activar el porcentaje de una linea de impuesto */
function activar_porcentajes_producto(select) {
    //Obtener la linea de impuesto
    var taxLine = $(select).parents(".taxLine");

    //Obtener el valor data-code del select
    var code = $(select).find("option:selected").data("code");

    let selectValue = $(select).val();

    validateTaxLines(form_activo);

    taxLine.find(".taxPercentage").val("");
    calcular_valor_producto(form_activo);

    //Si el valor del select es '01' o '07' activar el select de taxRates
    if (code == "01" || code == "07") {
        //Activar el campo del porcentaje
        taxLine.find(".taxPercentage").attr("disabled", true);

        //Recorrer los option de .taxRates y escondelos
        const taxRates = taxLine.find(".taxRates option");

        $.each(taxRates, function (i, option) {
            if ($(option).val() != "") {
                $(option).prop("hidden", false);
            }
        });
    } else {
        //taxLine.find(".taxRates").attr("disabled", true);
        taxLine.find(".taxRates").val("");

        //Activar el campo del porcentaje
        taxLine.find(".taxPercentage").attr("disabled", false);

        //Recorrer los option de .taxRates y escondelos
        const taxRates = taxLine.find(".taxRates option");

        $.each(taxRates, function (i, option) {
            if ($(option).val() != "") {
                $(option).prop("hidden", true);
            }
        });
    }
}

/**Colocar el porcentaje de impuesto en el campo .taxPercentage de la linea de impuesto */
function colocar_tarifa_producto(select = null) {
    if (select != null) {
        //Obtener la linea de impuesto
        var taxLine = $(select).parents(".taxLine");

        //Obtener el data-porcentaje del select
        var porcentaje = $(select).find("option:selected").data("percentage");

        //Colocar el porcentaje en el campo .taxPercentage
        taxLine.find(".taxPercentage").val(porcentaje);

        // Desactivar el campo del porcentaje
        taxLine.find(".taxPercentage").attr("disabled", true);

        //Calcular la linea activa
        calcular_valor_producto(form_activo);
    }
}

function colocar_impuesto(taxLine, impuesto) {
    //Obtener el tipo de impuesto
    var type = impuesto.type;

    var taxPercentage = 0;

    console.log(impuesto);

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

            activar_porcentajes_producto(taxLine.find(".taxTypes"));
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

                colocar_tarifa_producto(taxLine.find(".taxRates"));

                taxPercentage = impuesto.taxRate.percentage;
            } else {
                option.selected = false;
            }
        });
    } else {
        taxPercentage = impuesto.rate;

        //Colocar '' en el taxRates
        taxLine.find(".taxRates").val("");

        //Colocar el porcentaje en el campo .taxPercentage
        taxLine.find(".taxPercentage").val(taxPercentage);
    }

    return taxPercentage;
}

function agregar_impuestos_producto(impuestos) {
    const form = "#" + form_activo;

    //Eliminar los impuestos actuales
    eliminar_impuestos_producto();

    //Obtener la tabla de impuestos
    var taxesTable = $(form).find(".taxesTable");

    //Obtener la primera linea de impuesto
    var taxLine = taxesTable.find(".taxLine").first();

    var taxPercentage = 0;

    //Recorrer todos los impuestos
    for (var i = 0; i < impuestos.length; i++) {
        var impuesto = impuestos[i];

        if (i == 0) {
            taxPercentage += colocar_impuesto(taxLine, impuesto);
        } else {
            taxLine = agregar_impuesto_producto();
            taxPercentage += colocar_impuesto(taxLine, impuesto);
        }
    }

    validateTaxLines(form_activo);

    return taxPercentage;
}

/**
 * Agregar el impuesto sugerido a la linea de impuesto.
 */
function agregar_impuesto_cabys() {
    const form = $("#" + form_activo);

    const impuestoSugerido = form.find(".category_suggestedTax").val();

    //Obtener la tabla de impuestos
    var taxesTable = form.find(".taxesTable");

    var taxLine = null;

    //Si solo hay una linea de impuesto y el taxType no esta seleccionado
    if (taxesTable.find(".taxLine").length == 1 && taxesTable.find(".taxLine").find(".taxTypes").val() == "") {
        taxLine = taxesTable.find(".taxLine").first();
    } else {
        taxesTable.find(".taxLine").each(function (i, line) {
            if ($(line).find(".taxTypes").find("option:selected").data("code") == "01") {
                taxLine = $(line);
            }
        });

        if (taxLine == null) {
            taxLine = agregar_impuesto_producto();
        }
    }

    //Colocar el taxType de codigo '01' en el select
    const taxTypes = taxLine.find(".taxTypes option");

    //Recorrer los option de .taxTypes para selecciona el de codigo '01' (Impuesto de valor agregado)
    $.each(taxTypes, function (i, option) {
        //Obtener el data-code del option
        var code = $(option).data("code");

        //Si el valor del select es igual al tipo de impuesto
        if (code == "01") {
            //Marcar el select como seleccionado
            option.selected = true;

            activar_porcentajes_producto(taxLine.find(".taxTypes"));
        } else {
            option.selected = false;
        }
    });

    //Recorrer los option de .taxRates para selecciona el que contenga el porcentaje de impuesto sugerido y tenga el tipo de tarifa diferente de 3
    const taxRates = taxLine.find(".taxRates option");

    $.each(taxRates, function (i, option) {
        //Obtener el data-percentage del option
        var percentage = $(option).data("percentage");

        //Obtener el data-rateTypeId del option
        var rateTypeId = $(option).data("rateTypeId");

        //Si el valor del porcentaje es igual al porcentaje de impuesto sugerido y el rateTypeId es diferente de 3
        if (percentage == impuestoSugerido && rateTypeId != 3) {
            //Marcar el select como seleccionado
            option.selected = true;

            colocar_tarifa_producto(taxLine.find(".taxRates"));
        } else {
            option.selected = false;
        }
    });

    calcular_valor_producto(form_activo);
}

/**Eliminar una linea de impuesto */
function eliminar_impuesto_producto(boton) {
    //Obtener la linea de impuesto
    var taxLine = $(boton).closest(".taxLine");

    //Si es la ultima linea de descuento en la taxes padre, deshabilitar el boton
    if (taxLine.siblings(".taxLine").length == 0) {
        //Colocar los input y select en empty
        limpiar_impuesto_producto(taxLine);

        //Desactivar el boton de eliminar
        taxLine.closest(".taxesTable").find(".btn-elm").attr("disabled", true);
    } else {
        taxLine.remove();
    }

    contar_impuestos_producto();
    calcular_valor_producto(form_activo);
} //Fin del metodo eliminar_impuesto

/**Calcular impuestos de una linea de detalle */
function calcular_impuestos_producto() {
    var impuestoTotal = 0;

    const form = $("#" + form_activo);

    var netValue = form.find(".netValue").val();

    if (netValue == "" || isNaN(netValue)) {
        netValue = 0;
    }

    //Obtener la tabla de impuestos
    var taxesTable = form.find(".taxesTable");

    //Obtener todas las lineas de impuestos
    var taxLines = taxesTable.find(".taxLine");

    //Recorrer todas las lineas de impuestos
    taxLines.each(function (index, taxLine) {
        //Calcular el impuesto de la linea
        var impuesto = calcular_impuesto_producto(taxLine, netValue);

        //Sumar el impuesto a la variable impuestoTotal
        impuestoTotal += impuesto;
    });

    //Colocar el impuesto total en el campo .ivNetoVL
    form.find(".ivNetoVL").val(formato_moneda(impuestoTotal, 2, monedaDocumento));

    return impuestoTotal;
}

/**Calcular una linea de impuesto */
function calcular_impuesto_producto(taxLine = null, netValue = 0) {
    if (taxLine != null) {
        taxLine = $(taxLine);

        var taxPercentage = taxLine.find(".taxPercentage").val();

        if (taxPercentage == undefined || taxPercentage == "") {
            taxPercentage = 0;
        }

        var impuesto = (netValue * taxPercentage) / 100;

        var impuesto_neto = impuesto;

        taxLine.find(".tax_amount").val(impuesto);
        taxLine.find(".tax_amount_money").val(formato_moneda(impuesto, 2, monedaDocumento));

        return impuesto_neto;
    } //Fin de validacion de taxLine
} //Fin del calculo de la linea de impuesto

/**
 * Contar el porcentaje de impuesto de todas las lineas
 *
 * @returns  porcentaje del impuesto
 *
 */
function contar_porcentaje_impuesto(form_activo) {
    const form = $("#" + form_activo);

    var porcentaje = 0;

    //Obtener la tabla de impuestos
    var taxesTable = form.find(".taxesTable");

    //Obtener todas las lineas de impuestos
    const taxLines = taxesTable.find(".taxLine");

    //Recorrer todas las lineas de impuestos
    taxLines.each(function (index, taxLine) {
        //Calcular el impuesto de la linea
        var taxPercentage = $(taxLine).find(".taxPercentage").val();

        if (taxPercentage == "" || isNaN(taxPercentage)) {
            taxPercentage = 0;
        }

        porcentaje += parseFloat(taxPercentage);
    });

    return porcentaje;
}

function validateTaxLines(form_activo) {
    const form = $("#" + form_activo);
    let validLines = true;

    //Obtener la tabla de impuestos
    var taxesTable = form.find(".taxesTable");

    //Obtener todas las lineas de impuestos
    const taxLines = taxesTable.find(".taxLine");

    //Recorrer todas las lineas de impuestos
    taxLines.each(function (index, taxLine) {
        //Obtener el taxType de la linea
        var taxtype = $(taxLine).find(".taxTypes").val();
        var taxPercentage = $(taxLine).find(".taxPercentage").val();

        if (taxtype == "") {
            //Eliminar el borde rojo de los campos
            $(taxLine).find(".taxTypes").removeClass("border-danger");

            $(taxLine).find(".taxPercentage").removeClass("border-danger");

            //Eliminar el borde rojo del campo de taxRate
            $(taxLine).find(".taxRates").removeClass("border-danger");

            //Desabilitar el campo de porcentaje
            $(taxLine).find(".taxPercentage").attr("disabled", true);
            $(taxLine).find(".taxRates").attr("disabled", true);

            //Poner los campos en readonly
            $(taxLine).find(".taxPercentage").attr("readonly", true);
            $(taxLine).find(".taxRates").attr("readonly", true);

            //Si solo hay una linea de impuesto y el taxType no esta seleccionado, deshabilitar el boton de eliminar
            if (taxLines.length == 1) {
                $(taxLine).find(".btn-elm").attr("disabled", true);
            }
        } else {
            //Habilitar el boton de eliminar
            $(taxLine).find(".btn-elm").attr("disabled", false);

            const taxCode = $(taxLine).find(".taxTypes option:selected").data("code");

            //Si el taxCode es '01' o '07', validar que el taxRate no este vacio
            if (taxCode == "01" || taxCode == "07") {
                const taxRate = $(taxLine).find(".taxRates").val();

                //Habilitar el campo de taxRate
                $(taxLine).find(".taxRates").attr("disabled", false);
                $(taxLine).find(".taxRates").attr("readonly", false);

                //Desabilitar el campo de porcentaje
                $(taxLine).find(".taxPercentage").attr("disabled", true);
                $(taxLine).find(".taxPercentage").attr("readonly", true);

                if (taxRate == "") {
                    $(taxLine).find(".taxRates").addClass("border-danger");

                    validLines = false;
                } else {
                    $(taxLine).find(".taxRates").removeClass("border-danger");
                }

                $(taxLine).find(".taxPercentage").removeClass("border-danger");
            } else {
                $(taxLine).find(".taxRates").removeClass("border-danger");

                //Habilitar el campo de porcentaje
                $(taxLine).find(".taxPercentage").attr("disabled", false);
                $(taxLine).find(".taxPercentage").attr("readonly", false);

                //Desabilitar el campo de taxRate
                $(taxLine).find(".taxRates").attr("disabled", true);
                $(taxLine).find(".taxRates").attr("readonly", true);

                //Agregar el borde rojo al campo de porcentaje si esta vacio
                if (taxPercentage == "") {
                    $(taxLine).find(".taxPercentage").addClass("border-danger");

                    validLines = false;
                } else {
                    $(taxLine).find(".taxPercentage").removeClass("border-danger");
                }
            }
        }
    });

    return validLines;
}

$(document).ready(function () {
    //Cuando cambia el netValue
    $(document).on("change keyup", ".tax-inp", function () {
        validateTaxLines(form_activo);
    });
}); //Fin del document ready
