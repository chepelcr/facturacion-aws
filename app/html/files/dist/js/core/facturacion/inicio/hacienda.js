/**
 *
 */
function enviar_documento(id_documento = 0) {
    if (id_documento != null) {
        data = {};

        //Obtener el correo electronico desde el modalNotificar
        let email = $("#modalNotificar").find(".email").val();

        //Si el correo electronico no esta vacio y es un correo electronico valido
        if (email != "" && validar_email(email)) {
            data.email = email;
        } else {
            //Si el correo electronico no esta vacio y no es un correo electronico valido
            if (email != "") {
                mensajeAutomatico("Atencion", "El correo electronico no es valido", "error");
                return;
            }
        }

        Pace.track(function () {
            $.ajax({
                url: base + "documentos/enviar_documento/" + id_documento,
                method: "GET",
                data: data,
                dataType: "json",
            })
                .done(function (response) {
                    if (!response.error) {
                        mensajeAutomatico("Atencion", response.mensaje, "success");
                        cerrarNotificar();
                    } else {
                        mensajeAutomatico("Atencion", response.error, "error");
                    }
                })
                .fail(function (jqXHR, textStatus, errorThrown) {
                    json = JSON.parse(jqXHR.responseText);
                    mensajeAutomatico("Atencion", json.error, "error");
                });
        });
    }
} //Fin de la funcion para enviar el documento por correo electronico

function cerrarNotificar() {
    //Cerrar el modalNotificar
    $("#modalNotificar").modal("hide");

    //Eliminar el documentkey del campo btn-enviar
    $("#modalNotificar").find(".btn-enviar").val("");

    //Eliminar el correo electronico del campo email
    $("#modalNotificar").find(".email").val("");
}

function validar_email(email) {
    var re = /\S+@\S+\.\S+/;
    return re.test(email);
}

function abrirModalNotificar(documentkey = "") {
    $("#modalNotificar").modal("show");

    //Colocar el documentkey en el campo btn-enviar del modalNotificar
    $("#modalNotificar").find(".btn-enviar").val(documentkey);
}

/**Enviar documento al ministerio de hacienda */
function enviar_hacienda(id_documento = null) {
    if (id_documento != null) {
        Pace.track(function () {
            $.ajax({
                url: base + "documentos/enviar_hacienda/" + id_documento,
                method: "POST",
                dataType: "json",
            }).done(function (response) {
                if (!response.error) {
                    mensajeAutomatico("Atencion", response.mensaje, "success");
                } else {
                    mensajeAutomatico("Atencion", response.error, "error");
                }
            });
        });
    }
} //Fin de la funcion para enviar el documento al ministerio de hacienda

/**Validar el estado de un documento enviado al ministerio de hacienda */
function validar_documento(id = "") {
    if (id != "") {
        Pace.track(function () {
            $.ajax({
                url: base + "documentos/validar_documento/" + id,
                method: "get",
                dataType: "json",
            }).done(function (response) {
                var mensaje = "El documento ha sido " + response.validar_estado + " por el Ministerio de Hacienda";

                if (response.validar_estado == "rechazado") {
                    response.estado = "error";
                }

                if (response.validar_estado == "procesando") {
                    response.estado = "warning";
                    mensaje = "El documento esta siendo procesado por el Ministerio de Hacienda";
                }
                Swal.fire({
                    title: "Atencion",
                    text: mensaje,
                    icon: response.estado,
                    showConfirmButton: true,
                    //Texto del boton de confirmacion
                    confirmButtonText: "Aceptar",
                });
            });
        });
    }
}

/**Guardar un documento en la base de datos y enviarlo al ministerio de hacienda */
function guardar_documento() {
    activar_campo_clase("inp-fct", false, factura_activa);

    //Capturar los datos de la factura activa en FormData
    var document = new FormData($("#" + factura_activa)[0]);

    Pace.track(function () {
        $.ajax({
            url: base + "documentos/guardar",
            method: "post",
            data: document,
            dataType: "json",
            contentType: false,
            processData: false,
            cache: false,
        })
            .done(function (response) {
                if (response.error) {
                    Swal.fire({
                        title: "Atencion",
                        text: response.message,
                        icon: "error",
                        showConfirmButton: true,
                        //Texto del boton de confirmacion
                        confirmButtonText: "Aceptar",
                        confirmButtonColor: "#3085d6",
                    }).then((result) => {
                        activar_campo_clase("inp-fct", false, factura_activa);
                    });
                } else {
                    const clave = response.consecutiveNumber;
                    var mensaje = "El documento " + clave + " ha sido enviado al Ministerio de Hacienda";

                    Swal.fire({
                        title: "Documento generado",
                        text: mensaje,
                        icon: "success",
                        showConfirmButton: true,

                        //Texto del boton de confirmacion
                        confirmButtonText: "Ver PDF",
                        //Accion del boton de confirmacion
                        confirmButtonColor: "#3085d6",
                        //Color del boton de cancelacion
                        cancelButtonColor: "#d33",
                        //Icono en el boton de cancelacion
                        cancelButtonText: '<i class="fas fa-times"></i>',

                        //Mostrar el boton de cancelacion
                        showCancelButton: true,
                    }).then((result) => {
                        if (result.value) {
                            const documentUrl =
                                "https://cloudfront.dev.ivois.io/" +
                                response.documentRoute +
                                "/" +
                                response.documentName +
                                ".pdf";
                            verPdf(documentUrl);
                        }

                        cancelar_documento();
                    });
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                let response = jqXHR.responseText;

                if (
                    response != "" ||
                    response != null ||
                    response != undefined ||
                    response != "undefined" ||
                    response != "null"
                ) {
                    response = JSON.parse(jqXHR.responseText);
                } else {
                    response = { message: "Error al guardar el documento", status: "error" };
                }

                Swal.fire({
                    title: "Atencion",
                    text: response.message,
                    icon: "error",
                    showConfirmButton: true,

                    //Texto del boton de confirmacion
                    confirmButtonText: "Aceptar",
                    confirmButtonColor: "#3085d6",
                }).then((result) => {
                    activar_campo_clase("inp-fct", false, factura_activa);
                });
            });
    });
}

/**Validar los documentos que se encuentran en proceso */
function validar_documentos() {
    Pace.track(function () {
        $.ajax({
            url: base + "documentos/validar_documentos",
            method: "get",
            dataType: "json",
        }).done(function (response) {
            if (response.error) {
                Swal.fire({
                    title: "Atencion",
                    text: response.error,
                    icon: "error",
                    showConfirmButton: false,
                    timer: 2000,
                }).then((result) => {
                    salir();
                });
            }
        });
    });
} //Fin de la funcion para validar los documentos
