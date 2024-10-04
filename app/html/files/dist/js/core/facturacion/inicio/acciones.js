var cantidad_documentos = 0;

/**Agregar un documento electronico al modulo */
function agregar_documento(tipoDocumento = "") {
    data = {
        documentNumber: cantidad_documentos + 1,
    };

    //Solicitud ajax del card de facturacion
    $.ajax({
        url: base + "documentos/crear_documento/" + tipoDocumento,
        data: data,
        type: "GET",
        dataType: "html",
    }).done(function (data) {
        cantidad_documentos++;

        //Agregar el card de facturacion al la pagina
        $("#contenedor_facturas").append(data);

        boton = crearBotonFactura(cantidad_documentos);

        //Agregar el boton de la factura al la pagina
        $("#nav-facturacion").append(boton);

        ver_factura(cantidad_documentos);
    }).fail(function (jqXHR, textStatus, errorThrown) {
        response = jqXHR.responseText;

        if (response != null && response != "") {
            response = JSON.parse(response);
        } else {
            response = { error: "Error desconocido", status: jqXHR.status };
        }
        
        mensajeAutomatico("Error", response.error, "error");
    });
} //Fin de agregar una nueva factura al modulo

function crearBotonFactura(numero_documento) {
    boton =
        '<div class="col-md-4 col-lg col-md col-sm p-1 col-btn-fct-' +
        numero_documento +
        '">' +
        '<button class="btn btn-factura nav-button btn-block" type="button" onclick="ver_factura(' +
        numero_documento +
        ')" id="btn_factura_' +
        numero_documento +
        '" data-toggle="tooltip" data-placement="top" title="Documento ' +
        numero_documento +
        '" ' +
        'value="' +
        numero_documento +
        '">Documento ' +
        numero_documento +
        "</button></div>";

    return boton;
}

/**Cargar todos los documentos de la empresa */
function cargar_documentos(reportType = "") {
    var direcion_url = base + "documentos/cargar_documentos/";

    //Validar el tipo de reporte
    switch (reportType) {
        case "emitidos":
            direcion_url += "emitidos";

            //Poner el titulo
            poner_titulo("Documentos", "Enviados");

            activar_modulo_boton("documentos", "emitidos");
            break;

        case "recibidos":
            direcion_url += "recibidos";

            //Poner el titulo
            poner_titulo("Documentos", "Recibidos");

            activar_modulo_boton("documentos", "recibidos");
            break;

        case "buscar":
            var fecha_actual = new Date();

            //Eliminar el min del campo #startDate
            $("#startDate").attr("min", "");
            $("#endDate").attr("min", "");

            //Poner la fecha maxima del campo #startDate
            $("#startDate").attr("max", fecha_actual.toISOString().split("T")[0]);

            //Colocar el max del campo #endDate en la fecha actual
            $("#endDate").attr("max", fecha_actual.toISOString().split("T")[0]);
            return;

            break;

        default:
            if (submodulo_activo == "") {
                direcion_url += "emitidos";

                //Poner el titulo
                poner_titulo("documentos", "emitidos");

                activar_modulo_boton("documentos", "emitidos");
            }

            if (submodulo_activo == "emitidos") {
                direcion_url += "emitidos";
            }

            if (submodulo_activo == "recibidos") {
                direcion_url += "recibidos";
            }
            break;
    } //Fin de validacion de reporte

    if (reportType != "buscar") {
        const listadoDocumentos = $("#listado_documentos");
        Pace.track(function () {
            $.ajax({
                url: direcion_url,
                type: "GET",
                dataType: "html",
                data: $("#frm_filtro_documentos").serialize(),
                success: function (respuesta) {
                    desactivar_tooltips_documentos();

                    listadoDocumentos.empty();

                    listadoDocumentos.append(respuesta);

                    crear_data_table("documentos");
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    response = jqXHR.responseText;

                    if (response != null && response != "") {
                        response = JSON.parse(response);
                    } else {
                        response = { error: "Error desconocido", status: jqXHR.status };
                    }

                    errorPage = getErrorPage(response);

                    listadoDocumentos.empty().append(errorPage);
                },
            });

            //Ocultar todas las facturas
            $(".contenedor_facturas").hide();

            //Habilitar los botones de facturas
            $(".btn-factura").attr("disabled", false);

            //Activar el boton de documentos
            $(".btn-documentos").addClass("btn-warning").removeClass("btn-dark");

            //Desactivar el boton de facturas
            $(".btn-factura").addClass("btn-dark").removeClass("btn-purple");

            //Deshabilitar el boton de documentos
            $(".btn-documentos").attr("disabled", true);

            //Collapse .card-opciones-documentos
            $(".card-opciones-documentos").CardWidget("collapse");

            //Collapse .card-finalizar
            $(".card-finalizar").CardWidget("collapse");

            //Mostrar .cont-reporte
            $(".cont-reporte").show();

            //Contraer el card-reporte
            contraer_reporte();

            //Activar tooltips
            activar_tooltips_documentos();

            //Mostrar el contenedor de documentos
            listadoDocumentos.show();
        });
    } //Fin de validacion de tipo de reporte
}

