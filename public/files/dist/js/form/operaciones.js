/**Ruta de la accion del formulario que se encuentran en la pantalla */
var ruta_accion = "";

/**Nombre del formulario activo */
var form_activo = '';

/**ID del objeto que se muestra en el formulario */
var id_objeto = 0;

/**Abrir el formulario para agregar un objeto */
function agregar(titulo = '') {
    modulo = modulo_activo;
    submodulo = submodulo_activo;

    if ((modulo) != '' && (submodulo) != '') {
        ruta_accion = modulo + '/guardar/' + submodulo;

        elemento = elemento_activo;

        form_activo = 'frm_' + modulo_activo + '_' + submodulo_activo

        //Mostrar el card-frm del elemento activo
        $('#' + elemento).find('.card-frm').show();

        //Cerrar todos los card
        $('#' + elemento).find('.card-table').CardWidget('collapse');

        vaciar_campos(form_activo);

        $('#' + elemento).find(".titulo-submodulo").html(titulo);

        $('#' + elemento).find('.btt-mod').hide();
        $('#' + elemento).find('.btt-edt').hide();
        $('#' + elemento).find('.btt-grd').show();

        $('#' + elemento).find('.btn-grd').prop('disabled', false);

        campos_activos(false, form_activo);

        //Cerrar el card
        $('#' + elemento).find('.card-table').hide();

        //Abrir el card-frm
        $('#' + form_activo).find('.card-form').CardWidget('collapse');

        switch (modulo) {
            case 'empresa':
                switch (submodulo) {
                    case 'productos':
                        campos_cabys(true, form_activo);

                        $('#' + form_activo).find('.valor_total').val(0);
                        $('#' + form_activo).find('.impuesto').val(0);
                        $('#' + form_activo).find('.valor_impuesto').val(0);
                        $('#' + form_activo).find('.valor_unitario').val(0);

                        break;
                    case 'clientes':
                        activar_campos_contribuyente(true, form_activo);
                        vaciar_ubicacion();

                        //Poner el foco en el campo de cedula
                        $('#' + form_activo).find('.identificacion').focus();
                        break;
                }
                break;

            case 'seguridad':
                switch (submodulo) {
                    case 'roles':
                        desactivar_permisos(form_activo);
                        break;

                    case 'usuarios':
                        activar_campos_contribuyente(true, form_activo);

                        //Poner el foco en el campo de cedula
                        $('#' + form_activo).find('.identificacion').focus();
                }
                break;
        }

        //Abrir el card-frm
        //$('#' + form_activo).find('.card-form').CardWidget('expand');
    }
}//Fin de la funcion

/**Cancelar la accion del formulario actual */
function cancelar_accion()
{
    vaciar_campos(form_activo);
    
    campos_activos(true, form_activo);

    activar_campo_clase('btn-grd', true, elemento_activo);
    activar_campo_clase('btn-edt', true, elemento_activo);
    activar_campo_clase('btn-mdf', true, elemento_activo);

    form_activo = '';

    //Cerrar el card-frm
    $('#' + elemento_activo).find('.card-frm').hide();

    $('#' + elemento_activo).find('.card-table').show();
    $('#' + elemento_activo).find('.card-table').CardWidget('expand');

    //Poner el nombre del submodulo en el titulo con la primera letra en mayuscula
    $('#' + elemento_activo).find(".titulo-submodulo").html(submodulo_activo.charAt(0).toUpperCase() + submodulo_activo.slice(1));
}

function enviar_frm(formulario = '', nombre_elemento = '') {
    if (formulario != '') {
        campos_activos(false, nombre_elemento);

        if (nombre_elemento != '') {
            var formData = new FormData($('#' + nombre_elemento).find('#' + formulario)[0]);
        }

        else {
            var formData = new FormData($('#' + formulario)[0]);
        }

        campos_activos(true, nombre_elemento);

        Pace.track(function () {
            $.ajax({
                "url": base + ruta_accion,
                "method": "post",
                "data": formData,
                "dataType": "json",
                "contentType": false,
                "processData": false,
                "cache": false,
            }).done(function (response) {
                if (!response.error) {
                    Swal.fire({
                        title: 'Atencion',
                        text: response.success,
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false,
                    }).then((result) => {
                        //Cerrar el elemento
                        if (nombre_elemento != '') {
                            //Si el elemento es un modal
                            if (nombre_elemento == 'modalAccion') {
                                $('#' + nombre_elemento).modal('hide');
                            }

                            else {
                                $('#' + nombre_elemento).hide();
                            }
                        }

                        //Esperar un segundo
                        setTimeout(function () {
                            cargar_listado(modulo_activo, submodulo_activo, base + modulo_activo + "/" + submodulo_activo + "/listado");
                        }, 1000);
                    })//Fin del mensaje
                }
                else {
                    mensajeAutomatico('Alerta', response.error, 'error');
                } //Fin del else*/
            });
        });
    }
}//Fin de la funcion

