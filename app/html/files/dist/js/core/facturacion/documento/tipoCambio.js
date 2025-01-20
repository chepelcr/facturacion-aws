function selectTipoCambio() {
  //Obtener el option seleccionado en el select
  var option = $("#" + factura_activa)
    .find(".currencyCode")
    .find("option:selected");

  //Obtener el valor data-currencyCode del option
  let moneda = $(option).data("currencycode");
  
  monedaDocumento = moneda;

  if (moneda == "CRC") {
    $("#" + factura_activa)
      .find(".exchangeRate")
      .val(1);

    tipoCambioDocumento = 1;

    activar_campo_clase("exchangeRate", true, factura_activa);
  } else if (moneda == "USD") {
    $("#" + factura_activa)
      .find(".exchangeRate")
      .val(cambio_venta);

    tipoCambioDocumento = cambio_venta;

    activar_campo_clase("exchangeRate", true, factura_activa);
  } else {
    $("#" + factura_activa)
      .find(".exchangeRate")
      .val(1);

    tipoCambioDocumento = 1;

    activar_campo_clase("exchangeRate", false, factura_activa);
  }

  cambiarPrecioLineas(tipoCambioDocumento);
}

function cambiarPrecioLineas(tipoCambio) {
  $("#" + factura_activa)
    .find(".detail")
    .each(function (i, item) {
      let originalPrice = $(item).find(".originalSalePrice").val();
      let newPrice = originalPrice / tipoCambio;

      newPrice = parseFloat(newPrice);
      newPrice.toFixed(2);

      $(item).find(".netPrice").val(newPrice);

      let originalBaseAmount = $(item).find(".originalBaseAmount").val();

      let newBaseAmount = originalBaseAmount / tipoCambio;

      newBaseAmount = parseFloat(newBaseAmount);
      newBaseAmount.toFixed(2);

      $(item).find(".base_imponible").val(newBaseAmount);

      calcular($(item));
    });
}

$(document).ready(function () {
  //Cuando cambia calcular_tipo_cambio
  $(document).on("keyup change", ".calcular_tipo_cambio", function () {
    let valor = $(this).val();

    tipoCambioDocumento = valor;

    //Si el valor es diferente de 0, se debe recorrer cada una de las lineas de detalle y cambiar el salePrice por (originalPrice / valor) y calcular el total de la linea
    if (valor != 0) {
      cambiarPrecioLineas(valor);
    }
  });
});
