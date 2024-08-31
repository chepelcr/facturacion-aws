/**
 * Tabla de datos de la vista
 */
let table = null;

/**
 * Fila actual de la tabla
 */
var fila_actual = null;

/**
 * URL del listado
 */
var url_listado = "";

/**
 * Nombre de la vista del modulo
 */
let nombre_vista_modulo = "";

/**
 * Nombre de la vista del submodulo
 * */
let nombre_vista_submodulo = "";

/**
 * Cargar el listado en el contenedor
 * @param {string} modulo Nombre del modulo
 * @param {string} submodulo Nombre del submodulo
 * @param {string} vista_modulo Nombre visual del modulo
 * @param {string} vista_submodulo Nombre visual del submodulo
 * @param {string} url Url del listado
 */
function cargar_listado(
  modulo = "",
  submodulo = "",
  vista_modulo = "",
  vista_submodulo = "",
  url = ""
) {
  elemento_activo = "";
  formato = false;
  fila_actual = null;

  url_listado = url;

  nombre_vista_modulo = vista_modulo;
  nombre_vista_submodulo = vista_submodulo;

  desactivar_tooltips();

  if (modulo != "" && submodulo != "") {
    modulo_activo = modulo;
    submodulo_activo = submodulo;

    cargar_contenido(getLoadPage(), "cargando");

    Pace.track(function () {
      //Solicitar el submodulo
      $.ajax({
        url: url_listado,
        type: "GET",
      })
        .done(function (respuesta) {
          if (!respuesta.error) {
            cargar_contenido(respuesta, "listado");
          } else {
            //Mostrar la respuesta
            notificacion(respuesta.error, "", "error");

            //Cargar el listado
            cargar_contenido(getErrorPage(respuesta), "cargando");
          }
        })
        .fail(function (xhr, textStatus, errorThrown) {
          response = xhr.responseText;

          if (response != "") {
            response = JSON.parse(response);
          }

          //Mostrar la respuesta
          notificacion(response.error, "", "error");

          //Cargar el listado
          cargar_contenido(getErrorPage(response), "cargando");
        });
    });
  } //Fin if
} //Fin de cargar_listado

/**
 * Obtener pagina de carga
 *
 * @returns
 */
function getLoadPage() {
  let html =
    "<div class='d-flex justify-content-center'><div class='spinner-border text-primary' role='status'><span class='sr-only'>Cargando...</span></div></div>";

  return html;
}

/**
 * Obtener pagina de error
 * @param {string} error
 * @returns
 */
function getErrorPage(error) {
  let html =
    "<div class='card card-danger'><div class='card-header'><h3 class='card-title" +
    "'>Error</h3></div><div class='card-body'><p>" +
    error.error +
    "</p></div></div>";

  return html;
}

/**Cargar contenido en un contenedor o modal
 * @param {string} contenido Contenido a cargar
 */
function cargar_contenido(contenido, estado = "cargando") {
  var modulo = modulo_activo;
  var submodulo = submodulo_activo;

  var vista_modulo = nombre_vista_modulo;
  var vista_submodulo = nombre_vista_submodulo;

  var elemento = "modal-" + modulo + "-" + submodulo;

  //Mostrar la respuesta
  if (
    (modulo == "empresa" && submodulo == "ordenes") ||
    (modulo == "seguridad" &&
      (submodulo == "errores" || submodulo == "auditorias"))
  ) {
    //Cerrar todos los modal
    $(".modal").modal("hide");

    //Vaciar el contenedor de la pagina
    $("#contenedor").empty();

    //Agregar la respuesta
    $("#contenedor").append(contenido);

    cargar_modulo("contenedor");
  } else {
    //Vaciar el contenedor del modal
    $("#" + elemento)
      .find(".contenedor_submodulo")
      .empty();

    //Agregar el contenido al contenedor del modal
    $("#" + elemento)
      .find(".contenedor_submodulo")
      .append(contenido);

    if (
      modulo == "configuracion" &&
      (submodulo == "documentos" || submodulo == "empresa")
    ) {
      if (submodulo == "documentos") {
        campos_activos(true, "frm_configuracion_empresa");

        //Cerrar todos los card
        $("#frm_configuracion_empresa")
          .find(".card-frm")
          .CardWidget("collapse");

        campos_activos(true, "frm_llave_criptografica");

        //Cerrar todos los card
        $("#frm_llave_criptografica").find(".card-frm").CardWidget("collapse");
      } else if (submodulo == "empresa") {
        form_activo = "frm_informacion_empresa";

        campos_activos(true, form_activo);

        desactivar_ubicaciones();

        //Cerrar todos los card
        $("#" + form_activo)
          .find(".card-frm")
          .CardWidget("collapse");
      }
    } else {
      //Collapse el card-form del modal
      $("#" + elemento)
        .find(".card-frm")
        .hide();

      if (modulo == "empresa" && submodulo == "productos") {
        //Esconder el card-cabys
        $("#" + elemento)
          .find(".card-cabys")
          .hide();
      }

      //Mostrar el card-table del modal
      $("#" + elemento)
        .find(".card-table")
        .show();
    }

    if (elemento_activo != elemento) {
      cargar_modal(elemento);
    }
  }

  activar_modulo_boton(modulo, submodulo);

  poner_titulo(vista_modulo, vista_submodulo);

  //Activar los tooltip
  activar_tooltips();

  //Crear la data table
  crear_data_table("listado_" + modulo + "_" + submodulo);

  if (
    submodulo != "" &&
    submodulo != "auditorias" &&
    submodulo != "errores" &&
    submodulo != "ordenes" &&
    submodulo != "documentos"
  ) {
    activar_botones_accion(elemento, estado);
  }
}

