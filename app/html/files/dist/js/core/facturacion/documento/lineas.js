var linea_activa = null;

var tblDetalles_activa = null;

var lineas_activas = 0;

var monedaDocumento = "CRC";
var tipoCambioDocumento = 1;

/**Mostrar el modal detalles de la linea */
function mostrar_detalles(boton) {
    if (boton != null) {
        linea_activa = $(boton).parents(".detail");
    }

    //Mostrar el .modal_detalle de la linea
    linea_activa.find(".modal_detalle").modal("show");

    //CardWidget collapse a todos los card del modal
    linea_activa.find(".modal_detalle").find(".card").CardWidget("collapse");
} //Fin del metodo mostrar_detalles

/**Eliminar una linea de la facura activa */
function eliminar_linea(boton_eliminar) {
    const linea = $(boton_eliminar).parents(".detail");
    const activeDocument = $("#" + factura_activa);

    //Si solo queda una linea en la factura
    if (activeDocument.find(".detail").length == 1) {
        //Agregar una nueva linea
        aumentar_linea();
    }

    //Eliminar la linea de la factura
    $(linea).remove();

    //Contar las lineas de la factura
    contar_lineas();

    //Calcular el total de la factura
    totales();
} //Fin de la funcion eliminar_linea

/**Agregar un producto en la linea activa o una linea que tenga la misma informacion */
function agregar_linea_activa(producto, cantidad = 1, precio_final = 0) {
    let linea = linea_activa;

    //Obtener el codigo del producto
    var codigo = producto.category.code;
    var taxPercentage = 0;
    var codigo_venta = 0;

    const activeDocument = $("#" + factura_activa);

    if (producto.codes != null && producto.codes.length > 0) {
        console.log(producto.codes);

        //Crear un foreach para recorrer los codigos
        producto.codes.forEach(function (code) {
            //Si el tipo de codigo es igual a 1
            if (code.codeType.code == "03") {
                //Colocar el codigo de venta
                codigo_venta = code.number;
            }
        });

        if (codigo_venta == 0) {
            codigo_venta = lineas_activas + 1;
        }
    } else {
        codigo_venta = lineas_activas + 1;
    }

    //Si solo hay una linea
    if (activeDocument.find(".detail").length == 1) {
        linea = activeDocument.find(".detail");

        if (linea.find(".saleCode").val() != "" && linea.find(".saleCode").val() != 0) {
            //&& (linea.find(".cabys").val() != 0 || linea.find(".cabys").val() != '')) {
            linea = aumentar_linea();
        }
    } else {
        //Recorrer las lineas de la factura
        activeDocument.find(".detail").each(function () {
            //Si la linea es igual al producto
            if ($(this).find(".saleCode").val() == codigo_venta) {
                //Obtener la cantidad de la linea
                var cantidad_linea = $(this).find(".quantity-det").val();

                //Sumar la cantidad de la linea activa con la cantidad de la linea
                cantidad = parseFloat(cantidad) + parseFloat(cantidad_linea);

                linea = $(this);
            }
        });

        //Si la linea no fue encontrada
        if (linea == null) {
            linea = aumentar_linea();
        }
    }

    //Colocar la linea activa
    linea_activa = linea;

    //Si se ha definido descuentos en el producto (la variable discounts no es null o vacia)
    if (producto.discounts != null && producto.discounts.length > 0) {
        agregar_descuentos(linea, producto.discounts);
    }

    //Si el producto tiene impuestos
    if (producto.taxes != null && producto.taxes.length > 0) {
        taxPercentage = agregar_impuestos_api(linea, producto.taxes);
    }

    var salePrice = producto.salePrice;

    linea.find(".productId").val(producto.productId);
    linea.find(".description").val(producto.name);
    linea.find(".cabys").val(codigo);
    linea.find(".saleCode").val(codigo_venta);
    linea.find(".quantity-det").val(cantidad);
    linea.find(".unitId").val(producto.measurementUnit.unitId);

    //Si el precio final es difernte de 0
    if (precio_final != 0 && precio_final != salePrice) {
        //Obtener el monto del impuesto del precio final
        var impuesto = precio_final - precio_final / (taxPercentage / 100 + 1);

        //Restar el porcentaje de impuesto del precio
        precio_final = parseFloat(precio_final) - parseFloat(impuesto);

        //Poner el precio en entero
        salePrice = parseFloat(precio_final);

        //Colocar el precio original de venta (originalSalePrice)'
        linea.find(".originalSalePrice").val(salePrice);
    } else {
        var impuesto = salePrice - salePrice / (taxPercentage / 100 + 1);

        salePrice = parseFloat(salePrice) - parseFloat(impuesto);

        salePrice = parseFloat(salePrice);

        //Colocar el precio original de venta (originalSalePrice)'
        linea.find(".originalSalePrice").val(salePrice);
    }

    let tipoCambio = tipoCambioDocumento;

    if (tipoCambioDocumento != 1) {
        salePrice = salePrice / tipoCambio;
    }

    //Colocar el precio en la linea
    linea.find(".salePrice").val(salePrice);

    linea.find(".salePrice_money").val(formato_moneda(salePrice, 2, monedaDocumento));

    calcular(linea);

    //Mostrar el boton de eliminar linea
    linea.find(".eliminarLinea").prop("hidden", false);

    //Contar las lineas de la factura
    contar_lineas();

    //Eliminar el codigo de q_codigo_barras
    activeDocument.find(".gnl-agregar").val("");

    //Poner el foco en q_codigo_barras
    activeDocument.find(".gnl-agregar").focus();
}

