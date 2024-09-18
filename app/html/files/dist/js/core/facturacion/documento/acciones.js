var factura_activa = "";
var id_factura_activa = 0;

/**Finalizar el documento activo */
function finalizar_documento() {
  //Mostrar el .mopdal-finalizar de la factura activa
  $("#" + factura_activa)
    .find(".modal-cierre")
    .modal("show");

  //Validar si el documento tiene los campos requeridos
  if (validar_documento()) {
    //Habilitar el boton de finalizar
    $("#" + factura_activa)
      .find(".btn-guardar-documento")
      .attr("disabled", false);
  } else {
    //Deshabilitar el boton de finalizar
    $("#" + factura_activa)
      .find(".btn-guardar-documento")
      .attr("disabled", true);
  }
}

function validar_documento() {
  var valido = true;

  //Validar si los campos que tienen la clase .required estan llenos
  $("#" + factura_activa)
    .find(".required")
    .each(function () {
      if ($(this).val() == "") {
        valido = false;
      }
    });

  return valido;
}

/**Eliminar el documento activo en la pantalla */
function cancelar_documento() {
  //Cerrar el modal de cierre de factura
  $("#" + factura_activa)
    .find(".modal-cierre")
    .modal("hide");

  //Esperar un segundo
  setTimeout(function () {
    //Eliminar el contenido de la factura activa
    $("#" + factura_activa).empty();

    //Ocultar el boton de la factura activa
    $(".col-btn-fct-" + id_factura_activa).hide();

    //Cargar documentos
    cargar_documentos("emitidos");
  }, 1000);
}

/**Ver el contenedor de una factura */
function ver_factura(id_factura) {
  factura = "card-factura-" + id_factura;

  //Si la factura esta vacia o no existe
  if ($("#" + factura).length == 0 || $("#" + factura).is(":empty")) {
    mensajeAutomatico("Atencion", "No existe factura con ese ID", "info");
  } else {
    submodulo_activo = "facturacion";

    factura_activa = factura;
    id_factura_activa = id_factura;

    //Ocultar el contenedor de documentos
    $("#listado_documentos").hide();

    //Mostrar el contenedor de facturas
    $(".contenedor_facturas").show();

    //Ocultar todas las facturas
    $(".card-factura").hide();

    //Expand .card-opciones-documentos
    $(".card-finalizar").CardWidget("expand");

    //Collapse .card-opciones
    $(".card-opciones").CardWidget("collapse");

    //Contraer el card-opciones-reporte
    $(".card-opciones-reporte").CardWidget("collapse");

    //Ocultar .cont-reporte
    $(".cont-reporte").hide();

    //Desactivar boton de documentos
    $(".btn-documentos").removeClass("btn-warning").addClass("btn-dark");

    //Ocultar boton .btn-walmart
    $(".col-walmart").hide();

    //Habilitar los botones de facturas
    $(".btn-factura").attr("disabled", false);

    //Habilitar el boton de documentos
    $(".btn-documentos").attr("disabled", false);

    //Deshabilitar el boton de la factura
    $("#btn_factura_" + id_factura).attr("disabled", true);

    //Seleccionar el tipo de cambio
    selectTipoCambio();

    $("#" + factura_activa).show();

    //Obtener el id de tipo de documento
    var documentTypeCode = $("#" + factura_activa)
      .find(".documentTypeCode")
      .val();

    //Collapse .card-opciones-documentos
    $(".card-opciones-documentos").CardWidget("collapse");

    //Eliminar las clases de los botones de la factura
    $(".btn-factura")
      .removeClass(
        "btn-success btn-warning btn-danger btn-secondary btn-purple btn-info"
      )
      .addClass("btn-dark");

    //Validar el tipo de documento
    switch (documentTypeCode) {
      case "01":
        //Activar el boton de la factura
        $("#btn_factura_" + id_factura)
          .addClass("btn-success")
          .removeClass("btn-dark");
        break;

      //Nota de debito
      case "02":
        //Activar el boton
        $("#btn_factura_" + id_factura)
          .addClass("btn-warning")
          .removeClass("btn-dark");
        break;

      //Nota de credito
      case "03":
        //Activar el boton
        $("#btn_factura_" + id_factura)
          .addClass("btn-danger")
          .removeClass("btn-dark");
        break;

      //Tiquete de venta
      case "04":
        //Activar el boton
        $("#btn_factura_" + id_factura)
          .addClass("btn-secondary")
          .removeClass("btn-dark");
        break;

      //Factura de compras
      case "08":
        //Activar el boton
        $("#btn_factura_" + id_factura)
          .addClass("btn-purple")
          .removeClass("btn-dark");
        break;

      default:
        //Activar el boton de la factura
        $("#btn_factura_" + id_factura)
          .addClass("btn-info")
          .removeClass("btn-dark");
        break;
    } //Fin del switch

    //Obtener la identificacion del modal de la factura activa
    var identificacion = $("#" + factura_activa)
      .find(".customerId")
      .val();

    if (identificacion != "") {
      obtener_cliente(identificacion);
    }

    $(".col-referencia").show();

    //Mostrar el card-opciones-documentos
    $(".card-opciones-documentos").CardWidget("expand");

    //Contar las lineas de la factura
    contar_lineas();

    //Poner el titulo
    poner_titulo("Documentos", "Facturacion");

    //Activar tooltip
    activar_tooltips();

    //Poner el cursor en el campo de codigo de barras (gnl) de la factura activa
    $(".contenedor_facturas").find(".gnl-agregar").focus();
  }
} //Fin de la funcion ver_factura

