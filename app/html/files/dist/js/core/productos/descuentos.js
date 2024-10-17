/** Contar las lineas de descuento del formulario */
function contar_descuentos_producto() {
    var lineas = 0;

    const form = $("#" + form_activo);

    form.find(".discounts")
        .find(".discountLine")
        .each(function () {
            var inputs = $(this).find("input");

            //Recorrer los inputs de la nueva linea
            inputs.each(function (index, input) {
                if ($(input).attr("name") != undefined) {
                    //Obtener el nombre del input
                    const name = $(input).attr("name");

                    const newLineNumber = lineas;

                    const newFieldName = name.replace(/discounts\[\d+\]/, `discounts[${newLineNumber}]`);

                    //Asignar el nuevo nombre al input
                    $(input).attr("name", newFieldName);
                }
            });

            //Incrementar la cantidad de lineas
            lineas++;
        });

    return lineas;
}

/**Agregar una linea de descuento en el formulario */
function agregar_descuento_producto() {
    const form = $("#" + form_activo);
    var cantidad_lineas = form.find(".discounts").find(".discountLine").length;

    //Si ya hay 5 lineas de descuento, mostrar un mensaje de error
    if (cantidad_lineas >= 5) {
        notificacion("Solo se pueden agregar 5 descuentos.", "", "warning");
        return;
    }

    //Obtener la tabla de descuentos de la linea activa
    var discountsTable = form.find(".discounts");

    //Obtener la ultima linea de descuento de la tabla
    var ultima_linea = discountsTable.find(".discountLine").last();

    //Si la ultima linea tiene un descuento de 0, no se puede agregar otra linea
    if (ultima_linea.find(".discount_percentage").val() == 0 || ultima_linea.find(".discount_reason").val() == "") {
        notificacion("No se puede agregar un descuento si el anterior no se ha completado.", "", "warning");
        return;
    }

    //Clonar la ultima linea de descuento
    var nueva_linea = ultima_linea.clone();

    nueva_linea = limpiar_descuento(nueva_linea);

    //Agregar la nueva linea a la tabla
    discountsTable.append(nueva_linea);

    contar_descuentos_producto();

    //Activar los btn-dlt de la tabla
    discountsTable.find(".btn-dlt").attr("disabled", false);

    return nueva_linea;
} //Fin del metodo descuento_producto

/**
 * Limpiar los campos de una linea de descuento
 *
 * @param {*} linea
 * @returns La linea de descuento con los campos limpios
 */
function limpiar_descuento(linea) {
    //Limpiar los campos de la linea de descuento
    linea.find(".discount_reason").val("");
    linea.find(".discount_percentage").val(0);
    linea.find(".discount_amount_money").val(formato_moneda(0));
    linea.find(".discount_amount").val(0);

    return linea;
}

/**
 * Elimina la linea de descuento de la cual se presiono el boton
 * @param {*} boton Boton de eliminar de la linea de descuento
 */
function eliminar_descuento_producto(boton) {
    var discountLine = $(boton).closest(".discountLine");

    //Si es la ultima linea de descuento en la discounts padre, deshabilitar el boton
    if (discountLine.siblings(".discountLine").length == 0) {
        discountLine.closest(".discounts").find(".btn-dlt").attr("disabled", true);

        limpiar_descuento(discountLine);
    } else {
        discountLine.remove();
    }

    contar_descuentos_producto();

    calcular_valor_producto(form_activo);
} //Fin del metodo eliminar_descuento

/**
 * Elmiminar los descuentos de una linea
 * @param {*} linea
 */
function eliminarDescuentosProducto() {
    const form = $("#" + form_activo);

    //Validar si hay mas de una linea de descuento
    if (form.find(".discounts").find(".discountLine").length > 1) {
        //Eliminar las lineas de descuento
        form.find(".discounts").find(".discountLine").not(":first").remove();
    }

    //Limpiar la linea de descuento
    limpiar_descuento(form.find(".discounts").find(".discountLine").first());

    validateDiscountLines(form_activo);
}

/**
 * Agregar un descuento a una linea de descuento
 * @param {*} discountLine
 * @param {*} descuento
 */
function descuento_producto(discountLine, descuento = null) {
    console.log("Descuento: ", descuento);
    console.log("DiscountLine: ", discountLine);

    if (descuento != null) {
        discountLine.find(".discount_reason").val(descuento.reason);
        discountLine.find(".discount_percentage").val(descuento.percentage);
    }
}

function agregar_descuentos_producto(descuentos = []) {
    eliminarDescuentosProducto();
    const form = $("#" + form_activo);
    var discountsTable = form.find(".discounts");
    var discountLine = discountsTable.find(".discountLine").first();

    for (var i = 0; i < descuentos.length; i++) {
        var descuento = descuentos[i];

        if (i == 0) {
            descuento_producto(discountLine, descuento);
        } else {
            discountLine = agregar_descuento_producto();
            descuento_producto(discountLine, descuento);
        }
    }
}

