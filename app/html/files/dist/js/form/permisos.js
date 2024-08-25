/**Marcar un permiso */
function marcar_permiso(modulo, submodulo, accion) {
    var nombre_permiso = 'permiso_' + modulo + '_' + submodulo + '_' + accion;

    var elemento = form_activo;
    
    var check = null;

    if (elemento == '') {
        var check = $('#' + nombre_permiso);
    }//Fin del if !elemento

    else {
        var check = $('#' + elemento).find('#' + nombre_permiso);
    }//Fin del else

    if (check.prop('checked')) {
        activar_permiso(nombre_permiso, false, elemento, accion);
    }//Fin del if check.prop('checked')

    else {
        activar_permiso(nombre_permiso, true, elemento, accion);
    }//Fin del else
}//Fin de permiso

/**Llenar los permisos de un rol */
function llenar_permisos(modulos, elemento = '') {
    //Modulo {0: id_modulo: 1, nombre_modulo: 'sucursal', submodulos:{0: id_submodulo: 1, nombre_submodulo: 'sucursal', acciones:{0: id_accion: 1, nombre_accion: 'crear', icono: 'fa-plus'}}}
    desactivar_permisos(elemento);
    //Recorrrer los modulos
    $.each(modulos, function (index, modulo) {
        nombre_modulo = modulo.nombre_modulo;
        submodulos = modulo.submodulos;

        //Recorrer los submodulos
        $.each(submodulos, function (index, submodulo) {
            nombre_submodulo = submodulo.nombre_submodulo;
            acciones = submodulo.acciones;

            //Recorrer las acciones
            $.each(acciones, function (index, accion) {
                nombre_accion = accion.nombre_accion;
                estado = accion.estado;

                var nombre_permiso = 'permiso_' + nombre_modulo + '_' + nombre_submodulo + '_' + nombre_accion;

                if (estado == 1) {
                    activar_permiso(nombre_permiso, true, elemento, nombre_accion);
                }//Fin del if estado

                else {
                    activar_permiso(nombre_permiso, false, elemento, nombre_accion);
                }//Fin del else estado
            });
        });
    });
}//Fin de llenar los permisos de un rol

/**Activar un permiso */
function activar_permiso(nombre_permiso, estado = true, elemento = '', accion = '') {
    var check = null;
    var boton = null;

    if (elemento == '') {

        //Obtener el checkbox
        check = $('#' + nombre_permiso);

        //Obtener el boton
        boton = $('.btn_' + nombre_permiso);
    }//Fin del if !elemento

    else {
        //Obtener el checkbox
        check = $('#' + elemento).find('#' + nombre_permiso);

        //Obtener el boton
        boton = $('#' + elemento).find('.btn_' + nombre_permiso);
    }//Fin del else

    //Marcar o desmarcar el checkbox
    check.prop('checked', estado);

    //Si el estado es true
    if (estado) {
        //Poner valor true al checkbox
        check.val(estado);
    }//Fin del if estado

    //Si el estado es false
    else {
        //Poner valor false al checkbox
        check.val('');
    }//Fin del else estado

    if (estado) {
        //Activar el boton
        boton.removeClass('btn-secondary');

        switch (accion) {
            case 'insertar':
                boton.addClass('btn-danger');
                break;

            case 'modificar':
                boton.addClass('btn-warning');
                break;

            case 'consultar':
                boton.addClass('btn-info');
                break;

            default:
                boton.addClass('btn-success');
                break;
        }//Fin del switch
    }//Fin del if estado

    else {
        //Desactivar el boton
        boton.addClass('btn-secondary');

        //Eliminar otras clases
        boton.removeClass('btn-danger').removeClass('btn-warning').removeClass('btn-info').removeClass('btn-primary');
    }//Fin del else
}