/**Lenar un formulario con la informacion enviada */
function llenarFrm(objeto, titulo, nombre_form = '', ver = false) {
    form_activo = nombre_form;

    //Cerrar todos los card
    $('#' + nombre_form).find('.card').CardWidget('collapse');

    if (objeto) {
        var identificacion = false;
        var tipo_identificacion = '';

        $.each(objeto, function (key, valor) {
            if (key == 'identificacion') {
                identificacion = valor;
            }

            else if (key == 'id_tipo_identificacion') {
                tipo_identificacion = valor;
            }

            $('#' + nombre_form).find("." + key).val(valor);

        });

        if (identificacion) {
            identificacion = formatear_cedula(identificacion, tipo_identificacion);
            $('#' + nombre_form).find(".identificacion").val(identificacion);
        }

        $('#' + elemento_activo).find(".titulo-form").html(titulo);

        //Mostrar el card-frm
        $('#' + elemento_activo).find('.card-frm').show();

        if(ver)
        {
            $('#' + elemento_activo).find('.btt-mod').hide();
            $('#' + elemento_activo).find('.btt-edt').show();
            $('#' + elemento_activo).find('.btt-grd').hide();

            activar_campo_clase('btn-grd', true, elemento_activo);
            activar_campo_clase('btn-edt', false, elemento_activo);
            activar_campo_clase('btn-mdf', true, elemento_activo);
        }

        else
        {
            $('#' + elemento_activo).find('.btt-mod').show();
            $('#' + elemento_activo).find('.btt-edt').hide();
            $('#' + elemento_activo).find('.btt-grd').hide();

            activar_campo_clase('btn-grd', true, elemento_activo);
            activar_campo_clase('btn-edt', true, elemento_activo);
            activar_campo_clase('btn-mdf', false, elemento_activo);
        }

        campos_activos(ver, nombre_form);

        //Abrir el card
        $('#' + form_activo).find('.card').CardWidget('expand');
    }//Fin de la validacion
}//Fin de la funcion

/**Editar el contenido de un formulario */
function editar() {
    $('#' + elemento_activo).find('.btt-edt').hide();
    $('#' + elemento_activo).find('.btt-mod').show();

    activar_campo_clase('btn-edt', true, elemento_activo);
    activar_campo_clase('btn-mdf', false, elemento_activo);

    campos_activos(false, form_activo);

    switch (modulo_activo) {
        case 'empresa':
            switch (submodulo_activo) {
                case 'clientes':
                    activar_campos_cedula(true, form_activo);
                    break;

                case 'productos':
                    campos_productos(true, form_activo);
            }
            break;

        case 'seguridad':
            switch (submodulo_activo) {
                case 'usuarios':
                    activar_campos_cedula(true, form_activo);
                    break;
            }
            break;
    }
}//Fin de la funcion editar

/**Verificar si existe un elemento en la base de datos */
function validar(elemento = '', objeto = '') {
    if (elemento != '' && elemento) {
        $.ajax({
            "url": base + modulo_activo + "/validar/" + elemento + "/" + submodulo_activo,
            "dataType": "json",
        }).done(function (response) {
            if (response) {
                mensajeAutomatico("Alerta", "El " + objeto + " ya existe", "info");

                campos_activos(true, form_activo);

                $('#' + elemento_activo).find(".btn-grd").attr("disabled", true);

                if (objeto == 'usuario' || objeto == 'cliente') {
                    //console.log(objeto);
                    //Activar el campo de identificacion
                    //$('#' + form_activo).find(".identificacion").attr("disabled", false);
                    //$('#' + form_activo).find(".identificacion").attr("readonly", false);

                    //Activar el boton para eliminar la identificacion
                    //Activar el btn-eliminar
                    $("#" + form_activo).find(".btn-eliminar").attr("disabled", false);
                }

                if (objeto == 'producto') {
                    $('#' + form_activo).find("#codigo_venta").attr("disabled", false);
                    $('#' + form_activo).find("#codigo_venta").attr("readonly", false);
                }
            }//Fin del usuario existente

            else {
                campos_activos(false, form_activo);

                if (objeto == 'usuario' || objeto == 'cliente') {
                    obtener_contribuyente(elemento);
                }

                if (objeto == 'producto') {
                    campos_cabys(true, form_activo);
                }

                $('#' + elemento_activo).find(".btn-grd").attr("disabled", false);
            }
        });
    }//Fin de validacion de elemento
}//Fin de verificar un elemento en la base de datos