/** Aumentar el numero de la ultima linea agregada al modulo */
function aumentar_linea() {
    //Clonar la linea
    cloneLine();

    //Incrementar el numero de lineas activas
    lineas_activas++;

    const activeDocument = $("#" + factura_activa);

    //Obtener la ultima linea del documento activo
    const linea = activeDocument.find(".detail").last();

    eliminarDescuentosLinea(linea);
    eliminar_impuestos(linea);

    //Agregar el valor a los botones de acciones
    $(linea).find(".descB").val(lineas_activas);
    $(linea).find(".eliminarLinea").val(lineas_activas);
    //$(linea).find(".btn-buscar-prod").val(lineas_activas);

    //Vaciar todos los campos tipo texto
    $(linea).find("input[type=text]").val("");

    //Vaciar todos los campos tipo numero
    $(linea).find("input[type=number]").val("0");

    //Vaciar todos los campos tipo select
    $(linea).find("select").val("");

    /**Colocar los valores de numero en 0 */
    //$(linea).find(".discount_percentage").val(0);
    $(linea).find(".salePrice").val(0);
    $(linea).find(".reason").val("");
    $(linea).find(".neto").val(0);
    $(linea).find(".total_discount").val(0);
    $(linea).find(".quantity-det").val(0);
    $(linea).find(".subtotal").val(0);
    $(linea).find(".tax_amount").val(0);
    $(linea).find(".totalL").val(0);
    $(linea).find(".totalVL").val(0);

    $(linea).find(".cabys").val("");
    $(linea).find(".saleCode").val("");

    //Agregar el numero de linea a la discountLine .numero_linea
    $(linea).find(".productId").val(lineas_activas);

    //Agregar el numero de linea a .numero_linea_lbl
    $(linea)
        .find(".numero_linea_lbl")
        .text("Linea " + lineas_activas);

    return $(linea);
} //Fin de la funcion aumentar_linea

/**Contar las lineas de detalle del documento activo */
function contar_lineas() {
    var lineas = 0;

    const activeDocument = $("#" + factura_activa);

    activeDocument.find(".detail").each(function () {
        //Aumentar el numero de lineas
        lineas++;

        //Colocar el numero de linea en la linea
        $(this).find(".numero_linea").val(lineas);
        $(this)
            .find(".numero_linea_lbl")
            .text("Linea " + lineas);

        //Activar los tooltips
        $(this).find('[data-toggle="tooltip"]').tooltip();

        //Si la linea no esta vacia
        if ($(this).find(".cabys").val() != "" && $(this).find(".saleCode").val() != "") {
            $(this).find(".eliminarLinea").prop("hidden", false);
        } else {
            $(this).find(".eliminarLinea").prop("hidden", true);
        }

        var inputs = $(this).find("input, select");

        //Recorrer los inputs de la nueva linea
        inputs.each(function (index, input) {
            //Validar si el input tiene nombre
            if ($(input).attr("name") != undefined) {
                //Obtener el nombre del input
                const name = $(input).attr("name");

                const newLineNumber = lineas - 1;

                const newFieldName = name.replace(/details\[\d+\]/, `details[${newLineNumber}]`);

                //Asignar el nuevo nombre al input
                $(input).attr("name", newFieldName);
            }
        });
    });

    //Poner el cursor en el campo de codigo de barras (gnl) de la factura activa
    activeDocument.find(".gnl-agregar").focus();

    return lineas;
}

