let username = '';
let password = '';
let notifySentDocuments = '';
let notifyReceivedDocuments = '';
let notifyProcessingDocuments = '';
let callbackUrl = '';

let ver = false;

const frmEmpresa = 'frm_configuracion_empresa';

function editar_configuracion() {
    campos_activos(false, frmEmpresa);

    if (username == '') {
        username = $('#' + frmEmpresa).find('.inp_username').val();
    }

    if (password == '') {
        password = $('#' + frmEmpresa).find('.inp_password').val();
    }

    if (notifySentDocuments == '') {
        notifySentDocuments = $('#' + frmEmpresa).find('.inp_notifySentDocuments').val();
    }

    if (notifyReceivedDocuments == '') {
        notifyReceivedDocuments = $('#' + frmEmpresa).find('.inp_notifyReceivedDocuments').val();
    }

    if (notifyProcessingDocuments == '') {
        notifyProcessingDocuments = $('#' + frmEmpresa).find('.inp_notifyProcessingDocuments').val();
    }

    if (callbackUrl == '') {
        callbackUrl = $('#' + frmEmpresa).find('.inp_callbackUrl').val();
    }

    // Quitar el atributo hidden de los botones de guardar y cancelar
    $('#' + frmEmpresa).find('.btn-grd').removeAttr('hidden');

    // Esconder el boton de editar
    $('#' + frmEmpresa).find('.btn-edt').attr('hidden', true);

    // Abrir todos los card
    abrir_configuracion()
}

function cancelar_edicion_configuracion() {
    vaciar_campos(frmEmpresa);

    $('#' + frmEmpresa).find('.inp_username').val(username);
    $('#' + frmEmpresa).find('.inp_password').val(password);
    $('#' + frmEmpresa).find('.inp_callbackUrl').val(callbackUrl);

    cambiar_estado_notificacion(notifySentDocuments);

    estado_notificacion_proceso(notifyProcessingDocuments);

    estado_notificacion_recibido(notifyReceivedDocuments);

    campos_activos(true, frmEmpresa);

    limpiar_variables();
}

function cambiar_estado_notificacion(notifySentDocumentsValue) {
    // Activar el boton de la notificacion de documentos enviados
    if (notifySentDocumentsValue == 1) {
        //btn-ntf-aprv
        boton_estado = $('#' + frmEmpresa).find('.btn-ntf-aprv');
    } else if (notifySentDocumentsValue == 2) {
        //btn-ntf-rjct
        boton_estado = $('#' + frmEmpresa).find('.btn-ntf-rjct');

    } else if (notifySentDocumentsValue == 3) {
        //btn-ntf-all
        boton_estado = $('#' + frmEmpresa).find('.btn-ntf-all');
    } else {
        //btn-ntf-none
        boton_estado = $('#' + frmEmpresa).find('.btn-ntf-none');
    }

    // Elminar la clase btn-success de todos los botones btn-ntf del frm_configuracion_empresa
    $('#' + frmEmpresa).find('.btn-ntf').removeClass('btn-success');

    // Eliminar la clase btn-secondary de todos los botones btn-ntf del frm_configuracion_empresa
    $('#' + frmEmpresa).find('.btn-ntf').removeClass('btn-secondary');

    // Agregar la clase btn-success al boton que se le dio click
    $(boton_estado).addClass('btn-success');

    //Agregar la clase btn-secondary a los botones que no se le dio click
    $(boton_estado).siblings().addClass('btn-secondary');

    //Colocar el valor del boton en el campo de notificacion
    $('#' + frmEmpresa).find('.inp_notifySentDocuments').val(notifySentDocumentsValue);
}

function estado_notificacion_proceso(value) {
    boton_estado = $('#' + frmEmpresa).find('.notifyProcessingDocuments');

    // Si el valor es 1, se activa la notificacion, si es 0 se desactiva
    if (value == 1) {
        //Eliminar la clase btn-success del boton
        $(boton_estado).addClass('btn-success');

        // Agregar la clase btn-secondary al boton
        $(boton_estado).removeClass('btn-secondary');

        // Cambiar el valor del boton a 0
        $(boton_estado).val(0);
    } else {
        //Agregar la clase btn-success al boton
        $(boton_estado).removeClass('btn-success');

        //Eliminar la clase btn-secondary del boton
        $(boton_estado).addClass('btn-secondary');

        // Cambiar el valor del boton a 1
        $(boton_estado).val(1);
    }

    //Colocar el valor 0 en el campo de notificacion
    $('#' + frmEmpresa).find('.inp_notifyProcessingDocuments').val(value);

}

