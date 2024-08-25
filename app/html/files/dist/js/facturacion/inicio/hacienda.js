/**Enviar documento por correo electronico */
function enviar_documento(id_documento = null) {
    if (id_documento != null) {
        Pace.track(function () {
            $.ajax({
                "url": base + "documentos/enviar_documento/" + id_documento,
                "method": "POST",
                "dataType": "json"
            }).done(function (response) {
                if (!response.error) {
                    mensajeAutomatico('Atencion', response.mensaje, 'success');
                }

                else {
                    mensajeAutomatico('Atencion', response.error, 'error');
                }
            });
        });
    }
}//Fin de la funcion para enviar el documento por correo electronico

/**Enviar documento al ministerio de hacienda */
function enviar_hacienda(id_documento = null) {
    if (id_documento != null) {
        Pace.track(function () {
            $.ajax({
                "url": base + "documentos/enviar_hacienda/" + id_documento,
                "method": "POST",
                "dataType": "json"
            }).done(function (response) {
                if (!response.error) {
                    mensajeAutomatico('Atencion', response.mensaje, 'success');
                }

                else {
                    mensajeAutomatico('Atencion', response.error, 'error');
                }
            });
        });
    }
}//Fin de la funcion para enviar el documento al ministerio de hacienda

/**Validar el estado de un documento enviado al ministerio de hacienda */
function validar_documento(id = '') {
    if (id != '') {
        Pace.track(function () {
            $.ajax({
                "url": base + "documentos/validar_documento/" + id,
                "method": "get",
                "dataType": "json",
            }).done(function (response) {
                var mensaje = 'El documento ha sido ' + response.validar_estado + ' por el Ministerio de Hacienda';

                if (response.validar_estado == 'rechazado') {
                    response.estado = 'error';
                }

                if (response.validar_estado == 'procesando') {
                    response.estado = 'warning';
                    mensaje = 'El documento esta siendo procesado por el Ministerio de Hacienda';
                }
                Swal.fire({
                    title: 'Atencion',
                    text: mensaje,
                    icon: response.estado,
                    showConfirmButton: true,
                    //Texto del boton de confirmacion
                    confirmButtonText: 'Aceptar',
                });
            });
        });
    }
}

/**Obtener el tipo de cambio desde los indicadores del banco central */
function obtener_tipo_cambio(indicador = '') {
    if (indicador == '') {
        Pace.track(function () {
            $.ajax({
                "url": base + 'documentos/indicadores',
                "method": "GET",
                "dataType": "json"
            }).done(function (response) {
                cambio_compra = response.compra;
                cambio_venta = response.venta;

                //Colocar el tipo de cambio en los campos tipo_compra y tipo_venta
                $('#tipo_compra').val(cambio_compra);
                $('#tipo_venta').val(cambio_venta);
                
                notificacion("Se ha actualizado el tipo de cambio","", "success");
            });
        });
    } else {
        Pace.track(function () {
            $.ajax({
                "url": base + 'documentos/indicadores/' + indicador,
                "method": "GET",
                "dataType": "json"
            }).done(function (response) {
                return response.tipo_cambio;
            });
        });
    }
}//Fin de la funcion para obtener el tipo de cambio

function abrirTipoCambio() {
    $('#modal-tipo-cambio').modal('show');
}

/**Guardar un documento en la base de datos y enviarlo al ministerio de hacienda */
function guardar_documento() {
    //activar_campo_clase('inp-fct', false, factura_activa);

    //Capturar los datos de la factura activa en FormData
    var formData = new FormData($('#' + factura_activa)[0]);

    //activar_campo_clase('inp-fct', true, factura_activa);

    //return;

    Pace.track(function () {
        $.ajax({
            "url": base + "documentos/guardar",
            "method": "post",
            "data": formData,
            "dataType": "json",
            "contentType": false,
            "processData": false,
            "cache": false,
        }).always(function (response) {
            console.log(response);
            if (!response.error) {
                var mensaje = 'El documento ha sido ' + response.validar_estado + ' por el Ministerio de Hacienda';

                if (response.validar_estado == 'rechazado') {
                    response.estado = 'error';
                }

                if (response.validar_estado == 'procesando') {
                    response.estado = 'warning';
                    mensaje = 'El documento esta siendo procesado por el Ministerio de Hacienda';
                }

                if (response.validar_estado == 'error') {
                    response.estado = 'error';
                    mensaje = 'El documento no ha podido ser validado por el Ministerio de Hacienda, debe intetarlo mas tarde';
                }

                Swal.fire({
                    title: 'Documento generado',
                    text: mensaje,
                    icon: response.estado,
                    showConfirmButton: true,

                    //Texto del boton de confirmacion
                    confirmButtonText: 'Ver PDF',
                    //Accion del boton de confirmacion
                    confirmButtonColor: '#3085d6',
                    //Color del boton de cancelacion
                    cancelButtonColor: '#d33',
                    //Icono en el boton de cancelacion
                    cancelButtonText: '<i class="fas fa-times"></i>',

                    //Mostrar el boton de cancelacion
                    showCancelButton: true,

                }).then((result) => {
                    if (result.value) {
                        verPdf(response.clave);
                    }

                    cancelar_documento();
                });
            }

            else {
                Swal.fire({
                    title: 'Atencion',
                    text: response.error,
                    icon: response.estado,
                    showConfirmButton: false,
                    timer: 2000

                }).then((result) => {
                    //activar_campo_clase('inp-fct', false, factura_activa);
                });
            }
        });
    });
}

/**Validar los documentos que se encuentran en proceso */
function validar_documentos() {
    Pace.track(function () {
        $.ajax({
            "url": base + "documentos/validar_documentos",
            "method": "get",
            "dataType": "json",
        }).done(function (response) {
            if (response.error) {
                Swal.fire({
                    title: 'Atencion',
                    text: response.error,
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 2000
                }).then((result) => {
                    salir();
                });
            }
        });
    });
}//Fin de la funcion para validar los documentos

