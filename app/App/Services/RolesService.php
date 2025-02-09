<?php

namespace App\Services;

use Core\Permisos\PermisosModel;
use Core\Permisos\RolesModel;
use Core\Permisos\SubmodulosAccionesModel;

class RolesService extends BaseService {
    /**
     * Obtener los datos de los roles
     */
    public function getData($id = null, $filters = null) {
        $model = new RolesModel();

        if ($id == 'all') {
            if (isset($filters['status'])) {
                $estado = $filters['status'];
                $model->where('estado', $estado);
            }

            return $model->getAll();
        } else {
            return $model->obtener($id);
        }
    }

    /**
     * Crear un rol en la base de datos
     */
    public function create($data) {
        $model = new RolesModel();


        $id = $model->insert($data);

        if ($id) {
            $submodulos_acciones_model = new SubmodulosAccionesModel();

            $modulos = $submodulos_acciones_model->modulos();

            //Recorrer modulos
            foreach ($modulos as $modulo) {
                $nombreModulo = $modulo->nombreModulo;
                $submodulos = $modulo->submodulos;

                //Recorrer submodulos
                foreach ($submodulos as $submodulo) {
                    $nombre_submodulo = $submodulo->nombre_submodulo;
                    $acciones = $submodulo->acciones;

                    //Recorrer acciones
                    foreach ($acciones as $accion) {
                        $nombre_accion = $accion->nombre_accion;

                        $data = array(
                            'id_rol' => $id,
                            'id_modulo' => $modulo->id_modulo,
                            'id_submodulo' => $submodulo->id_submodulo,
                            'id_accion' => $accion->id_accion,
                            'estado' => 0
                        );

                        $model = new PermisosModel();

                        $id_permiso = $model->insert($data);

                        if ($data['permiso_' . $nombreModulo . '_' . $nombre_submodulo . '_' . $nombre_accion]) {
                            $data = array(
                                'estado' => 1
                            );

                            $model->update($data, $id_permiso);
                        }
                    }
                }
            } //Fin del ciclo

            return array(
                'success' => 'El rol se ha registrado correctamente',
            );
        } //Fin de validacion de id

        else {
            return array(
                'error' => 'No se pudo guardar el rol.',
            );
        }
    }

    public function getRolesView() {
        $rolesModel = new RolesModel();
        $roles = $rolesModel->getAll();

        $tableName = 'seguridad/rol/table';

        $data_tabla = array(
            'nombreTable' => $tableName,
            'nombre_tabla' => 'listado_seguridad_roles',
            'dataTable' => array(
                'roles' => $roles
            )
        );

        $nombreForm = 'seguridad/rol/form';

        $submodulosAccionesModel = new SubmodulosAccionesModel();

        $dataForm = array(
            'modulos' => $submodulosAccionesModel->modulos(),
        );

        $data_form = array(
            'dataForm' => $dataForm,
            'nombreForm' => $nombreForm,
            'nombre_form' => 'frm_seguridad_roles'
        );

        $data = array(
            'data_tabla' => $data_tabla,
            'data_form' => $data_form,
        );

        return $data;
    }

    /**
     * Actualizar un rol en la base de datos
     */
    public function update($id, $data, $reinsert = false) {
        $permisos = $data['permisos'];
        unset($data['permisos']);

        $model = new RolesModel();
        $rol = $model->update($data, $id);

        if (is_object($rol)) {
            $model = new PermisosModel();

            foreach ($permisos as $permiso => $estado) {
                $permiso = explode('_', $permiso);

                $data = array(
                    'id_rol' => $rol->id_rol,
                    'id_modulo' => $permiso[0],
                    'id_submodulo' => $permiso[1],
                    'id_accion' => $permiso[2],
                    'estado' => $estado
                );

                $model = new PermisosModel();

                $id_permiso = $model->get_permiso($rol->id_rol, $permiso[0], $permiso[1], $permiso[2]);
                $model = new PermisosModel();

                if (!$id_permiso) {
                    $model->insert($data);
                } else {
                    $model->update($data, $id_permiso);
                }
            }

            return array(
                'success' => 'Rol actualizado correctamente',
                'status' => 200
            );
        } else {
            return array(
                'error' => 'No se pudo actualizar el rol',
                'status' => 500
            );
        }
    }

    /**
     * Cambiar el estado de un rol
     */
    public function changeStatus($id, $data) {
        $rolesModel = new RolesModel();
        $rol = $rolesModel->getById($id);

        if ($rol) {
            $data = array(
                'estado' => $data['status']
            );

            $rolesModel = new RolesModel();
            $data = $rolesModel->update($data, $id);

            if (!is_bool($data)) {
                $mensaje = '';

                switch ($data->estado) {
                    case 2:
                        $mensaje = 'Se ha desactivado el rol correctamente';
                        break;
                    case 3:
                        $mensaje = 'Se ha eliminado el rol correctamente';
                        break;
                    default:
                        $mensaje = 'Se ha activado el rol correctamente';
                        break;
                }

                return array(
                    'estado' => 1,
                    'success' => $mensaje
                );
            } else {
                return array(
                    'error' => 'No se pudo cambiar el estado del rol',
                    'status' => 500
                );
            }
        } else {
            return array(
                'error' => 'No se encontro el rol',
                'status' => 404
            );
        }
    }

    public function validarExistencia($name) {
        $model = new RolesModel();

        return $model->where('nombre', $name)->fila();
    }
}
