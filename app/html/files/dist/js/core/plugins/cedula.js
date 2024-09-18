/**Obtener un contribuyente del ministerio de hacienda */
function obtener_contribuyente(cedula = null) {
    var nombre = "";
    var tipoIdentificacion = "";

    if (cedula != "" && cedula) {
        //Si la cedula es menor a 9 digitos
        if (cedula.length < 9) {
            mensajeAutomatico("Atencion", "La identificacion indicada es muy corta", "error");
            return false;
        }

        Pace.track(function () {
            $.ajax({
                url: "https:/apis.gometa.org/cedulas/" + cedula,
                method: "get",
            })
                .done(function (response) {
                    if (!response.error) {
                        //Si hay elementos en el campo results
                        if (response.results.length > 0) {
                            //response = true;

                            //Obtener el primer elemento del array
                            var elemento = response.results[0];

                            //Asignar los valores al formulario
                            nombre = elemento.fullname;
                            tipoIdentificacion = response.tipoIdentificacion;

                            //Si el submodulo activo es usuarios, crear el nombre de usuario
                            if (submodulo_activo == "usuarios") {
                                //Si el tipo de identificacion es 01
                                if (response.tipoIdentificacion == "01") {
                                    {
                                        //Obtener la primera letra del nombre
                                        var nombre_usuario = nombre.substring(0, 1);

                                        //Poner el apellido solo con la primera letra en mayuscula
                                        var apellido = elemento.lastname1;

                                        apellido = apellido.replace(/\w\S*/g, function (txt) {
                                            return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
                                        });

                                        nombre_usuario = nombre_usuario + apellido;

                                        //Asignar el nombre de usuario
                                        $("#" + form_activo)
                                            .find(".nombre_usuario")
                                            .val(nombre_usuario);
                                    }

                                    //Si el tipo de identificacion es 02
                                } else if (response.tipoIdentificacion == "02") {
                                    mensajeAutomatico("Atencion", "El usuario debe ser una persona fisica", "info");
                                    return false;
                                }

                                //Desactivar el nombre de usuario
                                $("#" + form_activo)
                                    .find(".nombre_usuario")
                                    .attr("disabled", true);
                                $("#" + form_activo)
                                    .find(".nombre_usuario")
                                    .attr("readonly", true);
                            } //Fin de validacion de submodulo activo

                            llenar_identificacion(nombre, cedula, tipoIdentificacion, form_activo);
                        } //Fin de validacion de resultados

                        //Si no hay elementos en el campo results, buscar en la base de datos del ministerio de hacienda
                        else {
                            obtener_hacienda(cedula);
                        }
                    }
                })
                .fail(function (xhr, textStatus, errorThrown) {
                    obtener_hacienda(cedula);
                });
        });
    } //Fin if cedula
} //Fin de obtener un contribuyente del ministerio de hacienda

function llenar_identificacion(nombre, cedula, tipoIdentificacion, form_activo) {
    if (tipoIdentificacion != "" && nombre != "") {
        activar_campos_cedula("agregar-todos", form_activo);

        //Poner la prmera letra de cada palabra en mayuscula
        nombre = nombre.replace(/\w\S*/g, function (txt) {
            return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
        });

        cedula_formateada = formatear_cedula(cedula, tipoIdentificacion);

        //Si el tipo de identificacion es 02
        if (tipoIdentificacion == "02") {
            //Si el nombre contiene Sociedad De Responsabilidad Limitada, Sociedad Anonima, ETC; cambiar por "S.R.L.", "S.A.", etc
            if (nombre.includes("Sociedad De Responsabilidad Limitada")) {
                nombre = nombre.replace("Sociedad De Responsabilidad Limitada", "S.R.L.");
            }
            if (nombre.includes("Sociedad Anonima")) {
                nombre = nombre.replace("Sociedad Anonima", "S.A.");
            }
        }

        $("#" + form_activo)
            .find(".identification_number")
            .val(cedula_formateada);

        $("#" + form_activo)
            .find(".businessName")
            .val(nombre);

        //                        $("#" + form_activo).find(".identification_typeId").val(response.tipoIdentificacion);

        //Se debe asignar el tipo de identificacion de acuerdo al campo data-code de cada elemento del select
        //Ejemplo:
        //response.tipoIdentificacion = '01';
        //<option value="1" data-code="01">Fisica</option>
        const identifications = $("#" + form_activo).find(".identification_typeId option");

        //Recorrer los options con un each
        $.each(identifications, function (i, option) {
            //Si el data-code es igual al tipo de identificacion
            if ($(option).data("code") == tipoIdentificacion) {
                option.selected = true;
            } else {
                option.selected = false;
            }
        });

        $("#" + form_activo)
            .find(".nationality")
            .val(188);

        activar_campos_cedula("almacenando", form_activo);
    } else {
        $("#" + form_activo)
            .find(".businessName")
            .val("");
        $("#" + form_activo)
            .find(".identification_typeId")
            .val("");
        $("#" + form_activo)
            .find(".nationality")
            .val("");

        activar_campos_cedula("agregar-todos", form_activo);

        mensajeAutomatico("Atencion", "Debe ingresar la información manualmente", "info");
    }
}

function obtener_hacienda(cedula) {
    $.ajax({
        url: "https://api.hacienda.go.cr/fe/ae?identificacion=" + cedula,
        method: "get",
    })
        .done(function (response) {
            if (response.code != 400) {
                nombre = response.nombre;
                tipoIdentificacion = response.tipoIdentificacion;

                llenar_identificacion(nombre, cedula, tipoIdentificacion, form_activo);
            } else {
                activar_campos_cedula("agregar-todos", form_activo);

                mensajeAutomatico("Atencion", "No se encontro informacion del contribuyente", "info");
            }
        })
        .fail(function (xhr, textStatus, errorThrown) {
            activar_campos_cedula("agregar-todos", form_activo);
            mensajeAutomatico("Atencion", "No se encontro informacion del contribuyente", "info");
        });
}

function validar_extranjero(select) {
    const form = "#" + form_activo;
    const countryCode = $(select).val();

    //Obtener el data-serviceStatus del option seleccionado
    const serviceStatus = $(select).find("option:selected").data("servicestatus");

    //Si el servicio esta inactivo se deben ocultar los option de tipo de identificacion que sean diferente de 99
    if (serviceStatus != 1) {
        const identifications = $(form).find(".identification_typeId option");

        //Recorrer los options con un each
        $.each(identifications, function (i, option) {
            //Mostrar solo el option con data-code 99
            if ($(option).data("code") != 99) {
                option.hidden = true;
            } else {
                option.hidden = false;
            }
        });

        activar_campos_cedula("agregar-todos", form_activo);
    } else {
        const identifications = $(form).find(".identification_typeId option");

        //Recorrer los options con un each
        $.each(identifications, function (i, option) {
            //Mostrar todos los options
            option.hidden = false;
        });

        activar_campos_cedula("agregar", form_activo);
    }

    ubicacionExtranjero(countryCode);
}