/**Clonar una linea de la tabla */
function cloneLine() {
    const activeDocument = $("#" + factura_activa);

    //Agregar un clone de la ultima linea de la factura, en la tabla de detalles del documento
    activeDocument.find(".cont-details").append(activeDocument.find(".detail").last().clone());
} //Fin del metodo cloneLine

/**Calcular el valor total de una linea */
function calcular(linea) {
    var precio = linea.find(".salePrice").val();

    let moneda = monedaDocumento;

    if (precio != 0 && precio != "") {
        var cantidad = linea.find(".quantity-det").val();

        //Colocar los valores en la linea
        var neto = parseFloat(precio * cantidad);
        linea.find(".neto").val(neto);

        //Calcular el valor del descuento
        var descuento = calcular_descuentos(linea);

        //Calcular el valor de subtotal de la linea
        var subtotal = parseFloat(neto - descuento);

        //subtotal = parseFloat(subtotal);
        linea.find(".subtotal").val(subtotal);

        //Calcular el valor de impuesto de la linea
        var impuesto = calcular_impuestos(linea);

        //Calcular el valor total de la linea
        var total = parseFloat(subtotal + impuesto);

        linea.find(".totalL").val(total);

        neto = formato_moneda(neto, 2, moneda);
        linea.find(".netoVL").val(neto);

        subtotal = formato_moneda(subtotal, 2, moneda);
        linea.find(".subtotalVL").val(subtotal);

        total = formato_moneda(total, 2, moneda);
        linea.find(".totalVL").val(total);

        totales();
    }
}

/**Formatear un numero de acuerdo al pais */
function formato_moneda(numero, decimales = 0, currency = "CRC") {
    numero = numero.toLocaleString("es-CR", {
        style: "currency",
        currency: currency,
        minimumFractionDigits: decimales,
        maximumFractionDigits: decimales,
    });

    return numero;
} //Fin de la funcion para dar formato a un numero

function formato_numero(numero, decimales = 0) {
    numero = numero.toLocaleString("es-CR", {
        style: "decimal",
        minimumFractionDigits: decimales,
        maximumFractionDigits: decimales,
    });

    return numero;
}

/**Calcular el valor total del documento activo */
function totales() {
    var neto = 0;
    var descuentos = 0;
    var subtotal = 0;
    var IVA = 0;
    var total = 0;

    let moneda = monedaDocumento;

    const activeDocument = $("#" + factura_activa);

    activeDocument.find(".detail").each(function (i, item) {
        neto += parseFloat($(item).find(".neto").val());
        descuentos += parseFloat($(item).find(".total_discount").val());
        subtotal += parseFloat($(item).find(".subtotal").val());
        IVA += parseFloat($(item).find(".ivNeto").val());
        total += parseFloat($(item).find(".totalL").val());
    });

    activeDocument.find(".total_document").val(parseFloat(total).toFixed(2));


    //console.log("iva: " + IVA);

    neto = formato_moneda(neto, 2, moneda);
    descuentos = formato_moneda(descuentos, 2, moneda);
    subtotal = formato_moneda(subtotal, 2, moneda);
    IVA = formato_moneda(IVA, 2, moneda);
    total = formato_moneda(total, 2, moneda);

    activeDocument.find(".lbl_neto").val(neto);
    activeDocument.find(".lbl_descuentos").val(descuentos);
    activeDocument.find(".lbl_subtotal").val(subtotal);
    activeDocument.find(".lbl_iva").val(IVA);
    activeDocument.find(".lbl_total").val(total);

    validarMontoPagos();
}

