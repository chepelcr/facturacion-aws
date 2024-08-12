/**Enviar una contraseña temporal al usuario */
function enviar_contrasenia(id_usuario) {
    Pace.track(function () {
        $.ajax({
            "url": base + "seguridad/enviar_contrasenia/" + id_usuario,
            "dataType": "json",
        }).done(function (response) {
            if (response.estado!='0') {
                mensajeAutomatico("Alerta", 'Contraseña enviada correctamente', "success");
            } //Fin del if
            else {
                mensajeAutomatico('Atencion', 'Ha ocurrido un error: ' + response.error, 'error');
            } //Fin del else
        });//Fin del ajax
    });
}//Fin de enviar_contrasenia

/**Validar la contrasenia que esta ingresando el usuario */
function verificar_contraseña() {
    var nueva_contraseña = $('#nueva_contraseña').val();
    var contra_nueva_conf = $('#contra_nueva_conf').val();

    if(nueva_contraseña != contra_nueva_conf){
        $('#' + elemento_activo).find(".btt-grd").attr("disabled", true);

        mensajeAutomatico("Atencion", "La nueva contraseña no coincide, verifiquela e intente de nuevo.", "error");
    }//Fin de la validacion

    if(nueva_contraseña == contra_nueva_conf){
        $('#' + elemento_activo).find(".btt-grd").attr("disabled", false);
    }//Fin de la validacion
}//Fin de la funcion