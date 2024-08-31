/**
 * Estado de la aplicacion
 */
var estado_app = "loading";

/**
 * Cargar el modulo de inicio de un modulo
 *
 * @param {string} nombre_modulo Nombre del modulo
 * @param {string} vista_modulo Nombre visual del modulo
 */
function cargar_inicio_modulo(nombre_modulo, vista_modulo = "") {
  modulo_activo = nombre_modulo;
  submodulo_activo = "";

  poner_titulo(vista_modulo);

  desactivar_tooltips();

  if (nombre_modulo == "documentos") {
    cargar_modulo("contenedor_" + nombre_modulo);

    cargar_documentos("emitidos");
  } else {
    activar_modulo_boton(nombre_modulo);

    cargar_modal("modal-" + nombre_modulo);
  }

  activar_tooltips();
}

/**
 * Metodo de precarga de la aplicacion
 */
function loading() {
  var num = 0;
  $(".content-wrapper").hide();
  $(".main-header").hide();
  $(".main-footer").hide();

  for (i = 0; i <= 100; i++) {
    setTimeout(function () {
      if (num == 100) {
        $(".loader").hide();

        $(".main-header").show();
        $(".main-footer").show();
        $(".content-wrapper").show();
        $(".navbar").show();

        obtener_tipo_cambio();

        cargar_inicio();

        estado_app = "ready";
      }
      num++;
    }, i * 40);
  }
}

/**
 * Cargar el modulo de inicio
 */
function cargar_inicio() {
  elemento_activo = "inicio";
  form_activo = "";

  modulo_activo = "inicio";
  submodulo_activo = "";

  poner_titulo("Inicio");
  desactivar_tooltips();

  //Cargar el modulo de inicio
  cargar_modulo("inicio");

  //Activar el boton de inicio
  activar_modulo_boton("inicio");

  activar_tooltips();
}

/**
 * Obtener el tipo de cambio de la moneda
 * @param {string} indicador
 */
function obtener_tipo_cambio(indicador = "") {
  if (indicador == "") {
    Pace.track(function () {
      $.ajax({
        url: base + "documentos/indicadores",
        method: "GET",
        dataType: "json",
      }).done(function (response) {
        cambio_compra = response.compra;
        cambio_venta = response.venta;

        //Colocar el tipo de cambio en los campos tipo_compra y tipo_venta
        $("#tipo_compra").val(cambio_compra);
        $("#tipo_venta").val(cambio_venta);

        notificacion("Se ha actualizado el tipo de cambio", "", "success");
      });
    });
  } else {
    Pace.track(function () {
      $.ajax({
        url: base + "documentos/indicadores/" + indicador,
        method: "GET",
        dataType: "json",
      }).done(function (response) {
        return response.tipo_cambio;
      });
    });
  }
} //Fin de la funcion para obtener el tipo de cambio

/**
 * Abrir el modal del tipo de cambio
 */
function abrirTipoCambio() {
  $("#modal-tipo-cambio").modal("show");
}
