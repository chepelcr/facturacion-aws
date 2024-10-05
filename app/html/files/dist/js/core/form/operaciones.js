/**Ruta de la accion del formulario que se encuentran en la pantalla */
var ruta_accion = "";

/**Nombre del formulario activo */
var form_activo = "";

/**ID del objeto que se muestra en el formulario */
var id_objeto = 0;

var estado_form = "";

/**Abrir el formulario para agregar un objeto */
function agregar(titulo = "") {
    modulo = modulo_activo;
    submodulo = submodulo_activo;

    if (modulo != "" && submodulo != "") {
        ruta_accion = modulo + "/guardar/" + submodulo;

        elemento = elemento_activo;

        form_activo = "frm_" + modulo_activo + "_" + submodulo_activo;

        //Mostrar el card-frm del elemento activo
        $("#" + elemento)
            .find(".card-frm")
            .show();

        //Cerrar todos los card
        $("#" + elemento)
            .find(".card-table")
            .CardWidget("collapse");

        vaciar_campos(form_activo);

        $("#" + elemento)
            .find(".titulo-submodulo")
            .html(titulo);

        estado = "agregar";

        activar_botones_accion(elemento, estado);

        campos_activos(false, form_activo);

        //Cerrar el card
        $("#" + elemento)
            .find(".card-table")
            .hide();

        const form = $("#" + form_activo);

        //Abrir el card-frm
        form.find(".card-form").CardWidget("collapse");

        switch (modulo) {
            case "empresa":
                switch (submodulo) {
                    case "productos":
                        campos_cabys(estado, form_activo);
                        getUnitCode(form.find(".measurementUnit_unitId"));

                        //activar_campo_clase('slc_code', true, form_activo);

                        form.find(".salePrice").val(0);
                        form.find(".taxValue").val(0);
                        form.find(".unitPrice").val(0);
                        form.find(".netValue").val(0);

                        //Enfocar el campo de descripcion
                        form.find(".name").focus();

                        break;
                    case "clientes":
                        activar_campos_cedula(estado, form_activo);
                        vaciar_ubicacion(estado);

                        //Poner el foco en el campo de cedula
                        form.find(".identification_number").focus();
                        break;
                }
                break;

            case "seguridad":
                switch (submodulo) {
                    case "roles":
                        desactivar_permisos(form_activo);
                        break;

                    case "usuarios":
                        activar_campos_cedula(estado, form_activo);

                        //Poner el foco en el campo de cedula
                        form.find(".identification_number").focus();
                }
                break;
        }

        //Abrir el card-frm
        form.find(".card-form").CardWidget("expand");
    }
} //Fin de la funcion

/**Cancelar la accion del formulario actual */
function cancelar_accion() {
    vaciar_campos(form_activo);

    campos_activos(true, form_activo);

    activar_botones_accion(elemento_activo, "listado");

    form_activo = "";

    const activeElement = $("#" + elemento_activo);

    //Cerrar el card-frm
    activeElement.find(".card-frm").hide();

    activeElement.find(".card-table").show();
    activeElement.find(".card-table").CardWidget("expand");

    //Poner el nombre del submodulo en el titulo con la primera letra en mayuscula
    activeElement.find(".titulo-submodulo").html(nombre_vista_submodulo);
}

