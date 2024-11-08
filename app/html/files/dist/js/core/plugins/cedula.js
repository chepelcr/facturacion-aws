/**Obtener un contribuyente del ministerio de hacienda */
function obtener_contribuyente(cedula = null) {
    const activeForm = $("#" + form_activo);

    let nombre = "";

    if (cedula != "" && cedula) {
        //Si la cedula es menor a 9 digitos
        if (cedula.length < 9) {
            mensajeAutomatico("Atencion", "La identificacion indicada es muy corta", "error");
            return false;
        }

        const nationality = activeForm.find(".nationality").val();

        if(nationality == ""){
            mensajeAutomatico("Atencion", "Debe seleccionar la nacionalidad", "error");
            return false;
        }

        data = {
            taxpayerId: cedula,
            nationality: nationality,
        };

        Pace.track(function () {
            $.ajax({
                url: base + "data/contribuyentes",
                method: "get",
                data: data,
                dataType: "json",
            })
                .done(function (response) {
                    if (!response.error) {
                        nombre = response.businessName;

                        //Llenar el campo de nombre
                        llenar_nombre(nombre, form_activo);
                    }
                })
                .fail(function (xhr, textStatus, errorThrown) {
                    obtener_hacienda(cedula);
                });
        });
    } //Fin if cedula
} //Fin de obtener un contribuyente del ministerio de hacienda

/**
 * Llenar el campo de nombre del contribuyente
 * @param {string} nombre Nombre del contribuyente
 * @param {string} form_activo Nombre del formulario activo
 */
function llenar_nombre(nombre, form_activo) {
    const activeForm = $("#" + form_activo);

    activar_campos_cedula("agregar-todos", form_activo);

    //Poner la prmera letra de cada palabra en mayuscula
    nombre = nombre.replace(/\w\S*/g, function (txt) {
        return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
    });

    //Si el nombre contiene Sociedad De Responsabilidad Limitada, Sociedad Anonima, ETC; cambiar por "S.R.L.", "S.A.", etc
    if (nombre.includes("Sociedad De Responsabilidad Limitada")) {
        nombre = nombre.replace("Sociedad De Responsabilidad Limitada", "S.R.L.");
    }

    if (nombre.includes("Sociedad Anonima")) {
        nombre = nombre.replace("Sociedad Anonima", "S.A.");
    }

    activeForm.find(".businessName").val(nombre);

    activeForm.find(".name").show();

    activar_campos_cedula("almacenando", form_activo);

    //Cerrar el card de ubicaciones y contacto
    activeForm.find(".card-ubicacion").CardWidget("expand");
    activeForm.find(".card-contacto").CardWidget("expand");

    //Bloquear el btn-tool del card de ubicaciones y el de contacto
    activeForm.find(".card-ubicacion").find(".btn-tool").prop("disabled", false);
    activeForm.find(".card-contacto").find(".btn-tool").prop("disabled", false);
}

function obtener_hacienda(cedula) {
    const activeForm = $("#" + form_activo);

    Pace.track(function () {
        $.ajax({
            url: "https://api.hacienda.go.cr/fe/ae?identificacion=" + cedula,
            method: "get",
        })
            .done(function (response) {
                if (response.code != 400) {
                    nombre = response.nombre;

                    llenar_nombre(nombre, form_activo);
                } else {
                    mensajeAutomatico("Atencion", "No se encontro informacion del contribuyente", "info");

                    //Cerrar el card de ubicaciones y contacto
                    activeForm.find(".card-ubicacion").CardWidget("collapse");
                    activeForm.find(".card-contacto").CardWidget("collapse");

                    //Bloquear el btn-tool del card de ubicaciones y el de contacto
                    activeForm.find(".card-ubicacion").find(".btn-tool").prop("disabled", true);
                    activeForm.find(".card-contacto").find(".btn-tool").prop("disabled", true);
                }
            })
            .fail(function (xhr, textStatus, errorThrown) {
                //activar_campos_cedula("agregar-todos", form_activo);
                mensajeAutomatico("Atencion", "No se encontro informacion del contribuyente", "info");

                //Cerrar el card de ubicaciones y contacto
                activeForm.find(".card-ubicacion").CardWidget("collapse");
                activeForm.find(".card-contacto").CardWidget("collapse");

                //Bloquear el btn-tool del card de ubicaciones y el de contacto
                activeForm.find(".card-ubicacion").find(".btn-tool").prop("disabled", true);
                activeForm.find(".card-contacto").find(".btn-tool").prop("disabled", true);
            });
    });
}