function estado_notificacion_recibido(value) {
    boton_estado = $('#' + frmEmpresa).find('.notifyReceivedDocuments');

    // Si el valor es 1, se activa la notificacion, si es 0 se desactiva
    if (value == 0) {
        //Eliminar la clase btn-success del boton
        $(boton_estado).removeClass('btn-success');

        // Agregar la clase btn-secondary al boton
        $(boton_estado).addClass('btn-secondary');

        // Cambiar el valor del boton a 0
        $(boton_estado).val(1);
    } else {
        //Agregar la clase btn-success al boton
        $(boton_estado).addClass('btn-success');

        //Eliminar la clase btn-secondary del boton
        $(boton_estado).removeClass('btn-secondary');

        // Cambiar el valor del boton a 1
        $(boton_estado).val(0);
    }

    //Colocar el valor 0 en el campo de notificacion
    $('#' + frmEmpresa).find('.inp_notifyReceivedDocuments').val(value);
}

function guardar_configuracion() {
    //Capturar los datos de la factura activa en FormData
    var formData = new FormData($('#' + frmEmpresa)[0]);

    Pace.track(function () {
        campos_activos(true, frmEmpresa);

        $.ajax({
            "url": base + "configuracion/update/hacienda",
            "method": "post",
            "data": formData,
            "contentType": false,
            "processData": false,
            "dataType": "json"
        }).done(function (response) {
            limpiar_variables();
            notificacion('Se ha actualizado la configuracion de hacienda', '', 'success');
        }).fail(function (jqXHR, textStatus, errorThrown) {
            campos_activos(false, frmEmpresa);
            notificacion('Error al actualizar la configuracion de hacienda', '', 'error');
        });
    });
}

/**
 * Mostrar u ocultar la configuracion de la empresa
 */
function ver_configuracion() {
    var html = '';
    if (ver) {
        cerrar_configuracion();
    } else {
        abrir_configuracion();
    }
}

function guardar_llave_criptografica() {
    var formData = new FormData($('#frm_llave_criptografica')[0]);

    // .biller_certificate del frm_llave_criptografica
    var certificate = $('#frm_llave_criptografica').find('.biller_certificate');

    //Si el campo esta vacio, mostrar un mensaje de error
    if ($(certificate).val() == '') {
        notificacion('Debe seleccionar un archivo', '', 'error');
        return false;
    }


    Pace.track(function () {
        $.ajax({
            "url": base + "configuracion/update/llave_criptografica",
            "method": "post",
            "data": formData,
            "contentType": false,
            "processData": false,
            "dataType": "json"
        }).done(function (response) {
            notificacion('Se ha actualizado la llave criptografica', '', 'success');
        }).fail(function (jqXHR, textStatus, errorThrown) {
            notificacion('Error al actualizar la llave criptografica', '', 'error');
        });
    });
}

/**
 * Expandir el card de configuracion
 */
function abrir_configuracion() {
    var html = '<i class="fa-solid fa-eye-slash"></i> Ocultar';

    $('#' + frmEmpresa).find('.card-frm').CardWidget('expand');

    $('#' + frmEmpresa).find('.btn-ver').html(html);

    ver = true;
}


/**
 * Contraer el card de configuracion
 */
function cerrar_configuracion() {
    var html = '<i class="fa-solid fa-eye"></i> Ver';

    $('#' + frmEmpresa).find('.btn-ver').html(html);

    $('#' + frmEmpresa).find('.card-frm').CardWidget('collapse');

    ver = false;
}


function limpiar_variables() {
    username = '';
    password = '';
    notifySentDocuments = '';
    notifyReceivedDocuments = '';
    notifyProcessingDocuments = '';
    callbackUrl = '';

    // Agregar el atributo hidden a los botones de guardar y cancelar
    $('#' + frmEmpresa).find('.btn-grd').attr('hidden', true);

    // Mostrar el boton de editar
    $('#' + frmEmpresa).find('.btn-edt').removeAttr('hidden');

    campos_activos(true, frmEmpresa);

    //Esconder los card
    cerrar_configuracion();
}