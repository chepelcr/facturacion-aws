/**Abrir o cerrar el collapse de una linea de impuesto */
function exonerar_impuesto(boton = null) {
    if (boton != null) {
        const linea = $(boton).closest(".taxLine");

        //Abrir o cerrar el collapse de la linea
        if (linea.find(".collapse_impuesto").hasClass("show")) {
            linea.find(".collapse_impuesto").collapse("hide");
        } else {
            linea.find(".collapse_impuesto").collapse("show");
        }
    } //Fin del if
} //Fin del metodo exonerar_impuesto

/**Agregar una linea de impuesto a la linea activa */
function agregar_impuesto(boton = null, linea = null, force = false) {
    if (boton != null) {
        //Obtener la linea activa
        linea = $(boton).closest(".detail");
    } else if (linea != null) {
        linea = linea;
    }

    const taxesTable = linea.find(".taxesTable");

    const validTaxes = validar_impuestos_detalle(linea, true);

    if (!validTaxes && !force) {
        notificacion("No se puede agregar un impuesto si el anterior no se ha definido.", "", "warning");

        return;
    } else {
        //Obtener la ultima linea de impuesto
        const taxLine = taxesTable.find(".taxLine").last();

        //Clonar la ultima linea de impuesto
        let nueva_linea = taxLine.clone();

        nueva_linea = limpiar_linea_impuesto(nueva_linea);

        //taxesTable.find(".btn-elm").attr("disabled", false);

        //Agregar la nueva linea al inicio de la tabla de impuestos
        taxesTable.append(nueva_linea);

        validar_impuestos_detalle(linea);

        return nueva_linea;
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

    setExcemptionMax(taxLine);

    taxLine.find(".collapse_impuesto").collapse("hide");

    return taxLine;
}

/**Contar la cantidad de lineas de impuestos */
function colocar_nombre_impuesto(taxLine, lineNumber = 1) {
    const inputs = $(taxLine).find("input, select");

    //Recorrer los inputs de la nueva linea
    inputs.each(function (index, input) {
        //Validar si el input tiene nombre
        if ($(input).attr("name") != undefined) {
            //Obtener el nombre del input
            const name = $(input).attr("name");

            //const newLineNumber = taxLines;

            const newFieldName = name.replace(/\[taxes\]\[\d+\]/, `[taxes][${lineNumber}]`);

            //Asignar el nuevo nombre al input
            $(input).attr("name", newFieldName);
        }
    });
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

    validar_impuestos_detalle(linea);
}

/**Activar el porcentaje de una linea de impuesto */
function activar_porcentajes(taxLine) {
    //Obtener la linea de impuesto
    //var taxLine = $(select).parents(".taxLine");

    const select = taxLine.find(".taxTypes");

    //Obtener el valor data-code del select
    const code = $(select).find("option:selected").data("code");

    //Si el valor del select es '01' o '07' activar el select de taxRates
    if (code == "01" || code == "07") {
        taxLine.find(".taxRates").attr("disabled", false);

        //Activar el campo del porcentaje
        taxLine.find(".taxPercentage").attr("disabled", true);
        taxLine.find(".taxPercentage").attr("readonly", true);

        taxLine.find(".taxPercentage").val("");

        const taxesTable = taxLine.closest(".taxesTable");

        //Si hay mas de una linea de impuesto, colocar la linea al final
        if (taxesTable.find(".taxLine").length > 1) {
            //Eliminar la linea de impuesto de la tabla
            taxLine.detach();

            taxesTable.append(taxLine);
        } else {
            taxesTable.find(".taxLine").first().before(taxLine);
        }
    } else {
        taxLine.find(".taxRates").attr("disabled", true);
        taxLine.find(".taxRates").val("");

        //Activar el campo del porcentaje
        taxLine.find(".taxPercentage").attr("disabled", false);
        taxLine.find(".taxPercentage").attr("readonly", false);
    }
}

/**Colocar el porcentaje de impuesto en el campo .taxPercentage de la linea de impuesto */
function colocar_tarifa(taxLine) {
    const select = taxLine.find(".taxRates");

    //Obtener el data-porcentaje del select
    const porcentaje = $(select).find("option:selected").data("percentage");

    //Colocar el porcentaje en el campo .taxPercentage
    taxLine.find(".taxPercentage").val(porcentaje);

    // Desactivar el campo del porcentaje
    taxLine.find(".taxPercentage").attr("disabled", true);
    taxLine.find(".taxPercentage").attr("readonly", true);
}

function agregar_impuesto_linea(taxLine, impuesto) {
    //Obtener el tipo de impuesto
    const type = impuesto.type;

    let taxPercentage = 0;

    //Recorrer los option de .taxTypes
    const taxTypes = taxLine.find(".taxTypes option");

    console.log(taxTypes);

    $.each(taxTypes, function (i, option) {
        //Obtener el data-code del option
        const code = $(option).data("code");

        //Si el valor del select es igual al tipo de impuesto
        if (code == type.code) {
            //Marcar el select como seleccionado
            option.selected = true;

            console.log("Seleccionado");
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

                taxPercentage = impuesto.taxRate.rate;

                taxPercentage = parseFloat(taxPercentage);
            } else {
                option.selected = false;
            }
        });
    } else {
        taxPercentage = impuesto.rate;

        //Colocar '' en el taxRates
        taxLine.find(".taxRates").val("");
    }

    console.log("Porcentaje de impuesto: " + taxPercentage);

    //Colocar el porcentaje en el campo .taxPercentage
    taxLine.find(".taxPercentage").val(taxPercentage);

    validar_impuestos_detalle(taxLine.parents(".detail"));
    setExcemptionMax(taxLine);

    return taxPercentage;
}

