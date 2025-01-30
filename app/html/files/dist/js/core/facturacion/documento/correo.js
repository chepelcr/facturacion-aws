/**
 * Agregar un correo para copia
 */
function agregarCorreo() {
    const activeDocument = $("#" + factura_activa);

    //Contar la cantidad de col-correo que tiene el documento
    let cantidadCorreos = activeDocument.find(".col-correo").length;

    //Sumarle 1 a la cantidad de correos
    cantidadCorreos = cantidadCorreos + 1;

    //Obtener la ultima col-correo y duplicarla en email-copies
    const lastCorreo = activeDocument.find(".col-correo").last();

    //Activar el delete-email
    lastCorreo.find(".delete-email").attr("disabled", false);

    const newEmail = lastCorreo.clone();

    //Buscar el ccEmail y colocar copyEmails[*] en el name
    //newEmail.find(".ccEmail").attr("name", "copyEmails[" + cantidadCorreos + "]");

    const addButton = activeDocument.find(".addCopyEmail");

    //Agregar la linea a email-copies
    activeDocument.find(".email-copies").append(newEmail);

    //Si ya hay 3 correos, oculta el addCopyEmail
    if (cantidadCorreos >= 3) {
        addButton.hide();
    } else {
        //Eliminar el addButton del email-copies para agregarlo al final
        addButton.remove();

        //Agregar el boton al final
        activeDocument.find(".email-copies").append(addButton);
    }

    nombrarCorreos();
}

/**
 * Vaciar el correo electrónico seleccionado
 * @param {*} button Boton
 */
function vaciarCorreo(button) {
    button = $(button);

    //Obtener el elemento col-correo al que pertenece el boton
    const colCorreo = button.closest(".col-correo");

    //Contar las lineas de correos
    const activeDocument = $("#" + factura_activa);

    //Si hay mas de una linea, se debe eliminar el col-correo del boton y mostrar el boton de addCopyEmail
    if (activeDocument.find(".col-correo").length > 1) {
        const addButton = activeDocument.find(".addCopyEmail");

        colCorreo.remove();

        addButton.remove();
        activeDocument.find(".email-copies").append(addButton);

        activeDocument.find(".addCopyEmail").show();
    } else {
        //Elminar el valor del input
        colCorreo.find(".ccEmail").val("");

        //Si no hay mas de una linea, se debe ocultar el boton de eliminar
        colCorreo.find(".delete-email").attr("disabled", true);
    }

    nombrarCorreos();
}

/**
 * Cambiar el nombre de los elementos de correo de la factura
 */
function nombrarCorreos() {
    const activeDocument = $("#" + factura_activa);

    //Recorrer los col-correo y colocar el name
    activeDocument.find(".col-correo").each(function (index, element) {
        $(element)
            .find(".ccEmail")
            .attr("name", "copyEmails[" + index + "]");
    });
}

$(document).ready(function () {
    //Cuando cambia ccEmail
    $(document).on("change", ".ccEmail", function () {
        //Si el valor es diferente a vacio
        if ($(this).val() != "") {
            //Activar el boton de eliminar
            $(this).closest(".col-correo").find(".delete-email").attr("disabled", false);
        } else {
            //Si solo hay un correo, desactivar el boton de eliminar
            if ($("#" + factura_activa).find(".col-correo").length == 1) {
                $(this).closest(".col-correo").find(".delete-email").attr("disabled", true);
            }
        }
    });
});
