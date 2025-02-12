/**
 * Obtener las provincias de un país
 * @param {string} countryCode Código del país
 * @param {number} stateId Código de la provincia
 * @param {boolean} ver Indica si se debe habilitar el campo
 */
function obtener_provincias(stateId = null, ver = false) {
    const activeElement = $("#" + elemento_activo);

    const countryCode = activeElement.find(".nationality").val();

    var html = crear_option("", "Seleccionar");

    activeElement.find(".residence_countyId").html(html);
    activar_campo_clase("residence_countyId", true, elemento_activo);

    activeElement.find(".residence_districtId").html(html);
    activar_campo_clase("residence_districtId", true, elemento_activo);

    /*activeElement
        .find(".residence_neighborhoodId")
        .html(html);
    activar_campo_clase("residence_neighborhoodId", true, elemento_activo);*/

    Pace.track(function () {
        $.ajax({
            url: base + "ubicacion/provincias",
            dataType: "json",
            data: {
                countryCode: countryCode,
            },
            method: "GET",
        }).done(function (response) {
            if (response) {
                //0: {stateId:1 , nom_provincia: residence_stateId}
                $.each(response, function (i, provincia) {
                    console.log(provincia.stateId);
                    console.log(stateId);

                    if (stateId != null && stateId == provincia.stateId) {
                        html += crear_option(provincia.stateId, provincia.stateName, true);
                    } else {
                        html += crear_option(provincia.stateId, provincia.stateName);
                    }
                });
            }

            activeElement.find(".residence_stateId").html(html);

            activar_campo_clase("residence_stateId", ver, elemento_activo);
        });
    });

    isOtherLocation(elemento_activo);
}

/**
 * Obtener los cantones de un país y una provincia
 * @param {string} countryCode Código del país
 * @param {number} stateId Código de la provincia
 * @param {number} countyId Código del cantón
 * @param {boolean} ver Indica si se debe habilitar el campo
 */
function obtener_cantones(countryCode = null, stateId = null, countyId = null, ver = false) {
    const activeElement = $("#" + elemento_activo);

    if (countryCode == null) {
        countryCode = activeElement.find(".nationality").val();
    }

    if (stateId == null) {
        stateId = activeElement.find(".residence_stateId").val();
    }

    var html = crear_option("", "Seleccionar");

    activeElement.find(".residence_districtId").html(html);
    activar_campo_clase("residence_districtId", true, elemento_activo);

    if (stateId != "") {
        data = {
            countryCode: countryCode,
            stateId: stateId,
        };

        Pace.track(function () {
            $.ajax({
                url: base + "ubicacion/cantones",
                dataType: "json",
                data: data,
                method: "GET",
            }).done(function (response) {
                if (response) {
                    $.each(response, function (i, canton) {
                        if (countyId != null && countyId == canton.countyId) {
                            html += crear_option(canton.countyId, canton.countyName, true);
                        } else {
                            html += crear_option(canton.countyId, canton.countyName);
                        }
                    });
                }

                activeElement.find(".residence_countyId").html(html);
                activar_campo_clase("residence_countyId", ver, elemento_activo);
            });
        });
    } else {
        activeElement.find(".residence_countyId").html(html);
        activar_campo_clase("residence_countyId", true, elemento_activo);
    }

    isOtherLocation(elemento_activo);
}

