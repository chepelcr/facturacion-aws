var linea_activa = null;

var tblDetalles_activa = null;

var lineas_activas = 0;

/**Mostrar el modal detalles de la linea */
function mostrar_detalles(boton) {
    if (boton != null) {
        linea_activa = $(boton).parents(".linea");
    }

    //Mostrar el .modal_detalle de la linea
    linea_activa.find(".modal_detalle").modal("show");

    //CardWidget collapse a todos los card del modal
    linea_activa.find(".modal_detalle").find(".card").CardWidget('collapse');
}//Fin del metodo mostrar_detalles

/**Eliminar una linea de la facura activa */
function eliminar_linea(boton_eliminar) {
    var linea = $(boton_eliminar).parents(".linea");

    //Si solo queda una linea en la factura
    if ($("#" + factura_activa).find(".linea").length == 1) {
        //Agregar una nueva linea
        aumentar_linea();
    }
    
    //Eliminar la linea de la factura
    $(linea).remove();

    //Contar las lineas de la factura
    contar_lineas();

    //Calcular el total de la factura
    totales();
}//Fin de la funcion eliminar_linea

/**Agregar un producto en la linea activa o una linea que tenga la misma informacion */
function agregar_linea_activa(producto, cantidad = 1, precio_final = 0) {
    var linea = linea_activa;

    //Obtener el codigo del producto
    var codigo = producto.codigo_cabys;

    //Obtener el codigo_venta del producto
    var codigo_venta = producto.codigo_venta;



    //Si solo hay una linea
    if ($("#" + factura_activa).find(".linea").length == 1) {

        linea = $("#" + factura_activa).find(".linea");

        //console.log(linea);

        console.log(linea.find(".codigo_venta").val());
        console.log(linea.find(".codigo").val());

        if ((linea.find(".codigo_venta").val() != 0 || linea.find(".codigo_venta").val() != '') && (linea.find(".codigo").val() != 0 || linea.find(".codigo").val() != '')) {
            console.log('Linea encontrada');

            console.log('Validando linea');

            console.log('Codigo: ' + linea.find(".codigo").val());
            console.log('Codigo venta: ' + linea.find(".codigo_venta").val());

            linea = aumentar_linea();
        }

        /*//Si la linea de la factura no tiene gnl y codigo
        if ($("#" + factura_activa).find(".linea").find(".codigo_venta").val() == '' && $("#" + factura_activa).find(".linea").find(".codigo").val() == '') {
            linea = $("#" + factura_activa).find(".linea");
        } else {
            linea = aumentar_linea();
        }*/
    } else {
        //Recorrer las lineas de la factura
        $('#' + factura_activa).find('.linea').each(function () {
            console.log('Validando linea');

            //Si la linea es igual al producto
            if ($(this).find(".codigo").val() == codigo && $(this).find(".codigo_venta").val() == codigo_venta) {
                //Obtener la cantidad de la linea
                var cantidad_linea = $(this).find(".cantidad").val();

                //Sumar la cantidad de la linea activa con la cantidad de la linea
                cantidad = parseInt(cantidad) + parseInt(cantidad_linea);

                linea = $(this);

                console.log('Linea encontrada');
            }
        });

        //Si la linea no fue encontrada
        if (linea == null) {
            linea = aumentar_linea();
        }
    }

    //Colocar el IVA en la primera .linea_impuesto de la tabla de impuestos de la linea
    linea.find(".linea_impuesto").first().find(".impP").val(producto.impuesto);
    linea.find(".linea_impuesto").first().find(".imp").val("01");

    var tarifas = linea.find(".linea_impuesto").first().find(".tarifas");

    //Recorrer las opciones de tarifas
    tarifas.find('option').each(function () {
        //Si el data-porcentaje es igual al porcentaje del producto
        if ($(this).data('porcentaje') == producto.impuesto && $(this).data('tipoTarifa') != 'T') {
            //Seleccionar la opcion
            $(this).prop('selected', true);
        }
    });

    //Activar las tarifas
    tarifas.prop('disabled', false);

    linea.find(".descripcion").val(producto.descripcion);
    linea.find(".codigo").val(producto.codigo_cabys);
    linea.find(".codigo_venta").val(producto.codigo_venta);
    linea.find(".cantidad").val(cantidad);
    linea.find(".unidad").val(producto.simbolo_unidad);
    linea.find(".precio").val(producto.valor_unitario);

    var precio = formato_moneda(producto.valor_unitario);

    //Colocar el precio en precioVL
    linea.find(".precioVL").val(precio);

    //Si el precio final es difernte de 0
    if (precio_final != 0 && precio_final != producto.valor_total) {
        //Obtener el monto del impuesto del precio final
        var impuesto = precio_final - precio_final / (producto.impuesto / 100 + 1);

        //Restar el porcentaje de impuesto del precio
        precio_final = Math.round(precio_final) - parseFloat(impuesto).toFixed(2);

        //Poner el precio en entero
        precio_final = Math.round(precio_final);

        //Agregar el precio final a la linea
        linea.find(".precio").val(precio_final);

        //Colocar el precio en precioVL
        linea.find(".precioVL").val(formato_moneda(precio_final));
    }

    //Si el descuento es mayor a cero
    if (producto.porcentaje_descuento > 0) {
        linea.find(".descP").val(producto.porcentaje_descuento);
        linea.find(".mot").val('Descuento de sistema');
    }

    calcular(linea);

    //Mostrar el boton de eliminar linea
    linea.find(".eliminarLinea").prop('hidden', false);

    //Eliminar el codigo de q_codigo_barras
    $("#" + factura_activa).find(".gnl-agregar").val('');

    //Poner el foco en q_codigo_barras
    $("#" + factura_activa).find(".gnl-agregar").focus();

    linea_activa = linea;
}

