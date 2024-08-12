function obtener_cantones(cod_provincia = null) {
    if(cod_provincia == null) {
        var cod_provincia = $('#' + elemento_activo).find(".provincia").val();
    }

    var html = crear_option('', 'Seleccionar');

    $('#' + elemento_activo).find('.distrito').html(html);
    activar_campo_clase('distrito', true, elemento_activo);

    $('#' + elemento_activo).find('.barrio').html(html);
    activar_campo_clase('barrio', true, elemento_activo);

    Pace.track(function () {
        $.ajax({
            "url": base + 'ubicacion/cantones/' + cod_provincia,
            "dataType": "json",
            "method": "GET"
        }).done(function (response) {
            if (response) {
                //0: {cod_canton:1 , nom_canton: canton}
                $.each(response, function (i, canton) {
                    html += crear_option(canton.cod_canton, canton.canton);
                });
            }

            $('#' + elemento_activo).find('.canton').html(html);
            activar_campo_clase('canton', false, elemento_activo);
        });
    });
}

/**Obtener todos los distritos de un canton */
function obtener_distritos(cod_provincia = null, cod_canton = null) {
    if(cod_provincia == null) {
        var cod_provincia = $('#' + elemento_activo).find(".provincia").val();
    }

    if(cod_canton == null) {
        var cod_canton = $('#' + elemento_activo).find(".canton").val();
    }

    var html = crear_option('', 'Seleccionar');

    $('#' + elemento_activo).find('.barrio').html(html);
    activar_campo_clase('barrio', true, elemento_activo);

    Pace.track(function () {
        $.ajax({
            "url": base + 'ubicacion/distritos/' + cod_provincia + '/' + cod_canton,
            "dataType": "json",
            "method": "GET"
        }).done(function (response) {
            if (response) {
                $.each(response, function (i, distrito) {
                    html += crear_option(distrito.cod_distrito, distrito.distrito);
                });
            }

            $('#' + elemento_activo).find('.distrito').html(html);
            activar_campo_clase('distrito', false, elemento_activo);
        });
    });
}

/**Obtener todos los barrios de un distrito */
function obtener_barrios(cod_provincia = null, cod_canton = null, cod_distrito = null) {
    if(cod_provincia == null) {
        var cod_provincia = $('#' + elemento_activo).find(".provincia").val();
    }

    if(cod_canton == null) {
        var cod_canton = $('#' + elemento_activo).find(".canton").val();
    }

    if(cod_distrito == null) {
        var cod_distrito = $('#' + elemento_activo).find(".distrito").val();
    }

    var html = crear_option('', 'Seleccionar');

    Pace.track(function () {
        $.ajax({
            "url": base + 'ubicacion/barrios/' + cod_provincia + '/' + cod_canton + '/' + cod_distrito,
            "dataType": "json",
            "method": "GET"
        }).done(function (response) {
            if (response) {
                $.each(response, function (i, barrio) {
                    html += crear_option(barrio.id_ubicacion, barrio.barrio);
                });
            }

            $('#' + elemento_activo).find('.barrio').html(html);
            activar_campo_clase('barrio', false, elemento_activo);
        });
    });
}

/**Llenar la ubicacion */
function llenarUbicacion(cod_provincia, cod_canton, cod_distrito, id_ubicacion, ver = false) {
    var html = crear_option('', 'Seleccionar');

    //Poner el codigo de la provincia
    $('#' + elemento_activo).find('.provincia').val(cod_provincia);

    $('#' + elemento_activo).find('.canton').html(html);
    activar_campo_clase('canton', true, elemento_activo);

    $('#' + elemento_activo).find('.distrito').html(html);
    activar_campo_clase('distrito', true, elemento_activo);

    $('#' + elemento_activo).find('.barrio').html(html);
    activar_campo_clase('barrio', true, elemento_activo);

    var html_canton = html;
    var html_distritos = html;
    var html_barrios = html;

    Pace.track(function () {
        $.ajax({
            "url": base + 'ubicacion/cantones/' + cod_provincia,
            "dataType": "json",
            "method": "GET"
        }).done(function (response) {
            if (response) {
                //0: {cod_canton:1 , nom_canton: canton}
                $.each(response, function (i, canton) {
                    html_canton += crear_option(canton.cod_canton, canton.canton);
                });

                $('#' + elemento_activo).find('.canton').html(html_canton);
                $('#' + elemento_activo).find('.canton').val(cod_canton);
                
                $.ajax({
                    "url": base + 'ubicacion/distritos/' + cod_provincia + '/' + cod_canton,
                    "dataType": "json",
                    "method": "GET"
                }).done(function (response) {
                    if (response) {
                        $.each(response, function (i, distrito) {
                            html_distritos += crear_option(distrito.cod_distrito, distrito.distrito);
                        });

                        $('#' + elemento_activo).find('.distrito').html(html_distritos);
                        $('#' + elemento_activo).find('.distrito').val(cod_distrito);

                        $.ajax({
                            "url": base + 'ubicacion/barrios/' + cod_provincia + '/' + cod_canton + '/' + cod_distrito,
                            "dataType": "json",
                            "method": "GET"
                        }).done(function (response) {
                            if (response) {
                                $.each(response, function (i, barrio) {
                                    html_barrios += crear_option(barrio.id_ubicacion, barrio.barrio);
                                });

                                $('#' + elemento_activo).find('.barrio').html(html_barrios);
                                $('#' + elemento_activo).find('.barrio').val(id_ubicacion);
                            }
                        });

                        if(ver)
                        {
                            desactivar_ubicaciones(true, true);
                        }

                        else
                        {
                            desactivar_ubicaciones(false);
                        }
                    }
                });
            }
        });
    });
}//Fin de la funcion

/**Vaciar los campos de ubicacion */
function vaciar_ubicacion() {
    var html = crear_option('', 'Seleccionar');

    $('#' + elemento_activo).find('.provincia').val('');

    $('#' + elemento_activo).find('.canton').html(html);
    $('#' + elemento_activo).find('.distrito').html(html);
    $('#' + elemento_activo).find('.barrio').html(html);

    desactivar_ubicaciones(true);
}

/**Desactivar los campos de ubicacion */
function desactivar_ubicaciones(estado = true, provincia = false) {
    activar_campo_clase('provincia', provincia, elemento_activo);
    activar_campo_clase('canton', estado, elemento_activo);
    activar_campo_clase('distrito', estado, elemento_activo);
    activar_campo_clase('barrio', estado, elemento_activo);
}