/**Recargar el listado */
function recargar_listado(id_estado = "all") {
  var url = url_listado;
  fila_actual = null;

  cargar_contenido(getLoadPage(), "cargando");

  Pace.track(function () {
    //Solicitar el submodulo
    $.ajax({
      url: url,
      data: {
        id_estado: id_estado,
      },
      type: "GET",
    })
      .done(function (respuesta) {
        if (!respuesta.error) {
          cargar_contenido(respuesta, "listado");
        } else {
          //Mostrar la respuesta
          notificacion("Atencion", respuesta.error, "error");

          //Cargar el listado
          cargar_contenido(getErrorPage(respuesta), "cargando");
        }
      })
      .fail(function (xhr, textStatus, errorThrown) {
        response = xhr.responseText;

        if (response != "") {
          response = JSON.parse(response);
        }

        //Mostrar la respuesta
        notificacion(response.error, "", "error");

        //Cargar el listado
        cargar_contenido(getErrorPage(response), "cargando");
      });
  });
} //Fin de recargar_listado

/**Transformar una tabla a datatable
 * @param {string} nombre_tabla Nombre de la tabla`
 */
function crear_data_table(nombre_tabla) {
  desactivar_tooltips_tabla();

  nombre_tabla = "#" + nombre_tabla;

  //Validar que el elemento exista y sea una tabla
  if ($(nombre_tabla).length > 0 && $(nombre_tabla).is("table")) {
    //Si la tabla es DataTable
    if ($(nombre_tabla).hasClass("dataTable")) {
      //Destruir la tabla
      $(nombre_tabla).DataTable().destroy();

      table = null;
    }

    if (nombre_tabla != "#documentos") {
      if (submodulo_activo == "auditorias" || submodulo_activo == "errores") {
        //Crea la data table ordenando por el primer campo desc
        table = $(nombre_tabla).DataTable({
          paging: true,
          //Solo se permiten 10 registros por pagina
          pageLength: 10,
          //No se puede cabiar el numero de registros por pagina
          lengthChange: false,
          info: false,
          searching: true,
          ordering: true,
          order: [[0, "desc"]],
          language: {
            url: base + "files/dist/js/plugins/datatables/es-MX.json",
          },
          select: {
            style: "api",
          },
        });
      } else {
        //Crea la data table ordenando por el segundo campo
        table = $(nombre_tabla).DataTable({
          paging: true,
          //Solo se permiten 10 registros por pagina
          pageLength: 10,
          //No se puede cabiar el numero de registros por pagina
          lengthChange: false,
          info: false,
          searching: true,
          ordering: true,
          order: [[1, "asc"]],
          language: {
            url: base + "files/dist/js/plugins/datatables/es-MX.json",
          },
          select: {
            style: "api",
          },
        });
      }
    } else {
      //Crea la data table ordena por el tercer campo
      table = $(nombre_tabla).DataTable({
        paging: true,
        //Solo se permiten 10 registros por pagina
        pageLength: 10,
        //No se puede cabiar el numero de registros por pagina
        lengthChange: false,
        info: false,
        searching: true,
        language: {
          url: base + "files/dist/js/plugins/datatables/es-MX.json",
        },
        select: {
          style: "api",
        },
        order: [[2, "desc"]],
      });
    }

    activar_tooltip_tabla();
  }
} //Fin de la funcion