/** Aumentar el numero de la ultima linea agregada al modulo */
function aumentar_linea() {
    //Clonar la linea
    cloneLine();

    //Incrementar el numero de lineas activas
    lineas_activas++;

    //Obtener la ultima linea del documento activo
    linea = $("#" + factura_activa).find(".linea").last();

    //Agregar el valor a los botones de acciones
    $(linea).find(".descB").val(lineas_activas);
    $(linea).find(".eliminarLinea").val(lineas_activas);
    $(linea).find(".btn-buscar-prod").val(lineas_activas);

    //Vaciar todos los campos tipo texto
    $(linea).find("input[type=text]").val('');

    //Vaciar todos los campos tipo numero
    $(linea).find("input[type=number]").val('0');

    //Vaciar todos los campos tipo select
    $(linea).find("select").val('NA');

    /**Colocar los valores de numero en 0 */
    $(linea).find(".descP").val(0);
    $(linea).find(".precio").val(0);
    $(linea).find(".motivo").val('Descuento de sistema');
    $(linea).find(".neto").val(0);
    $(linea).find(".descM").val(0);
    $(linea).find(".cantidad").val(0);
    $(linea).find(".subtotal").val(0);
    $(linea).find(".impM").val(0);
    $(linea).find(".totalL").val(0);
    $(linea).find(".totalVL").val(0);
    
    $(linea).find(".codigo").val('');
    $(linea).find(".codigo_venta").val('');

    //Agregar el numero de linea a la linea_descuento .numero_linea
    $(linea).find(".numero_linea").val(lineas_activas);

    //Agregar el numero de linea a .numero_linea_lbl
    $(linea).find(".numero_linea_lbl").text('Linea ' + lineas_activas);

    //Contar las lineas de la factura
    contar_lineas();

    return $(linea);
}//Fin de la funcion aumentar_linea

/**Contar las lineas de detalle del documento activo */
function contar_lineas() {
    var lineas = 0;

    $('#' + factura_activa).find('.linea').each(function () {
        //Aumentar el numero de lineas
        lineas++;

        //Colocar el numero de linea en la linea
        $(this).find(".numero_linea").val(lineas);
        $(this).find(".numero_linea_lbl").text('Linea ' + lineas);

        //Activar los tooltips
        $(this).find('[data-toggle="tooltip"]').tooltip();

        //Si la linea no esta vacia
        if ($(this).find('.codigo').val() != '' && $(this).find('.codigo_venta').val() != "") {
            $(this).find(".eliminarLinea").prop('hidden', false);
        } else {
            $(this).find(".eliminarLinea").prop('hidden', true);
        }
    });

    //Poner el cursor en el campo de codigo de barras (gnl) de la factura activa
    $('.contenedor_facturas').find('.gnl-agregar').focus();

    return lineas;
}

/**Clonar una linea de la tabla */
function cloneLine() {
    //Agregar un clone de la ultima linea de la factura, en la tabla de detalles del documento
    $('#' + factura_activa).find('.cont-details').append(
        $('#' + factura_activa).find(".linea").last().clone());
}//Fin del metodo cloneLine


