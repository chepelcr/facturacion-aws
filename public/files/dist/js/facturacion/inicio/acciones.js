var cantidad_documentos = 0;

/**Agregar un documento electronico al modulo */
function agregar_documento(nombre_documento = '') {
    cantidad_documentos++;

    numero_documento = cantidad_documentos;

    //Solicitud ajax del card de facturacion
    $.ajax({
        url: base + 'documentos/' + nombre_documento + '/' + (cantidad_documentos),
        type: 'GET',
        dataType: 'html',
    }).done(function (data) {
        //Agregar el card de facturacion al la pagina
        $('#contenedor_facturas').append(data);

        //Solicitar el boton de la factura por ajax
        $.ajax({
            url: base + 'documentos/get_boton/' + (cantidad_documentos),
            type: 'GET',
            dataType: 'html',
        }).done(function (data) {
            //Agregar el boton de la factura al la pagina
            $('#nav-facturacion').append(data);

            ver_factura(cantidad_documentos);
        });
    });
}//Fin de agregar una nueva factura al modulo

/**Cargar todos los documentos de la empresa */
function cargar_documentos(tipo_reporte = '') {
    var direcion_url = base + 'documentos/cargar_documentos/';

    console.log(tipo_reporte);

    //Validar el tipo de reporte
    switch (tipo_reporte) {
        case 'emitidos':
            direcion_url += 'emitidos';

            //Poner el titulo
            poner_titulo('documentos', 'emitidos');

            activar_modulo_boton('documentos', 'emitidos');
            break;

        case 'recibidos':
            direcion_url += 'recibidos';

            //Poner el titulo
            poner_titulo('documentos', 'recibidos');

            activar_modulo_boton('documentos', 'recibidos');
            break;

        case 'buscar':
            var fecha_actual = new Date();

            //Eliminar el min del campo #fecha_inicio
            $('#fecha_inicio').attr('min', '');
            $('#fecha_fin').attr('min', '');

            //Poner la fecha maxima del campo #fecha_inicio
            $('#fecha_inicio').attr('max', fecha_actual.toISOString().split('T')[0]);

            //Colocar el max del campo #fecha_fin en la fecha actual
            $('#fecha_fin').attr('max', fecha_actual.toISOString().split('T')[0]);
            return;

            break;

        default:
            direcion_url += 'emitidos';

            //Poner el titulo
            poner_titulo('documentos', 'emitidos');

            activar_modulo_boton('documentos', 'emitidos');
            /*if (submodulo_activo == '') {
                
            } else if (submodulo_activo == 'emitidos') {
                direcion_url += 'emitidos';
            } else if (submodulo_activo == 'recibidos') {
                direcion_url += 'recibidos';
            }*/

            if (tipo_reporte != '') {
                direcion_url += '/' + tipo_reporte;
            }

            break;
    }//Fin de validacion de reporte

    console.log(direcion_url);

    if (tipo_reporte != 'buscar') {
        console.log('Cargando documentos');

        Pace.track(function () {
            $.ajax({
                url: direcion_url,
                type: 'POST',
                dataType: 'html',
                data: $('#frm_filtro_documentos').serialize(),
                success: function (respuesta) {
                    desactivar_tooltips_documentos();

                    $('#listado_documentos').empty();

                    $('#listado_documentos').append(respuesta);

                    crear_data_table('documentos');

                    //Ocultar todas las facturas
                    $('.contenedor_facturas').hide();

                    //Habilitar los botones de facturas
                    $('.btn-factura').attr('disabled', false);

                    //Activar el boton de documentos
                    $('.btn-documentos').addClass('btn-warning').removeClass('btn-dark');

                    //Desactivar el boton de facturas
                    $('.btn-factura').addClass('btn-dark').removeClass('btn-purple');

                    //Deshabilitar el boton de documentos
                    $('.btn-documentos').attr('disabled', true);

                    //Collapse .card-opciones-documentos
                    $('.card-opciones-documentos').CardWidget('collapse');

                    //Collapse .card-finalizar
                    $('.card-finalizar').CardWidget('collapse');

                    //Mostrar .cont-reporte
                    $('.cont-reporte').show();

                    //Contraer el card-reporte
                    contraer_reporte();

                    //Activar tooltips
                    activar_tooltips_documentos();

                    //Mostrar el contenedor de documentos
                    $('#listado_documentos').show();
                },
                error: function () {
                    mensajeAutomatico('Error', 'Error al cargar los documentos', 'error');
                }
            });
        });
    }//Fin de validacion de tipo de reporte
}