function agregar_impuestos_api(linea_activa, impuestos) {
    //Obtener la tabla de impuestos
    const taxesTable = linea_activa.find(".taxesTable");

    //Obtener la primera linea de impuesto
    let taxLine = taxesTable.find(".taxLine").first();

    let taxPercentage = 0;

    let taxIva = null;

    let hastTaxes = false;

    //Recorrer todos los impuestos
    for (let i = 0; i < impuestos.length; i++) {
        const impuesto = impuestos[i];

        //Si el impuesto es '01', '07' o '08'
        if (impuesto.type.code == "01" || impuesto.type.code == "07" || impuesto.type.code == "08") {
            taxIva = impuestos[i];
        } else {
            //Si es el primer impuesto, agregarlo a la primera linea de impuesto
            if (!hastTaxes) {
                taxPercentage += agregar_impuesto_linea(taxLine, impuestos[i]);

                hastTaxes = true;
            } else {
                taxLine = agregar_impuesto(null, linea_activa, true);
                taxPercentage += agregar_impuesto_linea(taxLine, impuestos[i]);
            }
        }
    }

    if (taxIva != null) {
        //Si hay mas de una linea de impuesto, colocar la linea al final
        if (hastTaxes) {
            //Agregar la linea de impuesto al final de la tabla
            taxLine = agregar_impuesto(null, linea_activa, true);
        } else {
            //Agregar la linea de impuesto al inicio de la tabla
            taxLine = taxesTable.find(".taxLine").first();
        }

        taxPercentage += agregar_impuesto_linea(taxLine, taxIva);
    }

    return taxPercentage;
}

