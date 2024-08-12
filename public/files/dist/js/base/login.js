var base = "http://localhost/";
//var base = "https://stag.modaslaura.works/";
//var base = "https://facturacion.modaslaura.works/";

base = window.location.host
protocol = window.location.protocol

if (protocol == 'http:') {
    base = 'http://' + base + '/';
} else {
    base = 'https://' + base + '/';
}

var cambio_compra = 0;
var cambio_venta = 0;

//Cuando el documento este listo
$(document).ready(function () {
    $("#frmLogin").on("submit", function (e) {
        e.preventDefault();

        $.ajax({
            "url": base + "login/consultar",
            "method": "post",
            "data": $("#frmLogin").serialize(),
            "dataType": "json"
        }).done(function (response) {
            switch (response.estado) {
                case "1":
                    location.reload();
                    break;

                //Si la contrasenia ya expiro
                case "2":
                    //Envia mensaje de error al usuario
                    Swal.fire({
                        title: "Atencion",
                        text: response.error,
                        icon: "info",
                        timer: 2000,
                        showConfirmButton: false
                    }).then((result) => {
                        //Redirecciona a la pagina de cambio de contraseña
                        location.reload();
                    });
                    break;

                default:
                    Swal.fire({
                        title: "Atencion",
                        text: response.error,
                        icon: "warning",
                        timer: 2000,
                        showConfirmButton: false
                    });
                    break;
            } //Fin switch
        }); //Fin del ajax
    }); //Fin del submit

    //Cuando de envia el formulario de cambio de contraseña
    $("#frm_contrasenia").on("submit", function (e) {
        e.preventDefault();

        $.ajax({
            "url": base + "seguridad/update/contrasenia",
            "method": "post",
            "data": $("#frm_contrasenia").serialize(),
            "dataType": "json"
        }).done(function (response) {
            if (!response.error) {
                //Envia mesaje de exito
                mensajeAutomaticoRecargar('Atencion', response.success, 'success');
            } //Fin del if
            else {
                mensajeAutomatico('Atencion', response.error, 'error');
            } //Fin del else
        });
    }); //Fin del submit

    $("#frmRecuperar").on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            "url": base + "login/recuperar",
            "method": "post",
            "data": $('#frmRecuperar').serialize(),
            "dataType": "json"
        }).done(function (response) {
            if (response != 0) {
                mensajeAutomaticoRecargar('Atencion', 'Se ha enviado la contraseña a su correo electronico', 'info');
            } //Fin del if
            else {
                mensajeAutomatico('Atencion', 'El correo electronico no se encuentra registrado', 'error');
            } //Fin del else
        }); //Fin del ajax
    }); //Fin del submit
}); //Fin del documento

/**Abrir el modal del perfil de usuario */
function abrir_perfil() {
    //Collapse todos los card
    $('#perfil').find('.card').CardWidget('collapse');

    campos_activos(true, 'perfil');

    $('.btn-grd-prf').hide();
    $('.btn-cnl-prf').hide();

    //Expand todos los card
    $('#perfil').find('.card').CardWidget('expand');

    $('#perfil').modal('show');

    //Ocultar el modal de login
    $('#modal_login').modal('hide');
}

function cambio_contrasenia() {
    /**Mostrar el #modal_login */
    $('#modal_login').modal('show');

    //Ocultar el perfil
    $('#perfil').modal('hide');
}

/**Cerrar la sesion del usuario */
function salir() {
    Swal.fire({
        title: 'Espere',
        text: 'Cerrando sesión',
        icon: 'info',
        timer: 1500,
        showConfirmButton: false,
    }).then((result) => {
        $.ajax({
            url: base + 'login/salir',
            type: 'POST',
            dataType: 'JSON',
            success: function (respuesta) {
                if (respuesta.estado == 1) {
                    location.href = base + 'login';
                }
            }
        });
    })//Fin del mensaje
}//Fin de la funcion salir
