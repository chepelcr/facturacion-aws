

function crear_option(valor, texto, selected = false) {
    var html = '<option value="' + valor + '"';
    if(selected) {
        html += ' selected';
    }
    html += '>' + texto + '</option>';
    
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
        if(nombre_elemento != '') {
            $('#' + nombre_elemento).find("." + clase).attr("readonly", estado);
            $('#' + nombre_elemento).find("." + clase).attr("disabled", estado);
        } else {
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
        if(nombre_elemento != '') {
            // Vaciar todos los inputs que contengan la clase en el elemento, no contar los elementos que son botones
            $('#' + nombre_elemento).find("." + clase).each(function() {
                // Si el elemento no es un boton
                if(!$(this).hasClass('btn')) {
                    $(this).val("");
                }
            });

        } else {
            // Vaciar todos los inputs que contengan la clase, no contar los elementos que son botones
            $("." + clase).each(function() {
                // Si el elemento no es un boton
                if(!$(this).hasClass('btn')) {
                    $(this).val("");
                }
            });
        }
    }
}//Fin de la funcion

/**Activar o desactivar los campos de cedula 
 * y razon social
 * 
 * @param {boolean} estado 'agregar', 'editar', 'ver', 'agregar-todos'.
 * @param {string} nombre_elemento 
*/
function activar_campos_cedula(estado = 'agregar', nombre_elemento = '')
{
    if(estado == 'agregar') {
        activar_campo_clase('identification_number', false, nombre_elemento);

        activar_campo_clase('businessName', true, nombre_elemento);
        activar_campo_clase('identification_typeId', true, nombre_elemento);
        activar_campo_clase('nationality', true, nombre_elemento);

        activar_campo_clase('btn-eliminar', true, nombre_elemento);
    } else if(estado == 'editar' || estado == 'ver') {
        activar_campo_clase('identification_number', true, nombre_elemento);

        activar_campo_clase('businessName', true, nombre_elemento);
        activar_campo_clase('identification_typeId', true, nombre_elemento);
        activar_campo_clase('nationality', true, nombre_elemento);

        activar_campo_clase('btn-eliminar', true, nombre_elemento);
    } else if(estado == 'agregar-todos') {
        activar_campo_clase('identification_number', false, nombre_elemento);

        activar_campo_clase('businessName', false, nombre_elemento);
        activar_campo_clase('identification_typeId', false, nombre_elemento);
        activar_campo_clase('nationality', false, nombre_elemento);

        activar_campo_clase('btn-eliminar', false, nombre_elemento);
    } if(estado == 'almacenando') {
        activar_campo_clase('identification_number', true, nombre_elemento);

        activar_campo_clase('businessName', true, nombre_elemento);
        activar_campo_clase('identification_typeId', true, nombre_elemento);
        activar_campo_clase('nationality', true, nombre_elemento);

        activar_campo_clase('btn-eliminar', false, nombre_elemento);
    }
}//Fin de la funcion

/**Activar o desactivar campos del codigo cabys */
function campos_cabys(estado = 'ver', elemento = '') {

    if (estado == 'ver') {
        activar_campo_clase('cabys', true, elemento);
        //Inhabilitar el btn-cabys
        activar_campo_clase('btn-cabys', true, elemento);
    } else if (estado == 'agregar' || estado == 'editar') {
        activar_campo_clase('cabys', true, elemento);
        //Habilitar el btn-cabys
        activar_campo_clase('btn-cabys', false, elemento);
    } else if (estado == 'almacenando') {
        activar_campo_clase('cabys', false, elemento);
        //Inhabilitar el btn-cabys
        activar_campo_clase('btn-cabys', true, elemento);
    }
}

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