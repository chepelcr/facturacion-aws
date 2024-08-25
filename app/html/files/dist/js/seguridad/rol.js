var id_rol = "";

//Habilitar un usuario
function habilitar(id_rol) {
    $.ajax({
        "url": base + "seguridad/activar/" + id_rol + "/roles",
        "method": "post",
        "dataType": "json",
    }).done(function (response) {
        if (!response.error) {
            mensajeAutomaticoRecargar("Alerta", 'Rol habilitado correctamente', "success");
        } //Fin del if
        else {
            mensajeAutomatico('Atencion', 'Ha ocurrido un error: ' + response.error, 'error');
        } //Fin del else
    });
}//Fin de habilitar un usuario

//Deshabilitar un usuario
function deshabilitar(id_rol) {
    $.ajax({
        "url": base + "seguridad/desactivar/" + id_rol + "/roles",
        "method": "post",
        "dataType": "json",
    }).done(function (response) {
        if (!response.error) {
            mensajeAutomaticoRecargar("Alerta", 'Rol deshabilitado correctamente', "success");
        } //Fin del if
        else {
            mensajeAutomatico('Atencion', 'Ha ocurrido un error: ' + response.error, 'error');
        } //Fin del else
    });
}//Fin de deshabilitar un usuario

$(document).ready(function() {

    //Agregar un nuevo rol
    $("#frm").on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            "url": base + "seguridad/guardar/roles",
            "method": "post",
            "data": $('#frm').serialize(),
            "dataType": "json",
        }).done(function(response) {
            if (!response.error) {
                mensajeAutomaticoRecargar("Alerta", response.success, "success");
            } //Fin del if
            else {
                mensajeAutomatico('Atencion',response.error, 'error');
            } //Fin del else
        });
    });

    //Modificar un rol
    $(document).on('click', '.btt-mod', function(e) {
        e.preventDefault();
        
        $.ajax({
            "url": base + "seguridad/update/" + id_rol + "/roles",
            "method": "post",
            "data": $('#frm').serialize(),
            "dataType": "json",
        }).done(function(response) {
            
            if (!response.error) {
                mensajeAutomatico('Atencion', 'Rol actualizado correctamente', 'success').then(function(){
                    location.reload();
                });
            } //Fin del if
            else {
                mensajeAutomatico('Atencion', 'Ha ocurrido un error: ' + response.error, 'error');
            } //Fin del else
        });
    });//Fin de modificar un rol

    //Cuando se le da click al boton de agregar
    $(document).on('click', '#btnAgregar', function () {
        $(".titulo-form").html('Agregar rol');
    });

    //Cuando se le da click al boton de modificar
    $(document).on('click', '#modificar', function() {
        id_rol = this.value;

        $.ajax({
            "url": base + "seguridad/obtener/" + id_rol + "/roles",
            "dataType": "json",
        }).done(function(response) {
            llenarFrm(response, 'Modificar Rol');
        });
    });

    //Cuando se le da click al boton de ver
    $(document).on('click', '#ver', function() {
        id_rol = this.value;

        $.ajax({
            "url": base + "seguridad/obtener/" + id_rol + "/roles",
            "dataType": "json",
        }).done(function(response) {
            verFrm(response, 'Informacion de Rol'); 
        });
    });

    //Cuando se le da click al boton de activar
    $(document).on('click', '#activar', function() {
        id_rol = this.value;
        habilitar(id_rol);
    });
    
    //Cuando se le da click al boton de desactivar
    $(document).on('click', '#desactivar', function() {
        id_rol = this.value;
        deshabilitar(id_rol);
    });
});