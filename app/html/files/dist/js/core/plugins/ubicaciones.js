function obtener_cantones(countryCode = null, stateId = null, countyId = null, ver = false) {
    if (countryCode == null) {
        countryCode = $("#" + elemento_activo)
            .find(".residence_countryCode")
            .val();
    }

    if (stateId == null) {
        stateId = $("#" + elemento_activo)
            .find(".residence_stateId")
            .val();
    }

    var html = crear_option("", "Seleccionar");

    $("#" + elemento_activo)
        .find(".residence_districtId")
        .html(html);
    activar_campo_clase("residence_districtId", true, elemento_activo);

    $("#" + elemento_activo)
        .find(".residence_neighborhoodId")
        .html(html);
    activar_campo_clase("residence_neighborhoodId", true, elemento_activo);

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

            $("#" + elemento_activo)
                .find(".residence_countyId")
                .html(html);

            activar_campo_clase("residence_countyId", ver, elemento_activo);
        });
    });
}

function obtener_provincias(countryCode = null, stateId = null, ver = false) {
    if (countryCode == null) {
        countryCode = $("#" + elemento_activo)
            .find(".residence_countryCode")
            .val();
    }

    var html = crear_option("", "Seleccionar");

    $("#" + elemento_activo)
        .find(".residence_countyId")
        .html(html);
    activar_campo_clase("residence_countyId", true, elemento_activo);

    $("#" + elemento_activo)
        .find(".residence_districtId")
        .html(html);
    activar_campo_clase("residence_districtId", true, elemento_activo);

    $("#" + elemento_activo)
        .find(".residence_neighborhoodId")
        .html(html);
    activar_campo_clase("residence_neighborhoodId", true, elemento_activo);

    data = {
        countryCode: countryCode,
    };

    Pace.track(function () {
        $.ajax({
            url: base + "ubicacion/provincias",
            dataType: "json",
            data: data,
            method: "GET",
        }).done(function (response) {
            if (response) {
                //0: {stateId:1 , nom_provincia: residence_stateId}
                $.each(response, function (i, provincia) {
                    if (stateId != null && stateId == provincia.stateId) {
                        html += crear_option(provincia.stateId, provincia.stateName, true);
                    } else {
                        html += crear_option(provincia.stateId, provincia.stateName);
                    }
                });
            }

            $("#" + elemento_activo)
                .find(".residence_stateId")
                .html(html);

            activar_campo_clase("residence_stateId", ver, elemento_activo);
        });
    });
}

/**Obtener todos los distritos de un residence_countyId */
function obtener_distritos(countryCode = null, stateId = null, countyId = null, districtId = null, ver = false) {
    if (countryCode == null) {
        var countryCode = $("#" + elemento_activo)
            .find(".residence_countryCode")
            .val();
    }

    if (stateId == null) {
        var stateId = $("#" + elemento_activo)
            .find(".residence_stateId")
            .val();
    }

    if (countyId == null) {
        var countyId = $("#" + elemento_activo)
            .find(".residence_countyId")
            .val();
    }

    var html = crear_option("", "Seleccionar");

    $("#" + elemento_activo)
        .find(".residence_neighborhoodId")
        .html(html);
    activar_campo_clase("residence_neighborhoodId", true, elemento_activo);

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

            $("#" + elemento_activo)
                .find(".residence_districtId")
                .html(html);

            activar_campo_clase("residence_districtId", ver, elemento_activo);
        });
    });
}

/**Obtener todos los barrios de un residence_districtId */
function obtener_barrios(
    countryCode = null,
    stateId = null,
    countyId = null,
    districtId = null,
    neighborhoodId = null,
    ver = false
) {
    if (countryCode == null) {
        var countryCode = $("#" + elemento_activo)
            .find(".residence_countryCode")
            .val();
    }

    if (stateId == null) {
        var stateId = $("#" + elemento_activo)
            .find(".residence_stateId")
            .val();
    }

    if (countyId == null) {
        var countyId = $("#" + elemento_activo)
            .find(".residence_countyId")
            .val();
    }

    if (districtId == null) {
        var districtId = $("#" + elemento_activo)
            .find(".residence_districtId")
            .val();
    }

    var html = crear_option("", "Seleccionar");

    data = {
        countryCode: countryCode,
        stateId: stateId,
        countyId: countyId,
        districtId: districtId,
    };

    Pace.track(function () {
        $.ajax({
            url: base + "ubicacion/barrios",
            dataType: "json",
            data: data,
            method: "GET",
        }).done(function (response) {
            if (response) {
                $.each(response, function (i, barrio) {
                    if (neighborhoodId != null && neighborhoodId == barrio.neighborhoodId) {
                        html += crear_option(barrio.neighborhoodId, barrio.neighborhoodName, true);
                    } else {
                        html += crear_option(barrio.neighborhoodId, barrio.neighborhoodName);
                    }
                });
            }

            $("#" + elemento_activo)
                .find(".residence_neighborhoodId")
                .html(html);

            activar_campo_clase("residence_neighborhoodId", ver, elemento_activo);
        });
    });
}

