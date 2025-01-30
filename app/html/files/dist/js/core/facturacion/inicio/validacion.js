/**
 * Validar el estado de un documento en el Ministerio de Hacienda
 * @param {string} id Clave del documento electrónico a validar
 */
function solicitar_validacion(id = "") {
    if (id != "") {
        Pace.track(function () {
            $.ajax({
                url: base + "documentos/validar_documento/" + id,
                method: "get",
                dataType: "json",
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
                },
                success: function (response) {
                    let mensaje = "";

                    if (response.validationStatus == 3) {
                        response.estado = "error";
                        mensaje = "El documento ha sido rechazado por el Ministerio de Hacienda";
                    } else if (response.validationStatus == 2) {
                        response.estado = "warning";
                        mensaje = "El documento esta siendo procesado por el Ministerio de Hacienda";
                    } else if (response.validationStatus == 1) {
                        response.estado = "success";
                        mensaje = "El documento ha sido aceptado por el Ministerio de Hacienda";
                    }

                    Swal.fire({
                        title: "Atencion",
                        text: mensaje,
                        icon: response.estado,
                        showConfirmButton: true,
                        //Texto del boton de confirmacion
                        confirmButtonText: "Aceptar",
                    }).then((result) => {
                        ver_validacion(response, id);
                    });
                },
            });
        });
    }
}

/**
 * Ver la validacion de un documento en el Ministerio de Hacienda
 *
 * @param {object} atvValidationDTO Validacion del ministerio de Hacienda
 * @param {string} documentKey Clave del documento electronico
 */
function ver_validacion(atvValidationDTO, documentKey) {
    if (atvValidationDTO == null) {
        solicitar_validacion(documentKey);
    } else {
        //documentKey
        $("#modalValidacionDocumento .documentKey").val(documentKey);

        //Colocar el status del receptor en el campo status
        $("#modalValidacionDocumento .status").val(atvValidationDTO.validationStatus);

        //Si el espacio atvvalidationDTO. errors esta vacio
        if (atvValidationDTO.errors != null && atvValidationDTO.errors.length > 0) {
            //Crear la tabla de errores
            const errorsTable = $("#modalValidacionDocumento .table-validacion");

            //Limpiar la tabla de errores
            errorsTable.empty();

            //Colocar el thead
            const thead = $("<thead></thead>");

            const tr = $("<tr></tr>");

            const th1 = $("<th></th>").text("Código").addClass("text-center ivois-label");
            const th2 = $("<th></th>").text("Mensaje").addClass("text-center ivois-label");

            tr.append(th1);
            tr.append(th2);

            //Colocar el thead en la tabla
            thead.append(tr);

            //Crear el tbody
            const tbody = $("<tbody></tbody>");

            //Se debe usar el campo code del error en la primea columna y el message en la segunda
            atvValidationDTO.errors.forEach((error) => {
                const row = $("<tr></tr>");
                const code = $("<td></td>").text(error.code);
                const message = $("<td></td>").text(error.message);

                row.append(code);
                row.append(message);

                tbody.append(row);
            });

            //Colocar el thead en la tabla
            errorsTable.append(thead);

            //Colocar el tbody en la tabla
            errorsTable.append(tbody);

            //Mostrar la tabla de errores
            $("#modalValidacionDocumento .validation-errors").show();
        } else {
            //Ocultar la tabla de errores
            $("#modalValidacionDocumento .validation-errors").hide();

            //Vaciar la tabla de errores
            $("#modalValidacionDocumento .table-validacion").empty();
        }

        //Colocar todos los input, select, text area en disabled, readonly
        $("#modalValidacionDocumento .form-control").attr("disabled", true);
        $("#modalValidacionDocumento .form-control").attr("readonly", true);

        //Abrir el modal modalValidacionDocumento
        $("#modalValidacionDocumento").modal("show");
    }
}
