<?php

namespace App\Controllers;

use App\Services\UsuariosService;
use Core\Auditorias\AuditoriaModel;
use Core\Auditorias\ErroresModel;
use Core\Permisos\PermisosModel;
use Core\Permisos\RolesModel;
use Core\Permisos\SubmodulosAccionesModel;

/**
 * Clase para manejar el modulo de seguridad de la aplicacion
 * @package App\Controllers
 * @subpackage Seguridad
 * @version 1.5
 * @author jcampos
 */
class Seguridad extends BaseController {
    protected $isModulo = true;

    protected $nombreModulo = 'seguridad';

    protected $objetos = ['usuarios', 'roles'];

    protected $validationFields = array(
        'usuarios' => 'identificacion',
        'roles' => 'nombre_rol'
    );

    protected $validacion_login = array(
        'usuarios' => true,
        'roles' => true,
    );

    /**
     * Cargar pagina de inicio del modulo de seguridad
     */
    public function index() {
        if (is_login()) {
            $script = cargar('cargar_inicio_modulo("seguridad");');

            $data = array(
                'script' => $script,
            );

            return $this->inicio($data);
        } //Fin de la validacion

        else {
            redirect(baseUrl('login'));
        }
    } //Fin de la funcion index

    /**
     * Obtener todos los usuarios de la apliacion 
     * 
     * @return string Lista de usuarios
     */
    public function usuarios() {
        if (!is_login()) {
            redirect(baseUrl('login'));
        }

        if (!validar_permiso('seguridad', 'usuarios', 'consultar')) {
            $error = array(
                'error' => 'No tiene permiso para realizar esta acción',
                'status' => 403
            );

            return  $this->error($error);
        }

        switch (getsegment(3)) {
            case 'listado':
                $usuariosService = new UsuariosService();

                return $usuariosService->getUsersView();
                break;

            default:
                $data = array(
                    'script' => cargar("cargar_listado('seguridad', 'usuarios', 'Seguridad', 'Usuarios', '" . baseUrl('seguridad/usuarios/listado') . "');")
                );

                return $this->inicio($data);
                break;
        } //Fin del switch
    } //Fin de la funcion para retornar los usuarios del sistema

    /**Obtener todos los roles del sistema */
    public function roles() {
        if (!is_login()) {
            header('Location: ' . baseUrl('login'));
        }

        if (!validar_permiso('seguridad', 'roles', 'consultar')) {
            $error = $this->object_error(403, 'No tiene permiso para realizar esta acción');

            return  $this->error($error);
        }

        switch (getsegment(3)) {
            case 'listado':
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

                return $this->listado($data);
                break;

            default:
                $data = array(
                    'script' => cargar("cargar_listado('seguridad', 'roles', 'Seguridad', 'Roles', '" . baseUrl('seguridad/roles/listado') . "');")
                );

                return $this->inicio($data);
                break;
        } //Fin del switch
    } //Fin de la funcion

    /**Mostrar las acciones de la base de datos */
    public function auditorias() {
        if (is_login()) {
            if (getSegment(3) == 'listado') {
                $auditoriaModel = new AuditoriaModel();

                $dataView = array(
                    'auditorias' => $auditoriaModel->getAll(),
                );

                return view('seguridad/auditoria/listado', $dataView);
            } else {
                $data = array(
                    'script' => cargar('cargar_listado("seguridad", "auditorias", "Seguridad", "Auditorias", "' . baseUrl('seguridad/auditorias/listado') . '");')
                );

                return $this->inicio($data);
            }
        } else {
            redirect(baseUrl('login'));
        }
    } //Fin de la funcion para mostrar el listado de auditorias

    /**Obtener los errores del sistema */
    public function errores() {
        if (getSegment(3) == 'listado') {
            if (!is_login()) {
                return $this->error($this->object_error(505, 'No ha iniciado sesión'));
            } else {
                $erroresModel = new ErroresModel();

                $errores = $erroresModel->getAll();

                $dataView = array(
                    'errores' => $errores,
                );

                return view('seguridad/auditoria/errores', $dataView);
            }
        } else {
            if (!is_login()) {
                header('Location: ' . baseUrl('login'));
            }

            $data = array(
                'script' => '<script>
                        $(document).ready(function(){
                            cargar_listado("seguridad", "errores", "Seguridad", "Errores", "' . baseUrl('seguridad/errores/listado') . '");
                        });
                    </script>'
            );

            return $this->inicio($data);
        }
    } //Fin de la funcion para mostrar todos los errores