/**Obtener todos los distritos de un residence_countyId */
function obtener_distritos(countryCode = null, stateId = null, countyId = null, districtId = null, ver = false) {
    const activeElement = $("#" + elemento_activo);

    if (countryCode == null) {
        var countryCode = activeElement.find(".nationality").val();
    }

    if (stateId == null) {
        var stateId = activeElement.find(".residence_stateId").val();
    }

    if (countyId == null) {
        var countyId = activeElement.find(".residence_countyId").val();
    }

    var html = crear_option("", "Seleccionar");

    if (stateId != "" && countyId != "") {
        data = {
            countryCode: countryCode,
            stateId: stateId,
            countyId: countyId,
        };

        Pace.track(function () {
            $.ajax({
                url: base + "ubicacion/distritos",
                dataType: "json",
                data: data,
                method: "GET",
            }).done(function (response) {
                if (response) {
                    $.each(response, function (i, distrito) {
                        if (districtId != null && districtId == distrito.districtId) {
                            html += crear_option(distrito.districtId, distrito.districtName, true);
                        } else {
                            html += crear_option(distrito.districtId, distrito.districtName);
                        }
                    });
                }

                activeElement.find(".residence_districtId").html(html);
                activar_campo_clase("residence_districtId", ver, elemento_activo);

                isOtherLocation(elemento_activo);
            });
        });
    } else {
        activeElement.find(".residence_districtId").html(html);
        activar_campo_clase("residence_districtId", true, elemento_activo);

        isOtherLocation(elemento_activo);
    }
}

/**
 * Llena la ubicación de un contribuyente
 *
 * @param {*} residence Residencia del contribuyente
 * @param {string} countryCode Codigo ISO de la ubicación a llenar
 * @param {boolean} ver Indica si está en modo edición o vista
 */
function llenarUbicacion(residence, countryCode, ver = false) {
    var html = crear_option("", "Seleccionar");

    const activeElement = $("#" + elemento_activo);

    activeElement.find(".residence_countyId").html(html);
    //activar_campo_clase('residence_countyId', true, elemento_activo);

    activeElement.find(".residence_districtId").html(html);
    //activar_campo_clase('residence_districtId', true, elemento_activo);

    /*activeElement
        .find(".residence_neighborhoodId")
        .html(html);
    activar_campo_clase("residence_neighborhoodId", true, elemento_activo);*/

    if (!validarUbicacion()) {
        //let neighborhoodId = residence.neighborhoodId;

        if (residence.id != 0) {
            const stateId = residence.stateId;
            const countyId = residence.countyId;
            const districtId = residence.districtId;

            obtener_provincias(stateId, ver);
            obtener_cantones(countryCode, stateId, countyId, ver);

            obtener_distritos(countryCode, stateId, countyId, districtId, ver);

            isOtherLocation(elemento_activo);
        } else {
            obtener_provincias(null, ver);
        }

        //obtener_barrios(countryCode, stateId, countyId, districtId, neighborhoodId, ver);
    }

    if (residence.address != null) {
        // Colocar la informacion en el campo de direccion (Text Area)
        const elemento = document.getElementById(elemento_activo);
        const textarea = elemento.querySelector(".residence_address");

        textarea.value = residence.address;
    }
} //Fin de la funcion

/**
 * Vaciar los campos de ubicacion
 */
function vaciar_ubicacion() {
    const html = crear_option("", "Seleccionar");
    const activeElement = $("#" + elemento_activo);

    activeElement.find(".residence_stateId").html(html);

    activeElement.find(".residence_countyId").html(html);

    activeElement.find(".residence_districtId").html(html);

    //activeElement.find(".residence_neighborhoodId").html(html);

    desactivar_ubicaciones("agregar");
}

/**Desactivar los campos de ubicacion */
function desactivar_ubicaciones(type = "agregar", activeElement = "") {
    if ((activeElement = "")) {
        activeElement = elemento_activo;
    }
    if (type == "agregar") {
        activar_campo_clase("residence_stateId", false, activeElement);
        activar_campo_clase("residence_countyId", true, activeElement);
        activar_campo_clase("residence_districtId", true, activeElement);
        //activar_campo_clase("residence_neighborhoodId", true, elemento_activo);
    } else if ((type = "editar")) {
        activar_campo_clase("residence_stateId", false, activeElement);
        activar_campo_clase("residence_countyId", false, activeElement);
        activar_campo_clase("residence_districtId", false, activeElement);
        //activar_campo_clase("residence_neighborhoodId", true, elemento_activo);
    } else {
        activar_campo_clase("residence_stateId", true, activeElement);
        activar_campo_clase("residence_countyId", true, activeElement);
        activar_campo_clase("residence_districtId", true, activeElement);
        //activar_campo_clase("residence_neighborhoodId", false, elemento_activo);
    }
}

