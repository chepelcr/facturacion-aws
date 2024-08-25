var formato = false;

/**Obtener un cliente de la base de datos */
function obtener_cliente(identificacion = '', validacion = false) {
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
                var cedula_formateada = formatear_cedula(data.identificacion, data.id_tipo_identificacion);

                //Ocultar cart-clientes
                $('.card-clientes').hide();

                //Ocultar card-busqueda
                $('.card-busqueda-clientes').hide();

                //Llenar el formulario del modal de la factura activa
                $.each(data, function (key, valor) {
                    if (key == 'identificacion') {
                        $('#' + form_activo).find('.identificacion').val(cedula_formateada);
                    } else {
                        $('#' + form_activo).find('.' + key).val(valor);
                    }
                });

                //Colocar el nombre del cliente en el input .nombre-cliente de la factura activa
                $('#' + factura_activa).find('.nombre-cliente').val(data.nombre);

                //Colocar la identificacion del cliente en el input .identificacion-cliente de la factura activa
                $('#' + factura_activa).find('.identificacion-cliente').val(cedula_formateada);

                //Si el nombre del cliente es igual a Walmart y es una factura (tipo_documento = "01")
                if (data.nombre_comercial == 'Walmart' && $('#' + factura_activa).find('.id_tipo_documento').val() == '01') {
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

                //Llenar la ubuicacion del cliente
                llenarUbicacion(data.cod_provincia, data.cod_canton, data.cod_distrito, data.id_ubicacion, true);

                campos_activos(true, form_activo);

                //Collapse todos los card del elemento activo
                $('#' + form_activo).find('.card').CardWidget('expand');

                //Mostrar el card de clientes
                $('#' + form_activo).show();

                if (validacion) {
                    mensajeAutomatico('Atencion', 'El cliente ya se encuentra registrado en la base de datos', 'info');
                }
            } else {
                //Expand todos los card del elemento activo
                $('#' + form_activo).find('.card').CardWidget('expand');

                obtener_contribuyente(identificacion);
            }
        });
    }
}

/**Validar la identificacion de un formulario */
function validar_identificacion(identificacion = '') {

    if (!formato && identificacion != '') {
        switch (modulo_activo) {
            case 'documentos':
                obtener_cliente(identificacion, validacion = true);
                break;

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

    else
        formato = false;
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
    var identificacion = $('#' + factura_activa).find('.identificacion-cliente').val();

    if (identificacion) {
        obtener_cliente(identificacion);
    }

    else
        buscar_clientes();

    //Mostrar el modal de busqueda de clientes
    $('.modal-clientes').modal('show');
}

/**Obtener todos los clientes de la base de datos */
function buscar_clientes() {
    //Solicitar los clientes por ajax
    $.ajax({
        url: base + 'documentos/get_clientes',
        type: 'GET',
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
    });
}

/**Funcion cuando el usuario presiona la opcion para agregar un cliente en el modulo buscar_cliente */
function agregar_cliente() {
    ruta_accion = 'empresa/guardar/clientes';

    //Agregar los clientes al modal
    $('.card-clientes').hide();

    //Ocultar card-busqueda
    $('.card-busqueda-clientes').hide();

    elemento_activo = 'frm_cliente';

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

    campos_activos(false, elemento_activo);

    vaciar_campos(elemento_activo);

    //Collapse todos los card del elemento activo
    $('#' + elemento_activo).find('.card').CardWidget('expand');

    //Mostrar el card de clientes
    $('#' + elemento_activo).show();
}