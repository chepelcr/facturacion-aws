/**Obtener un cliente de la base de datos */
function obtener_cliente(identificacion = "") {
    elemento_activo = "modal-receptor-" + id_factura_activa;

    const activeDocument = $("#" + factura_activa);

    if (identificacion && identificacion != "") {
        Pace.track(function () {
            //Solicitar el cliente por ajax
            $.ajax({
                url: base + "documentos/buscar_cliente/" + identificacion,
                type: "GET",
                dataType: "json",
            })
                .done(function (data) {
                    if (!data.error) {
                        llenarObjeto(elemento_activo, data, "ver");

                        //Colocar el nombre del cliente en el input .nombre-cliente de la factura activa
                        activeDocument.find(".nombre-cliente").val(data.businessName);

                        //Si el nombre del cliente es igual a Walmart y es una factura (tipo_documento = "01")
                        if (
                            data.identification.number == "3102007223" &&
                            activeDocument.find(".documentTypeCode").val() == "01"
                        ) {
                            //Mostrar el boton de walmart
                            $(".col-walmart").show();

                            //Si el .contenedor-walmart no tiene un .modal-walmart
                            if (!activeDocument.find(".contenedor-walmart").find(".modal-walmart").length) {
                                //Solicitar el modal de walmart
                                $.ajax({
                                    url: base + "documentos/get_walmart",
                                    type: "GET",
                                    dataType: "html",
                                }).done(function (data) {
                                    //Agregar el modal de walmart al documento activo
                                    activeDocument.find(".contenedor-walmart").empty().append(data);
                                });
                            }
                        } else {
                            //Ocultar el boton de walmart
                            $(".col-walmart").hide();

                            //Eliminar el modal de walmart del documento activo
                            activeDocument.find(".contenedor-walmart").empty();
                        }

                        //Ocultar el boton de guardar del modal de cliente
                        $(".btt-grd-clt").hide();

                        //Ocultar el boton de editar del modal de cliente
                        $(".btt-edt-clt").show();

                        //Ocultar el boton de guardar cambios del modal de cliente
                        $(".btt-grd-clt-cambios").hide();

                        //Mostrar el boton de aceptar cliente
                        $(".btt-aceptar-clt").show();

                        //Mostrar el boton de seleccionar otro
                        $(".btt-sct-clt").show();

                        //Mostrar el boton de agregar cliente
                        $(".btt-add-clt").hide();

                        //Mostrar el card de clientes
                        $("#modal-receptor-" + id_factura_activa).modal("show");

                        cerrar_clientes();
                    } else {
                        notificacion(data.error, "", "error");
                    }
                })
                .fail(function (jqXHR, status, error) {
                    response = jqXHR.responseText;

                    if (response != null && response != "") {
                        response = JSON.parse(response);
                    } else {
                        response = { error: "Error al obtener el cliente" };
                    }

                    notificacion(response.error, "", "error");
                });
        });
    }
}

/**Validar la identificacion de un formulario */
function validar_identificacion(identificacion = "") {
    if (!formato && identificacion != "") {
        switch (modulo_activo) {
            case "seguridad":
                if (submodulo_activo == "usuarios") validar(identificacion, "usuario");
                break;

            case "empresa":
                if (submodulo_activo == "clientes") {
                    $("#" + form_activo)
                        .find(".identificacion")
                        .val(identificacion);

                    validar(identificacion, "cliente");
                }
                break;
        } //Fin del switch
    } //Fin de validacion
    else {
        formato = false;
    }
}

/**Editar el cliente del documento activo */
function editar_cliente() {
    //Mostrar el boton de guardar del modal de cliente
    $(".btt-grd-clt").show();

    //Ocultar el boton de editar del modal de cliente
    $(".btt-edt-clt").hide();

    //Ocultar el boton de guardar cambios del modal de cliente
    $(".btt-grd-clt-cambios").hide();

    //Mostrar el boton de aceptar cliente
    $(".btt-aceptar-clt").hide();

    //Mostrar el boton de seleccionar otro
    $(".btt-sct-clt").show();

    //Mostrar el boton de agregar cliente
    $(".btt-add-clt").hide();

    campos_activos(false, elemento_activo);

    activar_campos_cedula("editar", elemento_activo);
}

/** Ver el modal del cliente del documento activo*/
function ver_modal_cliente() {
    const activeDocument = $("#" + factura_activa);

    //Obtener la identificacion del modal de la factura activa
    var identificacion = activeDocument.find(".identification_number").val();

    if (identificacion) {
        abrir_receptor();
    } else {
        buscar_clientes();
    }
}