function validarUbicacion() {
    let isForeign = false;

    const activeElement = $("#" + elemento_activo);

    //Obtener el data-serviceStatus del option seleccionado
    const serviceStatus = activeElement.find(".nationality option:selected").data("servicestatus");

    if (serviceStatus != 1) {
        vaciar_ubicacion();

        //Ocultar los campos de ubicacion del elemento activo
        activeElement.find(".ubicacion").hide();

        //Quitar el atributo required de los select de ubicacion
        //activeElement.find(".ubicacion select").removeAttr("required");

        isForeign = true;
    } else {
        if (estado_form == "agregar") {
            obtener_provincias();
        }

        //Mostrar los campos de ubicacion del elemento activo
        activeElement.find(".ubicacion").show();

        //Colocar el atributo required de los select de ubicacion
        //activeElement.find(".ubicacion select").attr("required", true);

        desactivar_ubicaciones("agregar");
    }

    //Colocar el mismo codigo en el campo .personalPhone_countryCode
    activeElement.find(".personalPhone_countryCode").val("188"); //activeElement.find(".nationality").val());

    activar_campo_clase("personalPhone_countryCode", true, elemento_activo);

    return isForeign;
}

/**
 *
 * @returns Validacion de ubicación vacia
 */
function isOtherLocation(formulario = "", purchaseInvoice = false) {
    if (formulario == "") {
        formulario = elemento_activo;
    }

    const activeElement = $("#" + formulario);

    //Validar si la provincia, canton, distrito  y barrio son otras locaciones
    const stateId = activeElement.find(".residence_stateId").val();
    const countyId = activeElement.find(".residence_countyId").val();
    const districtId = activeElement.find(".residence_districtId").val();

    //Obtener el address desde el textArea de residence_address
    const address = activeElement.find(".residence_address").val();

    let valid = true;

    //Si es una factura de compra y la direccion está vacia, poner el borde rojo, si no quitarlo
    if (purchaseInvoice == true && address == "") {
        activeElement.find(".residence_address").addClass("border-danger");

        valid = false;
    } else {
        activeElement.find(".residence_address").removeClass("border-danger");
    }

    //Si los tres tienen el valor ""
    if (stateId == "" && countyId == "" && districtId == "") {
        if (purchaseInvoice == false) {
            //Eliminar el borde rojo de los campos
            activeElement.find(".residence_stateId").removeClass("border-danger");
            activeElement.find(".residence_countyId").removeClass("border-danger");
            activeElement.find(".residence_districtId").removeClass("border-danger");
        } else {
            activeElement.find(".residence_stateId").addClass("border-danger");
            activeElement.find(".residence_countyId").addClass("border-danger");
            activeElement.find(".residence_districtId").addClass("border-danger");

            valid = false;
        }
    } else {
        if (stateId != "" && countyId != "" && districtId != "") {
            //Eliminar el borde rojo de los campos
            activeElement.find(".residence_stateId").removeClass("border-danger");
            activeElement.find(".residence_countyId").removeClass("border-danger");
            activeElement.find(".residence_districtId").removeClass("border-danger");
        }

        //Si el canton
        if (countyId == "") {
            activeElement.find(".residence_countyId").addClass("border-danger");

            valid = false;
        } else {
            activeElement.find(".residence_countyId").removeClass("border-danger");
        }

        if (districtId == "") {
            activeElement.find(".residence_districtId").addClass("border-danger");

            valid = false;
        } else {
            activeElement.find(".residence_districtId").removeClass("border-danger");
        }

        if(address == "") {
            activeElement.find(".residence_address").addClass("border-danger");

            valid = false;
        } else {
            activeElement.find(".residence_address").removeClass("border-danger");
        }
    }

    return valid;
}
