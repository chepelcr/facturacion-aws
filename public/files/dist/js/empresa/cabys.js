/**Codigos cabys que se buscan en el ministerio de hacienda */
var cabys = [];

/**Abrir la pantalla para buscar un codigo cabys */
function buscar_cabys() {
    if (modulo_activo == 'empresa' && submodulo_activo == 'productos') {
        //Ocultar el card-frm del elemento activo
        $("#" + elemento_activo).find(".card-frm").hide();

        //Mostrar el card-cabys del elemento activo
        $("#" + elemento_activo).find(".card-cabys").show();

        //Collapse el card-frm del elemento activo
        $("#" + elemento_activo).find(".card-frm").CardWidget('collapse');

        //Collapse el card-cabys del elemento activo
        $("#" + elemento_activo).find(".card-cabys").CardWidget('collapse');
    }
}//Fin del metodo buscar_cabys

/**Buscar codigo cabys en el ministerio de hacienda por nombre */
function nombre_cabys(nombre_producto) {
    if (nombre_producto != '') {
        Pace.track(function () {
            $.ajax({
                "url": 'https://api.hacienda.go.cr/fe/cabys?',
                "data": {
                    'q': nombre_producto
                },
                "dataType": "json",
                "method": "get"
            }).done(function (response) {
                var html = '';
                var i;

                response = response.cabys;

                cabys = [];
                impuesto = [];

                for (i = 0; i < response.length; i++) {
                    html += '<tr>' +
                        '<td>' + response[i].codigo + '</td>' +
                        '<td>' + response[i].descripcion + '</td>' +
                        '<td>' + response[i].impuesto + ' %</td>' +
                        '<td><button data-dismiss="modal" type="button" class="btn btn-warning btn-sm" value="' +
                        i + '" onclick="seleccionar_cabys(' + "'" + i + "'" + ')"><i class="fas fa-check"></i></button></td>'
                    '</tr>';

                    cabys[i] = response[i];
                }

                $('#' + elemento_activo).find('#cabys').html(html);

                //Expand el card-cabys
                $('#' + elemento_activo).find('.card-cabys').CardWidget('expand');
            });
        });
    }//Fin del if
}//Fin de la funcion cabys

/**Seleccionar un codigo cabys */
function seleccionar_cabys(valor) {
    campos_cabys(false, form_activo);

    $('#' + elemento_activo).find('#cabys').html('');
    $('#' + elemento_activo).find('#q_cabys').val('');

    $('#' + form_activo).find('.codigo_cabys').val(cabys[valor].codigo);
    $('#' + form_activo).find('.impuesto').val(cabys[valor].impuesto);
    
    campos_cabys(true, form_activo);

    cerrar_cabys();

    calcular_valor_producto(form_activo);
}

function cerrar_cabys() {
    //Ocultar el card-cabys
    $('#' + elemento_activo).find('.card-cabys').hide();

    //Mostrar el card-form
    $('#' + elemento_activo).find('.card-frm').show();

    //Expand el card-frm
    $('#' + elemento_activo).find('.card-frm').CardWidget('expand');
}

function obtener_cabys() {
    //Obtener el nombre del producto del q_cabys del card-cabys del elemento activo
    var nombre_producto = $('#' + elemento_activo).find('#q_cabys').val();

    //Buscar el codigo cabys por nombre
    nombre_cabys(nombre_producto);
}