function llenarObjeto(nombre_form, objeto, estado) {
    const activeForm = $("#" + nombre_form);

    //Cerrar todos los card
    activeForm.find(".card").CardWidget("collapse");

    if (modulo_activo == "empresa" && submodulo_activo == "productos") {
        eliminarDescuentosProducto();
        eliminar_impuestos_producto();
        eliminarCodigosProducto();
    }

    $.each(objeto, function (key, valor) {
        if (key == "identification") {
            activar_campos_cedula("agregar-todos", nombre_form);

            var identificacion = valor.number;
            var tipoIdentificacion = valor.code;

            identificacion = formatear_cedula(identificacion, tipoIdentificacion);

            activeForm.find(".identification_number").val(identificacion);

            const identifications = activeForm.find(".identification_typeId option");

            //Recorrer los options con un each
            $.each(identifications, function (i, option) {
                //Si el data-code es igual al tipo de identificacion
                if ($(option).data("code") == tipoIdentificacion) {
                    option.selected = true;
                } else {
                    option.selected = false;
                }
            });
        } else if (key == "residence") {
            if (estado == "ver") {
                llenarUbicacion(valor, true);
            } else {
                llenarUbicacion(valor, false);
            }
        } else if (key == "codes" && modulo_activo == "empresa" && submodulo_activo == "productos") {
            agregarCodigosProducto(valor, nombre_form);
        } else if (key == "nationality") {
            activeForm.find(".nationality").val(valor.isoCode);
        } else if (key == "modulos") {
            llenar_permisos(valor, form_activo);
        } else if (key == "taxes") {
            agregar_impuestos_producto(valor);
        } else if (key == "discounts") {
            agregar_descuentos_producto(valor);
        } else if (key == "measurementUnit") {
            activeForm.find(".measurementUnit_unitId").val(valor.unitId);

            var commercialUnit = valor.commercialUnit;

            if (commercialUnit == null || commercialUnit == "") {
                commercialUnit = valor.code;
            }

            activeForm.find(".measurementUnit_commercialUnit").val(commercialUnit);
        } else {
            // Validar si el elemento es un objeto
            if (typeof valor == "object") {
                if (valor != null) {
                    $.each(valor, function (inner_key, inner_value) {
                        inner_key = key + "_" + inner_key;

                        // Si la llave es category_productType, se debe cambiar a category_productType_id
                        if (inner_key == "category_productType") {
                            productTypes = activeForm.find(".category_productType_id option");

                            $.each(productTypes, function (i, option) {
                                if ($(option).val() == valor.productType.id) {
                                    option.selected = true;
                                } else {
                                    option.selected = false;
                                }
                            });
                        } else {
                            activeForm.find("." + inner_key).val(inner_value);
                        }
                    });
                }
            } else {
                activeForm.find("." + key).val(valor);
            }
        }
    });

    if (modulo_activo == "empresa" && submodulo_activo == "clientes") {
        if (objeto.tradeName == null) {
            activeForm.find(".tradeName").val(objeto.businessName);
        }
    } else if (modulo_activo == "empresa" && submodulo_activo == "productos") {
        calcular_con_precio_venta(nombre_form, objeto.salePrice);
    }

    activar_campos_formulario(nombre_form, estado);

    //Abrir el card
    activeForm.find(".card").CardWidget("expand");
}

function activar_campos_formulario(nombre_form, estado = "ver") {
    let modulo = modulo_activo;
    let submodulo = submodulo_activo;

    if (estado == "ver") {
        campos_activos(true, nombre_form);
    } else {
        campos_activos(false, nombre_form);
    }

    //Si el modulo es empresa y el submodulo es productos
    if (modulo == "empresa" && submodulo == "productos") {
        campos_cabys(estado, nombre_form);
        activarUnidadComercial(estado, nombre_form);
    } else if (modulo == "empresa" && submodulo == "clientes") {
        activar_campos_cedula(estado, nombre_form);
    } else if (modulo == "seguridad" && submodulo == "usuarios") {
        activar_campos_cedula(estado, nombre_form);

        activar_campo_clase("email", true, nombre_form);
    }

    activar_botones_accion(elemento_activo, estado);

    estado_form = estado;
}

/**Lenar un formulario con la informacion enviada */
function llenarFrm(objeto, titulo, nombre_form = "", estado = "") {
    form_activo = nombre_form;

    const activeElement = $("#" + elemento_activo);

    if (objeto) {
        llenarObjeto(nombre_form, objeto, estado);

        activeElement.find(".titulo-form").html(titulo);

        //Mostrar el card-frm
        activeElement.find(".card-frm").show();
    } //Fin de la validacion
} //Fin de la funcion

