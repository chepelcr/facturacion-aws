function selectTipoCambio() {
    const activeDocument = $("#" + factura_activa);

    //Obtener el option seleccionado en el select
    const option = activeDocument.find(".currencyCode").find("option:selected");

    //Obtener el valor data-currencyCode del option
    const moneda = $(option).data("currencycode");

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
    const activeDocument = $("#" + factura_activa);

    activeDocument.find(".detail").each(function (i, item) {
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

/**
 * Obtener el nombre de la moneda de acuerdo al código de moneda
 * @param {String} currencyCode Codigo de moneda
 * @returns Nombre de la moneda
 */
function getCurrencyName(currencyCode) {
    const formatter = new Intl.NumberFormat("es", {
        style: "currency",
        currency: currencyCode,
        currencyDisplay: "name",
    });
    let name = formatter.formatToParts(0).find((part) => part.type === "currency").value;

    //Colocar la primera letra en mayuscula
    name = name.charAt(0).toUpperCase() + name.slice(1);

    //Dejar solo la primera palabra
    name = name.split(" ")[0];

    return name;
}

/**
 * Colocar el nombre correcto de las monedas
 */
function setDocumentCurrencies() {
    const activeDocument = $("#" + factura_activa);
    const currencyCodeSelect = activeDocument.find(".currencyCode");

    let currencies = [];
    let currencyNames = [];

    //Recorrer el select de opciones y reemplazar el nombre, agregar el data-currencyCode a currencies y si se repite, elimina el option
    currencyCodeSelect.find("option").each(function (i, option) {
        const currencyCode = $(option).data("currencycode");
        let currencyName = getCurrencyName(currencyCode);

        if (currencies.includes(currencyCode) || currencyCode == "XXX") {
            $(option).remove();
        } else {
            //Si el currencyName no esta en la lista
            if (!currencyNames.includes(currencyName)) {
                currencyNames.push(currencyName);
                currencyName = currencyName + " " + currencyCode;

                console.log(currencyName);

                $(option).text(currencyName);
            } else {
                $(option).remove();
            }
        }
    });

    //Ordenar los options por el nombre de la moneda
    currencyCodeSelect.html(
        currencyCodeSelect.find("option").sort(function (a, b) {
            return $(a).text() > $(b).text() ? 1 : -1;
        })
    );
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
