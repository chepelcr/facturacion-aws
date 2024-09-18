/**Obtener un cliente de la base de datos */
function obtener_cliente(identificacion = '') {
    form_activo = 'frm_cliente';

    //Collapse todos los card del elemento activo
    $('#' + form_activo).find('.card').CardWidget('collapse');

    if (identificacion && identificacion != '') {
        //Solicitar el cliente por ajax
        $.ajax({
            url: base + 'documentos/buscar_cliente/' + identificacion,
            type: 'GET',
            dataType: 'json',
        }).done(function (data) {
            if (!data.error) {
                //Ocultar cart-clientes
                $('.card-clientes').hide();

                //Ocultar card-busqueda
                $('.card-busqueda-clientes').hide();

                llenarObjeto(form_activo, data, 'ver');

                //Colocar el nombre del cliente en el input .nombre-cliente de la factura activa
                $('#' + factura_activa).find('.nombre-cliente').val(data.businessName);

                //Colocar la identificacion del cliente en el input .customerId de la factura activa
                $('#' + factura_activa).find('.customerId').val(data.id);

                //Si el nombre del cliente es igual a Walmart y es una factura (tipo_documento = "01")
                if (data.identification.number == '3102007223' && $('#' + factura_activa).find('.documentTypeCode').val() == '01') {
                    //Mostrar el boton de walmart
                    $('.col-walmart').show();

                    //Si el .contenedor-walmart no tiene un .modal-walmart
                    if (!$('#' + factura_activa).find('.contenedor-walmart').find('.modal-walmart').length) {
                        //Solicitar el modal de walmart
                        $.ajax({
                            url: base + 'documentos/get_walmart',
                            type: 'GET',
                            dataType: 'html',
                        }).done(function (data) {
                            //Agregar el modal de walmart al documento activo
                            $('#' + factura_activa).find('.contenedor-walmart').empty().append(data);
                        });
                    }
                }

                else {
                    //Ocultar el boton de walmart
                    $('.col-walmart').hide();

                    //Eliminar el modal de walmart del documento activo
                    $('#' + factura_activa).find('.contenedor-walmart').empty();
                }

                //Ocultar el boton de guardar del modal de cliente
                $('.btt-grd-clt').hide();

                //Ocultar el boton de editar del modal de cliente
                $('.btt-edt-clt').show();

                //Ocultar el boton de guardar cambios del modal de cliente
                $('.btt-grd-clt-cambios').hide();

                //Mostrar el boton de aceptar cliente
                $('.btt-aceptar-clt').show();

                //Mostrar el boton de seleccionar otro
                $('.btt-sct-clt').show();

                //Mostrar el boton de agregar cliente
                $('.btt-add-clt').hide();

                //Mostrar el card de clientes
                $('#' + form_activo).show();

            } else {
                notificacion(data.error, '', 'error');
            }
        }).fail(function (jqXHR, status, error) {
            response = jqXHR.responseText;

            if (response != '') {
                response = JSON.parse(response);
            }

            notificacion(response.error, '', 'error');
        });
    }
}

/**Validar la identificacion de un formulario */
function validar_identificacion(identificacion = '') {

    if (!formato && identificacion != '') {
        switch (modulo_activo) {
            case 'seguridad':
                if (submodulo_activo == 'usuarios')
                    validar(identificacion, 'usuario');
                break;

            case 'empresa':
                if (submodulo_activo == 'clientes') {
                    $("#" + form_activo).find('.identificacion').val(identificacion);

                    validar(identificacion, 'cliente');
                }
                break;
        }//Fin del switch
    }//Fin de validacion

    else {
        formato = false;
    }
}

/**Editar el cliente del documento activo */
function editar_cliente() {
    //Ocultar el boton de guardar del modal de cliente
    $('.btt-grd-clt').hide();

    //Ocultar el boton de editar del modal de cliente
    $('.btt-edt-clt').hide();

    //Ocultar el boton de guardar cambios del modal de cliente
    $('.btt-grd-clt-cambios').show();

    //Mostrar el boton de aceptar cliente
    $('.btt-aceptar-clt').hide();

    //Mostrar el boton de seleccionar otro
    $('.btt-sct-clt').show();

    //Mostrar el boton de agregar cliente
    $('.btt-add-clt').hide();

    campos_activos(false, elemento_activo);

    activar_campos_cedula('editar', elemento_activo);
}

