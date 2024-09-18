function getUnitCode(select) {
    const form = "#" + form_activo;
    const option = $(select).find("option:selected");

    const code = $(option).data("code");

    //Validar si el codigo contiene la palabra 'Otros'
    if (code.includes("Otros")) {
        //Habilitar el campo de unidad de medida comercial
        activar_campo_clase("measurementUnit_commercialUnit", false, form_activo);

        //Vaciar el campo de unidad de medida comercial
        $(form).find(".measurementUnit_commercialUnit").val("");
    } else {
        //Deshabilitar el campo de unidad de medida comercial
        activar_campo_clase("measurementUnit_commercialUnit", true, form_activo);

        //Colocar el code en el campo unit_commercialUnit del formulario activo
        $(form).find(".measurementUnit_commercialUnit").val(code);
    }
}

function activarUnidadComercial(estado = 'editar', form_activo = '') {
    const form = "#" + form_activo;
    let select = $(form).find(".measurementUnit_measurementUnitId");

    let option = $(select).find("option:selected");
    let code = $(option).data("code");

    console.log("code", code);

    if(estado == 'editar') {
        //Validar si el codigo contiene la palabra 'Otros'
        if (code.includes("Otros")) {
            //Habilitar el campo de unidad de medida comercial
            activar_campo_clase("measurementUnit_commercialUnit", false, form_activo);
        } else {
            //Deshabilitar el campo de unidad de medida comercial
            activar_campo_clase("measurementUnit_commercialUnit", true, form_activo);
        }
    } else {
        //Deshabilitar el campo de unidad de medida comercial
        activar_campo_clase("measurementUnit_commercialUnit", true, form_activo);
    }
}
