/**Direccion web de la pagina */
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

/**Modulo activo de la aplicacion */
var modulo_activo = '';

/**Submodulo activo de la aplicacion */
var submodulo_activo = '';

/**Elemento grafico activo en la aplicacion */
var elemento_activo = '';

/** 
 * Abrir el modal login 
 * @param {string} modi - Modo en el que se abrira el modal login
 * 
*/
function abrir_login(modo = "login") {
    /**Mostrar el #modal_login */
    $('#modal_login').modal('show');

    switch (modo) {
        case "login":
            elemento_activo = 'modal_login';

            modulo_activo = 'login_perfil';
            submodulo_activo = 'login';

            //Ocultar el card-contrasenia del elemento_activo
            $('#' + elemento_activo).find('.card-contrasenia').hide();

            //Mostrar el card-login del elemento_activo
            $('#' + elemento_activo).find('.card-login').show();
            break;

        case "olvido":
            if (elemento_activo != 'login_perfil') {
                //Ocultar el card-login
                $('.card-login').hide();

                //Mostrar el card-olvido
                $('.card-olvido').show();
            }//Fin de la validacion

            else {
                //Ocultar el card-login del elemento_activo
                $('#' + elemento_activo).find('.card-login').hide();

                //Mostrar el card-olvido del elemento_activo
                $('#' + elemento_activo).find('.card-olvido').show();
            }

            submodulo_activo = 'olvido';
            break;

        default:
            elemento_activo = 'modal_login';

            modulo_activo = 'login_perfil';
            submodulo_activo = 'contrasenia';

            //Mostrar el card del cambio de contrasenia del elemento_activo
            $('#' + elemento_activo).find('.card-contrasenia').show();

            //Ocultar el card-login del elemento_activo
            $('#' + elemento_activo).find('.card-login').hide();
            break;
    }
}//Fin de la funcion

/**
 * Volver al login
 */
function volver_login() {
    if (modulo_activo == 'login_perfil') {
        //Ocultar el card-olvido del elemento_activo
        $('#' + elemento_activo).find('.card-olvido').hide();

        //Mostrar el card-login del elemento_activo
        $('#' + elemento_activo).find('.card-login').show();
    }//Fin de la validacion

    else {
        //Ocultar el card-olvido
        $('.card-olvido').hide();

        //Mostrar el card-login
        $('.card-login').show();
    }
}


/**Cerrar la sesion del usuario */
function salir() {
    Toast.fire({
        icon: 'info',
        title: 'Cerrando sesión',
        timer: 2000
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
    });
}//Fin de la funcion salir

//Cuando el documento este listo
$(document).ready(function () {
    //Iniciar sesion en la aplicacion
    $("#frmLogin").on("submit", function (e) {
        e.preventDefault();

        $.ajax({
            "url": base + "login/consultar",
            "method": "post",
            "data": $("#frmLogin").serialize(),
            "dataType": "json"
        }).done(function (response) {
            switch (response.estado) {

                //Si el estado es 1
                case "1":
                    if (modulo_activo == "login_perfil") {
                        abrir_perfil();
                    }//Fin de la validacion
                    else {
                        location.href = base + 'inicio';
                    }
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
                        if (modulo_activo == "login_perfil") {
                            mostrar_login('contrasenia');
                        }//Fin de la validacion
                        else {
                            location.href = base + 'inicio';
                        }
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
            }//Fin switch
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
                volver_login();

                mensajeAutomatico('Atencion', 'Se ha enviado la contraseña a su correo electronico', 'info');
            } //Fin del if
            else {
                mensajeAutomatico('Atencion', 'El correo electronico no se encuentra registrado', 'error');
            } //Fin del else
        }); //Fin del ajax
    }); //Fin del submit

    //Cuando el usuario da click en el boton de olvido
    $(".btnOlvido").on('click', function (e) {
        abrir_login('olvido');
    }); //Fin del click

    //Ocultar el card de olvido
    $(".card-olvido").hide();
}); //Fin del documento