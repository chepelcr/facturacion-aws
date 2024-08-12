var modal = false;

/**Abrir un modal */
function abrir_modal(nombre_modal) {
    //Cerrar todos los modal
    $('.modal').modal('hide');

    //Abrir el modal-nombre_modulo
    $('#' + nombre_modal).modal('show');

    elemento_activo = nombre_modal;
}

/**Cerrar modal */
function cerrar_modal(nombre_modal = '') {
    if (nombre_modal == '') {
        nombre_modal = elemento_activo;
    }

    $('#' + nombre_modal).modal('hide');

    elemento_activo = '';
}

/**Cerrar todos los modal */
function cerrar_modals() {
    $('.modal').modal('hide');
}