/**Llenar la ubicacion */
function llenarUbicacion(residence, ver = false) {
    var html = crear_option("", "Seleccionar");

    $("#" + elemento_activo)
        .find(".residence_countyId")
        .html(html);
    //activar_campo_clase('residence_countyId', true, elemento_activo);

    $("#" + elemento_activo)
        .find(".residence_districtId")
        .html(html);
    //activar_campo_clase('residence_districtId', true, elemento_activo);

    $("#" + elemento_activo)
        .find(".residence_neighborhoodId")
        .html(html);
    activar_campo_clase("residence_neighborhoodId", true, elemento_activo);

    let countryCode = residence.countryCode;

    if (!ubicacionExtranjero(countryCode)) {
        let stateId = residence.stateId;
        let countyId = residence.countyId;
        let districtId = residence.districtId;
        let neighborhoodId = residence.neighborhoodId;

        obtener_provincias(countryCode, stateId, ver);

        obtener_cantones(countryCode, stateId, countyId, ver);

        obtener_distritos(countryCode, stateId, countyId, districtId, ver);

        obtener_barrios(countryCode, stateId, countyId, districtId, neighborhoodId, ver);
    }

    if (residence.address != null) {
        // Colocar la informacion en el campo de direccion (Text Area)
        const elemento = document.getElementById(elemento_activo);
        const textarea = elemento.querySelector(".residence_address");

        textarea.value = residence.address;
    }
} //Fin de la funcion

/**Vaciar los campos de ubicacion */
function vaciar_ubicacion() {
    var html = crear_option("", "Seleccionar");

    $("#" + elemento_activo)
        .find(".residence_countryCode")
        .val("");

    $("#" + elemento_activo)
        .find(".residence_stateId")
        .html(html);
    $("#" + elemento_activo)
        .find(".residence_countyId")
        .html(html);
    $("#" + elemento_activo)
        .find(".residence_districtId")
        .html(html);
    $("#" + elemento_activo)
        .find(".residence_neighborhoodId")
        .html(html);

    desactivar_ubicaciones("agregar");
}

/**Desactivar los campos de ubicacion */
function desactivar_ubicaciones(type = "agregar") {
    if (type == "agregar") {
        activar_campo_clase("residence_countryCode", true, elemento_activo);

        activar_campo_clase("residence_stateId", true, elemento_activo);
        activar_campo_clase("residence_countyId", true, elemento_activo);
        activar_campo_clase("residence_districtId", true, elemento_activo);
        activar_campo_clase("residence_neighborhoodId", true, elemento_activo);
    }
}

function ubicacionExtranjero(countryCode = null) {
    let isForeign = false;

    if (countryCode == null) {
        countryCode = $("#" + elemento_activo)
            .find(".nationality")
            .val();
    }

    vaciar_ubicacion();

    //Colocar el valor del pais en el campo de pais
    $("#" + elemento_activo)
        .find(".residence_countryCode")
        .val(countryCode);

    //Obtener el data-serviceStatus del option seleccionado
    const serviceStatus = $("#" + elemento_activo)
        .find(".residence_countryCode option:selected")
        .data("servicestatus");

    if (serviceStatus != 1) {
        //Ocultar los campos de ubicacion del elemento activo
        $("#" + elemento_activo)
            .find(".ubicacion")
            .hide();

        let html = crear_option("0", "Otros", true);

        //Colocar el html en los campos de ubicacion (Provincia, Canton, Distrito, Barrio)
        $("#" + elemento_activo)
            .find(".residence_stateId")
            .html(html);

        $("#" + elemento_activo)
            .find(".residence_countyId")
            .html(html);

        $("#" + elemento_activo)
            .find(".residence_districtId")
            .html(html);

        $("#" + elemento_activo)
            .find(".residence_neighborhoodId")
            .html(html);
    } else {
        //Mostrar los campos de ubicacion del elemento activo
        $("#" + elemento_activo)
            .find(".ubicacion")
            .show();
    }

    //Desactivar el campo de pais
    activar_campo_clase("residence_countryCode", true, elemento_activo);

    return isForeign;
}
