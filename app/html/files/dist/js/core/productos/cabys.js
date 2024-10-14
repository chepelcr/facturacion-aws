/**Codigos cabys que se buscan en el ministerio de hacienda */
var cabys = [];

/**Valor del impuesto que se busca en el ministerio de hacienda */
var impuesto = [];

$(document).ready(function () {
    //Cuando el usuario presione la tecla enter en el campo .category_code
    $(document).on("keypress", ".category_code", function (e) {
        if (e.which == 13) {
            buscar_cabys();
        }
    });
});

/**Abrir la pantalla para buscar un codigo cabys */
function buscar_cabys() {
    const activeElement = $("#" + elemento_activo);

    if (modulo_activo == "empresa" && submodulo_activo == "productos") {
        //Ocultar el card-frm del elemento activo
        activeElement.find(".card-frm").hide();

        //Mostrar el card-cabys del elemento activo
        activeElement.find(".card-cabys").show();

        //Collapse el card-frm del elemento activo
        activeElement.find(".card-frm").CardWidget("collapse");

        //Collapse el card-cabys del elemento activo
        activeElement.find(".card-cabys").CardWidget("collapse");
    }

    //Obtener el valor del campo category_code del formulario activo
    const category_code = $("#" + form_activo)
        .find(".category_code")
        .val();

    if (category_code != "") {
        //Buscar el codigo cabys por nombre
        obtener_cabys(category_code, true);
    }
} //Fin del metodo buscar_cabys

/**Buscar codigo cabys en el ministerio de hacienda por nombre */
function buscar_categorias(search) {
    if (search != "") {
        const activeElement = $("#" + elemento_activo);

        Pace.track(function () {
            url = base + "data/codigos_cabys";
            $.ajax({
                url: url,
                data: {
                    search: search,
                },
                dataType: "json",
                method: "get",
            })
                .done(function (response) {
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

                    activeElement.find("#cabys").html(html);

                    //Expand el card-cabys
                    activeElement.find(".card-cabys").CardWidget("expand");
                })
                .fail(function (jqXHR, textStatus, errorThrown) {
                    let response = jqXHR.responseText;

                    console.log("Response: ", response);

                    if (
                        response == null ||
                        response == "" ||
                        response == undefined ||
                        response == "undefined" ||
                        response == "null"
                    ) {
                        response = { message: "Error al buscar el código CABYS", status: jqXHR.status };
                    } else {
                        response = JSON.parse(response);
                    }

                    mensajeAutomatico("Atencion", response.message, "error");

                    activeElement.find("#cabys").html(getErrorPage(response));
                });
        });
    } //Fin del if
} //Fin de la funcion cabys

/**Seleccionar un codigo cabys */
function seleccionar_cabys(valor) {
    const activeElement = $("#" + elemento_activo);
    const activeForm = $("#" + form_activo);

    campos_cabys("almacenando", form_activo);

    activeElement.find("#cabys").html("");
    activeElement.find(".q_cabys").val("");

    activeForm.find(".category_code").val(cabys[valor].code);
    activeForm.find(".category_suggestedTax").val(cabys[valor].suggestedTax);
    activeForm.find(".category_description").val(cabys[valor].description);
    activeForm.find(".category_productType_id").val(cabys[valor].productType.id);

    agregar_impuesto_cabys();

    campos_cabys("agregar", form_activo);

    cerrar_cabys();

    calcular_valor_producto(form_activo);

    mensajeAutomatico("Atención", "Código CABYS seleccionado correctamente", "success");
}
function cerrar_cabys() {
    const activeElement = $("#" + elemento_activo);

    //Ocultar el card-cabys
    activeElement.find(".card-cabys").hide();

    //Mostrar el card-form
    activeElement.find(".card-frm").show();

    //Expand el card-frm
    activeElement.find(".card-frm").CardWidget("expand");
}

function obtener_cabys(search = "", clean = false) {
    const activeElement = $("#" + elemento_activo);

    if (clean == true) {
        //Eliminar el contenido del campo q_cabys del card-cabys del elemento activo
        activeElement.find(".q_cabys").val("");
    }

    if (search == "") {
        search = activeElement.find(".q_cabys").val();
    } else {
        activeElement.find(".q_cabys").val(search);
    }

    //Buscar el codigo cabys por nombre
    buscar_categorias(search);
}