/**Ver un documento en pdf */
function verPdf(url) {
  $.ajax({
    url: base + "documentos/ver_pdf",
    data: {
      documentUrl: url,
    },
    dataType: "html",
  }).done(function (response) {
    //Vaciar los datos del contenedor_pdf
    $("#contenedor_pdf").empty();

    //Agregar el contenido del pdf
    $("#contenedor_pdf").append(response);

    $("#modalVerPdf").modal("show");
  });
} //Fin de la función verPdf

function descargarPdf(url, fileName) {
  axios.get(url, { responseType: "blob" }).then((response) => {
    const blob = new Blob([response.data], {
      type: "application/octet-stream",
    });
    const url = window.URL.createObjectURL(blob);
    const anchor = document.createElement("a");
    anchor.href = url;
    anchor.download = fileName + ".pdf";
    anchor.click();

    mensajeAutomatico("Atencion", "Se ha descargado el archivo", "success");
  });
  //Acceder a la nueva ventana
  //window.open(url, '_blank');
}

/*function descargarPdf(url, documentName) {
    
    //Se debe crear una nueva ventana sin url
    var win = window.open('', '_blank');

    //Poner el header para descargar el archivo:
        //'Content-Type: application/Force-Download'
        //'Content-Disposition: attachment; filename="'.$data['nombre_archivo'].'.pdf"'

    win.onload = function() {
        win.document.title = 'Descargar PDF';
        win.document.head.innerHTML = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
        win.document.head.innerHTML += '<meta http-equiv="Content-Type" content="application/Force-Download">';
        win.document.head.innerHTML += '<meta http-equiv="Content-Disposition" content="attachment; filename="' + documentName + '.pdf">';
    };

    //Cargar el pdf en la nueva ventana
    win.location = url;

    //Descargar el pdf (sin usar execCommand('SaveAs'))
    

    //Esperar un segundo
    setTimeout(function () {
        //Cerrar la ventana
        win.close();
    }, 3000);
}//Fin de la función descargarPdf*/

/**Agregar referencias al documento */
function agregar_referencias() {
  //Mostrar el modal de referencias de la factura activa
  $("#" + factura_activa)
    .find(".modal-referencias")
    .modal("show");
} //Fin de la funcion agregar_referencias

/**Ver la información de Walmart del documento */
function ver_walmart() {
  //Ocultar el contenedor de tiendas en .modal-walmart
  $("#" + factura_activa)
    .find(".modal-walmart")
    .find(".contenedor-tiendas")
    .hide();

  //Mostrar el contenedor de datos en .modal-walmart
  $("#" + factura_activa)
    .find(".modal-walmart")
    .find(".contenedor-datos")
    .show();

  //Mostrar el .modal-walmart de la factura activa
  $("#" + factura_activa)
    .find(".modal-walmart")
    .modal("show");

  activar_tooltips();
} //Fin de la funcion ver_walmart

/**
 * Agregar el termino de credito a la factura
 * @param {select} select
 * @returns {void}
 */
function agregar_termino_credito(select) {
  let option = $(select).find("option:selected");
  let termino = $(option).data("creditterm");

  $("#" + factura_activa)
    .find(".creditTerm")
    .val(termino);
} //Fin de la función agregar_termino_credito