function activar_botones_accion(elemento, estado = "agregar") {
    if (estado == "agregar") {
        $("#" + elemento)
            .find(".btt-mod")
            .hide();
        $("#" + elemento)
            .find(".btt-edt")
            .hide();
        $("#" + elemento)
            .find(".btt-grd")
            .show();

        activar_campo_clase("btn-grd", false, elemento_activo);
        activar_campo_clase("btn-edt", true, elemento_activo);
        activar_campo_clase("btn-mdf", true, elemento_activo);
    } else if (estado == "ver") {
        $("#" + elemento)
            .find(".btt-mod")
            .hide();
        $("#" + elemento)
            .find(".btt-edt")
            .show();
        $("#" + elemento)
            .find(".btt-grd")
            .hide();

        activar_campo_clase("btn-grd", true, elemento_activo);
        activar_campo_clase("btn-edt", false, elemento_activo);
        activar_campo_clase("btn-mdf", true, elemento_activo);
    } else if (estado == "editar") {
        $("#" + elemento)
            .find(".btt-mod")
            .show();
        $("#" + elemento)
            .find(".btt-edt")
            .hide();
        $("#" + elemento)
            .find(".btt-grd")
            .hide();

        activar_campo_clase("btn-grd", true, elemento_activo);
        activar_campo_clase("btn-edt", true, elemento_activo);
        activar_campo_clase("btn-mdf", false, elemento_activo);
    } else if (estado == "listado") {
        $("#" + elemento)
            .find(".btt-mod")
            .hide();
        $("#" + elemento)
            .find(".btt-edt")
            .hide();
        $("#" + elemento)
            .find(".btt-grd")
            .hide();

        activar_campo_clase("btn-grd", true, elemento_activo);
        activar_campo_clase("btn-edt", true, elemento_activo);
        activar_campo_clase("btn-mdf", true, elemento_activo);

        activar_campo_clase("btn-add", false, elemento_activo);
    } else if (estado == "almacenar") {
        activar_campo_clase("btn-grd", true, elemento_activo);
        activar_campo_clase("btn-mdf", true, elemento_activo);
    } else if (estado == "cargando") {
        $("#" + elemento)
            .find(".btt-mod")
            .hide();
        $("#" + elemento)
            .find(".btt-edt")
            .hide();
        $("#" + elemento)
            .find(".btt-grd")
            .hide();

        activar_campo_clase("btn-add", true, elemento_activo);
        activar_campo_clase("btn-edt", true, elemento_activo);
        activar_campo_clase("btn-mdf", true, elemento_activo);
    } else if (estado == "error") {
        activar_campo_clase("btn-grd", false, elemento_activo);
        activar_campo_clase("btn-mdf", false, elemento_activo);
    }
}

/**Editar el contenido de un formulario */
function editar() {
    estado = "editar";

    activar_campos_formulario(form_activo, estado);
} //Fin de la funcion editar

/**Verificar si existe un elemento en la base de datos */
function validar(elemento = "", objeto = "") {
    if (elemento != "" && elemento) {
        const form = $("#" + form_activo);
        const activeElement = $("#" + elemento_activo);

        $.ajax({
            url: base + modulo_activo + "/validar/" + elemento + "/" + submodulo_activo,
            dataType: "json",
        }).done(function (response) {
            if (response) {
                mensajeAutomatico("Alerta", "El " + objeto + " ya existe", "info");

                campos_activos(true, form_activo);

                activeElement.find(".btn-grd").attr("disabled", true);

                if (objeto == "usuario" || objeto == "cliente") {
                    form.find(".btn-eliminar").attr("disabled", false);
                }

                if (objeto == "producto") {
                    form.find("#codigo_venta").attr("disabled", false);
                    form.find("#codigo_venta").attr("readonly", false);
                }
            } //Fin del usuario existente
            else {
                campos_activos(false, form_activo);

                if (objeto == "usuario" || objeto == "cliente") {
                    obtener_contribuyente(elemento);
                }

                if (objeto == "producto") {
                    campos_cabys(true, form_activo);
                }

                activeElement.find(".btn-grd").attr("disabled", false);
            }
        });
    } //Fin de validacion de elemento
} //Fin de verificar un elemento en la base de datos

/**Activar un objeto en la base de datos */
function habilitar(id, objeto) {
    $.ajax({
        url: base + modulo_activo + "/activar/" + submodulo_activo + "/" + id,
        method: "get",
        dataType: "json",
    }).done(function (response) {
        if (!response.error) {
            //Poner la primeta letra en mayuscula
            objeto = objeto.charAt(0).toUpperCase() + objeto.slice(1);
            Swal.fire({
                title: "Alerta",
                text: objeto + " habilitado correctamente",
                icon: "success",
                timer: 2000,
                showConfirmButton: false,
            }).then((result) => {
                //Recargar la tabla
                recargar_listado(1);
            }); //Fin del mensaje
        } //Fin del if
        else {
            mensajeAutomatico("Atencion", "Ha ocurrido un error: " + response.error, "error");
        } //Fin del else
    });
} //Fin de habilitar un objeto en la base de datos