/**Eliminar una linea de impuesto */
function eliminar_impuesto(boton) {
    //Obtener la linea de impuesto
    const taxLine = $(boton).closest(".taxLine");
    const activeLine = $(taxLine).closest(".detail");

    setActiveLine(activeLine);

    //Si es la ultima linea de descuento en la taxes padre, deshabilitar el boton
    if (taxLine.siblings(".taxLine").length == 0) {
        //Colocar los input y select en empty
        limpiar_linea_impuesto(taxLine);

        //Desactivar el boton de eliminar
        taxLine.closest(".taxesTable").find(".btn-elm").attr("disabled", true);

        //Ocultar los campos .col-iva, .col-otros-impuestos y .col-base-imponible
        taxLine.find(".col-iva").attr("hidden", true);
        taxLine.find(".col-otros-impuestos").attr("hidden", true);
        taxLine.find(".col-base-imponible").attr("hidden", true);

        //Vaciar los campos .ivNeto, .otrosImpuestos, .baseImponible, .totalTaxVL, .otrosImpuestosVL, .baseImponibleVL
        taxLine.find(".ivNeto").val(0);
        taxLine.find(".otrosImpuestos").val(0);
        taxLine.find(".baseImponible").val(0);

        taxLine.find(".ivNetoVL").val("");
        taxLine.find(".otrosImpuestosVL").val("");
        taxLine.find(".baseImponibleVL").val("");
    } else {
        taxLine.remove();
    }

    validarLineaDetalle(activeLine);

    calcular_valor_producto(elemento_activo, true);

    calcular(activeLine);
} //Fin del metodo eliminar_impuesto

/**Calcular impuestos de una linea de detalle */
function calcular_impuestos(linea_detalle, subtotal, moneda) {
    //let impuestoTotal = 0;

    linea_detalle = $(linea_detalle);

    let totalAmountLine = subtotal;
    let otherTaxes = 0;

    //Obtener la tabla de impuestos
    const taxesTable = linea_detalle.find(".taxesTable");

    //Obtener todas las lineas de impuestos
    const lineas_impuestos = taxesTable.find(".taxLine");
    const baseAmount = linea_detalle.find(".base_imponible").val();

    let ivaTax = 0;

    //Validar si alguna de las lineas de impuesto tiene el codigo 07
    let hasIvaCE =
        lineas_impuestos.find(".taxTypes option:selected").filter(function () {
            return $(this).data("code") == "07";
        }).length > 0;

    if (!hasIvaCE) {
        linea_detalle.find(".base_imponible").val(0);
    }

    let ivaLine = null;

    //Recorrer todas las lineas de impuestos
    lineas_impuestos.each(function (index, taxLine) {
        console.log(subtotal);

        let taxValue = 0;

        console.log(taxValue);

        const taxCode = $(taxLine).find(".taxTypes option:selected").data("code");
        //Si el taxCode no es '01' o '07', sumar el impuesto a la variable subtotal

        if (taxCode != "01" && taxCode != "07" && taxCode != "08") {
            if (hasIvaCE) {
                taxValue = calcular_impuesto(taxLine, baseAmount);
            } else {
                taxValue = calcular_impuesto(taxLine, subtotal);
            }
            totalAmountLine += taxValue;
            otherTaxes += taxValue;
        } else {
            ivaLine = taxLine;
        }
    });

    if (ivaLine != null) {
        const taxCode = $(ivaLine).find(".taxTypes option:selected").data("code");

        //Validar si es tipo de impuesto '01' o '07'
        if (taxCode == "01" || taxCode == "07") {
            //Obtener el porcentaje del tarRate
            const taxPercentage = $(ivaLine).find(".taxRates option:selected").data("percentage");

            //Colocar el porcentaje en el campo .taxPercentage
            $(ivaLine).find(".taxPercentage").val(taxPercentage);
        }

        //Si el tipo es de IVA Calculo especial, se usa la base imponible del detalle para el calculo del impuesto.
        if (taxCode == "07") {
            ivaTax = calcular_impuesto(ivaLine, baseAmount);
        } else {
            ivaTax = calcular_impuesto(ivaLine, totalAmountLine);
        }
    }

    let totalTaxes = ivaTax + otherTaxes;

    //Colocar el total de impuestos en el campo .totalTaxVL
    linea_detalle.find(".totalTaxVL").val(formato_moneda(totalTaxes, 2, moneda));

    //Calcular el valor total de la linea
    let total = parseFloat(totalAmountLine + ivaTax);

    if (otherTaxes > 0) {
        //Colocar el valor de otherTaxes en el campo .otrosImpuestos
        linea_detalle.find(".otrosImpuestos").val(otherTaxes);

        otherTaxes = formato_moneda(otherTaxes, 2, moneda);
        linea_detalle.find(".otrosImpuestosVL").val(otherTaxes);

        //Mostrar la columna de otros impuestos .col-otros-impuestos y de base imponible .col-base-imponible
        linea_detalle.find(".col-otros-impuestos").attr("hidden", false);
    } else {
        //Ocultar la columna de otros impuestos .col-otros-impuestos y de base imponible .col-base-imponible
        linea_detalle.find(".col-otros-impuestos").attr("hidden", true);
    }

    if (ivaTax > 0) {
        //Colocar el valor de ivaTax en el campo .ivNeto
        linea_detalle.find(".ivNeto").val(ivaTax);

        ivaTax = formato_moneda(ivaTax, 2, moneda);
        linea_detalle.find(".ivNetoVL").val(ivaTax);

        //Mostrar la columna de iva .col-iva
        linea_detalle.find(".col-iva").attr("hidden", false);
    } else {
        //Ocultar la columna de iva .col-iva
        linea_detalle.find(".col-iva").attr("hidden", true);

        //Vaciar el campo .ivNeto
        linea_detalle.find(".ivNeto").val("");

        linea_detalle.find(".ivNetoVL").val("");
    }

    //Colocar el subtotal en el campo .subtotal
    linea_detalle.find(".subtotal").val(subtotal);

    subtotal = formato_moneda(subtotal, 2, moneda);
    linea_detalle.find(".subtotalVL").val(subtotal);

    linea_detalle.find(".totalL").val(total);

    total = formato_moneda(total, 2, moneda);
    linea_detalle.find(".totalVL").val(total);
}

