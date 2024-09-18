/** Contar las lineas de descuento del formulario */
function contar_descuentos_producto() {
  var lineas = 0;

  const form = "#" + form_activo;

  $(form)
    .find(".discounts")
    .find(".discountLine")
    .each(function () {
      var inputs = $(this).find("input");

      //Recorrer los inputs de la nueva linea
      inputs.each(function (index, input) {
        if ($(input).attr("name") != undefined) {
          //Obtener el nombre del input
          const name = $(input).attr("name");

          const newLineNumber = lineas;

          const newFieldName = name.replace(
            /discounts\[\d+\]/,
            `discounts[${newLineNumber}]`
          );

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
  const form = "#" + form_activo;
  var cantidad_lineas = $(form).find(".discounts").find(".discountLine").length;

  //Si ya hay 5 lineas de descuento, mostrar un mensaje de error
  if (cantidad_lineas >= 5) {
    notificacion("Solo se pueden agregar 5 descuentos.", "", "warning");
    return;
  }

  //Obtener la tabla de descuentos de la linea activa
  var table_descuentos = $(form).find(".discounts");

  //Obtener la ultima linea de descuento de la tabla
  var ultima_linea = table_descuentos.find(".discountLine").last();

  //Si la ultima linea tiene un descuento de 0, no se puede agregar otra linea
  if (
    ultima_linea.find(".discount_percentage").val() == 0 ||
    ultima_linea.find(".discount_reason").val() == ""
  ) {
    notificacion(
      "No se puede agregar un descuento si el anterior no se ha completado.",
      "",
      "warning"
    );
    return;
  }

  //Clonar la ultima linea de descuento
  var nueva_linea = ultima_linea.clone();

  nueva_linea = limpiar_descuento(nueva_linea);

  //Agregar la nueva linea a la tabla
  table_descuentos.append(nueva_linea);

  contar_descuentos_producto();

  //Activar los btn-dlt de la tabla
  table_descuentos.find(".btn-dlt").attr("disabled", false);

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
  const form = "#" + form_activo;
  var table_descuentos = $(form).find(".discounts");
  var discountLine = table_descuentos.find(".discountLine").first();

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
  var descuento_total = 0;

  var descuento = 0;

  const form = "#" + form_activo;

  var netValue = $(form).find(".netValue").val();

  netValue = parseFloat(netValue);

  var discounts = $(form).find(".discounts");

  discounts.find(".discountLine").each(function (i, discountLine) {
    descuento = calcular_descuento_producto(discountLine);
    descuento_total += descuento;
  });

  //Si el descuento es 0 y solo hay una linea de descuento, desactivar el btn-dlt
  if (descuento_total == 0 && discounts.find(".discountLine").length == 1) {
    discounts.find(".btn-dlt").attr("disabled", true);
  } else {
    discounts.find(".btn-dlt").attr("disabled", false);
  }

  descuento_total = parseFloat(descuento_total);

  //Colocar el valor del subtotal
  var subtotal = netValue - descuento_total;

  console.log("Subtotal: " + subtotal);

  //Colocar el valor total de los descuentos
  $(form).find(".total_discount").val(descuento_total);
  $(form)
    .find(".total_discount_money")
    .val(formato_moneda(descuento_total, 2, monedaDocumento));

  $(form).find(".subtotal").val(subtotal);
  $(form)
    .find(".subtotal_money")
    .val(formato_moneda(subtotal, 2, monedaDocumento));

  return descuento_total;
} //Fin del metodo calcular_descuento

/**Calcular el descuento de una linea */
function calcular_descuento_producto(discountLine = null) {
  const form = "#" + form_activo;

  var descuento = 0;
  var total_descuento = 0;

  if (discountLine != null) {
    var discount_percentage = parseInt(
      $(discountLine).find(".discount_percentage").val()
    );

    if (discount_percentage != "" && discount_percentage > 0) {
      //Obtener el valor netValue de la linea
      var netValue = $(form).find(".netValue").val();

      netValue = parseFloat(netValue);
      discount_percentage = parseFloat(discount_percentage);

      console.log("NetValue: " + netValue);
      console.log("Descuento: " + discount_percentage);

      //Calcular el descuento
      descuento = (discount_percentage * netValue) / 100;

      //Redondear el descuento
      descuento = parseFloat(descuento);
    }

    $(discountLine).find(".discount_amount").val(descuento);

    //Colocar el descuento en la linea de descuento
    $(discountLine)
      .find(".discount_amount_money")
      .val(formato_moneda(descuento, 2, monedaDocumento));

    //Obtener el total de los descuentos
    total_descuento = $(form).find(".total_discount").val();

    //Si el total de los descuentos no esta vacio y es mayor a 0
    if (total_descuento != "" && total_descuento > 0) {
      //Sumar el total de los descuentos
      total_descuento = parseFloat(total_descuento + descuento);
    } else {
      total_descuento = descuento;
    }

    //Colocar el total de los descuentos
    $(form).find(".total_discount").val(total_descuento);

    total_descuento = formato_moneda(total_descuento, 2, monedaDocumento);

    $(form).find(".total_discount_money").val(total_descuento);
  } //Fin de validacion de linea

  return descuento;
} //Fin del metodo calcular_descuento
