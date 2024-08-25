var modulo_activo = '';
var submodulo_activo = '';

var elemento_activo = '';

/**Activar tooltips */
function activar_tooltips() {
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
}

/**Desactivar tooltips */
function desactivar_tooltips() {
    $(function () {
        $('[data-toggle="tooltip"]').tooltip('dispose')
    });
}

function ocultar_contenedores() {
    //Ocultar el contenedor de inicio
    $('#inicio').hide();

    //Ocultar contenedores
    //$('.contenedor').hide();

    //Ocultar el contenedor
    $('#contenedor').hide();

    //Ocultar el contenedor de documentos
    $('#contenedor_documentos').hide();

    //Ocultar botones de agregar
    $('.agregar').hide();
}

function cargar_modulo(nombre_modulo) {
    ocultar_contenedores();

    activar_tooltips();

    elemento_activo = nombre_modulo;

    $('#' + nombre_modulo).show();
}

$(document).ready(function () {
    activar_tooltips();

    $(document).keydown(function (e) {
        //Si no hay ningun input enfocado
        if (!$('input:focus').length) {
            if (modulo_activo == 'documentos' && e.ctrlKey) {
                //Si el usuario presiona ctrlLeft+n en el modulo de documentos
                if (e.which == 78) {
                    e.preventDefault();
                    //Agregar una venta rapida
                    agregar_documento('tiquete');
                }

                //Si el usuario presiona ctrlLeft+f en el modulo de documentos
                if (e.which == 70) {
                    e.preventDefault();
                    //Agregar una factura
                    agregar_documento('factura');
                }

                //Si el usuario presiona un numero en el modulo de documentos
                if (e.which >= 48 && e.which <= 57) {
                    e.preventDefault();
                    //Ver una factura
                    ver_factura(e.which - 48);
                }

                //Si el usuario presiona ctrlLeft+d en el modulo de documentos
                if (e.which == 68) {
                    e.preventDefault();
                    cargar_documentos();
                }

                if (submodulo_activo == 'facturacion') {
                    //Si el usuario presiona ctrlLeft+c en el modulo de documentos
                    if (e.which == 67) {
                        e.preventDefault();
                        //Cerrar el modal de cierre de factura
                        $('#' + factura_activa).find('.modal-cierre').modal('hide');

                        //Esperar un segundo a que se cierre el modal
                        setTimeout(function () {
                            //Cancelar una venta
                            cancelar_documento();
                        });
                    }

                    //Si el usuario presiona ctrlLeft+s en el modulo de documentos
                    if (e.which == 83) {
                        e.preventDefault();
                        //Guardar una venta
                        finalizar_documento();
                    }

                    //Si el usuario preciona ctrlLeft+p
                    if (e.which == 80) {
                        e.preventDefault();
                        buscar_productos();
                    }
                }
            }

            if (modulo_activo != 'inicio' && e.ctrlKey && submodulo_activo != 'inicio') {
                //Si el usuario presiona ctrlLeft+n en un modulo distinto al de inicio y documentos
                if (e.which == 78 && form_activo == '') {
                    e.preventDefault();
                    agregar('Agregar ' + submodulo_activo)
                }

                //Si el usuario presiona ctrl+c
                if (e.which == 67 && form_activo != '') {
                    e.preventDefault();
                    cancelar_accion();
                }
            }

            if (modulo_activo != 'documentos' && e.ctrlKey) {
                if (form_activo != '') {
                    //Si el usuario presiona ctrlLeft+e
                    e.preventDefault();
                    if (e.which == 69) {
                        editar();
                    }
                }

                else
                {
                    //Si el usuario presiona ctrlLeft+e
                    if (e.which == 69) {
                        e.preventDefault();
                        cargar_inicio_modulo('empresa');
                    }

                    //Si el usuario presiona ctrlLeft+s
                    if (e.which == 83) {
                        e.preventDefault();
                        cargar_inicio_modulo('seguridad');
                    }

                    //Si el usuario presiona ctrlLeft+d
                    if (e.which == 68) {
                        e.preventDefault();
                        cargar_inicio_modulo('documentos');
                    }

                    //Si el usuario presiona ctrlLeft+i
                    if (e.which == 73) {
                        e.preventDefault();
                        cargar_inicio();
                    }
                }
            }
        }

        if (table != null && form_activo == '') {
            //Si el usuario presiona la tecla flecha abajo
            if (e.which == 40) {
                //Ir al siguiente elemento
                siguiente_elemento();
            }

            //Si el usuario presiona la tecla flecha arriba
            if (e.which == 38) {
                //Ir al anterior elemento
                elemento_anterior();
            }
        }

    });
});

/**Cambiar el titulo de la pagina y agregarla al historial */
function poner_titulo(modulo, submodulo = 'inicio') {
    modulo_activo = modulo;
    submodulo_activo = submodulo;

    //modulo con primera letra en mayuscula
    var modulo_mayuscula = modulo.charAt(0).toUpperCase() + modulo.slice(1);

    //Submodulo con primera letra en mayuscula
    var submodulo_mayuscula = submodulo.charAt(0).toUpperCase() + submodulo.slice(1);

    //Eliminar guiones bajos de los nombres de los modulos en mayuscula
    modulo_mayuscula = modulo_mayuscula.replace(/_/g, ' ');

    //Eliminar guiones bajos de los nombres de los submodulos en mayuscula
    submodulo_mayuscula = submodulo_mayuscula.replace(/_/g, ' ');

    $('.modulo-pagina').text(modulo_mayuscula);

    $('.submodulo-pagina').text(submodulo_mayuscula);

    if (submodulo_mayuscula != 'Inicio') {
        titulo = empresa + ' | ' + modulo_mayuscula + ' | ' + submodulo_mayuscula;

        //Agregar pagina al historial
        history.pushState(null, null, base + modulo + '/' + submodulo);
    }

    else {
        titulo = empresa + ' | ' + modulo_mayuscula;

        //Agregar pagina al historial
        history.pushState(null, null, base + modulo);
    }

    //Cambiar el titulo del navegador web
    $('title').text(titulo);
}//Fin de poner_titulo

/**Poner el titulo a un elemento */
function poner_titulo_elemento(padre, clase, titulo) {
    //Cambiar el titulo del elemento
    $('#' + padre).find('.' + clase).attr('title', titulo);

    //Activar tooltips
    activar_tooltips();
}