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