    /**Actualizar un objeto de la base de datos */
    public function update($id, $data, $reinsert = false) {
        if (is_login()) {
            if ($id == 'perfil' || $id == 'contrasenia') {
                $objeto = 'usuarios';
            } else {
                $objeto = $this->modelName;
            }

            if (!is_null($objeto) && in_array($objeto, $this->objetos)) {
                switch ($objeto) {
                    case 'usuarios':
                        $usuariosService = new UsuariosService();

                        if ($id == 'perfil') {

                            $data = $usuariosService->updateUserProfile($data);

                            if (!isset($data['error'])) {
                                return json_encode(array(
                                    'estado' => 1,
                                    'success' => 'Se ha actualizado el perfil correctamente'
                                ));
                            } else {
                                return $this->error($data);
                            }
                        } elseif ($id == 'contrasenia') {
                            $id = getSession('id_usuario');

                            $data = $usuariosService->actualizar_contrasenia($id, $data['contra_nueva_conf'], $data['contra_actual']);

                            if (!isset($data['error'])) {
                                return json_encode(array(
                                    'estado' => 1,
                                    'success' => 'Se ha actualizado la contraseña correctamente'
                                ));
                            } else {
                                return $this->error($data);
                            }
                        } else {
                            //Si el usuario no tiene permisos para modificar
                            if (!validar_permiso($this->nombreModulo, 'usuarios', 'modificar')) {
                                return json_encode(array(
                                    'error' => 'No tiene permisos para realizar esta acción.',
                                ));
                            } else {
                                $data = $usuariosService->update($id, $data);

                                if (!isset($data['error'])) {
                                    return json_encode(array(
                                        'estado' => 1,
                                        'success' => 'Se ha actualizado el usuario correctamente'
                                    ));
                                } else {
                                    return $this->error($data);
                                }
                            }
                        }


                        break;

                    case 'roles':
                        $data = array(
                            'nombre_rol' => post('nombre_rol'),
                        );

                        $model = model('roles');

                        if ($model->update($data, $id)) {
                            $submodulosModel = new SubmodulosAccionesModel();

                            $modulos = $submodulosModel->modulos();

                            //Recorrer modulos
                            foreach ($modulos as $modulo) {
                                $id_modulo = $modulo->id_modulo;
                                $nombreModulo = $modulo->nombreModulo;

                                $submodulos = $modulo->submodulos;

                                //Recorrer submodulos
                                foreach ($submodulos as $submodulo) {
                                    $id_submodulo = $submodulo->id_submodulo;
                                    $nombre_submodulo = $submodulo->nombre_submodulo;

                                    $acciones = $submodulo->acciones;

                                    //Recorrer acciones
                                    foreach ($acciones as $accion) {
                                        $id_accion = $accion->id_accion;
                                        $nombre_accion = $accion->nombre_accion;

                                        $model = new PermisosModel();

                                        $id_permiso = $model->get_permiso($id, $id_modulo, $id_submodulo, $id_accion);

                                        $model = new PermisosModel();

                                        if (post('permiso_' . $nombreModulo . '_' . $nombre_submodulo . '_' . $nombre_accion)) {
                                            $data = array(
                                                'estado' => 1
                                            );

                                            if (!$id_permiso) {
                                                $data = array(
                                                    'id_rol' => $id,
                                                    'id_modulo' => $modulo->id_modulo,
                                                    'id_submodulo' => $submodulo->id_submodulo,
                                                    'id_accion' => $accion->id_accion,
                                                    'estado' => 1
                                                );

                                                $model->insert($data);
                                            } else
                                                $model->update($data, $id_permiso);
                                        } else {
                                            if (!$id_permiso) {
                                                $data = array(
                                                    'id_rol' => $id,
                                                    'id_modulo' => $modulo->id_modulo,
                                                    'id_submodulo' => $submodulo->id_submodulo,
                                                    'id_accion' => $accion->id_accion,
                                                    'estado' => 0
                                                );

                                                $model->insert($data);
                                            } else
                                                $model->update(array('estado' => 0), $id_permiso);
                                        }
                                    }
                                }
                            }

                            return json_encode(array(
                                'success' => 'Se actualizó el rol correctamente.',
                            ));
                        } else
                            return json_encode(array(
                                'error' => 'No se pudo actualizar el rol',
                            ));
                        break;
                } //Fin del switch
            } //Fin de la validacion

            else {
                return json_encode(array(
                    'error' => 'No se pudo actualizar el objeto',
                ));   
            }
        } //Fin de la validacion de sesion

        else {
            $error = $this->object_error(420, 'login');
            return $this->error($error);
        }
    } //Fin del metodo para actualizar un objeto

