<?php

use Core\Permisos\PermisosModel;

/**Obtener los modulos de un rol */
function getModulos()
{
    $permisosModel = new PermisosModel();

    if (is_login()) {
        $modulos = $permisosModel->modulos(getSession('id_rol'));

        //Recorrer los modulos para obtener los permisos
        foreach ($modulos as $modulo) {
            $nombre_modulo = $modulo->nombre_modulo;
            $submodulos = $modulo->submodulos;

            foreach ($submodulos as $submodulo) {
                $nombre_submodulo = $submodulo->nombre_submodulo;
                $acciones = $submodulo->acciones;

                foreach ($acciones as $accion) {
                    $nombre_accion = $accion->nombre_accion;

                    //var_dump( $accion->estado, $nombre_submodulo);

                    setSession($nombre_modulo . '_' . $nombre_submodulo . '_' . $nombre_accion, $accion->estado);
                } //Fin del foreach
            } //Fin de la validacion
        } //Fin del foreach

        return $modulos;
    } //Fin de la validacion

    else {
        return $permisosModel->modulos(0);
    } //Fin de la validacion
} //Fin de la funcion para obtener los modulos de un rol

/**Validar si un usuario tiene acceso a un modulo */
function validar_permiso($v_modulo, $v_objeto, $v_accion)
{
    if (getSession($v_modulo . '_' . $v_objeto . '_' . $v_accion) == 1) {
        return true;
    } //Fin de la validacion

    else {
        return false;
    } //Fin de la validacion
} //Fin de la funcion

/**Obtener los botones para una tabla del sistema */
function get_botones($v_id, $v_objeto, $v_modulo, $v_submodulo, $v_estado = null)
{
    $data = array(
        'id' => $v_id,
        'objeto' => $v_objeto,
        'modulo' => $v_modulo,
        'submodulo' => $v_submodulo,
        'estado' => $v_estado
    );
    return view('base/botones_tabla', $data);
} //Fin de la funcion

function formatear_cedula($cedula, $tipo_cedula = '01')
{
    $identificacion = $cedula;

    if ($tipo_cedula == '01') {
        //La cedula viene: 123456789
        //El formato debe ser: 01-2345-6789

        //Colocar un cero delante
        $identificacion = '0' . $identificacion;

        //Formatear la cedula
        $identificacion = substr($identificacion, 0, 2) . '-' . substr($identificacion, 2, 4) . '-' . substr($identificacion, 6, 9);
    } elseif ($tipo_cedula == '02') {
        //El formato debe ser: 3-123-001245, sin eliminar los ceros a la izquierda
        //La cedula viene 1234567891
        //Separar la cedula en partes

        //Parte 1: 1
        $parte1 = substr($identificacion, 0, 1);

        //Parte 2: 234
        $parte2 = substr($identificacion, 1, 3);

        //Parte 3: 567891
        $parte3 = substr($cedula, 4, 10);

        //Rellenar los ceros a la izquierda en la parte 3 hasta que tenga 6 caracteres
        $parte3 = str_pad($parte3, 6, '0', STR_PAD_LEFT);

        //Concatenar las partes
        $identificacion = $parte1 . '-' . $parte2 . '-' . $parte3;
    }

    return $identificacion;
}

function desformatear_cedula($cedula)
{
    $cedula = str_replace('-', '', $cedula);

    //Si el primer digito es 0, eliminarlo
    if (isset($cedula) && $cedula[0] == '0') {
        $cedula = substr($cedula, 1, strlen($cedula));
    }

    return $cedula;
}
