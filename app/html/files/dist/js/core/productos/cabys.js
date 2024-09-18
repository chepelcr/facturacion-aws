/**Codigos cabys que se buscan en el ministerio de hacienda */
var cabys = [];

/**Valor del impuesto que se busca en el ministerio de hacienda */
var impuesto = [];

/**Abrir la pantalla para buscar un codigo cabys */
function buscar_cabys() {
    if (modulo_activo == "empresa" && submodulo_activo == "productos") {
        //Ocultar el card-frm del elemento activo
        $("#" + elemento_activo)
            .find(".card-frm")
            .hide();

        //Mostrar el card-cabys del elemento activo
        $("#" + elemento_activo)
            .find(".card-cabys")
            .show();

        //Collapse el card-frm del elemento activo
        $("#" + elemento_activo)
            .find(".card-frm")
            .CardWidget("collapse");

        //Collapse el card-cabys del elemento activo
        $("#" + elemento_activo)
            .find(".card-cabys")
            .CardWidget("collapse");
    }

    //Obtener el valor del campo category_code del formulario activo
    const category_code = $("#" + form_activo)
        .find(".category_code")
        .val();

    if (category_code != "") {
        //Colocar el valor del campo category_code en el campo q_cabys del card-cabys del elemento activo
        $("#" + elemento_activo)
            .find(".q_cabys")
            .val(category_code);

        //Buscar el codigo cabys por nombre
        obtener_cabys();
    } else {
        //Eliminar el contenido del campo q_cabys del card-cabys del elemento activo
        $("#" + elemento_activo)
            .find(".q_cabys")
            .val("");
    }
} //Fin del metodo buscar_cabys

/**Buscar codigo cabys en el ministerio de hacienda por nombre */
function buscar_categorias(search) {
    if (search != "") {
        Pace.track(function () {
            url = base + "data/codigos_cabys";
            $.ajax({
                url: url,
                data: {
                    search: search,
                },
                dataType: "json",
                method: "get",
            }).done(function (response) {
                var html = "";
                var i;

                //response = response.cabys;

                cabys = [];
                impuesto = [];

                for (i = 0; i < response.length; i++) {
                    html +=
                        "<tr>" +
                        "<td>" +
                        response[i].code +
                        "</td>" +
                        "<td>" +
                        response[i].description +
                        "</td>" +
                        "<td>" +
                        response[i].suggestedTax +
                        " %</td>" +
                        '<td><button data-dismiss="modal" type="button" class="btn btn-warning btn-sm" value="' +
                        i +
                        '" onclick="seleccionar_cabys(' +
                        "'" +
                        i +
                        "'" +
                        ')"><i class="fas fa-check"></i></button></td>';
                    ("</tr>");

                    cabys[i] = response[i];
                }

                $("#" + elemento_activo)
                    .find("#cabys")
                    .html(html);

                //Expand el card-cabys
                $("#" + elemento_activo)
                    .find(".card-cabys")
                    .CardWidget("expand");
            });
        });
    } //Fin del if
} //Fin de la funcion cabys

/**Seleccionar un codigo cabys */
function seleccionar_cabys(valor) {
    campos_cabys("almacenando", form_activo);

    $("#" + elemento_activo)
        .find("#cabys")
        .html("");
    $("#" + elemento_activo)
        .find(".q_cabys")
        .val("");

    $("#" + form_activo)
        .find(".category_code")
        .val(cabys[valor].code);
    $("#" + form_activo)
        .find(".category_suggestedTax")
        .val(cabys[valor].suggestedTax);
    $("#" + form_activo)
        .find(".category_description")
        .val(cabys[valor].description);
    $("#" + form_activo)
        .find(".category_productType_id")
        .val(cabys[valor].productType.id);

    agregar_impuesto_cabys();

    campos_cabys("agregar", form_activo);

    cerrar_cabys();

    calcular_valor_producto(form_activo);

    mensajeAutomatico("Atención", "Código CABYS seleccionado correctamente", "success");
}
function cerrar_cabys() {
    //Ocultar el card-cabys
    $("#" + elemento_activo)
        .find(".card-cabys")
        .hide();

    //Mostrar el card-form
    $("#" + elemento_activo)
        .find(".card-frm")
        .show();

    //Expand el card-frm
    $("#" + elemento_activo)
        .find(".card-frm")
        .CardWidget("expand");
}

function obtener_cabys() {
    //Obtener el nombre del producto del q_cabys del card-cabys del elemento activo
    const search = $("#" + elemento_activo)
        .find(".q_cabys")
        .val();

    //Buscar el codigo cabys por nombre
    buscar_categorias(search);
}
