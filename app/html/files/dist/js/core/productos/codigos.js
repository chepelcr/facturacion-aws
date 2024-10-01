function agregarCodigo() {
    const form = $("#" + form_activo);

    //Obtener el slc_codes del formulario activo
    const select = form.find(".slc_codes");
    const value = $(select).val();

    crear_codigo(value, "", form_activo);

    contarCodigos();
}

function contarCodigos() {
    const codes = $("#" + form_activo + " .codes .code");

    console.log(codes);

    let cantidadCodigos = 0;

    //Validar si hay codigos
    if (codes.length == 0) {
        return 0;
    } else {
        cantidadCodigos = codes.length;
    }

    //Recorrer los codigos para colocarles el numero correspondiente
    codes.each(function (index, element) {
        if (cantidadCodigos == 1) {
            $(element).addClass("col-md-12");
        } else {
            //Si la cantidad de codigos es 5 y es el ultimo, poner la clase col-md-12
            if (cantidadCodigos == 5 && index == 4) {
                $(element).addClass("col-md-12");
            } else {
                //Eliminar la clase col-md-12
                $(element).removeClass("col-md-12");

                $(element).addClass("col-md-6");
            }
        }

        const codeTypeId = $(element).find(".codeTypeId");
        const saleCode = $(element).find(".saleCode");

        $(codeTypeId).attr("name", "codes[" + index + "][codeTypeId]");
        $(saleCode).attr("name", "codes[" + index + "][number]");
    });

    return cantidadCodigos;
}

function crear_codigo(codeTypeId, code = "", form_activo = "") {
    const form = $("#" + form_activo);

    //Obtener el slc_codes del formulario activo
    form.find(".slc_codes").val(codeTypeId);

    //Validar si el codigo es un numero y pasarlo a string
    if (typeof code == "number") {
        code = code.toString();
    }

    //Si el codeTypeId esta vacio, mosrar un mensaje de error
    if (codeTypeId == "") {
        mensajeAutomatico("Atención", "Debe seleccionar un tipo de código", "info");
        return;
    }

    //Obtener el option seleccionado
    const option = form.find(".slc_codes").find("option:selected");
    const description = $(option).data("description");

    //Crear la estructura de un codigo
    /**
     * <!-- Codigo -->
            <div class="code">
                <div class="form-group...>
                */
    const codeDiv = $("<div>").addClass("code");
    const formGroup = $("<div>").addClass("form-group");
    const label = $("<label>").addClass("text-left").text(description);
    const inputGroup = $("<div>").addClass("input-group");
    const inputGroupPrepend = $("<div>").addClass("input-group-prepend");
    const span = $("<span>").addClass("input-group-text");
    const icon = $("<i>").addClass("fas fa-barcode");
    const inputCodeTypeId = $("<input>")
        .addClass("form-control inp codeTypeId")
        .attr("type", "text")
        .attr("required", true)
        .attr("hidden", true)
        .val(codeTypeId);
    const inputSaleCode = $("<input>")
        .addClass("form-control inp saleCode")
        .attr("type", "text")
        .attr("required", true)
        .val(code);
    const inputGroupAppend = $("<div>").addClass("input-group-append");
    const btnEliminar = $("<button>")
        .addClass("btn btn-danger inp btn-eliminar")
        .attr("type", "button")
        .attr("data-toggle", "tooltip")
        .attr("data-placement", "top")
        .attr("title", "Eliminar")
        .attr("onclick", "eliminarCodigo(this)");

    const iconEliminar = $("<i>").addClass("fas fa-times");

    //Agregar el icono al span
    span.append(icon);

    //Agregar el span al inputGroupPrepend
    inputGroupPrepend.append(span);

    //Agregar los inputs al inputGroup
    inputGroup.append(inputGroupPrepend);
    inputGroup.append(inputCodeTypeId);
    inputGroup.append(inputSaleCode);

    //Agregar el icono al boton
    btnEliminar.append(iconEliminar);

    //Agregar el boton al inputGroupAppend
    inputGroupAppend.append(btnEliminar);

    //Agregar el label al formGroup
    formGroup.append(label);

    //Agregar el inputGroup al formGroup
    formGroup.append(inputGroup);

    //Agregar el inputGroupAppend al inputGroup
    inputGroup.append(inputGroupAppend);

    //Agregar el formGroup al codeDiv
    codeDiv.append(formGroup);

    //Agregar el codeDiv al formulario activo
    form.find(".codes").append(codeDiv);

    //Ocultar el option seleccionado
    $(option).hide();

    //Colocar el select en vacio
    form.find(".slc_codes").val("");

    //Enfocar el input de codigo
    inputSaleCode.focus();
}

function eliminarCodigo(btn) {
    const form = $(btn).closest("form");
    const code = $(btn).closest(".code");
    const codeTypeId = $(code).find(".codeTypeId").val();

    //Mostrar el option oculto
    form.find(".slc_codes option[value='" + codeTypeId + "']").show();

    //Eliminar el codigo
    code.remove();

    contarCodigos();
}

function eliminarCodigosProducto() {
    const form = $("#" + form_activo);

    //Eliminar los codigos
    form.find(".codes").empty();

    //Mostar los options ocultos
    form.find(".slc_codes option").show();

    //Contar los codigos
    contarCodigos();
}

function agregarCodigosProducto(codes, nombre_form) {
    //Recorrer la lista de codigos
    $.each(codes, function (i, code) {
        crear_codigo(code.codeType.codeTypeId, code.number, nombre_form);
    });

    contarCodigos();
}
