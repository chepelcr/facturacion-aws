var factura_activa = '';
var id_factura_activa = 0;

/**Finalizar el documento activo */
function finalizar_documento() {
    //Obtener el valor de .moneda de la factura activa
    var moneda = $('#' + factura_activa).find(".moneda").val();

    //Mostrar el .mopdal-finalizar de la factura activa
    $('#' + factura_activa).find('.modal-cierre').modal('show');
}

/**Eliminar el documento activo en la pantalla */
function cancelar_documento() {
    //Cerrar el modal de cierre de factura
    $('#' + factura_activa).find('.modal-cierre').modal('hide');

    //Esperar un segundo
    setTimeout(function () {
        //Eliminar el contenido de la factura activa
        $('#' + factura_activa).empty();

        //Ocultar el boton de la factura activa
        $('.col-btn-fct-' + id_factura_activa).hide();

        //Cargar documentos
        cargar_documentos('emitidos');
        }, 1000);
}

function imprimirTiquete() {
    //Tomar el contenido del #ticketFrame e imprimirlo 
    var contenido = document.getElementById('ticketFrame').contentWindow;

    contenido.focus();

    contenido.print();

    //Cerrar el modal de impresion
    $('#modalImprimir').modal('hide');
}

/**Ver el contenedor de una factura */
function ver_factura(id_factura) {
    factura = 'card-factura-' + id_factura;

    //Si la factura esta vacia o no existe
    if ($('#' + factura).length == 0 || $('#' + factura).is(':empty')) {
        mensajeAutomatico('Atencion', 'No existe factura con ese ID', 'info');
    }

    else {
        submodulo_activo = 'facturacion';

        factura_activa = factura;
        id_factura_activa = id_factura;

        //Ocultar el contenedor de documentos
        $('#listado_documentos').hide();

        //Mostrar el contenedor de facturas
        $('.contenedor_facturas').show();

        //Ocultar todas las facturas
        $('.card-factura').hide();

        //Expand .card-opciones-documentos
        $('.card-finalizar').CardWidget('expand');

        //Collapse .card-opciones
        $('.card-opciones').CardWidget('collapse');

        //Contraer el card-opciones-reporte
        $('.card-opciones-reporte').CardWidget('collapse');

        //Ocultar .cont-reporte
        $('.cont-reporte').hide();

        //Desactivar boton de documentos
        $('.btn-documentos').removeClass('btn-warning').addClass('btn-dark');

        //Ocultar boton .btn-walmart
        $('.col-walmart').hide();

        //Habilitar los botones de facturas
        $('.btn-factura').attr('disabled', false);

        //Habilitar el boton de documentos
        $('.btn-documentos').attr('disabled', false);

        //Deshabilitar el boton de la factura
        $('#btn_factura_' + id_factura).attr('disabled', true);

        $('#' + factura_activa).find(".tipo_cambio").val(cambio_compra);

        $('#' + factura_activa).show();

        //Obtener el id de tipo de documento
        var id_tipo_documento = $('#' + factura_activa).find('.id_tipo_documento').val();

        //Collapse .card-opciones-documentos
        $('.card-opciones-documentos').CardWidget('collapse');

        //Validar el tipo de documento
        switch (id_tipo_documento) {
            case '01':
                //Activar el boton de la factura
                $('#btn_factura_' + id_factura).addClass('btn-success').removeClass('btn-dark');
            break;

            //Nota de debito
            case '02':
                //Activar el boton
                $('#btn_factura_' + id_factura).addClass('btn-warning').removeClass('btn-dark');
            break;

            //Nota de credito
            case '03':
                //Activar el boton
                $('#btn_factura_' + id_factura).addClass('btn-danger').removeClass('btn-dark');
            break;

            //Tiquete de venta
            case '04':
                //Activar el boton
                $('#btn_factura_' + id_factura).addClass('btn-secondary').removeClass('btn-dark');
            break;

            //Factura de compras
            case '08':
                //Activar el boton
                $('#btn_factura_' + id_factura).addClass('btn-purple').removeClass('btn-dark');
            break;

            default:
                //Activar el boton de la factura
                $('#btn_factura_' + id_factura).addClass('btn-info').removeClass('btn-dark');
            break;
        }//Fin del switch

        //Si el tipo de documento es factura 04, ocultar el boton de clientes
        if (id_tipo_documento != '04') {
            //Obtener la identificacion del modal de la factura activa
            var identificacion = $('#' + factura_activa).find('.identificacion-cliente').val();

            if (identificacion != '') {
                obtener_cliente(identificacion);
            }

            if (id_tipo_documento == '02' || id_tipo_documento == '03') {
                //Ocultar el boton de referencias
                $('.col-referencia').show();
            }

            else {
                //Ocultar el boton de referencias
                $('.col-referencia').hide();
            }

            //Mostrar el card-opciones-documentos
            $('.card-opciones-documentos').CardWidget('expand');
        }

        //Contar las lineas de la factura
        contar_lineas();

        //Poner el titulo
        poner_titulo('documentos', 'facturacion');

        //Activar tooltip
        activar_tooltips();

        //Poner el cursor en el campo de codigo de barras (gnl) de la factura activa
        $('.contenedor_facturas').find('.gnl-agregar').focus();
    }
}//Fin de la funcion ver_factura

/**Ver un documento en pdf */
function verPdf(clave) {
    if (clave != '') {
        $.ajax({
            "url": base + 'documentos/ver_pdf/' + clave,
            "dataType": "html",
        }).done(function (response) {
            //Vaciar los datos del contenedor_pdf
            $('#contenedor_pdf').empty();

            //Agregar el contenido del pdf
            $('#contenedor_pdf').append(response);

            $('#modalImprimir').modal('show');

        });
    }//Fin del if
}//Fin de la función verPdf

/**Agregar referencias al documento */
function agregar_referencias() {
    //Mostrar el modal de referencias de la factura activa
    $('#' + factura_activa).find('.modal-referencias').modal('show');
}//Fin de la funcion agregar_referencias

/**Ver la información de Walmart del documento */
function ver_walmart() {
    //Ocultar el contenedor de tiendas en .modal-walmart
    $('#' + factura_activa).find('.modal-walmart').find('.contenedor-tiendas').hide();

    //Mostrar el contenedor de datos en .modal-walmart
    $('#' + factura_activa).find('.modal-walmart').find('.contenedor-datos').show();

    //Mostrar el .modal-walmart de la factura activa
    $('#' + factura_activa).find('.modal-walmart').modal('show');

    activar_tooltips();
}//Fin de la funcion ver_walmart