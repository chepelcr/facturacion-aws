
/**
 * 
 */
function enviar_documento(id_documento = 0) {
    if (id_documento != null) {
        data = {};

        //Obtener el correo electronico desde el modalNotificar
        let email = $('#modalNotificar').find('.email').val();

        //Si el correo electronico no esta vacio y es un correo electronico valido
        if (email != '' && validar_email(email)) {
            data.email = email;
        } else {
            //Si el correo electronico no esta vacio y no es un correo electronico valido
            if (email != '') {
                mensajeAutomatico('Atencion', 'El correo electronico no es valido', 'error');
                return;
            }
        }

        Pace.track(function () {
            $.ajax({
                "url": base + "documentos/enviar_documento/" + id_documento,
                "method": "GET",
                "data": data,
                "dataType": "json"
            }).done(function (response) {
                if (!response.error) {
                    mensajeAutomatico('Atencion', response.mensaje, 'success');
                    cerrarNotificar();
                } else {
                    mensajeAutomatico('Atencion', response.error, 'error');
                }
            }).fail(function (jqXHR, textStatus, errorThrown) {
                json = JSON.parse(jqXHR.responseText);
                mensajeAutomatico('Atencion', json.error, 'error');
            });
        });
    }
}//Fin de la funcion para enviar el documento por correo electronico

function cerrarNotificar() {

    //Cerrar el modalNotificar
    $('#modalNotificar').modal('hide');

    //Eliminar el documentkey del campo btn-enviar
    $('#modalNotificar').find('.btn-enviar').val('');

    //Eliminar el correo electronico del campo email
    $('#modalNotificar').find('.email').val('');
}

function validar_email(email) {
    var re = /\S+@\S+\.\S+/;
    return re.test(email);
}

function abrirModalNotificar(documentkey = '') {
    $('#modalNotificar').modal('show');

    //Colocar el documentkey en el campo btn-enviar del modalNotificar
    $('#modalNotificar').find('.btn-enviar').val(documentkey);
}


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

                notificacion("Se ha actualizado el tipo de cambio", "", "success");

                //Desactivar el boton de actualizar
                $('#btn_cambio').attr('disabled', true);
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


/**Guardar un documento en la base de datos y enviarlo al ministerio de hacienda */
function guardar_documento() {
    activar_campo_clase('inp-fct', false, factura_activa);

    //Capturar los datos de la factura activa en FormData
    var document = new FormData($('#' + factura_activa)[0]);
    //var document = $('#' + factura_activa).serialize();

    //Obtener el customerId del documento
    var customerId = $('#' + factura_activa).find('.customerId').val();

    if (customerId != '') {
        activar_campo_clase('inp', false, 'frm_cliente');

        var receiver = new FormData($('#frm_cliente')[0]);

        var documentReceiver = {};

        //Recorrer los datos del cliente para agregarlos al FormData
        for (var pair of receiver.entries()) {
            //Se debe validar si el campo pertenece a un objeto (identification[typeId] por ejemplo)
            if (pair[0].includes('identification')) {
                //Obtener el nombre del campo
                var field = pair[0].split('[');
                field = field[1].split(']');
                field = field[0];

                //Si el campo no existe en el objeto, crearlo
                if (!documentReceiver['identification']) {
                    documentReceiver['identification'] = {};
                }

                //Si el campo es number, desformatiarlo
                if (field == 'number') {
                    pair[1] = quitar_formato(pair[1]);
                }

                //Agregar el valor al objeto
                documentReceiver['identification'][field] = pair[1];
            } else if (pair[0].includes('personalPhone')) {
                //Obtener el nombre del campo
                var field = pair[0].split('[');
                field = field[1].split(']');
                field = field[0];

                //Si el campo no existe en el objeto, crearlo
                if (!documentReceiver['personalPhone']) {
                    documentReceiver['personalPhone'] = {};
                }

                //Agregar el valor al objeto
                documentReceiver['personalPhone'][field] = pair[1];
            } else if (pair[0].includes('residence')) {
                //Obtener el nombre del campo
                var field = pair[0].split('[');
                field = field[1].split(']');
                field = field[0];

                //Si el campo no existe en el objeto, crearlo
                if (!documentReceiver['residence']) {
                    documentReceiver['residence'] = {};
                }

                //Agregar el valor al objeto
                documentReceiver['residence'][field] = pair[1];
            } else {
                //Agregar el valor al objeto
                documentReceiver[pair[0]] = pair[1];
            }
        }

        //Agregar el receiver al FormData
        document.append('receiver', JSON.stringify(documentReceiver));
    }

    Pace.track(function () {
        $.ajax({
            "url": base + "documentos/guardar",
            "method": "post",
            "data": document,
            "dataType": "json",
            "contentType": false,
            "processData": false,
            "cache": false,
        }).done(function (response) {
            const clave = response.consecutiveNumber
            var mensaje = 'El documento ' + clave + ' ha sido enviado al Ministerio de Hacienda';

            /*if (response.validar_estado == 'rechazado') {
                response.estado = 'error';
            }
 
            if (response.validar_estado == 'procesando') {
                response.estado = 'warning';
                mensaje = 'El documento esta siendo procesado por el Ministerio de Hacienda';
            }
 
            if (response.validar_estado == 'error') {
                response.estado = 'error';
                mensaje = 'El documento no ha podido ser validado por el Ministerio de Hacienda, debe intetarlo mas tarde';
            }*/

            Swal.fire({
                title: 'Documento generado',
                text: mensaje,
                icon: 'success',
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
                    const documentUrl = 'https://cloudfront.dev.ivois.io/' + response.documentRoute + '/' + response.documentName + '.pdf';
                    verPdf(documentUrl);
                }

                cancelar_documento();
            });
        }).fail(function (jqXHR, textStatus, errorThrown) {
            json = JSON.parse(jqXHR.responseText);

            Swal.fire({
                title: 'Atencion',
                text: response.message,
                icon: 'error',
                showConfirmButton: true,

                //Texto del boton de confirmacion
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#3085d6',


            }).then((result) => {
                //activar_campo_clase('inp-fct', false, factura_activa);
            });
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