function validar_extranjero() {
    const activeForm = $("#" + form_activo);
    const nationality = activeForm.find(".nationality");

    //Obtener el data-serviceStatus del option seleccionado
    const serviceStatus = $(nationality).find("option:selected").data("servicestatus");

    const identifications = activeForm.find(".identification_typeId option");

    //Si el servicio esta inactivo se deben ocultar los option de tipo de identificacion que sean diferente de 99
    if (serviceStatus != 1 || $(nationality).val() == "") {
        //Recorrer los options con un each
        $.each(identifications, function (i, option) {
            //Mostrar solo el option con data-code 99
            if ($(option).data("code") != 99) {
                option.hidden = true;
            } else {
                option.hidden = false;
                option.selected = true;
            }
        });

        activar_campos_cedula("agregar-extranjero", form_activo);
    } else {
        const customerType = activeForm.find(".customerType-radio:checked").val();

        //Recorrer los options con un each
        $.each(identifications, function (i, option) {
            const code = $(option).data("code");

            if (customerType == 1) {
                //Mostrar solo el option con data-code 01, 03 y 04
                if (code == "01" || code == "03" || code == "04" || $(option).val() == "") {
                    option.hidden = false;
                } else {
                    option.hidden = true;
                }
            } else {
                //Mostrar solo el option con data-code 02 y 04
                if (code == "02" || code == "04" || $(option).val() == "") {
                    option.hidden = false;
                } else {
                    option.hidden = true;
                }
            }
        });

        //Colocar el tipo de identificacion en ""
        activeForm.find(".identification_typeId").val("");

        activar_campos_cedula("agregar-nacional", form_activo);
    }

    validarUbicacion();
}

/**
 * Cambiar el tipo de cliente seleccionado
 *
 * @param {int} customerType Tipo de cliente
 */
function changeCustomerType(customerType) {
    const activeForm = $("#" + form_activo);

    //Obtener el radio seleccionado
    const radio = activeForm.find(".customerType-" + customerType);

    const identification = activeForm.find(".identification_number");

    if (identification.val() != "") {
        Swal.fire({
            title: "Atención",
            text: "Al cambiar el tipo de cliente se borrará la cédula ingresada",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
                vaciar_cedula();

                //Quitar el radio seleccionado de los otros customerType
                const radios = activeForm.find(".customerType-radio").not(radio);

                radios.prop("checked", false);

                radio.prop("checked", true);

                validar_extranjero();
            } else {
                radio.prop("checked", false);
            }
        });
    } else {
        //vaciar_cedula();

        //Quitar el radio seleccionado de los otros customerType
        const radios = activeForm.find(".customerType-radio").not(radio);

        radios.prop("checked", false);

        radio.prop("checked", true);

        validar_extranjero();
    }
}

/**Vaciar los campos relacionados con la cedula de un contribuyente */
function vaciar_cedula() {
    const activeForm = $("#" + form_activo);

    activeForm.find(".identification_number").val("");
    activeForm.find(".businessName").val("");
    activeForm.find(".identification_typeId").val("");

    //activar_campo_clase("identification_number", true, form_activo);

    activeForm.find(".name").hide();
    //$("#" + form_activo).find(".nationality").val('');

    activar_campos_cedula("agregar", form_activo);
} //Fin de vaciar los campos relacionados con la cedula de un contribuyente

/**
 *
 * @param {string} cedula Número de identificación
 * @param {string} tipo_cedula Tipo de identificación
 * @returns {boolean} Indica si la identificación tiene el formato correcto
 */
