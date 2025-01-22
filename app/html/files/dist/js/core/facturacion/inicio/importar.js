/**
 * Mostrar el modal cargar documentos electrónicos a la plataforma
 */
function cargar_documento() {
    $("#modalSubirDocumentos").modal("show");
} //Fin de la funcion cargar_documento

$(document).ready(function () {
    //Cuando el frm_subir_documento hace submit
    $("#frm_subir_documento").submit(function (e) {
        e.preventDefault();

        //Obtener el archivo
        /*var archivo = $("#frm_subir_documento input[type=file]").val();

        //Obtener el nombre del archivo
        var nombre_archivo = archivo.name;

        console.log(nombre_archivo);

        //Obtener la extension del archivo
        var extension = nombre_archivo.split(".").pop();*/

        //Si el archivo es un xml
        //if (extension == "xml") {
        //Enviar el archivo
        var formData = new FormData(this);

        //console.log("Llegando");

        Pace.track(function () {
            //Enviar el archivo
            $.ajax({
                url: base + "documentos/subir_documento",
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

                        //Validar el tipo de objeto de respuesta
                        console.log(typeof(response));

                        const message = "El documento " + clave + " ha sido enviado al API de IVOIS para su procesamiento";

                        Swal.fire({
                            title: "Documento enviado",
                            text: message,
                            icon: "success",
                            showConfirmButton: true,

                            //Texto del boton de confirmacion
                            confirmButtonText: "Aceptar",
                            //Accion del boton de confirmacion
                            confirmButtonColor: "#3085d6",
                        }).then((result) => {
                            //Vaciar los campos del formulario
                            $("#frm_subir_documento")[0].reset();
                            cerrar_modal("modalSubirDocumentos", cargar_documentos());
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
                        response = { message: "Error al guardar el documento", status: "error" };
                    }

                    mensajeAutomatico("Error", response.message, "error");
                },
            });
        });

        /*const clave = "00500110010000000233";

        const message = "El documento " + clave + " ha sido enviado al API de IVOIS para su procesamiento";

        Swal.fire({
            title: "Documento enviado",
            text: message,
            icon: "success",
            showConfirmButton: true,

            //Texto del boton de confirmacion
            confirmButtonText: "Aceptar",
            //Accion del boton de confirmacion
            confirmButtonColor: "#3085d6",
        }).then((result) => {
            cerrar_modal("modalSubirDocumentos", cargar_documentos());
        });*/
        /*} else {
            mensajeAutomatico("Error", "El archivo no es un xml", "error");
        }*/
    });
});