/**
 * Calcular el impuesto de una linea
 * @param {*} taxLine Linea de impuesto
 * @param {number} subtotal Subtotal de la linea
 * @returns Monto del impuesto neto
 */
function calcular_impuesto(taxLine, subtotal) {
    taxLine = $(taxLine);

    let taxPercentage = taxLine.find(".taxPercentage").val();

    if (taxPercentage == "" || isNaN(taxPercentage)) {
        taxLine.find(".taxPercentage").val(0);
        taxPercentage = 0;
    }

    const impuesto = (subtotal * taxPercentage) / 100;

    const porcentajeExoneracion = taxLine.find(".excemption_percentage").val();

    console.log("Porcentaje de exoneracion: " + porcentajeExoneracion);

    let montoExoneracion = 0;
    let impuesto_neto = 0;

    //Buscar si la linea tiene .excemption_percentage y si tiene valor
    if (porcentajeExoneracion != "" && porcentajeExoneracion > 0) {
        //Calcular el monto de exoneracion
        montoExoneracion = (subtotal * porcentajeExoneracion) / 100;

        //Calcular el impuesto
        impuesto_neto = impuesto - montoExoneracion;

        montoExoneracion = parseFloat(montoExoneracion);

        console.log("Monto de exoneracion: " + montoExoneracion);
    } else {
        impuesto_neto = impuesto;
    }

    console.log("Impuesto neto: " + impuesto_neto);

    taxLine.find(".excemption_amount").val(montoExoneracion);
    taxLine.find(".excemption_amount_money").val(formato_moneda(montoExoneracion, 2, monedaDocumento));

    taxLine.find(".tax_amount").val(impuesto);
    taxLine.find(".tax_amount_money").val(formato_moneda(impuesto, 2, monedaDocumento));

    return impuesto_neto;
} //Fin del calculo de la linea de impuesto

/**Buscar un numero de exoneracion en el ministerio de hacienda
 * Formato: AL-00000000-20
 */