    /**Guardar un objeto en la base de datos */
    public function guardar($data = null) {
        if (is_login()) {
            $objeto = $this->modelName;

            if (!is_null($objeto) && in_array($objeto, $this->objetos)) {
                //$model = $this->model($objeto);

                switch ($objeto) {
                    case 'usuarios':
                        //Validar el permiso de acceso
                        if (validar_permiso($this->nombreModulo, 'usuarios', 'insertar')) {
                            $usuariosService = new UsuariosService();
                            $data = $usuariosService->create($data);

                            if (!isset($data['error'])) {
                                return json_encode(array(
                                    'status' => 1,
                                    'success' => 'Se ha guardado el usuario correctamente'
                                ));
                            } else {
                                return $this->error($data);
                            }
                        } else {
                            return $this->error(array(
                                'error' => 'No tiene permisos para realizar esta acción.',
                                'status' => 403
                            ));
                        }
                        break;

                    case 'roles':
                        $model = new RolesModel();
                        $data = array(
                            'nombre_rol' => post('nombre_rol'),
                        );

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

                                        if (post('permiso_' . $nombreModulo . '_' . $nombre_submodulo . '_' . $nombre_accion)) {
                                            $data = array(
                                                'estado' => 1
                                            );

                                            $model->update($data, $id_permiso);
                                        }
                                    }
                                }
                            } //Fin del ciclo

                            return json_encode(array(
                                'success' => 'El rol se ha registrado correctamente',
                            ));
                        } //Fin de validacion de id

                        else
                            return json_encode(array(
                                'error' => 'No se pudo guardar el rol.',
                            ));
                        break;
                } //Fin del switch
            } //Fin de la validacion

            return json_encode(array(
                'error' => 'Se ha generado un error en la solicitud',
            ));
        } //Fin de la validacion de login

        else
            return json_encode(array(
                'error' => 'No se ha iniciado sesión',
            ));
    } //Fin del metodo para guardar un objeto

    /**Enviar una contraseña temporal a un usuario */
    public function enviar_contrasenia() {
        if (!is_login()) {
            return $this->error(array(
                'error' => 'No se ha iniciado sesión',
                'status' => 403
            ));
        }

        if (getSegment(3)) {
            //Validar permiso
            if (!validar_permiso($this->nombreModulo, 'usuarios', 'modificar')) {
                return $this->error(array(
                    'error' => 'No tiene permisos para realizar esta acción.',
                    'status' => 403
                ));
            } else {
                $id_usuario = getSegment(3);

                $usuariosService = new UsuariosService();
                $data = $usuariosService->enviarContraseniaTemporal($id_usuario);

                if ($data['estado'] == 1) {
                    return json_encode(array(
                        'success' => 'Se ha enviado la contraseña correctamente',
                    ));
                } else {
                    return $this->error(array(
                        'error' => 'No se pudo enviar la contraseña',
                        'status' => 404
                    ));
                }
            }
        } else {
            return $this->error(array(
                'error' => 'No se ha indicado el usuario',
                'status' => 404
            ));
        }
    } //Fin del metodo para enviar una contraseña temporal
}//Fin de la clase