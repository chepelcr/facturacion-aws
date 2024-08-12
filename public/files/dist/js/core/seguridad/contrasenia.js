/**Abrir el modal login y mostrar el espacio para el cambio de contrasenia */
function cambio_contrasenia() {
    //Si el modulo activo es perfil
    if(modulo_activo == 'perfil'){
        //Ocultar el perfil
        $('#perfil').modal('hide');
    }//Fin del if

    //Mostrar el modal de login
    abrir_login("contrasenia");
}//Fin de la funcion

/**Volver al perfil del usuario */
function volver_perfil() {
    //Si el modulo activo es login
    if(modulo_activo == 'login_perfil'){
        //Ocultar el modal de login
        $('#modal_login').modal('hide');
    }//Fin del if

    //Mostrar el perfil
    abrir_perfil();
}//Fin de la funcion

/**Validar la contrasenia que esta ingresando el usuario */
function verificar_contrasenia() {
    var nueva_contraseña = $('#new_pass').val();
    var contra_nueva_conf = $('#new_pass_conf').val();

    if(nueva_contraseña != contra_nueva_conf){
        $('#' + elemento_activo).find(".btt-grd").attr("disabled", true);

        notificacion("Las contraseñas no coinciden", '', "error");
    }//Fin de la validacion

    if(nueva_contraseña == contra_nueva_conf){
        $('#' + elemento_activo).find(".btt-grd").attr("disabled", false);
    }//Fin de la validacion
}//Fin de la funcion