function buscar_exoneracion(exoneracion = "", taxLine = null) {
    if (exoneracion != "") {
        //La exoneracion debe tener el formato ^[aA]{1}[lL]{1}-\d{8}-\d{2}$ (AL-00000000-00)
        var patron = /^[aA]{1}[lL]{1}-\d{8}-\d{2}$/;

        if (patron.test(exoneracion)) {
            url = "https://api.hacienda.go.cr/fe/ex?autorizacion=" + exoneracion;

            Pace.track(function () {
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "json",
                })
                    .done(function (data) {
                        //Colocar la fechaEmision en formato yyyy-MM-dd (2020-03-30T00:00:00)
                        var fechaEmision = data.fechaEmision.split("T")[0];

                        //Colocar los datos en los campos correspondientes
                        taxLine.find(".excemption_issueDate").val(fechaEmision);

                        taxLine.find(".excemption_institutionName").val(data.nombreInstitucion);
                        taxLine.find(".excemption_percentage").val(data.porcentajeExoneracion);

                        campos_exoneracion(taxLine, true);

                        validar_impuestos_detalle(taxLine.parents(".detail"));

                        //activarBotonExoneracion(false, taxLine);

                        calcular(taxLine.parents(".detail"));

                        return;
                    })
                    .fail(function (xhr, textStatus, errorThrown) {
                        //Mostrar la respuesta
                        notificacion("No se ha encontrado la autorizacion solicitada", "", "warning");

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
    const taxLine = $(botonEliminar).parents(".taxLine");

    taxLine.find(".excemption_documentType").val("");
    taxLine.find(".excemption_issueDate").val("");
    taxLine.find(".excemption_institutionName").val("");
    taxLine.find(".excemption_percentage").val(0);
    taxLine.find(".excemption_amount").val("");
    taxLine.find(".excemption_amount_money").val(formato_moneda(0));
    taxLine.find(".excemption_number").val("");

    campos_exoneracion(taxLine, true);
    activarBotonExoneracion(true, taxLine);

    validar_exoneracion(taxLine);

    //calcular(taxLine.parents(".detail"));
}

function setExcemptionMax(taxLine) {
    const taxPercentage = taxLine.find(".taxPercentage").val();

    taxLine.find(".excemption_percentage").attr("max", taxPercentage);
}

function validar_impuestos_detalle(linea_activa, forAdd = false) {
    let validLines = true;

    //Obtener la tabla de impuestos
    const taxesTable = linea_activa.find(".taxesTable");

    //Obtener todas las lineas de impuestos
    const taxLines = taxesTable.find(".taxLine");

    const suggestedTax = linea_activa.find(".category_suggestedTax").val();

    let lineNumber = 0;

    //Validar si alguna de las lineas de impuesto tiene el codigo 07
    let hasIvaCE =
        taxLines.find(".taxTypes option:selected").filter(function () {
            return $(this).data("code") == "07";
        }).length > 0;

    if(hasIvaCE) {
        linea_activa.find(".col-base-imponible").show();

        const baseAmount = linea_activa.find(".base_imponible").val();

        if(baseAmount == "" || baseAmount == 0 || isNaN(baseAmount)) {
            validLines = false;

            linea_activa.find(".base_imponible").addClass("border-danger");
        } else {
            linea_activa.find(".base_imponible").removeClass("border-danger");
        }
    } else {
        linea_activa.find(".base_imponible").val(0);
        linea_activa.find(".col-base-imponible").hide()
    }

    //Recorrer todas las lineas de impuestos
    taxLines.each(function (index, taxLine) {
        colocar_nombre_impuesto($(taxLine), lineNumber);

        //Obtener el taxType de la linea
        const taxtype = $(taxLine).find(".taxTypes").val();

        //const taxPercentage = $(taxLine).find(".taxPercentage").val();

        if (taxtype == "") {
            //Si solo hay una linea de impuesto y el taxType no esta seleccionado, deshabilitar el boton de eliminar
            if (taxLines.length == 1) {
                $(taxLine).find(".btn-elm").attr("disabled", true);

                //Eliminar el borde rojo de los campos
                $(taxLine).find(".taxTypes").removeClass("border-danger");

                if (forAdd) {
                    validLines = false;
                }
            } else {
                //Habilitar el boton de eliminar
                $(taxLine).find(".btn-elm").attr("disabled", false);

                //Agregar el borde rojo de los campos
                $(taxLine).find(".taxTypes").addClass("border-danger");

                validLines = false;
            }

            $(taxLine).find(".taxPercentage").removeClass("border-danger");

            //Eliminar el borde rojo del campo de taxRate
            $(taxLine).find(".taxRates").removeClass("border-danger");

            //Desabilitar el campo de porcentaje
            $(taxLine).find(".taxPercentage").attr("disabled", true);
            $(taxLine).find(".taxRates").attr("disabled", true);

            //Poner los campos en readonly
            $(taxLine).find(".taxPercentage").attr("readonly", true);
            $(taxLine).find(".taxRates").attr("readonly", true);

            //Desactivar el boton de exonerar btn-exn-imp
            $(taxLine).find(".btn-exn-imp").attr("disabled", true);

            //Vaciar el  campo de taxPercentage
            $(taxLine).find(".taxPercentage").val("");
        } else {
            //Habilitar el boton de eliminar
            $(taxLine).find(".btn-elm").attr("disabled", false);

            //Eliminar el borde rojo de los campos
            $(taxLine).find(".taxTypes").removeClass("border-danger");

            $(taxLine).find(".btn-exn-imp").attr("disabled", false);

            const taxCode = $(taxLine).find(".taxTypes option:selected").data("code");

            //Si el taxCode es '01' o '07', validar que el taxRate no este vacio
            if (taxCode == "01" || taxCode == "07" || taxCode == "08") {
                const taxRate = $(taxLine).find(".taxRates");

                activar_porcentajes($(taxLine));

                if (taxCode == "08") {
                    //Deshabilitar el taxRate
                    taxRate.attr("disabled", true);
                    taxRate.attr("readonly", true);

                    //Habilitar el campo de porcentaje
                    $(taxLine).find(".taxPercentage").attr("disabled", false);
                    $(taxLine).find(".taxPercentage").attr("readonly", false);

                    const taxPercentage = $(taxLine).find(".taxPercentage").val();

                    //Validar que tenga un porcentaje
                    if (taxPercentage == "" || taxPercentage == 0) {
                        $(taxLine).find(".taxPercentage").addClass("border-danger");

                        validLines = false;
                    } else {
                        $(taxLine).find(".taxPercentage").removeClass("border-danger");
                    }

                    //Eliminar el borde rojo del campo de taxRates
                    $(taxLine).find(".taxRates").removeClass("border-danger");
                } else {
                    //Habilitar el campo de taxRate
                    taxRate.attr("disabled", false);
                    taxRate.attr("readonly", false);

                    //Desabilitar el campo de porcentaje
                    $(taxLine).find(".taxPercentage").attr("disabled", true);
                    $(taxLine).find(".taxPercentage").attr("readonly", true);

                    //Si no hay taxRate seleccionado
                    if (taxRate.val() == "") {
                        $(taxLine).find(".taxRates").addClass("border-danger");

                        validLines = false;
                    } else {
                        $(taxLine).find(".taxRates").removeClass("border-danger");

                        colocar_tarifa($(taxLine));
                    }

                    //Validar si el impuesto seleccionado es igual al sugerido
                    const taxPercentage = $(taxLine).find(".taxPercentage").val();

                    if (taxPercentage != suggestedTax) {
                        $(taxLine).find(".taxRates").addClass("border-warning");
                    } else {
                        $(taxLine).find(".taxRates").removeClass("border-warning");
                    }

                    //Eliminar el borde rojo del campo de taxPercentage
                    $(taxLine).find(".taxPercentage").removeClass("border-danger");
                }
            } else {
                $(taxLine).find(".taxRates").removeClass("border-danger");

                activar_porcentajes($(taxLine));

                //Habilitar el campo de porcentaje
                $(taxLine).find(".taxPercentage").attr("disabled", false);
                $(taxLine).find(".taxPercentage").attr("readonly", false);

                //Desabilitar el campo de taxRate
                $(taxLine).find(".taxRates").attr("disabled", true);
                $(taxLine).find(".taxRates").attr("readonly", true);

                const taxPercentage = $(taxLine).find(".taxPercentage").val();

                //Agregar el borde rojo al campo de porcentaje si esta vacio
                if (taxPercentage == "" || taxPercentage == 0) {
                    $(taxLine).find(".taxPercentage").addClass("border-danger");

                    validLines = false;
                } else {
                    $(taxLine).find(".taxPercentage").removeClass("border-danger");
                }
            }
        }

        const validExcemption = validar_exoneracion($(taxLine));

        if (!validExcemption) {
            validLines = false;
        }

        lineNumber++;
    });

    if (validLines) {
        //Desactivar el boton de finalizar detalle
        linea_activa.find(".btn-fin-det").attr("disabled", false);
    } else {
        //Activar el boton de finalizar detalle
        linea_activa.find(".btn-fin-det").attr("disabled", true);
    }

    return validLines;
}

//Validar si la lista de impuestos tiene un impuesto de tipo IVA
function validar_impuestos_iva(taxesTable, taxLine) {
    let hasIva = false;

    let selectedIva = false;

    const taxCode = taxLine.find(".taxTypes option:selected").data("code");

    //Si el taxCode es '01', '07' o '08' tiene IVA
    if (taxCode == "01" || taxCode == "07" || taxCode == "08") {
        selectedIva = true;
    }

    //Seleccionar todas las lineas de impuestos menos la actual
    taxesTable
        .find(".taxLine")
        .not(taxLine)
        .each(function (index, taxLine) {
            taxLine = $(taxLine);

            const taxCode = taxLine.find(".taxTypes option:selected").data("code");

            //Si el taxCode es '01', '07' o '08' tiene IVA
            if (taxCode == "01" || taxCode == "07" || taxCode == "08") {
                hasIva = true;
            }
        });

    if (hasIva && selectedIva) {
        notificacion("Solo se puede agregar un impuesto de tipo IVA.", "", "warning");

        //Colocar un borde rojo en el campo de taxType
        taxLine.find(".taxTypes").addClass("border-danger");

        //Desactivar el boton de exonerar btn-exn-imp
        taxLine.find(".btn-exn-imp").attr("disabled", true);

        //Desactivar el taxRate
        taxLine.find(".taxRates").attr("disabled", true);
        taxLine.find(".taxRates").attr("readonly", true);

        //Desactivar el campo de porcentaje
        taxLine.find(".taxPercentage").attr("disabled", true);
        taxLine.find(".taxPercentage").attr("readonly", true);

        //Desactivar el boton de finalizar detalle
        taxLine.parents(".detail").find(".btn-fin-det").attr("disabled", true);

        return true;
    }

    if (taxCode == "07") {
        linea_activa.find(".col-base-imponible").show();
    } else {
        linea_activa.find(".col-base-imponible").hide();
    }

    return false;
}

function validar_exoneracion(taxLine) {
    let validExcemption = true;

    //Validar si la linea tiene todo vacio
    if (
        taxLine.find(".excemption_documentType").val() != "" ||
        taxLine.find(".excemption_number").val() != "" ||
        taxLine.find(".excemption_issueDate").val() != "" ||
        taxLine.find(".excemption_institutionName").val() != "" ||
        (taxLine.find(".excemption_percentage").val() != "" && taxLine.find(".excemption_percentage").val() != 0)
    ) {
        activarBotonExoneracion(false, taxLine);

        //Si el excemption_documentType esta vacio
        if (taxLine.find(".excemption_documentType").val() == "") {
            taxLine.find(".excemption_documentType").addClass("border-danger");

            validExcemption = false;
        } else {
            taxLine.find(".excemption_documentType").removeClass("border-danger");
        }

        //Si el excemption_number esta vacio
        if (taxLine.find(".excemption_number").val() == "") {
            taxLine.find(".excemption_number").addClass("border-danger");

            validExcemption = false;
        } else {
            taxLine.find(".excemption_number").removeClass("border-danger");
        }

        //Si el excemption_issueDate esta vacio
        if (taxLine.find(".excemption_issueDate").val() == "") {
            taxLine.find(".excemption_issueDate").addClass("border-danger");

            validExcemption = false;
        } else {
            taxLine.find(".excemption_issueDate").removeClass("border-danger");
        }

        //Si el excemption_institutionName esta vacio
        if (taxLine.find(".excemption_institutionName").val() == "") {
            taxLine.find(".excemption_institutionName").addClass("border-danger");

            validExcemption = false;
        } else {
            taxLine.find(".excemption_institutionName").removeClass("border-danger");
        }

        const taxPercentage = parseFloat(taxLine.find(".taxPercentage").val());
        const excemption_percentage = parseFloat(taxLine.find(".excemption_percentage").val());

        //Si el excemption_percentage esta vacio
        if (isNaN(excemption_percentage) || excemption_percentage == 0) {
            taxLine.find(".excemption_percentage").addClass("border-danger");

            validExcemption = false;
        } else {
            taxLine.find(".excemption_percentage").removeClass("border-danger");
        }
    } else {
        activarBotonExoneracion(true, taxLine);

        //Eliminar el borde rojo de los campos
        taxLine.find(".excemption_documentType").removeClass("border-danger");
        taxLine.find(".excemption_number").removeClass("border-danger");
        taxLine.find(".excemption_issueDate").removeClass("border-danger");
        taxLine.find(".excemption_institutionName").removeClass("border-danger");
        taxLine.find(".excemption_percentage").removeClass("border-danger");
    }

    const taxPercentage = parseFloat(taxLine.find(".taxPercentage").val());
    const excemption_percentage = parseFloat(taxLine.find(".excemption_percentage").val());

    if (!isNaN(taxPercentage) && !isNaN(excemption_percentage) && excemption_percentage > taxPercentage) {
        notificacion("El porcentaje de exoneración no puede ser mayor al porcentaje de impuesto.", "", "info");

        //Colocar el porcentaje de exoneracion en el taxPercentage
        taxLine.find(".excemption_percentage").val(taxPercentage);
    }

    if (validExcemption) {
        //Activar el boton de finalizar detalle
        taxLine.parents(".detail").find(".btn-fin-det").attr("disabled", false);
    } else {
        //Desactivar el boton de finalizar detalle
        taxLine.parents(".detail").find(".btn-fin-det").attr("disabled", true);
    }

    return validExcemption;
}

$(document).ready(function () {
    //Cuando sale del campo .excemption_number
    $(document).on("blur", ".excemption_number", function () {
        buscar_exoneracion($(this).val(), $(this).parents(".taxLine"));
    });

    //Cuando cambia el campo .excemption_percentage
    $(document).on("change keyup", ".excemption_percentage", function () {
        //Calcular la linea activa
        calcular($(this).parents(".detail"));
    });

    //Cuando cambia el campo .taxPercentage
    $(document).on("change keyup", ".taxPercentage", function () {
        //Colocar el valor en el max de excemption_percentage
        const taxLine = $(this).parents(".taxLine");

        setExcemptionMax(taxLine);
    });

    //Cuando cambia el campo detailTaxType
    $(document).on("change", ".detailTaxType", function () {
        //Eliminar el porcentaje de impuesto
        $(this).parents(".taxLine").find(".taxPercentage").val("");

        const taxLine = $(this).parents(".taxLine");
        const taxesTable = $(this).parents(".taxesTable");

        const selectedIva = validar_impuestos_iva(taxesTable, taxLine);

        if (!selectedIva) {
            validar_impuestos_detalle($(this).parents(".detail"));
        }

        calcular($(this).parents(".detail"));
        calcular_valor_producto(elemento_activo, true);
    });

    //Cuando el usuario da click en btn-elm-excemption
    $(document).on("click", ".btn-elm-excemption", function () {
        vaciarExoneracion(this);

        calcular($(this).parents(".detail"));
    });
}); //Fin del document ready
