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

    newEmail.find(".ccEmail").val("");

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
    }

    //Si solo queda una linea, desactivar el boton
    if (activeDocument.find(".col-correo").length == 1 && activeDocument.find(".col-correo").find(".ccEmail").val() == "") {
        activeDocument.find(".delete-email").attr("disabled", true);
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

    validarCorreos();
}

/**
 * Validar si los correos de la lista son validos y no se repiten
 *
 * En caso que algun correo sea repetido, se debera colocar la clase border-danger
 */
function validarCorreos() {
    const activeDocument = $("#" + factura_activa);

    let validEmails = true;

    //Obtener los correos de la lista
    const correos = activeDocument.find(".ccEmail");

    //Eliminar los bordes rojos
    correos.removeClass("border-danger");

    //Obtener los valores que no estan vacios
    const correosValidos = correos
        .filter(function () {
            return $(this).val() != "";
        })
        .map(function () {
            return $(this).val();
        });

    //Recorrer los correos validando que no se repitan
    correos.each(function (index, element) {
        const value = $(element).val();
        //Si el correo no esta vacio
        if (value != "") {
            //Validar si cumple con estructura de correo
            if (!validarCorreo(value)) {
                //Agregar la clase border-danger
                $(element).addClass("border-danger");

                validEmails = false;
            }

            //Si el correo esta repetido
            if (correosValidos.filter((correo) => correo == value).length > 1) {
                //Agregar la clase border-danger
                $(element).addClass("border-danger");

                validEmails = false;
            }
        }
    });

    //Validar si hay mas de uno vacio
    const correosVacios = correos.filter(function () {
        return $(this).val() == "";
    });

    //Si hay mas de uno vacio, se colocan invalidos
    if (correosVacios.length > 1  || (correosVacios.length == 1 && correosValidos.length > 0)) {
        correosVacios.each(function (index, element) {
            $(element).addClass("border-danger");
        });

        validEmails = false;
    }

    //Si los correos no son validos, desabilitar el btn-guardar-documento de la factura activa
    if (!validEmails) {
        activeDocument.find(".btn-guardar-documento").attr("disabled", true);

        //Desactivar el boton de agregar correos
        activeDocument.find(".addEmailButton").attr("disabled", true);
    } else {
        activeDocument.find(".btn-guardar-documento").attr("disabled", false);

        //Activar el boton de agregar correos 
        activeDocument.find(".addEmailButton").attr("disabled", false);
    }

    //Si solo queda un correo y está vacio, desactivar el boton de agregar
    if (validEmails && (correos.length == 1 && correosVacios.length == 1)) {
        activeDocument.find(".addEmailButton").attr("disabled", true);
    }/* else {
        activeDocument.find(".addEmailButton").attr("disabled", false);
    }*/
}

/**
 * Validar un correo electrónico
 * @param {string} correo Correo electrónico a validar
 * @returns true | false
 */
function validarCorreo(correo) {
    //Expresion regular para validar correo
    
    const regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    if (correo == "") {
        return true;
    } else {
        correo = correo.toLowerCase();
    }
    
    return regex.test(correo);
}

$(document).ready(function () {
    //Cuando cambia ccEmail
    $(document).on("change keyup", ".ccEmail", function () {
        //Si solo hay un correo y esta vacio, desactivar el boton de eliminar
        if ($("#" + factura_activa).find(".col-correo").length == 1 && $(this).val() == "") {
            $(this).closest(".col-correo").find(".delete-email").attr("disabled", true);
        } else {
            //Activar el boton
            $(this).closest(".col-correo").find(".delete-email").attr("disabled", false);
        }

        validarCorreos();
    });
});
