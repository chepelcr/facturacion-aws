/**Activar o desactivar los campos de cedula 
 * y razon social
 * 
 * @param {boolean} estado
*/
function activar_campos_cedula(estado)
{
    if(estado)
    {
        $(".identificacion").attr("disabled", false);
        $(".nombre").attr("disabled", false);
        $(".id_tipo_identificacion").attr("disabled", false);
        $(".cod_pais").attr("disabled", false);
    }
    else
    {
        $(".identificacion").attr("disabled", true);
        $(".nombre").attr("disabled", true);
        $(".id_tipo_identificacion").attr("disabled", true);
        $(".cod_pais").attr("disabled", true);
    }
}

/**Activar o desactivar los campos de un formulario 
 * 
 * @param {boolean} estado
*/
function campos_activos(estado)
{
    if(estado)
    {
        $('.inp').attr("readonly", false);
        $('.inp').attr("disabled", false);
    }

    else
    {
        $('.inp').attr("readonly", true);
        $('.inp').attr("disabled", true);
    }
}

/**Cuando el documento esta listo */
$(document).ready(function() {
    campos_activos(false);

    $('.guardar').hide();

    //Evento para cambiar el estado del boton guardar
    $(document).on('click', '#btn_editar', function() {
        $('.guardar').show();

        $('.botones').hide();

        $(".perfil").attr("readonly", false);
        $(".perfil").attr("disabled", false);

        activar_campos_cedula(false);
    });

    //Cuando se le da click al boton cancelar
    $(document).on('click', '.btn_cancelar', function() {
        location.reload();
    });
});