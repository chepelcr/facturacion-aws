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

function ajustarPerfil()
{
    $('.inp-perfil').attr("readonly", false);
    $('.inp-perfil').attr("disabled", false);

    /**Remover la clase col-md-4 */
    $('.inp-perfil').removeClass('col-md-4');
    $('.inp-perfil').removeClass('col-md-1');
    $('.inp-perfil').removeClass('col-md-2');
    $('.inp-perfil').removeClass('col-md-3');
    $('.inp-perfil').removeClass('col-md-5');
    $('.inp-perfil').removeClass('col-md-6');
    $('.inp-perfil').removeClass('col-md-7');
    $('.inp-perfil').removeClass('col-md-8');
    $('.inp-perfil').removeClass('col-md-9');
    $('.inp-perfil').removeClass('col-md-10');
    $('.inp-perfil').removeClass('col-md-11');

    /**Agregar la clase col-md-12 */
    $('.inp-perfil').addClass('col-md-12');
}

$(document).ready(function() {
    //Evento para cambiar el estado del boton guardar
    $(document).on('click', '#btn_editar', function() {
        $('.btn_guardar').show();
        $('.btn_cancelar').show();

        $('#btn_editar').hide();
        $('#btn_contrasenia').hide();
        $('.btn_foto').hide();

        $(".perfil").attr("readonly", false);
        $(".perfil").attr("disabled", false);

        activar_campos_cedula(false);
    });

    //Cuando se le da click al boton cancelar
    $(document).on('click', '.btn_cancelar', function() {
        location.reload();
    });

    //Mostrar el modal para agregar o modificar un usuario
    $(document).on('click', '#btn_contrasenia', function() {
        $(".modal-title").html('Cambiar contraseña');

        $(".pass").attr("readonly", false);
        $(".pass").attr("disabled", false);

        $(".pass").val("");
        
        $('.btt-mod').hide();
        $('.btt-edt').hide();
        
        $('.btt-grd').show();
    });
    
    //Actualizar el perfil del usuario
    $("#frm_usuario").on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            "url": base + "seguridad/update/perfil",
            "method": "post",
            "data": $('#frm_usuario').serialize(),
            "dataType": "json",
        }).done(function(response) {
            
            if (!response.error) {
                $(".perfil").attr("readonly", true);
                $(".perfil").attr("disabled", true);
                $('.btn_guardar').hide();
                $('.btn_cancelar').hide();

                $('#btn_editar').show();
                $('#btn_contrasenia').show();
                $('.btn_foto').show();

                //Mostrar mensaje de exito
                mensajeAutomaticoRecargar('Atencion', 'Perfil actualizado correctamente', 'success');
            } //Fin del if
            else {
                mensajeAutomatico('Atencion',response.error, 'error');
            } //Fin del else
        });
    });//Fin del evento submit


    //Realizar cambio de contraseña
    $("#frm").on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            "url": base + "seguridad/update/contrasenia",
            "method": "post",
            "data": $('#frm').serialize(),
            "dataType": "json",
        }).done(function(response) {
            
            if (!response.error) {
                //Enviar mesaje de exito
                mensajeAutomaticoRecargar('Atencion', 'Contraseña actualizada correctamente', 'success');
                
            } //Fin del if
            else {
                mensajeAutomatico('Atencion', response.error, 'error');
            } //Fin del else
        });
    });
});