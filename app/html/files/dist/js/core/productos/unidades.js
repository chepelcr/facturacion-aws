function getUnitCode(select) {
    const form = "#" + form_activo;
    const value = $(select).val();
    
    if(value == ""){
        //Vaciar el campo de unidad de medida comercial
        $(form).find(".measurementUnit_commercialUnit").val("");
        //Deshabilitar el campo de unidad de medida comercial
        activar_campo_clase("measurementUnit_commercialUnit", true, form_activo);

        return;
    }

    const option = $(select).find("option:selected");
    let code = $(option).data("code");

    //Validar si el codigo es un numero y pasarlo a string
    if(typeof code == "number"){
        code = code.toString();
    }

    //Validar si el codigo contiene la palabra 'Otros'
    if (code != undefined && code.includes("Otros")) {
        //Habilitar el campo de unidad de medida comercial
        activar_campo_clase("measurementUnit_commercialUnit", false, form_activo);

        //Vaciar el campo de unidad de medida comercial
        $(form).find(".measurementUnit_commercialUnit").val("");
    } else {
        //Colocar el code en el campo unit_commercialUnit del formulario activo
        $(form).find(".measurementUnit_commercialUnit").val(code);

        //Deshabilitar el campo de unidad de medida comercial
        activar_campo_clase("measurementUnit_commercialUnit", true, form_activo);
    }
}

function activarUnidadComercial(estado = "ver", form_activo = "") {
    const form = "#" + form_activo;
    const select = $(form).find(".measurementUnit_unitId");

    const selectOption = $(select).find("option:selected");
    const code = $(selectOption).data("code");

    if (estado == "editar" || estado == "agregar") {
        //Validar si el codigo esta definido y si contiene la palabra 'Otros'
        if (code != undefined && code.includes("Otros")) {
            //Habilitar el campo de unidad de medida comercial
            activar_campo_clase("measurementUnit_commercialUnit", false, form_activo);
        } else {
            if ($(select).val() == "") {
                //Deshabilitar el campo de unidad de medida comercial
                activar_campo_clase("measurementUnit_commercialUnit", false, form_activo);
            } else {
                //Habilitar el campo de unidad de medida comercial
                activar_campo_clase("measurementUnit_commercialUnit", true, form_activo);
            }
        }
    } else {
        //Deshabilitar el campo de unidad de medida comercial
        activar_campo_clase("measurementUnit_commercialUnit", true, form_activo);
    }
}