/** Calcular el valor de los descuentos de una linea de detalle */
function calcular_descuentos_producto() {
    const form = $("#" + form_activo);

    let descuento_total = 0;

    let netValue = form.find(".netValue").val();

    if (netValue == "" || isNaN(netValue)) {
        netValue = 0;
    }

    const discounts = form.find(".discounts");

    discounts.find(".discountLine").each(function (i, discountLine) {
        descuento_total += calcular_descuento_producto(discountLine, netValue);
    });

    const subtotal = new Decimal(netValue).minus(descuento_total).toDecimalPlaces(5).toNumber();

    //Colocar el valor total de los descuentos
    form.find(".total_discount").val(descuento_total);
    form.find(".total_discount_money").val(formato_moneda(descuento_total, 5));

    form.find(".subtotal").val(subtotal);

    validateDiscountLines(form_activo);

    return descuento_total;
} //Fin del metodo calcular_descuento

/**Calcular el descuento de una linea */
function calcular_descuento_producto(discountLine, netValue = 0) {
    const form = $("#" + form_activo);

    let descuento = 0;

    if (netValue == null) {
        netValue = form.find(".netValue").val();
    } else {
        if (isNaN(netValue) || netValue == "") {
            netValue = 0;
        }
    }

    let discount_percentage = $(discountLine).find(".discount_percentage").val();

    console.log("Descuento: ", discount_percentage);

    if (discount_percentage == "" || isNaN(discount_percentage)) {
        discount_percentage = 0;
    } else {
        discount_percentage = parseInt(discount_percentage);
    }

    if (discount_percentage > 0) {
        console.log("NetValue: ", netValue);

        descuento = new Decimal(netValue).times(discount_percentage).dividedBy(100).toDecimalPlaces(5).toNumber();
    }

    console.log("Descuento: ", descuento);

    $(discountLine).find(".discount_amount").val(descuento);

    //Colocar el descuento en la linea de descuento
    $(discountLine).find(".discount_amount_money").val(formato_moneda(descuento, 5));

    return descuento;
} //Fin del metodo calcular_descuento

function validateDiscountLines(form_activo = "") {
    const form = $("#" + form_activo);
    const discountsTable = form.find(".discounts");

    const discountLines = discountsTable.find(".discountLine");

    let valid = true;

    discountLines.each(function (index, discountLine) {
        const discountReason = $(discountLine).find(".discount_reason").val();
        const discountPercentage = $(discountLine).find(".discount_percentage").val();

        //Si la razon no existe y el porcentaje es 0, no se toma en cuenta
        if (discountReason == "" && (discountPercentage == "" || discountPercentage == 0)) {
            //Reomover el borde rojo de la razon
            $(discountLine).find(".discount_reason").removeClass("border-danger");

            //Reomover el borde rojo del porcentaje
            $(discountLine).find(".discount_percentage").removeClass("border-danger");

            //Si solo hay una linea de descuento, desactivar el boton de eliminar
            if (discountLines.length == 1) {
                $(discountLine).find(".btn-dlt").attr("disabled", true);
            }
        } else {
            //Si existe una razon y un porcentaje, quitar el borde rojo
            if (discountReason != "" && discountPercentage != "" && discountPercentage > 0) {
                $(discountLine).find(".discount_reason").removeClass("border-danger");
                $(discountLine).find(".discount_percentage").removeClass("border-danger");
            } else {
                valid = false;

                //Si el porcentaje es menor a 0 o no existe, poner el borde rojo en el porcentaje
                if (discountPercentage == "" || discountPercentage <= 0) {
                    $(discountLine).find(".discount_percentage").addClass("border-danger");
                }

                //Si la razon no existe y el porcentaje es mayor a 0, poner el borde rojo en la razon
                if (discountReason == "" && (discountPercentage != "" || discountPercentage > 0)) {
                    $(discountLine).find(".discount_reason").addClass("border-danger");
                }
            }

            //Actvivar el boton de eliminar
            $(discountLine).find(".btn-dlt").attr("disabled", false);
        }
    });

    return valid;
}

/**
 * Contar el porcentaje de los descuentos de un producto
 * @param {*} form_activo  Formulario activo
 * @returns El porcentaje total de los descuentos
 */
function contarPorcentajeDescuentos(form_activo) {
    const form = $("#" + form_activo);
    var total_porcentaje = 0;

    form.find(".discounts")
        .find(".discountLine")
        .each(function () {
            var percentage = $(this).find(".discount_percentage").val();

            if (percentage == "" || isNaN(percentage)) {
                percentage = 0;
            }

            total_porcentaje += parseInt(percentage);
        });

    return total_porcentaje;
}

$(document).ready(function () {
    //Cuando cambia el netValue
    $(document).on("change keyup", ".discount-inp", function () {
        //Validar si el elemento tiene la clase discount_percentage
        if ($(this).hasClass("discount_percentage")) {
            let percentage = $(this).val();

            //Validar si el porcentaje es un numero
            if (isNaN(percentage) || percentage == "") {
                percentage = 0;
            }

            //Parsear el porcentaje a entero
            percentage = parseInt(percentage);

            $(this).val(percentage);

            //Colocar el porcentaje en el input
            //$(this).val(percentage);

            percentage = contarPorcentajeDescuentos(form_activo);

            //Si el porcentaje es mayor a 100, mostrar un mensaje de error
            if (percentage > 100) {
                notificacion("El total de los descuentos no puede ser mayor al 100%.", "", "warning");
                $(this).val(0);
            }

            calcular_valor_producto(form_activo);
        }

        validateDiscountLines(form_activo);
    });
}); //Fin del document ready
