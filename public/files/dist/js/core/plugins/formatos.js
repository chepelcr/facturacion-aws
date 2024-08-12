var formato = false;
var setCambio = false;

/**Dar formato a la fecha */
function formatoFecha(fecha, formato = 'dd/mm/yyyy') {
    const map = {
        dd: fecha.getDate(),
        mm: fecha.getMonth() + 1,
        yy: fecha.getFullYear().toString().slice(-2),
        yyyy: fecha.getFullYear()
    }

    const format = formato.replace(/(dd|mm|yyyy|yy)/g, (match) => map[match]);

    return format;
}

/**Formatear la cedula de un contribuyente */
function formatear_cedula(cedula, tipo_cedula = "01") {
    var cedula_formateada = cedula;
    console.log(cedula_formateada);
    console.log(tipo_cedula);

    switch (tipo_cedula) {

    case "01":
        //Formato de cedula
        //01-0234-0569

        //Formatear la cedula
        //Obtener el primer digito
        var primer_digito = cedula.substring(0, 1);

        //Obtener el del segundo al quinto digito
        var segundo_digito = cedula.substring(1, 5);

        //Obtener el sexto digito al noveno digito
        var tercer_digito = cedula.substring(5, 9);

        //Rellenar con ceros a la izquierda el primer digito hasta que tenga 2 digitos
        primer_digito = primer_digito.padStart(2, '0');

        //Rellenar con ceros a la izquierda el segundo digito y el tercer digito hasta que sean de 4 digitos
        while (segundo_digito.length < 4) {
            segundo_digito = "0" + segundo_digito;
        }

        while (tercer_digito.length < 4) {
            tercer_digito = "0" + tercer_digito;
        }

        //Unir los 3 digitos con -
        cedula_formateada = primer_digito + "-" + segundo_digito + "-" + tercer_digito;

        formato = true;
        break;

    case "02":
        //Formato de cedula
        //3-123-456700

        //Formatear la cedula
        //Obtener el primer digito
        var primer_digito = cedula.substring(0, 1);

        //Obtener el del segundo al cuarto digito
        var segundo_digito = cedula.substring(1, 4);

        //Obtener todos los restantes digitos
        var tercer_digito = cedula.substring(4, 10);

        //Rellenar con ceros a la izquierda el segundo digito hasta que tenga 3 digitos
        while (segundo_digito.length < 3) {
            segundo_digito = "0" + segundo_digito;
        }

        //Rellenar con ceros a la izquierda el tercer digito hasta que sean de 9 digitos
        while (tercer_digito.length < 6) {
            tercer_digito = "0" + tercer_digito;
        }

        //Unir los 3 digitos con -
        cedula_formateada = primer_digito + "-" + segundo_digito + "-" + tercer_digito;

        console.log(cedula_formateada);

        formato = true;
        break;
    }

    return cedula_formateada;
}//Fin de formatear cedula

function quitar_formato(cedula) {
    //Eliminar los 0 al inicio y los -
    cedula = cedula.replace(/^0+/, '');
    cedula = cedula.replace(/-/g, '');

    return cedula;
}

/**Vaciar los campos relacionados con la cedula de un contribuyente */
function vaciar_cedula() {
    $("#" + form_activo).find(".identification_number").val('');
    $("#" + form_activo).find(".businessName").val('');
    $("#" + form_activo).find(".identification_typeId").val('');
    $("#" + form_activo).find(".nationality").val('');

    activar_campos_cedula('agregar', form_activo);

    formato = false;
}//Fin de vaciar los campos relacionados con la cedula de un contribuyente