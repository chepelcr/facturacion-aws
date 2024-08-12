var modal = false;

/**Abrir un modal */
function abrir_modal(nombre_modal) {
    cerrar_modals();

    //Abrir el modal-nombre_modulo
    $('#' + nombre_modal).modal('show');

    elemento_activo = nombre_modal;

    modal = true;
}

/**Cerrar modal */
function cerrar_modal(nombre_modal = '', funcion = function() {}) {
    if (nombre_modal == '') {
        nombre_modal = elemento_activo;
    }

    $('#' + nombre_modal).modal('hide');

    elemento_activo = '';

    modal = false;

    //Si la función no es vacía
    if (funcion != function() {}) {
        //Ejecutar la función
        funcion();
    }

    else {
        cargar_inicio();
    }
}

/**Cerrar todos los modal */
function cerrar_modals() {
    $('.modal').modal('hide');
}
