<?php

namespace App\Controllers;

use App\Services\ModulosService;
use App\Services\RolesService;
use App\Services\UsuariosService;
use Core\Auditorias\AuditoriasService;

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

    protected $objetos = ['usuarios', 'roles', 'modulos'];

    protected $validationFields = array(
        'usuarios' => 'identificacion',
        'roles' => 'nombre_rol'
    );

    protected $validacion_login = array(
        'usuarios' => true,
        'roles' => true,
        'modulos' => true
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
            redirect(baseUrl('login'));
        }

        if (!validar_permiso('seguridad', 'roles', 'consultar')) {
            $error = $this->object_error(403, 'No tiene permiso para realizar esta acción');

            return  $this->error($error);
        }

        if (getsegment(3) == 'listado') {
            $rolesService = new RolesService();
            $data = $rolesService->getRolesView();

            return $this->listado($data);
        } else {
            $data = array(
                'script' => cargar("cargar_listado('seguridad', 'roles', 'Seguridad', 'Roles', '" . baseUrl('seguridad/roles/listado') . "');")
            );

            return $this->inicio($data);
        }
    } //Fin de la funcion

    /**Mostrar las acciones de la base de datos */
    public function auditorias() {
        if (is_login()) {
            if (getSegment(3) == 'listado') {
                $auditoriasService = new AuditoriasService();

                return $auditoriasService->getAuditoriasView();
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

    /**
     * Obtener los modulos de la aplicacion
     */
    public function modulos() {
        if (is_login()) {
            if (validar_permiso("seguridad", "modulos", "consultar")) {
                if (getSegment(3) == 'listado') {

                    $modulosService = new ModulosService();
                    $dataModulos = $modulosService->obtenerModulos();

                    return $this->listado($dataModulos);
                } else {
                    $data = array(
                        'script' => cargar('cargar_listado("seguridad", "modulos", "Seguridad", "Modulos", "' . baseUrl('seguridad/modulos/listado') . '");')
                    );

                    return $this->inicio($data);
                }
            } else {
                $error = $this->object_error(500, 'No tiene permisos para consultar modulos.');

                return $this->error($error);
            }
        } else {
            header(self::LOCATION . baseUrl('login'));
        }
    }

    /**Obtener los errores del sistema */
    public function errores() {
        if (getSegment(3) == 'listado') {
            if (!is_login()) {
                redirect(baseUrl('login'));
            } else {
                $auditoriasService = new AuditoriasService();

                return $auditoriasService->getErroresView();
            }
        } else {
            $data = array(
                'script' => cargar('cargar_listado("seguridad", "errores", "Seguridad", "Errores", "' . baseUrl('seguridad/errores/listado') . '");')
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
                        $rolesService = new RolesService();
                        $data = $rolesService->update($id, $data);

                        if (!isset($data['error'])) {
                            return json_encode(array(
                                'success' => 'Se ha actualizado el rol correctamente',
                            ));
                        } else {
                            return $this->error($data);
                        }
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
                switch ($objeto) {
                    case 'usuarios':
                        //Validar el permiso de acceso
                        if (validar_permiso($this->nombreModulo, 'usuarios', 'insertar')) {
                            $usuariosService = new UsuariosService();
                            $data = $usuariosService->create($data);
                        } else {
                            $data = $this->error(array(
                                'error' => 'No tiene permisos para realizar esta acción.',
                                'status' => 403
                            ));
                        }
                        break;

                    case 'roles':
                        if (validar_permiso($this->nombreModulo, 'usuarios', 'insertar')) {
                            $rolesService = new RolesService();
                            $data = $rolesService->create($data);
                        } else {
                            $data = $this->error(array(
                                'error' => 'No tiene permisos para realizar esta acción.',
                                'status' => 403
                            ));
                        }
                        break;
                } //Fin del switch
            } //Fin de la validacion

            $data = array(
                'error' => 'Se ha generado un error en la solicitud',
                'status' => 500
            );
        } //Fin de la validacion de login

        else {
            $data = array(
                'error' => 'No se ha iniciado sesión',
                'status' => 403
            );
        }

        if (!isset($data['error'])) {
            return $data;
        } else {
            return $this->error($data);
        }
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