/**
 * Validar el
 */
function validarMontoPagos() {
    const activeDocument = $("#" + factura_activa);

    let totalDocument = activeDocument.find(".total_document").val();

    if (totalDocument == "") {
        totalDocument = 0;
    } else {
        totalDocument = parseFloat(totalDocument);
    }

    let totalPagos = 0;

    //Sumar el total de los valores de .monto cuando no esten vacios o sean 0
    activeDocument.find(".monto").each(function (i, item) {
        if ($(item).val() != "" && $(item).val() != 0) {
            totalPagos += parseFloat($(item).val());
        }
    });

    //Validar si el total de pagos es mayor al total del documento
    console.log("totalPagos: " + totalPagos);

    console.log("totalDocument: " + totalDocument);

    console.log("totalPagos > totalDocument: " + (totalPagos > totalDocument));

    //Si el total de pagos es mayor al total del documento, mostrar un mensaje de error y bloquear el boton de finalizar
    if (totalPagos > totalDocument) {
        mensajeAutomatico("Atención", "El total de los pagos no puede ser mayor al total del documento", "error");

        activeDocument.find(".btn-guardar-documento").attr("disabled", true);

        //Colocar el border rojo en los campos de .monto
        activeDocument.find(".monto").addClass("border-danger");
    } else {
        activeDocument.find(".btn-guardar-documento").attr("disabled", false);

        //Quitar el border rojo en los campos de .monto
        activeDocument.find(".monto").removeClass("border-danger");
    }
}

$(document).ready(function () {
    $(document).on("keyup change", ".calcular", function () {
        linea_activa = $(this).parents(".detail");
        calcular(linea_activa);
    });

    //Cuando cambia el valor de .quantity
    $(document).on("keyup change", ".quantity-det", function () {
        //Obtener la linea activa
        linea_activa = $(this).parents(".detail");

        //Obtener el valor de la cantidad
        var cantidad = $(this).val();

        //Si la cantidad es mayor a 0
        if (cantidad > 0) {
            //Si la cantidad es mayor que 999999999
            if (cantidad > 999999999) {
                //Colocar en el campo de .quantity-det de la linea activa
                linea_activa.find(".quantity-det").val(999999999);

                cantidad = 999999999;

                mensajeAutomatico("Atención", "La cantidad no puede ser mayor a 999999999", "info");
            }

            //Colocar en el campo de .quantity-det de la linea activa
            linea_activa.find(".quantity-det-mod").val(cantidad);
        }
    });

    //Cuando cambia el valor de .quantity-det-mod
    $(document).on("keyup change", ".quantity-det-mod", function () {
        //Obtener la linea activa
        linea_activa = $(this).parents(".detail");

        //Obtener el valor de la cantidad
        var cantidad = $(this).val();

        //Si la cantidad es mayor a 0
        if (cantidad > 0) {
            //Colocar en el campo de .quantity-det de la linea activa
            linea_activa.find(".quantity-det").val(cantidad);
        }
    });

    //Cuando se enfoca el .gnl
    $(document).on("focus", ".gnl-agregar", function () {
        //Seleccionar la ultima .detail de la factura activa
        linea_activa = null;
    });

    //Cuando cambia el porcentaje de descuento o la razon
    $(document).on("change keyup", ".validar_linea", function () {
        var linea_activa = $(this).closest(".detail");

        let descuentos_validos = validar_descuentos_detalle(linea_activa);
        let impuestos_validos = validar_impuestos_detalle(linea_activa);

        if (!descuentos_validos || !impuestos_validos) {
            //Bloquear el boton de finalizar detalle 'btn-fin-det'
            linea_activa.find(".btn-fin-det").attr("disabled", true);
        } else {
            //Habilitar el boton de finalizar detalle 'btn-fin-det'
            linea_activa.find(".btn-fin-det").attr("disabled", false);
        }
    });

    //Cuando cambia un .monto
    $(document).on("change keyup", ".monto", function () {
        //Si hay un 0 por delante, eliminarlo
        if ($(this).val().charAt(0) == "0") {
            $(this).val($(this).val().substring(1));
        }

        validarMontoPagos();
    });
});