/**Enfocar la siguiente fila de la tabla que esta en la pantalla */
function siguiente_elemento() {
  var tabla = table;

  if (tabla != null) {
    //Obtener la fila actual
    var fila = fila_actual;

    if (fila != null) {
      var fila_siguiente = fila + 1;

      if (fila_siguiente < tabla.rows().count()) {
        //Seleccionar la fila siguiente
        tabla.row(fila_siguiente).select();

        //Si la fila siguiente es un multiplo de 10, pasar a la siguiente pagina
        if (fila_siguiente % 10 == 0) {
          tabla.page("next").draw(false);
        }

        fila_actual = tabla.row(".selected").index();

        //Deseleccionar la fila actual
        tabla.row(fila_actual).deselect();

        enfocar_fila_actual();
      }
    } else {
      tabla.row(0).select();

      fila_actual = tabla.row(".selected").index();

      //Deseleccionar la fila actual
      tabla.row(fila_actual).deselect();

      enfocar_fila_actual();
    }
  }
}

/**Enfocar el elemento anterior */
function elemento_anterior() {
  var tabla = table;

  if (tabla != null) {
    //Obtener la fila actual
    var fila = fila_actual;

    if (fila != null) {
      var fila_anterior = fila - 1;

      if (fila_anterior >= 0) {
        //Enfocar la fila anterior
        tabla.row(fila_anterior).select();

        //Si la fila anterior es un multiplo de 10, pasar a la pagina anterior
        if ((fila_anterior + 1) % 10 == 0) {
          tabla.page("previous").draw(false);
        }

        fila_actual = tabla.row(".selected").index();

        //Deseleccionar la fila actual
        tabla.row(fila_actual).deselect();

        enfocar_fila_actual();
      }
    } else {
      tabla.row(0).select();

      fila_actual = tabla.row(".selected").index();

      //Deseleccionar la fila actual
      tabla.row(fila_actual).deselect();

      enfocar_fila_actual();
    }
  }
}

/**Activar los tooltip de todas las filas de la tabla */
function activar_tooltip_tabla() {
  //Obtener la tabla
  var tabla = table;

  if (tabla != null) {
    //Recorrer cada nodo de la tabla
    tabla.rows().every(function (rowIdx, tableLoop, rowLoop) {
      //Activar los tooltip que se encuentren en la fila
      $(this.node()).find('[data-toggle="tooltip"]').tooltip();
    });
  }
}

/**Desactivar los tooltip de todas las filas */
function desactivar_tooltips_tabla() {
  //Obtener la tabla
  var tabla = table;

  if (tabla != null) {
    //Recorrer cada nodo de la tabla
    tabla.rows().every(function (rowIdx, tableLoop, rowLoop) {
      //Desactivar los tooltip que se encuentren en la fila
      $(this.node()).find('[data-toggle="tooltip"]').tooltip("dispose");
    });
  }
}

/**Enfocar la fila en la que el mouse esta, o por medio de las flechas */
function enfocar_fila_actual() {
  var fila = fila_actual;

  //Eliminar color de fondo gris de todas las filas
  $(table.rows().nodes())
    .removeClass("bg-gradient-gray")
    .removeClass("text-white");

  //Poner color de fondo gris claro a la fila actual
  $(table.row(fila).node()).addClass("bg-gradient-gray").addClass("text-white");

  if (submodulo_activo != "auditorias" && submodulo_activo != "errores") {
    //Poner el foco en btn-ver de la fila
    $(table.row(fila).node()).find(".btn-ver").focus();
  }
}

/**Encontrar elementos que coincidan en la tabla solicitada
 * @author jcampos
 */
function filtrar_tabla(id_tabla, filtro) {
  if (filtro != "") {
    $("#" + id_tabla + " tr").filter(function () {
      $(this).toggle($(this).text().toLowerCase().indexOf(filtro) > -1);
    });
  } else {
    $("#" + id_tabla + " tr").show();

    $("#" + id_tabla + " tr").each(function (index, value) {
      $(this).show();
    });
  }
}

/**
 * Filtrar los card de un contenedor
 * @param {string} contenedor
 * @param {string} tipo_elemento
 * @param {string} filtro
 */
function filtrar_elemento(contenedor, claseElemento, filtro) {
  if (filtro != "") {
    //Recorrer todos los tipos de elemento del elemento
    $("#" + contenedor + " ." + claseElemento).each(function (index, value) {
      //Si algun texto del card coincide con el filtro o algun input coincide con el filtro, se muestra
      if (
        $(this).text().toLowerCase().indexOf(filtro) > -1 ||
        $(this).find("input").val().toLowerCase().indexOf(filtro) > -1
      ) {
        $(this).show();
      } else {
        $(this).hide();
      }
    });
  } else {
    $("#" + contenedor + " ." + claseElemento).show();

    $("#" + contenedor + " ." + claseElemento).each(function (index, value) {
      $(this).show();
    });
  }
}

//Cuando el mouse entra en una fila de la tabla
$(document).on("mouseenter", ".dataTables_wrapper tbody tr", function () {
  //Seleccionar la fila
  table.row(this).select();

  fila_actual = table.row(this).index();

  //Deseleccionar la fila actual
  table.row(fila_actual).deselect();

  enfocar_fila_actual();
});
