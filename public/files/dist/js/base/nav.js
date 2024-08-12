/**Validar si un menu esta abierto o no */
var menu_abierto = false;

//Estado de la aplicacion
var estado_app = 'loading';

//Cuando el documento esta listo
$(document).ready(function () {
    /**Cargar el preloader y luego el inicio */
    loading();

    //Cuando el mouse entra a .nav-menu
    $('.nav-menu').mouseenter(function () {
        //Cerrar todos los dropdown
        $('.drp-nav').not($(this).parent().children('.drp-nav')).hide();

        //Mostrar el dropdown
        $(this).parent().children('.drp-nav').show();

        //Menu abierto
        menu_abierto = true;
    });

    //Cuando el mouse entra a nav-modulo
    $('.nav-modulo').mouseenter(function () {
        //Cerrar todos los dropdown
        $('.drp-nav').hide();

        //Menu abierto
        menu_abierto = false;
    });

    //Cuando el mouse entre a .contenedor
    $('.contenedor').mouseenter(function () {
        //Cerrar todos los dropdown
        $('.drp-nav').hide();

        //Menu abierto
        menu_abierto = false;
    });

    //Cuando el mouse sale de .drp-nav
    $('.drp-nav').mouseleave(function () {
        //Cerrar el dropdown
        $(this).hide();

        //Menu abierto
        menu_abierto = false;
    });

    /**Validar donde esta el mouse en el documento */
    $(document).mousemove(function (e) {
        mouse_documento = false;

        //Si el mouse esta en el documento
        if (e.clientX > 0 && e.clientX < $(document).width() && e.clientY > 0 && e.clientY < $(document).height()) {
            //Si el mouse esta en el documento
            if (mouse_documento == false) {
                //Si el mouse esta en el documento
                mouse_documento = true;
                //Si el mouse esta en el documento
                mouse_documento_time = setTimeout(function () {
                    //Si el mouse esta en el documento
                    mouse_documento = false;
                }, 1000);
            } //Fin del if

            //Si el mouse e.clientY es menor a 50
            mostrar_nav(e.clientY);

            //Ver el punto donde esta el mouse
            //console.log(e.clientX + ',' + e.clientY);
        } //Fin del if
    }); //Fin del mousemove
});

function mostrar_nav(distancia)
{
    if (distancia < 70) {
        $("#navbar_collapse").collapse('show');
    } else {
        if(!menu_abierto)
            $("#navbar_collapse").collapse('hide');
    }
}

/**Preloader */
function loading() {
    var num = 0;
    $('.content-wrapper').hide();
    $('.main-header').hide();
    $('.main-footer').hide();

    for (i = 0; i <= 100; i++) {
        setTimeout(function () {
            if (num == 100) {
                $('.loader').hide();
                
                $('.main-header').show();
                $('.main-footer').show();
                $('.content-wrapper').show();

                obtener_tipo_cambio();

                cargar_inicio();

                estado_app = 'ready';
            }
            num++;
        }, i * 40);
    };
}

/**Cargar el modulo de inicio de la aplicacion */
function cargar_inicio() {
    poner_titulo('inicio');
    desactivar_tooltips();

    //Cargar el modulo de inicio
    cargar_modulo('inicio');

    //Activar el boton de inicio
    activar_modulo_boton('inicio');

    elemento_activo = '';
    form_activo = '';

    activar_tooltips();
}

/**Cargar el modulo de inicio de un modulo */
function cargar_inicio_modulo(nombre_modulo) {
    poner_titulo(nombre_modulo);
    desactivar_tooltips();

    if (nombre_modulo == 'documentos') {
        cargar_modulo('contenedor_' + nombre_modulo);
        cargar_documentos();

        elemento_activo = 'contenedor_' + nombre_modulo;
    }

    else {
        activar_modulo_boton(nombre_modulo);

        //Cerrar todos los modal
        $('.modal').modal('hide');

        //Abrir el modal-nombre_modulo
        $('#modal-' + nombre_modulo).modal('show');

        elemento_activo = 'modal-' + nombre_modulo;
    }

    activar_tooltips();
}

/**Activar el boton para un modulo y su submodulo */
function activar_modulo_boton(nombre_modulo, nombre_submodulo = '') {
    $('.nav-button').each(function (i, e) {
        //Desactivar todos los botones
        $(e).removeClass('btn-info');
        $(e).addClass('btn-dark');
    });

    //Desactivar todos los .nav-menu
    $('.nav-menu').each(function (i, e) {
        $(e).removeClass('btn-success');
        $(e).addClass('btn-danger');
    });

    //Desactivar otros botones
    $('.nav-modulo').addClass('btn-secondary').removeClass('btn-warning');

    //Activar el boton del modulo
    $('.nav-' + nombre_modulo).addClass('btn-warning').removeClass('btn-secondary');

    if (nombre_modulo == 'documentos') {
        $('.btn-documentos').addClass('btn-info').removeClass('btn-dark');
    }

    //Si el nombre del submodulo no esta vacio
    if (nombre_submodulo != '') {
        //Activar el boton del submodulo
        $('.btn_' + nombre_modulo + '_' + nombre_submodulo).addClass('btn-info').removeClass('btn-dark');

        //Desactivar otros botones
        $('.nav-item').each(function (i, e) {
            if (!$(e).hasClass('nav-' + nombre_modulo)) {
                $(e).find('.nav-submodulo').addClass('btn-dark').removeClass('btn-info');
            }
        });

        //Desactivar todos los .nav-menu
        $('.nav-menu').each(function (i, e) {
            $(e).removeClass('btn-success');
            $(e).addClass('btn-danger');
        });

        //Activar el .nav-menu
        $('.nav-menu-' + nombre_modulo).addClass('btn-success').removeClass('btn-danger');
    }
}

