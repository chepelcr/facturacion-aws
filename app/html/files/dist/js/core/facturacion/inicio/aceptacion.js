function aceptar_documento(documentKey) {
    //Actualizar las sucursales del modal de aceptación
    actualizar_sucursales("aceptacion");

    //Colocar la clave del documento en el campo de texto del modal de aceptación
    $("#modalAceptarDocumentos .documentKey").val(documentKey);

    //Habilitar el btn-validar
    $("#modalAceptarDocumentos .btn-validar").attr("disabled", false);

    //Ocultar el campo de la watch-validation
    $("#modalAceptarDocumentos .watch-validation").hide();

    //Mostrar los campos send-validation
    $("#modalAceptarDocumentos .send-validation").show();

    //Abrir el modal modalAceptarDocumentos
    $("#modalAceptarDocumentos").modal("show");
}

/**
 * Ver la respuesta del receptor para un documento electrónico
 *
 * @param {} receiverValidationDTO Validación del receptor
 */
function ver_validacion_receptor(receiverValidationDTO) {
    //Colocar el status del receptor en el campo status
    $("#modalAceptarDocumentos .status").val(receiverValidationDTO.status);

    //Colocar el message de la validacion
    $("#modalAceptarDocumentos .message").val(receiverValidationDTO.message);

    //Colocar la fecha de la validación
    $("#modalAceptarDocumentos .validationDate").val(receiverValidationDTO.validationDate);

    //Mostrar el campo de la watch-validation
    $("#modalAceptarDocumentos .watch-validation").show();

    //Ocultar los campos send-validation
    $("#modalAceptarDocumentos .send-validation").hide();

    //Colocar todos los input, select, text area en disabled, readonly
    $("#modalAceptarDocumentos .form-control").attr("disabled", true);
    $("#modalAceptarDocumentos .form-control").attr("readonly", true);

    //Abrir el modal modalAceptarDocumentos
    $("#modalAceptarDocumentos").modal("show");
}

$(document).ready(function () {
    //Cuando el frm_aceptar_documento hace submit
    $("#frm_aceptar_documento").submit(function (e) {
        e.preventDefault();

        const formData = new FormData(this);

        //Bloquear el boton .btn-validar del modalAceptarDocumentos
        $("#modalAceptarDocumentos .btn-validar").attr("disabled", true);

        const key = $("#modalAceptarDocumentos .documentKey").val();

        Pace.track(function () {
            //Enviar el archivo
            $.ajax({
                url: base + "documentos/validacion_receptor/" + key,
                type: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.error) {
                        mensajeAutomatico("Error", response.message, "error");
                    } else {
                        response = JSON.parse(response);

                        const clave = response.consecutiveNumber;

                        const message = "Se ha enviado la validación del documento " + clave + " al emisor";

                        Swal.fire({
                            title: "Documento validado",
                            text: message,
                            icon: "success",
                            showConfirmButton: true,

                            //Texto del boton de confirmacion
                            confirmButtonText: "Aceptar",
                            //Accion del boton de confirmacion
                            confirmButtonColor: "#3085d6",
                        }).then((result) => {
                            //Vaciar los campos del formulario
                            $("#frm_aceptar_documento")[0].reset();
                            cerrar_modal("modalAceptarDocumentos", cargar_documentos("recibidos"));
                        });
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
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
                        response = { message: "Error al validar el documento", status: "error" };
                    }

                    mensaje("Error", response.message, "error");

                    //Habilitar el btn-validar
                    $("#modalAceptarDocumentos .btn-validar").attr("disabled", false);
                },
            });
        });
    });
});