/**Activar un objeto en la base de datos */
function habilitar(id, objeto) {
    $.ajax({
        "url": base + modulo_activo + "/activar/" + id + "/" + submodulo_activo,
        "method": "get",
        "dataType": "json",
    }).done(function (response) {
        if (!response.error) {
            //Poner la primeta letra en mayuscula
            objeto = objeto.charAt(0).toUpperCase() + objeto.slice(1);
            Swal.fire({
                title: 'Alerta',
                text: objeto + " habilitado correctamente",
                icon: 'success',
                timer: 2000,
                showConfirmButton: false,
            }).then((result) => {
                //Recargar la tabla
                recargar_listado('activos');
            })//Fin del mensaje
        } //Fin del if
        else {
            mensajeAutomatico('Atencion', 'Ha ocurrido un error: ' + response.error, 'error');
        } //Fin del else
    });
}//Fin de habilitar un objeto en la base de datos

/**Desactivar un objeto de la base de datos */
function deshabilitar(id, objeto) {
    $.ajax({
        "url": base + modulo_activo + "/desactivar/" + id + "/" + submodulo_activo,
        "method": "get",
        "dataType": "json",
    }).done(function (response) {
        if (!response.error) {
            //Poner el objeto en mayusculas
            objeto = objeto.charAt(0).toUpperCase() + objeto.slice(1);
            Swal.fire({
                title: 'Alerta',
                text: objeto + " deshabilitado correctamente",
                icon: 'success',
                timer: 2000,
                showConfirmButton: false,
            }).then((result) => {
                recargar_listado('inactivos');
            })//Fin del mensaje
        } //Fin del if
        else {
            mensajeAutomatico('Atencion', 'Ha ocurrido un error: ' + response.error, 'error');
        } //Fin del else
    });
}//Fin de deshabilitar un objeto en la base de datos

/**Obtener un objeto de la base de datos */
function obtener(id, objeto, ver = false) {
    id_objeto = id;

    $.ajax({
        "url": base + modulo_activo + "/obtener/" + id + '/' + submodulo_activo,
        "method": "get",
        "dataType": "json",
    }).done(function (response) {
        if (!response.error) {
            modulo = modulo_activo;
            submodulo = submodulo_activo;

            ruta_accion = modulo + '/update/' + id_objeto + '/' + submodulo;

            //Collapsar el listado
            $('#' + elemento_activo).find('.card-table').CardWidget('collapse');

            //Cerrar el card
            $('#' + elemento_activo).find('.card-table').hide();

            if(ver){
                titulo = 'Ver ' + objeto;
            } else {
                titulo = 'Editar ' + objeto;
            }

            llenarFrm(response, titulo, 'frm_' + modulo_activo + '_' + submodulo_activo, ver);

            if (objeto == 'usuario') {
                activar_campos_cedula(true, form_activo);
            }

            if (objeto == 'cliente') {
                activar_campos_cedula(true, form_activo);
                llenarUbicacion(response.cod_provincia, response.cod_canton, response.cod_distrito, response.id_ubicacion, ver);
            }

            if (objeto == 'producto') {
                campos_productos(true, form_activo);
                calcular_valor_producto(form_activo);
            }

            /**Si existe response.modulos */
            if (objeto == 'rol') {
                llenar_permisos(response.modulos, form_activo);
            }
        }

        else {
            mensajeAutomatico('Atencion', 'Ha ocurrido un error: ' + response.error, 'error');
        }
    });
}//Fin de obtener un objeto de la base de datos

function enviar_formulario() {
    var nombre_form = form_activo;

    if (nombre_form != '') {
        campos_activos(false, nombre_form);

        var formData = new FormData($('#' + nombre_form)[0]);

        //console.log(formData);

        campos_activos(true, nombre_form);

        //Collapsar los card
        $('#' + nombre_form).find('.card').CardWidget('collapse');

        Pace.track(function () {
            $.ajax({
                "url": base + ruta_accion,
                "method": "post",
                "data": formData,
                "dataType": "json",
                "contentType": false,
                "processData": false,
            }).done(function (response) {
                if (!response.error) {
                    Swal.fire({
                        title: 'Atencion',
                        text: response.success,
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false,
                    }).then((result) => {
                            cargar_listado(modulo_activo, submodulo_activo, url_listado);
                    })//Fin del mensaje
                } //Fin del if
                else {
                    mensajeAutomatico('Atencion', 'Ha ocurrido un error: ' + response.error, 'error');
                } //Fin del else
            });//Fin del ajax
        });//Fin de track
    }//Fin del if !elemento
}

$(document).ready(function () {
    //Cuando se envia el frm
    $(document).on('submit', '#frm', function (e) {
        e.preventDefault();

        enviar_frm('frm', 'modalAccion');

        return false;
    });

    //Cuando el mouse entra en un .card-form
    $(document).on('mouseenter', '.card-form', function () {
        //Expandir el card-form al pasar el mouse
        $(this).CardWidget('expand');
    });
});