/** Ver el modal del cliente del documento activo*/
function ver_modal_cliente() {
    //Obtener la identificacion del modal de la factura activa
    var identificacion = $('#' + factura_activa).find('.customerId').val();

    if (identificacion) {
        obtener_cliente(identificacion);
    }

    else {
        buscar_clientes();
    }

    //Mostrar el modal de busqueda de clientes
    $('.modal-clientes').modal('show');
}

function validarCliente() {
    var clienteValido = validarDataForm('frm_cliente');

    inputs.each(function (index, input) {
        if ($(input).attr('required') && $(input).val() == '') {
            //Colocar un borde rojo al input
            $(input).addClass('border-danger');
            clienteValido = false;
        } else {
            $(input).removeClass('border-danger');
        }
    });

    //Si el cliente es valido, cerrar el modal .modal-clientes
    if (clienteValido) {
        $('.modal-clientes').modal('hide');

        //Colocar el valor del cliente en el input .customerId de la factura activa
        $('#' + factura_activa).find('.customerId').val($('#frm_cliente').find('.identification_number').val());

        //Colocar el nombre del cliente en el input .nombre-cliente de la factura activa
        $('#' + factura_activa).find('.nombre-cliente').val($('#frm_cliente').find('.businessName').val());
    } else {
        notificacion('Debe llenar todos los campos obligatorios del cliente', '', 'error');
    }
}

/**Obtener todos los clientes de la base de datos */
function buscar_clientes() {
    //Obtener el tipo de documento de la factura activa mediante el data-code del option seleccionado
    let documentTypeCode = $('#' + factura_activa).find('.documentTypeId').find('option:selected').data('code');

    data = {
        documentTypeCode: documentTypeCode
    };

    //Solicitar los clientes por ajax
    $.ajax({
        url: base + 'documentos/get_clientes',
        type: 'GET',
        data: data,
        dataType: 'html',
    }).done(function (data) {
        //Agregar los clientes al modal
        $('.card-clientes').show();

        //Ocultar card-busqueda
        $('.card-busqueda-clientes').show();

        //Agregar los clientes al modal
        $('.card-clientes').empty().append(data);

        //Collapse el .card-cliente de la factura activa
        $('#frm_cliente').hide();

        //Ocultar el boton de guardar del modal de clientes
        $('.btt-grd-clt').hide();

        //Ocultar el boton de editar del modal de clientes
        $('.btt-edt-clt').hide();

        //Ocultar el boton de guardar cambios del modal de clientes
        $('.btt-grd-clt-cambios').hide();

        //Ocultar el boton de aceptar del modal de clientes
        $('.btt-aceptar-clt').hide();

        //Mostrar el boton de seleccionar otro
        $('.btt-sct-clt').hide();

        //Mostrar el boton de agregar cliente
        $('.btt-add-clt').show();
    }).fail(function (jqXHR, status, error) {
        response = jqXHR.responseText;

        if (response != '') {
            response = JSON.parse(response);
        }

        notificacion(response.error, '', 'error');
    });
}

/**Funcion cuando el usuario presiona la opcion para agregar un cliente en el modulo buscar_cliente */
function agregar_cliente() {
    //ruta_accion = 'empresa/guardar/clientes';

    //Agregar los clientes al modal
    $('.card-clientes').hide();

    //Ocultar card-busqueda
    $('.card-busqueda-clientes').hide();

    form_activo = 'frm_cliente';

    //Mostrar el boton de guardar del modal de cliente
    $('.btt-grd-clt').show();

    //Ocultar el boton de editar del modal de cliente
    $('.btt-edt-clt').hide();

    //Ocultar el boton de aceptar del modal de clientes
    $('.btt-aceptar-clt').hide();

    //Ocultar el boton de guardar cambios del modal de cliente
    $('.btt-grd-clt-cambios').hide();

    //Mostrar el boton de seleccionar otro
    $('.btt-sct-clt').show();

    //Mostrar el boton de agregar cliente
    $('.btt-add-clt').hide();

    campos_activos(false, form_activo);

    vaciar_campos(form_activo);

    //Collapse todos los card del elemento activo
    $('#' + form_activo).find('.card').CardWidget('expand');

    //Mostrar el card de clientes
    $('#' + form_activo).show();
}