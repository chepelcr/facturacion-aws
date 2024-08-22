/**Abrir el modal del perfil de usuario */
function abrir_perfil() {
    //Si el modulo activo es login
    if (modulo_activo == 'login') {
        //Ocultar el modal de login
        $('#modal_login').modal('hide');
    }//Fin del if

    //Desactivar los campos de perfil
    campos_perfil(false);

    //Expand todos los card
    $('#perfil').find('.card').CardWidget('expand');

    $('#perfil').modal('show');

    elemento_activo = 'perfil';
    modulo_activo = 'perfil';
}//Fin de la funcion

/**Editar el perfil del usuario que ha iniciado sesión */
function editar_perfil() {
    //Si el elemento activo no es el perfil
    abrir_perfil();

    form_activo = 'frm_perfil';
    ruta_accion = 'seguridad/update/perfil';

    //Activar los campos del perfil
    campos_perfil(true);
}//Fin de la funcion editar_perfil

/**Activar o desactivar campos del perfil */
function campos_perfil(activar = false) {
    activar_campos_cedula('ver', 'perfil');

    if (activar) {
        activar_campo_clase('perfil', false, 'perfil');

        //Mostrar el panel_guardar del perfil
        $('#perfil').find('.panel-guardar').show();

        //Ocultar el panel_perfil del perfil
        $('#perfil').find('.panel-perfil').hide();
    } else {
        activar_campo_clase('perfil', true, 'perfil');

        //Ocultar el panel-guardar del perfil
        $('#perfil').find('.panel-guardar').hide();

        //Mostrar el panel_perfil del perfil
        $('#perfil').find('.panel-perfil').show();
    }//Fin de la validacion

    activar_campo_clase('id_empresa', true, 'perfil');
    activar_campo_clase('id_rol', true, 'perfil');
}//Fin de la funcion

/**Cancelar la edicion del perfil */
function cancelar_perfil() {
    //Collapse todos los card
    $('#perfil').find('.card').CardWidget('collapse');

    //Ocultar el panel_guardar del perfil
    $('#perfil').find('.panel-guardar').hide();

    //Mostrar el panel_perfil del perfil
    $('#perfil').find('.panel-perfil').show();

    //Desactivar los campos del perfil
    campos_perfil(false);
}//Fin de la funcion cancelar_perfil