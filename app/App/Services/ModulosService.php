<?php

namespace App\Services;

use Core\Permisos\SubmodulosAccionesModel;

/**
 * Clase para el manejo de los modulos
 */
class ModulosService {
    /**
     * Obtener toda la informacion de los modulos
     */
    public function obtenerModulos() {
        $submodulosAccionesModel = new SubmodulosAccionesModel();
        $modulos = $submodulosAccionesModel->modulos();

        $tableName = 'seguridad/modulos/table';

        $data_tabla = array(
            'nombreTable' => $tableName,
            'nombre_tabla' => 'listado_seguridad_modulos',
            'dataTable' => array(
                'modulos' => $modulos
            )
        );

        $nombreForm = 'seguridad/modulos/form';

        $data_form = array(
            'nombreForm' => $nombreForm,
            'nombre_form' => 'frm_seguridad_modulos'
        );

        return array(
            'data_tabla' => $data_tabla,
            'data_form' => $data_form,
        );
    }

    /**
     * Obtener la informacion de un modulo o todos los modulos
     */
    public function getData($id = null) {
        $submodulosAccionesModel = new SubmodulosAccionesModel();

        return $submodulosAccionesModel->getModulo($id);
    }
}