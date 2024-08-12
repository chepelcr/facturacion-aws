$(document).on('click', '#btnAgregar', function() {
    $(".modal-title").html('Agregar lote de produccion');
});


//Agregar un nuevo usuario
$("#frm").on('submit', function(e) {
    e.preventDefault();

    /*$.ajax({
        "url": base + "usuario/guardar",
        "method": "post",
        "data": $('#frmUsuario').serialize(),
        "dataType": "json",
    }).done(function(response) {
        
        if (response != 0) {
            swal({
                title: "Atencion",
                text: "Usuario agregado correctamente",
                icon: "success",
                timer: 3000,
                buttons: false
            }).then(function(){
                location.reload();    
            });//Fin del mensaje
            
        } //Fin del if
        else {
            mensajeAutomatico('Atencion','Ha ocurrido un error', 'error');
        } //Fin del else
    });*/

    mensaje("Atencion", "Se ha agregado el lote de produccion", "success");
});