/**Desactivar un objeto de la base de datos */
function deshabilitar(id, objeto) {
    $.ajax({
        url: base + modulo_activo + "/desactivar/" + submodulo_activo + "/" + id,
        method: "get",
        dataType: "json",
    }).done(function (response) {
        if (!response.error) {
            //Poner el objeto en mayusculas
            objeto = objeto.charAt(0).toUpperCase() + objeto.slice(1);
            Swal.fire({
                title: "Alerta",
                text: objeto + " deshabilitado correctamente",
                icon: "success",
                timer: 2000,
                showConfirmButton: false,
            }).then((result) => {
                recargar_listado(2);
            }); //Fin del mensaje
        } //Fin del if
        else {
            mensajeAutomatico("Atencion", "Ha ocurrido un error: " + response.error, "error");
        } //Fin del else
    });
} //Fin de deshabilitar un objeto en la base de datos

/**Obtener un objeto de la base de datos */
function obtener(id, objeto, estado) {
    id_objeto = id;

    const activeElement = $("#" + elemento_activo);

    $.ajax({
        url: base + modulo_activo + "/obtener/" + submodulo_activo + "/" + id,
        method: "get",
        dataType: "json",
    })
        .done(function (response) {
            if (!response.error) {
                modulo = modulo_activo;
                submodulo = submodulo_activo;

                ruta_accion = modulo + "/update/" + submodulo_activo + "/" + id;

                //Collapsar el listado
                activeElement.find(".card-table").CardWidget("collapse");

                //Cerrar el card
                activeElement.find(".card-table").hide();

                llenarFrm(response, "Editar " + objeto, "frm_" + modulo_activo + "_" + submodulo_activo, estado);
            } else {
                mensajeAutomatico("Atencion", "Ha ocurrido un error: " + response.error, "error");
            }
        })
        .fail(function (xhr, textStatus, errorThrown) {
            //Mostrar la respuesta
            notificacion("Error", errorThrown, "error");
        });
} //Fin de obtener un objeto de la base de datos

function enviar_formulario() {
    var nombre_form = form_activo;

    const activeForm = $("#" + nombre_form);

    if (nombre_form != "") {
        if (!validarDataForm(nombre_form)) {
            mensajeAutomatico("Atencion", "Por favor complete los campos requeridos", "error");
            return;
        } else {
            campos_activos(false, nombre_form);

            var formData = new FormData(activeForm[0]);

            campos_activos(true, nombre_form);

            activar_botones_accion(elemento_activo, "almacenar");

            //Collapsar los card
            activeForm.find(".card").CardWidget("collapse");

            Pace.track(function () {
                $.ajax({
                    url: base + ruta_accion,
                    method: "post",
                    data: formData,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                })
                    .done(function (response) {
                        if (!response.error) {
                            Swal.fire({
                                title: "Atencion",
                                text: response.success,
                                icon: "success",
                                timer: 2000,
                                showConfirmButton: false,
                            }).then((result) => {
                                //Recargar la tabla//Cuando el usuario actualiza el perfil
                                if (modulo_activo == "perfil") {
                                    campos_perfil(false);
                                } else {
                                    recargar_listado("all");
                                }
                            }); //Fin del mensaje
                        } //Fin del if
                        else {
                            notificacion(response.error, "", "error");

                            activar_botones_accion(elemento_activo, "error");
                        } //Fin del else
                    })
                    .fail(function (jqXHR, textStatus, errorThrown) {
                        response = jqXHR.responseText;

                        console.log(response);

                        if (response != 'null' && response != "") {
                            response = JSON.parse(response);
                        } else {
                            response = { message: errorThrown };
                        }

                        notificacion(response.message, "", "error");

                        activar_campos_formulario(nombre_form, estado_form);
                    });
            }); //Fin de track
        }
    } //Fin del if !elemento
}

function validarDataForm(formulario) {
    var dataValida = true;

    //Obtener los inputs del formulario, select, textarea, etc
    const inputs = $("#" + formulario).find("input, select, textarea");

    inputs.each(function (index, input) {
        if ($(input).attr("required") && $(input).val() == "") {
            //Colocar un borde rojo al input
            $(input).addClass("border-danger");

            dataValida = false;
        } else {
            $(input).removeClass("border-danger");
        }
    });

    if (modulo_activo == empresa && submodulo_activo == productos) {
        dataValida = validateDiscountLines(formulario);
        dataValida = validateTaxLines(formulario);
    }

    return dataValida;
}

$(document).ready(function () {
    //Cuando el mouse entra en un .card-form
    $(document).on("mouseenter", ".card-form", function () {
        //Expandir el card-form al pasar el mouse
        //$(this).CardWidget('expand');
    });
});