/**Descargar un reporte */
function reporte(tipo_reporte) {
    mensajeAutomatico('Generando reporte', 'Espera un momento', 'info');

    //Recorrer todas las lineas de la tabla
    var table = $('#documentos').DataTable();

    let documentos = [];

    //Recorrer las filas que se han filtrado
    table.rows({
        search: 'applied'
    }).every(function () {
        //Si el  $(this.node()).find('.chk-dct') se encuentra checked
        if ($(this.node()).find('.chk-dct').is(':checked')) {
            //Obtener el valor del checkbox
            var id_documento = $(this.node()).find('.chk-dct').val();

            //Agregar el id_documento a los documentos
            documentos.push(id_documento);
        }
    });

    //Enviar una solicitud ajax
    Pace.track(function () {
        //Obtener el archivo zip
        $.ajax({
            url: base + 'documentos/reporte/' + tipo_reporte,
            type: 'POST',
            dataType: 'json',
            data: {
                'documentos': documentos
            },
            success: function (respuesta) {
                if (!respuesta.error) {
                    if (tipo_reporte == 'descarga') {
                        location.href = base + 'documentos/descargar_zip/' + respuesta.nombre_archivo;

                    } else {
                        mensajeAutomatico('Reporte generado', respuesta.success, 'success');
                    }
                } else {
                    mensajeAutomatico('Error', respuesta.error, 'error');
                }
            }
        });
    });
}

/**Abrir el modal para importar documentos electronicos*/
function importar_documentos() {
    if (modulo_activo != 'documentos') {
        cargar_inicio_modulo("documentos");
    }

    poner_titulo('documentos', 'importar');

    activar_modulo_boton('documentos', 'importar');

    //Mostrar el .modal-importar
    $('#modal-importar').modal('show');
}

/**Contraer o expandir el card de reporte */
function contraer_reporte(estado = false) {
    //Si no hay ningun .chk-dct seleccionado
    if ($('.chk-dct:checked').length == 0 || !estado) {
        //Si no hay ningun .chk-dct seleccionado
        if ($('.chk-dct:checked').length == 0) {
            //Contraer el card-opciones-reporte
            $('.card-opciones-reporte').CardWidget('collapse');

            //Expandir el card-opciones
            $('.card-opciones').CardWidget('expand');

            //Descheck #check_documentos
            $('#check_documentos').prop('checked', false);
        }
    }//Fin de la validacion

    //Si estado es true
    else {
        //Expandir el card-opciones-reporte
        $('.card-opciones-reporte').CardWidget('expand');

        //Contraer el card-opciones
        $('.card-opciones').CardWidget('collapse');
    }
}

//Activar todos los checkbox de los documentos
function check_documentos(boton) {
    var table = $('#documentos').DataTable();

    //Si el boton esta activo
    if (boton.checked) {
        //Recorrer las filas que se han filtrado
        table.rows({
            search: 'applied'
        }).every(function () {
            //Activar el checkbox
            $(this.node()).find('.chk-dct').prop('checked', true);
        });
    }

    //Si el boton esta desactivado
    else {
        //Desactivar el checkbox de la fila
        table.rows().every(function () {
            $(this.node()).find('.chk-dct').prop('checked', false);
        });
    }

    contraer_reporte(boton.checked);
}//Fin de la función check_documentos

/**Desactivar los tooltip de cada linea de documentos */
function desactivar_tooltips_documentos() {
    //Recorrer todas las lineas de la tabla
    var table = $('#documentos').DataTable();

    //Si la tabla existe y tiene filas
    if (table.rows().count() > 0) {
        //Recorrer las filas que se han filtrado
        table.rows({
            search: 'applied'
        }).every(function () {
            //Desactivar los tooltips data-toggle="tooltip"
            $(this.node()).find('[data-toggle="tooltip"]').tooltip('dispose');
        });
    }
}//Fin de la función desactivar_tooltips

/**Activar los tooltip de cada linea de documentos */
function activar_tooltips_documentos() {
    //Recorrer todas las lineas de la tabla
    var table = $('#documentos').DataTable();

    //Recorrer las filas que se han filtrado
    table.rows({
        search: 'applied'
    }).every(function () {
        //Activar los tooltips data-toggle="tooltip"
        $(this.node()).find('[data-toggle="tooltip"]').tooltip();
    });
}//Fin de la función activar_tooltips


function asignar_fecha(campo) {
    //Obtener el valor del campo
    var fecha = $(campo).val();

    console.log(fecha);

    //Colocar el campo min del campo fecha_fin
    $('#fecha_fin').attr('min', fecha);
}

//document ready
$(document).ready(function () {
    //Cuando el usuario envia un form dentro de la factura activa
    $(document).on('submit', 'form', function (e) {
        e.preventDefault();

        //No enviar el form
        return false;
    });

    //Cuando cambia el checked de un .chk-dct
    $(document).on('change', '.chk-dct', function () {
        contraer_reporte($(this).is(':checked'));
    });

    //Cuando el usuario presiona un tipo de pago, desmarcar los otros
    $(document).on('change', '.chk-pg', function () {
        //Desactivar los otros checkbox que no son el .chk-pg
        $('.chk-pg').not(this).prop('checked', false);
    });
});