/**Calcular el valor total de una linea */
function calcular(linea = null) {
    //Si la linea no esta definida
    if (linea == null) {
        //Obtener la linea activa
        linea = linea_activa;
    }

    var precio = linea.find(".precio").val();

    if (precio != 0 && precio != '') {
        var cantidad = linea.find(".cantidad").val();

        //Colocar los valores en la linea
        var neto = parseFloat(precio * cantidad);
        neto = Math.round(neto);
        linea.find(".neto").val(neto);

        //Calcular el valor del descuento
        var descuento = calcular_descuentos(linea);

        //Calcular el valor de subtotal de la linea
        var subtotal = parseFloat(neto) - Math.round(descuento);
        subtotal = Math.round(subtotal);
        linea.find(".subtotal").val(subtotal);

        //Calcular el valor de impuesto de la linea
        //var impuesto = parseFloat(subtotal) * parseInt(impP) / 100;

        var impuesto = calcular_impuestos(linea);
        console.log(impuesto);

        impuesto = Math.round(impuesto);
        linea.find(".ivNeto").val(impuesto);

        //Calcular el valor total de la linea
        var total = Math.round(subtotal + impuesto);
        total = Math.round(total);
        linea.find(".totalL").val(total);

        neto = formato_moneda(neto);
        linea.find(".netoVL").val(neto);

        subtotal = formato_moneda(subtotal);
        linea.find(".subtotalVL").val(subtotal);

        impuesto = formato_moneda(impuesto);
        linea.find(".ivNetoVL").val(impuesto);

        total = formato_moneda(total);
        linea.find(".totalVL").val(total);

        totales();
    }
}

/**Formatear un numero de acuerdo al pais */
function formato_moneda(numero, decimales = 0) {
    numero = numero.toLocaleString('es-CR', { style: 'currency', currency: 'CRC', minimumFractionDigits: decimales, maximumFractionDigits: decimales });

    return numero;
}//Fin de la funcion para dar formato a un numero

function formato_numero(numero, decimales = 0) {
    numero = numero.toLocaleString('es-CR', { style: 'decimal', minimumFractionDigits: decimales, maximumFractionDigits: decimales });

    return numero;
}

/**Calcular el valor total del documento activo */
function totales() {
    var neto = 0;
    var descuentos = 0;
    var subtotal = 0;
    var IVA = 0;
    var total = 0;

    $('#' + factura_activa).find(".linea").each(function (i, item) {
        neto += (parseInt($(item).find(".neto").val()));
        descuentos += (parseInt($(item).find(".descM").val()));
        subtotal += (parseInt($(item).find(".subtotal").val()));
        IVA += (parseInt($(item).find(".ivNeto").val()));
        total += (parseInt($(item).find(".totalL").val()));
    });

    neto = formato_moneda(neto);
    descuentos = formato_moneda(descuentos);
    subtotal = formato_moneda(subtotal);
    IVA = formato_moneda(IVA);
    total = formato_moneda(total);

    $('#' + factura_activa).find(".lbl_neto").val(neto);
    $('#' + factura_activa).find(".lbl_descuentos").val(descuentos);
    $('#' + factura_activa).find(".lbl_subtotal").val(subtotal);
    $('#' + factura_activa).find(".lbl_iva").val(IVA);
    $('#' + factura_activa).find(".lbl_total").val(total);
}

$(document).ready(function () {
    $(document).on('keyup change', '.calcular', function () {
        linea_activa = $(this).parents(".linea");
        calcular(linea_activa);
    });

    //Al cambiar el valor de .cantidad
    $(document).on('keyup change', '.cantidad-det', function () {
        //Obtener la linea activa
        linea_activa = $(this).parents(".linea");

        //Obtener el valor de la cantidad
        var cantidad = $(this).val();

        //Si la cantidad es mayor a 0
        if (cantidad > 0) {
            //Colocar en el campo de cantidad de la linea activa
            linea_activa.find(".cantidad").val(cantidad);

            //Calcular el valor de la linea
            calcular(linea_activa);
        }
    });

    //Cuando cambia el valor de .cantidad
    $(document).on('keyup change', '.cantidad', function () {
        //Obtener la linea activa
        linea_activa = $(this).parents(".linea");

        //Obtener el valor de la cantidad
        var cantidad = $(this).val();

        //Si la cantidad es mayor a 0
        if (cantidad > 0) {
            //Colocar en el campo de .cantidad-det de la linea activa
            linea_activa.find(".cantidad-det").val(cantidad);
        }
    });

    //Cuando se enfoca el .gnl
    $(document).on('focus', '.gnl-agregar', function () {
        //Seleccionar la ultima .linea de la factura activa
        linea_activa = null;
    });
});