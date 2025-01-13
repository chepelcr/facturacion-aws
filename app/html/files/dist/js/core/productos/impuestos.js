/**Agregar una linea de impuesto a la linea activa */
function agregar_impuesto_producto(force = false) {
    const form = $("#" + form_activo);
    const taxesTable = form.find(".taxesTable");

    //Obtener la ultima linea de impuesto
    const taxLine = taxesTable.find(".taxLine").last();

    const taxTypes = taxLine.find(".taxTypes").val();
    const taxPercentage = taxLine.find(".taxPercentage").val();
    const taxRates = taxLine.find(".taxRates").val();

    // (Si el producto tiene un taxType y un taxPercentage diferente de 0) o (Si el producto tiene un taxType y un taxRate)
    if ((taxTypes != "" && taxPercentage != "" && taxPercentage != "0") || (taxTypes != "" && taxRates != "")) {
        //Clonar la ultima linea de impuesto
        const nueva_linea = limpiar_impuesto_producto(taxLine.clone());

        taxesTable.find(".btn-elm").attr("disabled", false);

        //Agregar la nueva linea a la tabla
        taxesTable.append(nueva_linea);

        contar_impuestos_producto();

        return nueva_linea;
    } else {
        if (force == true) {
            //Limpiar los campos de la linea
            limpiar_impuesto_producto(taxLine);

            taxesTable.find(".btn-elm").attr("disabled", false);

            taxesTable.append(taxLine);

            contar_impuestos_producto();

            return taxLine;
        } else {
            notificacion("No se puede agregar un impuesto si el anterior no se ha definido.", "", "warning");
        }
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
    const taxLine = $(select).parents(".taxLine");

    //Obtener el valor data-code del select
    const code = $(select).find("option:selected").data("code");

    //Si el valor del select es '01' o '07' activar el select de taxRates
    if (code == "01" || code == "07") {
        //Activar el campo del porcentaje
        taxLine.find(".taxPercentage").attr("disabled", true);

        //Recorrer los option de .taxRates y escondelos
        const taxRates = taxLine.find(".taxRates option");

        let taxPercentage = null;

        $.each(taxRates, function (i, option) {
            if ($(option).val() != "") {
                $(option).prop("hidden", false);

                if (option.selected == true) {
                    taxPercentage = $(option).data("percentage");
                }
            }
        });

        if (taxPercentage != null) {
            taxLine.find(".taxPercentage").val(taxPercentage);
        } else {
            taxLine.find(".taxPercentage").val(0);
        }
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

        taxLine.find(".taxPercentage").val("");
    }

    validateTaxLines(form_activo);
    calcular_valor_producto(form_activo);
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
    const taxesTable = $(form).find(".taxesTable");

    //Obtener la primera linea de impuesto
    let taxLine = taxesTable.find(".taxLine").first();

    let taxIva = null;
    let hasTaxes = false;

    let taxPercentage = 0;

    //Recorrer todos los impuestos
    for (var i = 0; i < impuestos.length; i++) {
        const impuesto = impuestos[i];

        //Si el impuesto es '01', '07' o '08'
        if (impuesto.type.code == "01" || impuesto.type.code == "07" || impuesto.type.code == "08") {
            taxIva = impuestos[i];
        } else {
            if (!hasTaxes) {
                taxPercentage += colocar_impuesto(taxLine, impuesto);

                hasTaxes = true;
            } else {
                taxLine = agregar_impuesto_producto();
                taxPercentage += colocar_impuesto(taxLine, impuesto);
            }
        }
    }

    if (taxIva != null) {
        if (!hasTaxes) {
            taxPercentage += colocar_impuesto(taxLine, taxIva);
        } else {
            taxLine = agregar_impuesto_producto(true);
            taxPercentage += colocar_impuesto(taxLine, taxIva);
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
            taxLine = agregar_impuesto_producto(true);
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
        const percentage = $(option).data("percentage");

        //Obtener el tipo de tarifa seleccionado
        const rateTypeId = $(option).data("ratetypeid");

        //Si el valor del porcentaje es igual al porcentaje de impuesto sugerido y el rateTypeId es diferente de 3
        if (percentage == impuestoSugerido && rateTypeId != "3") {
            //Marcar el select como seleccionado
            option.selected = true;

            colocar_tarifa_producto(taxLine.find(".taxRates"));
        } else {
            option.selected = false;
        }
    });

    calcular_valor_producto(form_activo);

    validateTaxLines(form_activo);
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
function calcular_impuestos_producto(subtotal, isBiller = false) {
    let impuestoTotal = 0;
    let totalAmountLine = subtotal;

    let otherTaxes = 0;
    let iva = 0;

    const form = $("#" + form_activo);

    let ivaTax = null;

    //Obtener la tabla de impuestos
    const taxesTable = form.find(".taxesTable");

    //Obtener todas las lineas de impuestos
    const taxLines = taxesTable.find(".taxLine");

    let baseAmount = form.find(".base_imponible").val();

    if(isNaN(baseAmount)) {
        baseAmount = 0;
        
        form.find(".base_imponible").val(0);
    } else {
        //Validar si la base imponible tiene un 0 por delante
        if(baseAmount.toString().charAt(0) == "0") {
            baseAmount = baseAmount.toString().substring(1);
        }

        baseAmount = parseFloat(baseAmount);
    }

    //Validar si alguna de las lineas de impuesto tiene el codigo 07
    let hasIvaCE =
        taxLines.find(".taxTypes option:selected").filter(function () {
            return $(this).data("code") == "07";
        }).length > 0;

    if(!hasIvaCE){
        baseAmount = 0;
        form.find(".base_imponible").val(0);
    }

    //Recorrer todas las lineas de impuestos
    taxLines.each(function (index, taxLine) {
        const taxTypeCode = $(taxLine).find(".taxTypes option:selected").data("code");

        if (taxTypeCode != "01" && taxTypeCode != "07" && taxTypeCode != "08") {
            if(hasIvaCE) {
                otherTaxes += calcular_impuesto_producto(taxLine, baseAmount, isBiller);
            } else {
                otherTaxes += calcular_impuesto_producto(taxLine, subtotal, isBiller);
            }
        } else {
            ivaTax = taxLine;
        }
    });

    if (otherTaxes > 0) {
        //Mostrar la columna de other taxes
        form.find(".col-other-taxes").show();

        //Colocar el valor en otrosImpuestosVL
        form.find(".other_taxes").val(formato_moneda(otherTaxes, 5));

        totalAmountLine += otherTaxes;
    } else {
        form.find(".col-other-taxes").hide();
    }

    if (ivaTax != null) {
        //Si el tipo es 07, mostrar la columna de base imponible (col-base-imponible)
        if (hasIvaCE) {
            //Obtener el valor de la base imponible en el campo .base_imponible
            iva = calcular_impuesto_producto(ivaTax, baseAmount, isBiller);
        } else {
            iva = calcular_impuesto_producto(ivaTax, totalAmountLine, isBiller);
        }

        if (isBiller) {
            //Colocar el valor en el campo detail_discount_total
            form.find(".detail_tax_total").val(formato_moneda(iva, 5));
        } else {
            form.find(".taxValue").val(formato_moneda(iva, 5));
        }

        //col-iva
        form.find(".col-iva").show();
    } else {
        //Colocar 0 en la base imponible
        form.find(".baseAmount").val(0);

        if (isBiller) {
            form.find(".detail_tax_total").val(0);
        } else {
            form.find(".taxValue").val(0);
        }

        //col-iva
        form.find(".col-iva").hide();
    }

    impuestoTotal = new Decimal(iva).plus(otherTaxes).toDecimalPlaces(5).toNumber();

    if(isNaN(impuestoTotal)) {
        impuestoTotal = 0;
    }

    if (!isBiller) {
        //Colocar el impuesto total en el campo .ivNetoVL
        form.find(".ivNetoVL").val(formato_moneda(impuestoTotal, 5));
    }

    return impuestoTotal;
}

/**Calcular una linea de impuesto */
function calcular_impuesto_producto(taxLine = null, subtotal = 0, isBiller = false) {
    taxLine = $(taxLine);

    let taxAmount = 0;

    let taxPercentage = taxLine.find(".taxPercentage").val();

    if (taxPercentage == undefined || taxPercentage == "") {
        taxPercentage = 0;
    }

    if (taxPercentage > 0) {
        taxPercentage = new Decimal(taxPercentage).dividedBy(100).toDecimalPlaces(5).toNumber();

        console.log("Porcentaje de impuesto total: " + taxPercentage);

        taxAmount = new Decimal(subtotal).times(taxPercentage).toDecimalPlaces(5).toNumber();
    }

    console.log("Porcentaje de impuesto: " + taxPercentage);
    console.log("Valor neto: " + subtotal);
    console.log("Valor impuesto: " + taxAmount);

    if (!isBiller) {
        taxLine.find(".tax_amount").val(taxAmount);
        taxLine.find(".tax_amount_money").val(formato_moneda(taxAmount, 5));
    }

    return taxAmount;
} //Fin del calculo de la linea de impuesto

/**
 * Contar el porcentaje de impuesto de todas las lineas
 *
 * @param {string} form_activo
 * @returns  porcentaje del impuesto
 */
function contar_porcentaje_impuesto(form_activo, type = "all") {
    const form = $("#" + form_activo);

    let totalTaxPercentage = 0;

    let ivaTaxPercentage = 0;

    let otherTaxesPercentage = 0;
    let ivaTaxType;

    //Obtener la tabla de impuestos
    const taxesTable = form.find(".taxesTable");

    //Obtener todas las lineas de impuestos
    const taxLines = taxesTable.find(".taxLine");

    //Recorrer todas las lineas de impuestos
    taxLines.each(function (index, taxLine) {
        //Calcular el impuesto de la linea
        let taxPercentage = $(taxLine).find(".taxPercentage").val();

        if (taxPercentage == "" || isNaN(taxPercentage)) {
            taxPercentage = 0;
        }

        totalTaxPercentage += parseFloat(taxPercentage);

        const taxType = $(taxLine).find(".taxTypes option:selected").data("code");

        if (taxType == "01" || taxType == "07" || taxType == "08") {
            ivaTaxPercentage += parseFloat(taxPercentage);
            ivaTaxType = taxType;
        } else {
            otherTaxesPercentage += parseFloat(taxPercentage);
        }
    });

    if (type == "iva") {
        return {
            taxPercentage: ivaTaxPercentage,
            taxType: ivaTaxType,
        };
    } else if (type == "other") {
        return otherTaxesPercentage;
    } else {
        return totalTaxPercentage;
    }
}

function validateTaxLines(form_activo) {
    const form = $("#" + form_activo);
    let validLines = true;

    //Obtener la tabla de impuestos
    var taxesTable = form.find(".taxesTable");

    //Obtener todas las lineas de impuestos
    const taxLines = taxesTable.find(".taxLine");

    let hasIva = false;
    let hasIvaCE = false;

    //Recorrer todas las lineas de impuestos
    taxLines.each(function (index, taxLine) {
        //Obtener el taxType de la linea
        var taxtype = $(taxLine).find(".taxTypes").val();
        var taxPercentage = $(taxLine).find(".taxPercentage").val();
        const taxRate = $(taxLine).find(".taxRates");

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

            //Eliminar el borde rojo de los campos
            $(taxLine).find(".taxTypes").removeClass("border-danger");

            const taxCode = $(taxLine).find(".taxTypes option:selected").data("code");

            //Si el taxCode es '01' o '07', validar que el taxRate no este vacio
            if (taxCode == "01" || taxCode == "07") {
                //Desabilitar el campo de porcentaje
                $(taxLine).find(".taxPercentage").attr("disabled", true);
                $(taxLine).find(".taxPercentage").attr("readonly", true);

                if (hasIva) {
                    //Colocar un borde rojo en el campo de taxType
                    $(taxLine).find(".taxTypes").addClass("border-danger");

                    notificacion("Solo se puede agregar un impuesto de tipo IVA.", "", "warning");

                    //Habilitar el campo de taxRate
                    taxRate.attr("disabled", true);
                    taxRate.attr("readonly", true);

                    //Eliminar el borde rojo del campo de taxPercentage
                    $(taxLine).find(".taxPercentage").removeClass("border-danger");

                    validLines = false;
                } else {
                    hasIva = true;

                    //Habilitar el campo de taxRate
                    taxRate.attr("disabled", false);
                    taxRate.attr("readonly", false);

                    //Desabilitar el campo de porcentaje
                    $(taxLine).find(".taxPercentage").attr("disabled", true);
                    $(taxLine).find(".taxPercentage").attr("readonly", true);

                    if (taxRate.val() == "") {
                        taxRate.addClass("border-danger");

                        validLines = false;
                    } else {
                        taxRate.removeClass("border-danger");
                    }

                    $(taxLine).find(".taxPercentage").removeClass("border-danger");

                    if (taxCode == "07") {
                        form.find(".col-base-imponible").show();

                        hasIvaCE = true;
                    }
                }
            } else {
                $(taxLine).find(".taxRates").removeClass("border-danger");

                //Habilitar el campo de porcentaje
                $(taxLine).find(".taxPercentage").attr("disabled", false);
                $(taxLine).find(".taxPercentage").attr("readonly", false);

                //Desabilitar el campo de taxRate
                $(taxLine).find(".taxRates").attr("disabled", true);
                $(taxLine).find(".taxRates").attr("readonly", true);

                //Agregar el borde rojo al campo de porcentaje si esta vacio
                if (taxPercentage == "" || taxPercentage == 0) {
                    $(taxLine).find(".taxPercentage").addClass("border-danger");

                    validLines = false;
                } else {
                    $(taxLine).find(".taxPercentage").removeClass("border-danger");
                }
            }
        }
    });

    if(!hasIvaCE) {
        form.find(".col-base-imponible").hide();
    } else {
        const baseAmount = form.find(".base_imponible").val();

        if(baseAmount == "" || baseAmount == 0 || isNaN(baseAmount)) {
            form.find(".base_imponible").addClass("border-danger");

            validLines = false;
        } else {
            form.find(".base_imponible").removeClass("border-danger");
        }
    }

    return validLines;
}

$(document).ready(function () {
    //Cuando cambia el netValue
    $(document).on("change keyup", ".tax-inp", function () {
        //Validar si el campo tiene la clase taxPercentage
        if ($(this).hasClass("taxPercentage")) {
            let taxPercentage = $(this).val();

            //Validar si tiene letras con una expresion regular
            if (/[a-zA-Z]/.test(taxPercentage)) {
                taxPercentage = 0;
            }

            //Validar si tiene un punto o coma
            if (taxPercentage.includes(".") || taxPercentage.includes(",")) {
                taxPercentage = taxPercentage.replace(",", ".");

                //Obtener los valores a la izquierda y derecha del punto
                let left = taxPercentage.split(".")[0];
                let right = taxPercentage.split(".")[1];

                //Si el taxPercentage tiene un numero a la izquierda y nada a la derecha, no hacer nada
                if (!isNaN(left) && right == "") {
                    return;
                } else {
                    taxPercentage = left + "." + right;
                    taxPercentage = parseFloat(taxPercentage);
                }

                console.log(taxPercentage);
            }

            //Validar si el taxPercentage es un numero
            if (isNaN(taxPercentage) || taxPercentage == "") {
                $(this).val(0);
            } else {
                //Convertir el taxPercentage a un numero doble
                taxPercentage = parseFloat(taxPercentage);

                //Si el taxPercentage es mayor a 100, colocar 100
                if (taxPercentage > 100) {
                    taxPercentage = 100;
                }

                $(this).val(taxPercentage);
            }

            calcular_valor_producto(form_activo);
        }

        validateTaxLines(form_activo);
    });
}); //Fin del document ready
