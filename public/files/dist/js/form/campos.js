/**Activar o desactivar campos codigo_venta  y cabys */
function campos_productos(estado = false, elemento = '') {
    activar_campo_id('codigo_venta', estado, elemento);

    campos_cabys(estado);
}//Fin de campos_productos

function crear_option(valor, texto) {
    var html = '<option value="' + valor + '">' + texto + '</option>';
    return html;
}

/**Activar o desactivar campos de valor */
function campos_valor(estado = false , elemento = '') {
    activar_campo_clase('valor', estado, elemento);
}//Fin de campos_valor

/**Activar o desactivar un campo por clase */
function activar_campo_clase(clase = '', estado = false, nombre_elemento = '')
{
    if (clase != '') {
        if(nombre_elemento != '')
        {
            $('#' + nombre_elemento).find("." + clase).attr("readonly", estado);
            $('#' + nombre_elemento).find("." + clase).attr("disabled", estado);
        }

        else
        {
            $("." + clase).attr("readonly", estado);
            $("." + clase).attr("disabled", estado);
        }
    }
}//Fin de la funcion

/**Activar un campo por id */
function activar_campo_id(nombre_campo = '', estado = false, nombre_elemento = '')
{
    if (nombre_campo != '') {
        if(nombre_elemento != '')
        {
            $('#' + nombre_elemento).find("#" + nombre_campo).attr("readonly", estado);
            $('#' + nombre_elemento).find("#" + nombre_campo).attr("disabled", estado);
        }

        else
        {
            $("#" + nombre_campo).attr("readonly", estado);
            $("#" + nombre_campo).attr("disabled", estado);
        }
    }
}//Fin de la funcion

/**Activar o desactivar los campos de un formulario */
function campos_activos(estado = true, elemento = '')
{
    activar_campo_clase('inp', estado, elemento);
}

/**Vaciar los campos de un formulario */
function vaciar_campos(elemento = '')
{
    vaciar_campo_clase('inp', elemento);
}//Fin de la funcion

/**Vaciar un campo por id */
function vaciar_campo_id(nombre_campo = '', nombre_elemento = '')
{
    if (nombre_campo != '') {
        if(nombre_elemento != '')
        {
            $('#' + nombre_elemento).find("#" + nombre_campo).val("");
        }

        else
        {
            $("#" + nombre_campo).val("");
        }
    }
}//Fin de la funcion

/**Vaciar un campo por clase */
function vaciar_campo_clase(clase = '', nombre_elemento = '')
{
    if (clase != '') {
        if(nombre_elemento != '')
        {
            $('#' + nombre_elemento).find("." + clase).val("");
        }

        else
        {
            $("." + clase).val("");
        }
    }
}//Fin de la funcion

/**Activar o desactivar los campos de cedula 
 * y razon social
 * 
 * @param {boolean} estado 
 * @param {string} nombre_elemento 
*/
function activar_campos_cedula(estado, nombre_elemento = '')
{
    activar_campo_clase('identificacion', estado, nombre_elemento);
    activar_campo_clase('nombre', estado, nombre_elemento);
    activar_campo_clase('id_tipo_identificacion', estado, nombre_elemento);
    activar_campo_clase('cod_pais', estado, nombre_elemento);
}//Fin de la funcion

/**Activar o desactivar campos del codigo cabys */
function campos_cabys(estado, elemento = '') {
    activar_campo_clase('codigo_cabys', estado, elemento);
    activar_campo_clase('impuesto', estado, elemento);
}

/**Activar o desactivar campos de un contribuyente */
function activar_campos_contribuyente(estado = false, elemento = '') {
    activar_campo_clase('id_tipo_identificacion', estado, elemento);
    activar_campo_clase('cod_pais', estado, elemento);
    activar_campo_clase('nombre', estado, elemento);

    if(estado)
    {
        //Desactivar el campo de .btn-eliminar
        $('#' + elemento).find(".btn-eliminar").attr("disabled", true);
    }
}//Fin de la funcion

/**Desactivar todos los botones de permisos */
function desactivar_permisos(elemento = '') {
    if (elemento != '') {
        //Eliminar la clase btn-info, btn-warning, btn-danger de los btn-permiso
        $('#' + elemento).find('.btn-permiso').removeClass('btn-info').removeClass('btn-warning').removeClass('btn-danger').removeClass('btn-primary');

        //Agregar la clase btn-secondary a los btn-permiso
        $('#' + elemento).find('.btn-permiso').addClass('btn-secondary');

        $('#' + elemento).find('.inp-chk').prop('checked', false);
        $('#' + elemento).find('.inp-chk').val('');
    }

    else {
        //Eliminar la clase btn-info, btn-warning, btn-danger de los btn-permiso
        $('.btn-permiso').removeClass('btn-info').removeClass('btn-warning').removeClass('btn-danger').removeClass('btn-primary');

        //Agregar la clase btn-secondary a los btn-permiso
        $('.btn-permiso').addClass('btn-secondary');

        $('.inp-chk').prop('checked', false);
        $('.inp-chk').val('');
    }
}//Fin de la funcion