function validarFormatoIdentificacion(cedula) {
    const activeForm = $("#" + form_activo);
    let formato = false;
    let cedula_formateada = "";

    const idNumberType = activeForm.find(".identification_typeId");
    const tipo_cedula = $(idNumberType).find("option:selected").data("code");

    switch (tipo_cedula) {
        case "01":
            //Validar si la identificacion tiene 9 digitos o el formato 1-0234-0567 (expresion regular)
            if (cedula.length == 9 || cedula.match(/^\d{1}-\d{4}-\d{4}$/)) {
                formato = true;

                if (!cedula.match(/^\d{1}-\d{4}-\d{4}$/)) {
                    //Obtener el primer digito
                    const primer_digito = cedula.substring(0, 1);

                    //Obtener el del segundo al quinto digito
                    const segundo_digito = cedula.substring(1, 5);

                    //Obtener el sexto digito al noveno digito
                    const tercer_digito = cedula.substring(5, 9);

                    cedula_formateada = primer_digito + "-" + segundo_digito + "-" + tercer_digito;
                } else {
                    cedula_formateada = cedula;
                    cedula = cedula.replace(/-/g, "");
                }
            }
            break;

        case "02":
            //Formato de cedula
            //3-123-456700
            //Validar si la identificacion tiene 10 digitos o el formato 3-123-456700 (expresion regular)
            if (cedula.length == 10 || cedula.match(/^\d{1}-\d{3}-\d{6}$/)) {
                formato = true;

                if (!cedula.match(/^\d{1}-\d{3}-\d{6}$/)) {
                    //Obtener el primer digito
                    const primer_digito = cedula.substring(0, 1);

                    //Obtener el del segundo al cuarto digito
                    const segundo_digito = cedula.substring(1, 4);

                    //Obtener todos los restantes digitos
                    const tercer_digito = cedula.substring(4, 10);

                    cedula_formateada = primer_digito + "-" + segundo_digito + "-" + tercer_digito;
                } else {
                    cedula_formateada = cedula;
                    cedula = cedula.replace(/-/g, "");
                }
            }

            break;
        case "03":
            //Validar si la identificacion tiene 11 digitos y no tiene guiones
            if (cedula.length == 11 && !cedula.includes("-")) {
                formato = true;
                cedula_formateada = cedula;
            }

            break;

        case "04":
            //Validar si la identificacion tiene 10
            if (cedula.length == 10 && !cedula.includes("-")) {
                formato = true;
                cedula_formateada = cedula;
            }

            break;

        default:
            formato = true;
            cedula_formateada = cedula;
            break;
    }

    if (formato == true && idNumberType.val() != "") {
        if (tipo_cedula != "99") {
            obtener_contribuyente(cedula);
        }

        //Quitar el borde rojo en el campo de cedula
        activeForm.find(".identification_number").removeClass("border-danger");

        //Quitar el borde rojo en el campo de tipo de cedula
        activeForm.find(".identification_typeId").removeClass("border-danger");

        //Colocar la cedula formateada
        activeForm.find(".identification_number").val(cedula_formateada);
    } else {
        if (idNumberType.val() != "") {
            //Colocar el borde rojo en el campo de cedula
            activeForm.find(".identification_number").addClass("border-danger");

            //Quitar el borde rojo en el campo de tipo de cedula
            activeForm.find(".identification_typeId").removeClass("border-danger");
        } else {
            activeForm.find(".identification_number").removeClass("border-danger");

            //Agregar el borde rojo en el campo de tipo de cedula
            activeForm.find(".identification_typeId").addClass("border-danger");
        }

        //Vaciar el campo de nombre
        activeForm.find(".businessName").val("");

        //Ocultar el campo de nombre
        activeForm.find(".name").hide();
    }

    //Activar el boton de eliminar cedula (btn-dlt-id)
    activar_campo_clase("btn-dlt-id", false, form_activo);
} //Fin de formatear cedula

function selectCustomerType(customerType) {
    const activeForm = $("#" + form_activo);

    //Obtener el radio seleccionado
    const radio = activeForm.find(".customerType-" + customerType);

    radio.prop("checked", true);
}

$(document).ready(function () {
    //Cuando cambia el .customerType
    $(document).on("change", ".customerType-radio", function () {
        changeCustomerType($(this).val());
    });

    //Cuando cambia el .nationality
    $(document).on("change", ".nationality", function () {
        validar_extranjero();
    });

    //Cuando cambia el .identification_number
    $(document).on("change keyup", ".identification_number", function () {
        const cedula = $(this).val();

        //Validar el formato de la cedula
        validarFormatoIdentificacion(cedula);
    });

    //Cuando cambia el .identification_typeId
    $(document).on("change", ".identification_typeId", function () {
        const cedula = $("#" + form_activo)
            .find(".identification_number")
            .val();

        //Validar el formato de la cedula
        validarFormatoIdentificacion(cedula);
    });
});
