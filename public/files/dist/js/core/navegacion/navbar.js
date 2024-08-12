/**Validar si un menu esta abierto o no */
var menu_abierto = false;

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

