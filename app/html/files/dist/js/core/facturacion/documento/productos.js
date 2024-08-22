/**Seleccionar un producto de la base de datos */
function seleccionar_producto(id_producto, boton_producto = null) {
    if (boton_producto) {
        var linea_producto = $(boton_producto).parents(".producto");
        //Obtener la cantidad 
        var cantidad = $(linea_producto).find(".quantity").val();

        //Obtener el precio
        var precio = $(linea_producto).find(".salePrice").val();
    }

    //Obtener el producto
    $.ajax({
        "url": base + "empresa/obtener/productos/" + id_producto,
        "dataType": "json",
    }).done(function (response) {
        if (!response.error) {
            agregar_linea_activa(response, cantidad, precio);

            //Cerrar el modal de busqueda
            $('#modalProductos').modal('hide');
        }
    });
}

function buscar_producto(boton, gnl = '', agregar = false) {
    if (agregar) {
        //Obtener el gnl de $('#q_codigo_barras')
        gnl = $('#' + factura_activa).find('.gnl-agregar').val();
        linea_activa = null;
    } else {
        if (boton) {
            linea_activa = $(boton).parents(".detail");
        }

        if (gnl == '') {
            //Obtener el .gnl de la linea activa
            linea_activa.find(".gnl").val();
        }
    }

    //Si el .gnl no esta vacio
    if (gnl != '') {
        //Hacer trim al gnl
        gnl = gnl.trim();

        //Obtener el producto
        $.ajax({
            "url": base + "documentos/buscar_producto/" + gnl,
            "dataType": "json",
        }).done(function (response) {
            if (response && !response.error) {
                //Si la respuesta trae solamente un producto
                if (response.length == 1) {
                    response = response[0];
                    agregar_linea_activa(response, 1, response.salePrice);
                } else {
                    //Mostrar los productos en el modal
                    buscar_productos(gnl);
                }
            } else {
                if (response.error) {
                    mensajeAutomatico('Atencion', response.error, 'error');
                } else {
                    buscar_productos(gnl);
                }
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            json = JSON.parse(jqXHR.responseText);
            mensajeAutomatico('Atencion', json.error, 'error');
        });
    } else {
        if (boton) {
            buscar_productos();
        }
    }
}

/**Buscar productos de la base de datos */
function buscar_productos(gnl = '') {
    //Solicitar los productos por ajax
    $.ajax({
        url: base + 'documentos/get_productos',
        type: 'GET',
        dataType: 'html',
    }).done(function (data) {
        //Agregar los productos al modal
        $('#contenedor_busqueda_productos').empty().append(data);

        if (gnl != '') {
            //Hacer trim al gnl
            gnl = gnl.trim();

            //Escribir el gnl en el input
            $('#q_productos').val(gnl);

            //Buscar los productos
            filtrar_elemento('contenedor_busqueda_productos', 'producto', gnl);
        } else {
            //Eliminar el contenido del input
            $('#q_productos').val('');
        }

        //Mostrar el modal de busqueda de productos
        $('#modalProductos').modal('show');
    });
}//Fin de buscar_productos

$(document).ready(function () {
    //Cuando se abre el modalProductos
    $('#modalProductos').on('shown.bs.modal', function () {
        //Poner el foco en el input de busqueda
        $('#modalProductos').find('#q_productos').focus();
    });

    //Cuando el usuario presiona enter en el input .gnl
    $(document).on('keypress', '.gnl', function (e) {
        if (e.which == 13) {
            buscar_producto(null, $(this).val());
        }
    });

    //Cuando el usuario presiona enter en el input #q_codigo_barras
    $(document).on('keypress', '.gnl-agregar', function (e) {
        if (e.which == 13) {
            buscar_producto(null, $(this).val(), true);
        }
    });

    //cuando cambia #q_productos
    $(document).on('change', '#q_productos', function () {
        filtrar_elemento('contenedor_busqueda_productos', 'producto', $(this).val());
    });

    //Cuando el usuario presiona enter en el input #q_productos
    $(document).on('keypress', '#q_productos', function (e) {
        if (e.which == 13) {
            filtrar_elemento('contenedor_busqueda_productos', 'producto', $(this).val());
        }
    });

    //Cuando el usuario termina de escribir en el input #q_productos
    $(document).on('keyup', '#q_productos', function () {
        filtrar_elemento('contenedor_busqueda_productos', 'producto', $(this).val());
    });

    // Si el usuario limpia el input #q_productos
    $(document).on('input', '#q_productos', function () {
        filtrar_elemento('contenedor_busqueda_productos', 'producto', $(this).val());
    });
});
