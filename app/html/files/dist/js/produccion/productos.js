function deshabilitar(id_producto) {
    Swal.fire({
        title: 'Desea desactivar Almohada y funda bebé colores surtidos?',
        showDenyButton: true,
        confirmButtonText: 'Aceptar',
        denyButtonText: 'Cancelar',
        customClass: {
            actions: 'my-actions',
            confirmButton: 'order-1 right-gap',
            denyButton: 'order-2'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Producto desactivado!',
                showConfirmButton: false,
            });
        }
    });
}//Fin de la funcion para desactivar un producto

function habilitar(id_producto) {
    Swal.fire({
        title: 'Se activará Almohada y funda bebé colores surtidos, desea continuar?',
        showDenyButton: true,
        confirmButtonText: 'Aceptar',
        denyButtonText: 'Cancelar',
        customClass: {
            actions: 'my-actions',
            confirmButton: 'order-1 right-gap',
            denyButton: 'order-2'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Producto activado!',
                showConfirmButton: false,
            });
        }
    });
}//Fin de la funcion para desactivar un producto

//Cuando se le da click al boton de desactivar
$(document).on('click', '#btn_desactivar', function () {
    var id_producto = this.value;

    deshabilitar(id_producto);

    /*$.ajax({
        "url": base + "produccion/desactivar/" + id_usuario,
        "dataType": "json",
    }).done(function(response) {
        //Inserte codigo
    });*/

    $('#btn_activar').show();
    $('#btn_desactivar').hide();
});

//Cuando se le da click al boton de desactivar
$(document).on('click', '#btn_activar', function () {
    var id_producto = this.value;

    habilitar(id_producto);

    /*$.ajax({
        "url": base + "produccion/desactivar/" + id_usuario,
        "dataType": "json",
    }).done(function(response) {
        //Inserte codigo
    });*/

    $('#btn_desactivar').show();
    $('#btn_activar').hide();
});