function formatear_cedula(cedula, tipo_cedula = "01") {
    var cedula_formateada = cedula;
    console.log(cedula_formateada);
    console.log(tipo_cedula);

    switch (tipo_cedula) {

        case "01":
            //Formato de cedula
            //01-0234-0569

            //Formatear la cedula
            //Obtener el primer digito
            var primer_digito = cedula.substring(0, 1);

            //Obtener el del segundo al quinto digito
            var segundo_digito = cedula.substring(1, 5);

            //Obtener el sexto digito al noveno digito
            var tercer_digito = cedula.substring(5, 9);

            //Rellenar con ceros a la izquierda el primer digito hasta que tenga 2 digitos
            primer_digito = primer_digito.padStart(2, '0');

            //Rellenar con ceros a la izquierda el segundo digito y el tercer digito hasta que sean de 4 digitos
            while (segundo_digito.length < 4) {
                segundo_digito = "0" + segundo_digito;
            }

            while (tercer_digito.length < 4) {
                tercer_digito = "0" + tercer_digito;
            }

            //Unir los 3 digitos con -
            cedula_formateada = primer_digito + "-" + segundo_digito + "-" + tercer_digito;

            formato = true;
            break;

        case "02":
            //Formato de cedula
            //3-123-456700

            //Formatear la cedula
            //Obtener el primer digito
            var primer_digito = cedula.substring(0, 1);

            //Obtener el del segundo al cuarto digito
            var segundo_digito = cedula.substring(1, 4);

            //Obtener todos los restantes digitos
            var tercer_digito = cedula.substring(4, 10);

            //Rellenar con ceros a la izquierda el segundo digito hasta que tenga 3 digitos
            while (segundo_digito.length < 3) {
                segundo_digito = "0" + segundo_digito;
            }

            //Rellenar con ceros a la izquierda el tercer digito hasta que sean de 9 digitos
            while (tercer_digito.length < 6) {
                tercer_digito = "0" + tercer_digito;
            }

            //Unir los 3 digitos con -
            cedula_formateada = primer_digito + "-" + segundo_digito + "-" + tercer_digito;

            console.log(cedula_formateada);

            formato = true;
            break;
    }

    return cedula_formateada;
}//Fin de formatear cedula

/**Obtener un contribuyente del ministerio de hacienda */
function obtener_contribuyente(identificacion = null) {
    var cedula = identificacion;

    if (cedula != '' && cedula) {
        Pace.track(function () {
            $.ajax({
                "url": "https://api.hacienda.go.cr/fe/ae?identificacion=" + cedula,
                "method": "get",
            }).done(function (response) {
                if (response.code != 400 && response.code != 404) {
                    nombre = response.nombre;

                    //Poner la prmera letra de cada palabra en mayuscula
                    nombre = nombre.replace(/\w\S*/g, function (txt) {
                        return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
                    });

                    cedula_formateada = formatear_cedula(cedula, response.tipoIdentificacion);

                    $("#" + form_activo).find('.identificacion').val(cedula_formateada);

                    $("#" + form_activo).find(".nombre").val(nombre);
                    $("#" + form_activo).find(".id_tipo_identificacion").val(response.tipoIdentificacion);
                    $("#" + form_activo).find(".cod_pais").val(52);

                    activar_campos_contribuyente(true, form_activo);

                    //Desactivar el identificacion
                    $("#" + form_activo).find(".identificacion").attr("disabled", true);
                    $("#" + form_activo).find(".identificacion").attr("readonly", true);

                    //Activar el btn-eliminar
                    $("#" + form_activo).find(".btn-eliminar").attr("disabled", false);

                    notificacion('Contribuyente encontrado', '', 'success');
                } else if (response.code == 404) {
                    $("#" + form_activo).find(".nombre").val('');
                    $("#" + form_activo).find(".id_tipo_identificacion").val('');
                    $("#" + form_activo).find(".cod_pais").val('');

                    activar_campos_contribuyente(false, form_activo);

                    notificacion('No se encontró el contribuyente', '', 'info');
                } else {
                    $("#" + form_activo).find(".nombre").val('');
                    $("#" + form_activo).find(".id_tipo_identificacion").val('');
                    $("#" + form_activo).find(".cod_pais").val('');

                    activar_campos_contribuyente(false, form_activo);

                    notificacion('Error al obtener el contribuyente', '', 'error');
                }
            }).fail(function (jqXHR, textStatus, errorThrown) {
                $("#" + form_activo).find(".nombre").val('');
                $("#" + form_activo).find(".id_tipo_identificacion").val('');
                $("#" + form_activo).find(".cod_pais").val('');

                activar_campos_contribuyente(false, form_activo);

                notificacion('Error al obtener el contribuyente', '', 'error');
            });
        });
    } else {
        $("#" + form_activo).find(".nombre").val('');
        $("#" + form_activo).find(".id_tipo_identificacion").val('');
        $("#" + form_activo).find(".cod_pais").val('');

        activar_campos_contribuyente(false, form_activo);

        notificacion('El campo de identificación no puede estar vacío', '', 'info');
    }
}//Fin de obtener un contribuyente del ministerio de hacienda

function vaciar_cedula() {
    $("#" + form_activo).find(".identificacion").val('');
    $("#" + form_activo).find(".nombre").val('');
    $("#" + form_activo).find(".id_tipo_identificacion").val('');
    $("#" + form_activo).find(".cod_pais").val('');

    activar_campos_contribuyente(true, form_activo);

    $("#" + form_activo).find(".identificacion").attr("disabled", false);
    $("#" + form_activo).find(".identificacion").attr("readonly", false);

    formato = false;
}