function abrir_receptor() {
    elemento_activo = "modal-receptor-" + id_factura_activa;

    //Abrir el modal del receptor
    $("#" + elemento_activo).modal("show");

    form_activo = elemento_activo;

    //Collapse todos los card del elemento activo
    $("#" + form_activo)
        .find(".card")
        .CardWidget("collapse");

    //Cerrar el modal de clientes
    cerrar_clientes();

    editar_cliente();
}

function cerrar_clientes() {
    $(".modal-clientes").modal("hide");
}

function validarCliente() {
    const activeDocument = $("#" + factura_activa);

    var clienteValido = validarDataForm(form_activo);

    //Si el cliente es valido, cerrar el modal .modal-clientes
    if (clienteValido) {
        $(".modal-receptor").modal("hide");

        let businessName = $("#" + form_activo)
            .find(".businessName")
            .val();

        //Colocar el nombre del cliente en el input .nombre-cliente de la factura activa
        activeDocument.find(".nombre-cliente").val(businessName);
    } else {
        notificacion("Debe llenar todos los campos obligatorios del cliente", "", "error");
    }
}

/**Obtener todos los clientes de la base de datos */
function buscar_clientes() {
    const activeDocument = $("#" + factura_activa);

    //Obtener el tipo de documento de la factura activa mediante el data-code del option seleccionado
    let documentTypeCode = activeDocument.find(".documentTypeId").find("option:selected").data("code");

    data = {
        documentTypeCode: documentTypeCode,
    };

    //Solicitar los clientes por ajax
    $.ajax({
        url: base + "documentos/get_clientes",
        type: "GET",
        data: data,
        dataType: "html",
    })
        .done(function (data) {
            //Agregar los clientes al modal
            $(".card-clientes").show();

            //Ocultar card-busqueda
            $(".card-busqueda-clientes").show();

            //Agregar los clientes al modal
            $(".card-clientes").empty().append(data);

            //Collapse el .card-cliente de la factura activa
            $("#frm_cliente").hide();

            //Ocultar el boton de guardar del modal de clientes
            $(".btt-grd-clt").hide();

            //Ocultar el boton de editar del modal de clientes
            $(".btt-edt-clt").hide();

            //Ocultar el boton de guardar cambios del modal de clientes
            $(".btt-grd-clt-cambios").hide();

            //Ocultar el boton de aceptar del modal de clientes
            $(".btt-aceptar-clt").hide();

            //Mostrar el boton de seleccionar otro
            $(".btt-sct-clt").hide();

            //Mostrar el boton de agregar cliente
            $(".btt-add-clt").show();

            //Mostrar el modal de clientes
            $(".modal-clientes").modal("show");

            //Cerrar el modal del receptor
            $(".modal-receptor").modal("hide");
        })
        .fail(function (jqXHR, status, error) {
            response = jqXHR.responseText;

            if (response == null || response == "" || response == undefined || response == "undefined" || response == "null") {
                response = { message: "Error al obtener los clientes", status: jqXHR.status };
            } else {
                response = JSON.parse(response);
            }

            notificacion(response.error, "", "error");
        });
}

/**Funcion cuando el usuario presiona la opcion para agregar un cliente en el modulo buscar_cliente */
function agregar_cliente() {
    cerrar_clientes();
    elemento_activo = "modal-receptor-" + id_factura_activa;
    form_activo = elemento_activo;

    //Mostrar el boton de guardar del modal de cliente
    $(".btt-grd-clt").show();

    //Ocultar el boton de editar del modal de cliente
    $(".btt-edt-clt").hide();

    //Ocultar el boton de aceptar del modal de clientes
    $(".btt-aceptar-clt").hide();

    //Ocultar el boton de guardar cambios del modal de cliente
    $(".btt-grd-clt-cambios").hide();

    //Mostrar el boton de seleccionar otro
    $(".btt-sct-clt").show();

    //Mostrar el boton de agregar cliente
    $(".btt-add-clt").hide();

    campos_activos(false, form_activo);

    vaciar_campos(form_activo);

    //Collapse todos los card del elemento activo
    $("#" + form_activo)
        .find(".card")
        .CardWidget("expand");

    //Mostrar el modal del receptor
    $("#modal-receptor-" + id_factura_activa).modal("show");
}