/**Descargar un reporte */
function reporte(reportType) {
    mensajeAutomatico("Generando reporte", "Espera un momento", "info");

    //Recorrer todas las lineas de la tabla
    var table = $("#documentos").DataTable();

    let documentos = [];

    //Recorrer las filas que se han filtrado
    table
        .rows({
            search: "applied",
        })
        .every(function () {
            //Si el  $(this.node()).find('.chk-dct') se encuentra checked
            if ($(this.node()).find(".chk-dct").is(":checked")) {
                //Obtener el valor del checkbox
                var id_documento = $(this.node()).find(".chk-dct").val();

                //Agregar el id_documento a los documentos
                documentos.push(id_documento);
            }
        });

    //Enviar una solicitud ajax
    Pace.track(function () {
        //Obtener el archivo zip
        $.ajax({
            url: base + "documentos/reporte/" + reportType,
            type: "POST",
            dataType: "json",
            data: {
                documentos: documentos,
            },
            success: function (respuesta) {
                if (!respuesta.error) {
                    if (reportType == "descarga") {
                        location.href = base + "documentos/descargar_zip/" + respuesta.nombre_archivo;
                    } else {
                        mensajeAutomatico("Reporte generado", respuesta.success, "success");
                    }
                } else {
                    mensajeAutomatico("Error", respuesta.error, "error");
                }
            },
        });
    });
}

/**Abrir el modal para importar documentos electronicos*/
function importar_documentos() {
    if (modulo_activo != "documentos") {
        cargar_inicio_modulo("documentos");
    }

    poner_titulo("documentos", "importar");

    activar_modulo_boton("documentos", "importar");

    //Mostrar el .modal-importar
    $("#modal-importar").modal("show");
}

/**Contraer o expandir el card de reporte */
function contraer_reporte(estado = false) {
    //Si no hay ningun .chk-dct seleccionado
    if ($(".chk-dct:checked").length == 0 || !estado) {
        //Si no hay ningun .chk-dct seleccionado
        if ($(".chk-dct:checked").length == 0) {
            //Contraer el card-opciones-reporte
            $(".card-opciones-reporte").CardWidget("collapse");

            //Expandir el card-opciones
            $(".card-opciones").CardWidget("expand");

            //Descheck #check_documentos
            $("#check_documentos").prop("checked", false);
        }
    } //Fin de la validacion

    //Si estado es true
    else {
        //Expandir el card-opciones-reporte
        $(".card-opciones-reporte").CardWidget("expand");

        //Contraer el card-opciones
        $(".card-opciones").CardWidget("collapse");
    }
}

//Activar todos los checkbox de los documentos
function check_documentos(boton) {
    var table = $("#documentos").DataTable();

    //Si el boton esta activo
    if (boton.checked) {
        //Recorrer las filas que se han filtrado
        table
            .rows({
                search: "applied",
            })
            .every(function () {
                //Activar el checkbox
                $(this.node()).find(".chk-dct").prop("checked", true);
            });
    }

    //Si el boton esta desactivado
    else {
        //Desactivar el checkbox de la fila
        table.rows().every(function () {
            $(this.node()).find(".chk-dct").prop("checked", false);
        });
    }

    contraer_reporte(boton.checked);
} //Fin de la función check_documentos

/**Desactivar los tooltip de cada linea de documentos */
function desactivar_tooltips_documentos() {
    //Recorrer todas las lineas de la tabla
    var table = $("#documentos").DataTable();

    //Si la tabla existe y tiene filas
    if (table.rows().count() > 0) {
        //Recorrer las filas que se han filtrado
        table
            .rows({
                search: "applied",
            })
            .every(function () {
                //Desactivar los tooltips data-toggle="tooltip"
                $(this.node()).find('[data-toggle="tooltip"]').tooltip("dispose");
            });
    }
} //Fin de la función desactivar_tooltips

/**Activar los tooltip de cada linea de documentos */
function activar_tooltips_documentos() {
    //Recorrer todas las lineas de la tabla
    var table = $("#documentos").DataTable();

    //Recorrer las filas que se han filtrado
    table
        .rows({
            search: "applied",
        })
        .every(function () {
            //Activar los tooltips data-toggle="tooltip"
            $(this.node()).find('[data-toggle="tooltip"]').tooltip();
        });
} //Fin de la función activar_tooltips

function asignar_fecha(campo) {
    //Obtener el valor del campo
    var fecha = $(campo).val();

    //Colocar el campo min del campo endDate
    $("#endDate").attr("min", fecha);
}

//document ready
$(document).ready(function () {
    //Cuando el usuario envia un form dentro de la factura activa
    $(document).on("submit", "form", function (e) {
        e.preventDefault();

        //No enviar el form
        return false;
    });

    //Cuando cambia el checked de un .chk-dct
    $(document).on("change", ".chk-dct", function () {
        contraer_reporte($(this).is(":checked"));
    });

    //Cuando el usuario presiona un tipo de pago, desmarcar los otros
    $(document).on("change", ".chk-pg", function () {
        activar_tipo_pago(this);
    });
});

function activar_tipo_pago(check) {
    const code = $(check).data("code");

    const tiposPago = $("#" + factura_activa).find(".tipo-pago");

    //Recorrer todos los .tipo-pago con un each (i, tipoPago)
    tiposPago.each(function (i, tipoPago) {
        typeCode = $(tipoPago).data("code");
        //Mostar el .tipo-pago si el data-code es igual al code
        if (typeCode == code) {
            //Si el check esta activo
            if ($(check).is(":checked")) {
                //Deseleccionar el .opt-emp mas cercano
                $(tipoPago).find(".opt-emp").attr("selected", false);

                //Seleccionar el opt-pg del .tipo-pago
                $(tipoPago).find(".opt-pg").attr("selected", true);

                //Colocar 0 en el campo de monto
                $(tipoPago).find(".monto").val(0);

                //Eliminar la propiedad hidden
                $(tipoPago).attr("hidden", false);
            } else {
                //Ocultar el tipo de pago
                $(tipoPago).attr("hidden", true);

                //Deseleccionar el opt-pg del .tipo-pago
                $(tipoPago).find(".opt-pg").attr("selected", false);

                //Colocar '' en el campo de monto
                $(tipoPago).find(".monto").val("");

                //Seleccionar el .opt-emp
                $(tipoPago).find(".opt-emp").attr("selected", true);
            }
        }
    });
}
