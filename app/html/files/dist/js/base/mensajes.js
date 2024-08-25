const Toast = Swal.mixin({
    toast: true,
    position: 'bottom-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

/**Enviar un mensaje al usuario*/
function mensaje(titulo, mensaje, icono) {
    Swal.fire({
        icon: icono,
        title: titulo,
        text: mensaje,
        showConfirmButton: true,
        confirmButtonText: 'Aceptar',
    })
}//Fin del mensaje

/**Mensaje que se cierra automaticamente*/
function mensajeAutomatico(titulo, mensaje, icono) {
    Swal.fire({
        title: titulo,
        text: mensaje,
        icon: icono,
        timer: 4000,
        showConfirmButton: false,
    })//Fin del mensaje
}

function mensajeCargaModulo(titulo, mensaje, icono, nombre_modulo) {
    Swal.fire({
        title: titulo,
        text: mensaje,
        icon: icono,
        timer: 2000,
        showConfirmButton: false,
    }).then((result) => {
        cargar_modulo(nombre_modulo);
    })//Fin del mensaje
}

/**Mensaje que se cierra automaticamente y recarga la pagina*/
function mensajeAutomaticoRecargar(titulo, mensaje, icono) {
    Swal.fire({
        title: titulo,
        text: mensaje,
        icon: icono,
        timer: 2000,
        showConfirmButton: false,
    }).then((result) => {
        location.reload();
    })//Fin del mensaje
}//Fin del mensaje

/**Mensaje que realiza una accion luego de mostrarse
 * @param titulo Titulo del mensaje
 * @param mensaje Mensaje del mensaje
 * @param icono Icono del mensaje
 * @param accion Funcion que se ejecuta al mostrarse el mensaje
 */
function mensajeAutomaticoAccion(titulo, mensaje, icono, accion) {
    Swal.fire({
        title: titulo,
        text: mensaje,
        icon: icono,
        timer: 2000,
        showConfirmButton: false,
    }).then((result) => {
        accion;
    })//Fin del mensaje
}//Fin del mensaje

/**Mostrar una notificacion al usuario */
function notificacion(titulo, mensaje, icono) {
    Toast.fire({
        icon: icono,
        title: titulo,
        text: mensaje,
    })
}