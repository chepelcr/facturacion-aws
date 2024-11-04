/**Codigos cabys que se buscan en el ministerio de hacienda */
var cabys = [];

/**Valor del impuesto que se busca en el ministerio de hacienda */
var impuesto = [];

$(document).ready(function () {
    //Cuando el usuario presione la tecla enter en el campo .category_code
    $(document).on("keypress", ".category_description", function (e) {
        if (e.which == 13) {
            buscar_cabys();
        }
    });

    $(document).on("change", ".productType-radio", function () {
        const productType = this.value;

        console.log("Tipo de producto: " + productType);

        validateCabysCode(productType);
    });
});

/**
 * Abrir la ventana de busqueda de códigos cabys
 */
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
    const search = $("#" + form_activo)
        .find(".category_description")
        .val();

    if (search != "") {
        //Buscar el codigo cabys por nombre
        obtener_cabys(search, true);
    }
} //Fin del metodo buscar_cabys

/**
 * Buscar un codigo cabys en el API de Catálogo de Bienes y Servicios del Ministerio de Hacienda
 * @param {string} search Valor a buscar
 */
function buscar_categorias(search) {
    if (search != "") {
        const activeElement = $("#" + elemento_activo);

        //Obtener el valor del productType-radio seleccionado
        const productType = activeElement.find(".productType-radio:checked").val();

        console.log("Tipo de producto: " + productType);

        Pace.track(function () {
            url = base + "data/codigos_cabys";
            $.ajax({
                url: url,
                data: {
                    search: search,
                    productType: productType,
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

                    html = "<tr><td colspan='4'>No se encontraron resultados</td></tr>";

                    activeElement.find("#cabys").html(html);
                });
        });
    } //Fin del if
} //Fin de la funcion cabys

/**
 * Seleccionar un codigo cabys de la lista de resultados
 *
 * @param {int} valor Posicion del codigo cabys en la lista
 */
function seleccionar_cabys(valor) {
    const activeElement = $("#" + elemento_activo);
    const activeForm = $("#" + form_activo);

    campos_cabys("almacenando", form_activo);

    activeElement.find("#cabys").html("");
    activeElement.find(".q_cabys").val("");

    let description = cabys[valor].description + " - IVA: " + cabys[valor].suggestedTax + "%";

    activeForm.find(".category_code").val(cabys[valor].code);
    activeForm.find(".category_suggestedTax").val(cabys[valor].suggestedTax);
    activeForm.find(".category_description").val(description);

    selectProductType(cabys[valor].productType.id, true);

    agregar_impuesto_cabys();

    campos_cabys("agregar", form_activo);

    cerrar_cabys();

    calcular_valor_producto(form_activo);

    mensajeAutomatico("Atención", "Código CABYS seleccionado correctamente", "success");
}

/**
 * Seleccionar el tipo de producto
 * @param {int} productType Id del tipo de producto
 */
function selectProductType(productType, click = false) {
    const activeForm = $("#" + form_activo);

    //Quitar el radio seleccionado de todos los productType exepto el seleccionado
    const activeRadio = activeForm.find(".productType-" + productType);
    activeRadio.prop("checked", true);

    //Obtener los otros radios menos el seleccionado
    const radios = activeForm.find(".productType-radio").not(activeRadio);

    //Si el tipo de producto es 1, mostrar el check packageInfo
    if (productType == 1) {
        activeForm.find(".packageInfo").show();
    } else {
        activeForm.find(".packageInfo").hide();
    }

    //Quitar el radio seleccionado de los otros productType
    radios.prop("checked", false);
}

/**
 * Cerrar el card-cabys y mostrar el card-form
 */
function cerrar_cabys() {
    const activeElement = $("#" + elemento_activo);

    //Ocultar el card-cabys
    activeElement.find(".card-cabys").hide();

    //Mostrar el card-form
    activeElement.find(".card-frm").show();

    //Expand el card-frm
    activeElement.find(".card-frm").CardWidget("expand");
}

/**
 * Buscar en la lista de códigos cabys
 * @param {string} search Valor a buscar
 * @param {boolean} clean Eliminar el valor del campo q_cabys
 */
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

/**
 * Validar si el usuario desea reemplazar el código CABYS
 *
 * @param {int} productType Tipo de producto
 */
function validateCabysCode(productType) {
    const activeForm = $("#" + form_activo);

    const category_code = activeForm.find(".category_code").val();

    console.log("Código CABYS: " + category_code);

    if (category_code != "") {
        Swal.fire({
            title: "Si cambia el tipo de artículo, se eliminará el código CABYS",
            text: "¿Desea continuar?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Sí",
            cancelButtonText: "No",
        }).then((result) => {
            if (result.isConfirmed) {
                selectProductType(productType, true);

                activeForm.find(".category_code").val("");
                activeForm.find(".category_suggestedTax").val("");
                activeForm.find(".category_description").val("");
            } else {
                //Quitar el check del radio seleccionado
                activeForm.find(".productType-" + productType).prop("checked", false);
            }
        });
    } else {
        selectProductType(productType, true);
    }
}
