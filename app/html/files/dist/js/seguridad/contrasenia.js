//Verificar la contrasenia que esta ingresando el usuario
function verificar_contraseña() {
    var nueva_contraseña = $('#nueva_contraseña').val();
    var contra_nueva_conf = $('#contra_nueva_conf').val();

    if(nueva_contraseña != contra_nueva_conf){
        $(".btt-grd").attr("disabled", true);

        mensajeAutomatico("Atencion", "La nueva contraseña no coincide, verifiquela e intente de nuevo.", "error");
    }//Fin de la validacion

    if(nueva_contraseña == contra_nueva_conf){
        $(".btt-grd").attr("disabled", false);
    }//Fin de la validacion
}//Fin de la funcion

function cambiar_contrasenia()
{
    $.ajax({
        "url": base + "seguridad/update/contrasenia",
        "method": "post",
        "data": $('#frm_contrasenia').serialize(),
        "dataType": "json",
    }).done(function(response) {
        
        if (!response.error) {
            //Enviar mesaje de exito
            mensajeAutomaticoRecargar('Atencion', 'Contraseña actualizada correctamente', 'success');
            
        } //Fin del if
        else {
            mensajeAutomatico('Atencion', response.error, 'error');
        } //Fin del else
    });
}