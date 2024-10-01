<?php

namespace App\Services;

use App\Api\DataServiceApi;
use App\Api\LocationsApi;
use App\Api\TaxpayersApi;
use App\Librerias\Correo;
use App\Models\CodigosPaisesModel;
use App\Models\ContraseniaModel;
use App\Models\EmpresasModel;
use App\Models\UsuariosModel;
use Core\Permisos\RolesModel;

class UsuariosService extends BaseService {
    /**
     * Api de datos
     */
    private $dataServiceApi;

    /**
     * Api de ubicaciones
     */
    private $locationsApi;

    /**
     * Api de contribuyentes
     */
    private $taxpayersApi;


    public function __construct() {
        $this->dataServiceApi = new DataServiceApi();
        $this->locationsApi = new LocationsApi();
        $this->taxpayersApi = new TaxpayersApi();
    }

    /**
     * Actualizar un usuario
     * @param int $id Identificador del usuario
     * @param array $data Datos del usuario
     * @return array Respuesta de la API
     */
    public function update($id, $data) {

        $model = new UsuariosModel();
        $user = $model->getById($id);

        if ($user) {

            $empresasModel = new EmpresasModel();
            $empresa = $empresasModel->getByTaxpayerId($data['taxpayerId']);

            $data = array(
                'nombre_usuario' => $data['userName'],
                'correo' => $data['email'],
                'telefono' => $data['personalPhone']['number'],
                'id_rol' => $data['rolId'],
                'id_empresa' => $empresa->id_empresa
            );

            $model = new UsuariosModel();
            $data = $model->update($data, $id);

            if (!is_bool($data)) {
                return array(
                    'estado' => 1,
                    'success' => 'Se actualizó el usuario correctamente.',
                );
            } else {
                return array(
                    'error' => 'No se pudo actualizar el usuario',
                    'status' => 500
                );
            }
        } else {
            return array(
                'error' => 'No se encontro el usuario',
                'status' => 404
            );
        }
    }

    public function validarExistencia($data) {
        $model = new UsuariosModel();

        if (isset($data['correo'])) {
            $model->where('correo', $data['correo']);

            if ($model->fila()) {
                return array(
                    'error' => 'El correo ya se encuentra registrado.',
                    'status' => 400
                );
            }
        } elseif (isset($data['identificacion'])) {
            $data['identificacion'] = desformatear_cedula($data['identificacion']);

            $model->where('identificacion', $data['identificacion']);

            if ($model->fila()) {
                return array(
                    'error' => 'Ya existe un usuario con la identificación ' . $data['identificacion'],
                    'status' => 400
                );
            }
        } else {
            return array(
                'error' => 'No se pudo validar la existencia del usuario',
                'status' => 500
            );
        }
    }

    /**
     * Crear un usuario
     * @param array $data
     * @return array
     */
    public function create($data) {
        $identificacion = $data['identification']['number'];

        //Eliminar los guiónes del número de identificación
        $identificacion = desformatear_cedula($identificacion);

        $model = new UsuariosModel();

        $correo = $data['email'];
        $userData = $model->getByEmail($correo);

        if (is_bool($userData)) {
            $model = new UsuariosModel();
            $userData = $model->getByIdentification($identificacion);

            if (is_bool($userData)) {
                $dataServiceApi = $this->dataServiceApi;
                $identificationType = $dataServiceApi->getIdentificationTypeById($data['nationality'], $data['identification']['typeId']);

                $codigosPaisesModel = new CodigosPaisesModel();
                $pais = $codigosPaisesModel->getByIsoCode($data['nationality']);

                $empresasModel = new EmpresasModel();
                $empresa = $empresasModel->getByTaxpayerId($data['taxpayerId']);

                $model = new UsuariosModel();

                $data = array(
                    'identificacion' => $identificacion,
                    'id_tipo_identificacion' => $identificationType->code,
                    'nombre' => $data['businessName'],
                    'cod_pais' => $pais->cod_pais,
                    'telefono' => $data['personalPhone']['number'],
                    'correo' => $data['email'],
                    'nombre_usuario' => $data['userName'],
                    'id_rol' => $data['rolId'],
                    'id_empresa' => $empresa->id_empresa,
                );

                $userData = $model->insert($data);

                //Validar si es booleano
                if (!is_bool($userData)) {
                    $mensaje = 'Estimado ' . $userData->nombre . ',
                                                    <br>
                                                    
                                                    Se ha completado su registro en la plataforma de' . getEnt('app.name') . '.<br>
                                                    <br>

                                                    Presione el siguiente enlace para iniciar sesión: <br>
                                                    <a href="' . baseUrl() . '">Iniciar</a>
                                                    
                                                    Saludos,
                                                    <br>
                                                    <br>
                                                    <b>Equipo de ' . getEnt('app.name') . '</b>';

                    $correos = array(
                        $userData->nombre => $userData->correo,
                    );

                    $data = array(
                        'receptor' => $correos,
                        'asunto' => 'Registro de usuario',
                        'body' => $mensaje
                    );

                    $correo = new Correo();

                    if ($correo->enviarCorreo($data)) {
                        $mensaje = 'Se ha registrado el usuario correctamente';
                    } else {
                        $mensaje = 'Se ha registrado el usuario correctamente, pero no se pudo enviar el correo de confirmación';
                    }

                    $envioContrasenia = $this->enviar_contrasenia_temporal($userData);

                    if ($envioContrasenia['estado'] == 1) {
                        return array(
                            'status' => 200,
                            'success' => $mensaje,
                        );
                    } else {
                        return array(
                            'error' => $envioContrasenia['mensaje'],
                            'status' => 500
                        );
                    }
                } else {
                    return array(
                        'error' => 'No se pudo guardar el usuario.',
                        'status' => 500
                    );
                }
            } else {
                return array(
                    'error' => 'Ya existe un usuario con la identificación ' . $identificacion,
                    'status' => 400
                );
            }
        } else {
            return array(
                'error' => 'El correo ya se encuentra registrado.',
                'status' => 400
            );
        }
    }

    public function getUsersView() {
        $usuariosModel = new UsuariosModel();
        $usuarios = $usuariosModel->getAll();

        $tableName = 'seguridad/usuario/table';

        $data_tabla = array(
            'nombreTable' => $tableName,
            'nombre_tabla' => 'listado_seguridad_usuarios',
            'dataTable' => array(
                'usuarios' => $usuarios
            )
        );

        $dataServiceApi = $this->dataServiceApi;
        $identificaciones = $dataServiceApi->getIdentificationTypesByCountry(getCountryCode());

        $locationsApi = $this->locationsApi;
        $countries = $locationsApi->get_countries();

        $datos_personales = array(
            'identificaciones' => $identificaciones,
            'countries' => $countries
        );

        $datos_contacto = array(
            'countries' => $countries
        );

        $rolesModel = new RolesModel();
        $taxpayersApi = $this->taxpayersApi;

        $datos_usuario = array(
            'empresas' => $taxpayersApi->getAllTaxpayers(),
            'roles' => $rolesModel->getAll(),
        );

        $nombreForm = 'seguridad/usuario/form';

        $data_form = array(
            'dataForm' => array(
                'datos_personales' => $datos_personales,
                'datos_usuario' => $datos_usuario,
                'datos_contacto' => $datos_contacto
            ),
            'nombreForm' => $nombreForm,
            'nombre_form' => 'frm_seguridad_usuarios'
        );

        $data = array(
            'data_tabla' => $data_tabla,
            'data_form' => $data_form,
        );

        return listado($data);
    }

    public function changeStatus($id, $data) {
        $usersModel = new UsuariosModel();
        $usuario = $usersModel->getById($id);

        if ($usuario) {
            $data = array(
                'estado' => $data['status']
            );

            $usersModel = new UsuariosModel();
            $data = $usersModel->update($data, $id);

            if (!is_bool($data)) {
                return array(
                    'estado' => 1,
                    'success' => 'Se ha cambiado el estado del usuario correctamente',
                );
            } else {
                return array(
                    'error' => 'No se pudo cambiar el estado del usuario',
                    'status' => 500
                );
            }
        } else {
            return array(
                'error' => 'No se encontro el usuario',
                'status' => 404
            );
        }
    }

    public function getData($id = null, $filters = null) {
        $model = new UsuariosModel();

        if ($id == 'all') {
            if (isset($filters['id_estado'])) {
                $estado = $filters['id_estado'];
                $model->where('estado', $estado);
            }

            return $model->getAll();
        } elseif ($id == 'perfil') {
            return $model->getById(getSession('id_usuario'));
        } else {
            $data = $model->getById($id);

            //$tipoIdentificacion = $this->dataServiceApi->getIdentificationTypeByCode($data->cod_pais, $data->id_tipo_identificacion);

            $data = array(
                'id_usuario' => $data->id_usuario,
                'userName' => $data->nombre_usuario,
                'email' => $data->correo,
                'personalPhone' => array(
                    'number' => $data->telefono,
                    'countryCode' => $data->cod_pais
                ),
                'nationality' => array(
                    'isoCode' => $data->cod_pais
                ),
                'rolId' => $data->id_rol,
                'taxpayerId' => $data->ivois_id,
                'businessName' => $data->nombre,
                'identification' => array(
                    'number' => $data->identificacion,
                    'code' => $data->id_tipo_identificacion
                )
            );

            return (object) $data;
        }
    }

    public function updateUserProfile($data) {
        $id = getSession('id_usuario');

        $data = array(
            'nombre_usuario' => $data['nombre_usuario'],
            'correo' => $data['correo'],
            'telefono' => $data['telefono'],
        );

        $model = new UsuariosModel();

        if ($model->update($data, $id)) {
            setSession('nombre', $data['nombre']);
            setSession('nombre_usuario', $data['nombre_usuario']);
            setSession('correo', $data['correo']);
            setSession('telefono', $data['telefono']);

            return array(
                'estado' => 1,
                'success' => 'Se ha actualizado el perfil correctamente'
            );
        } //Fin de validacion de operacion

        else {
            return array(
                'error' => 'No se pudo actualizar el perfil',
                'status' => 500
            );
        }
    }

    /**Cambiar la contrasenia de un usuario */
    public function actualizar_contrasenia($id, $pass, $old_pass) {
        $id_usuario = $id;

        $model = new ContraseniaModel();

        $contrasenia = $model->where('id_usuario', $id_usuario)->fila();

        $old_pass = $old_pass . getEnt('app.config.key');
        $new_pass = $pass . getEnt('app.config.key');

        //Si la contrasenia actual es correcta
        if (password_verify($old_pass, $contrasenia->contrasenia)) {
            //Si la nueva contrasenia es igual a la actual
            if (password_verify($new_pass, $contrasenia->contrasenia)) {
                return array(
                    'error' => 'La nueva contraseña no puede ser igual a la actual',
                );
            } elseif (validar($pass)) {
                $data = array(
                    'contrasenia' => encriptar_texto($pass),
                    'fecha_expiracion' => date('Y-m-d H:i:s', strtotime('+1 year')),
                    'estado' => 1
                );

                $model = new ContraseniaModel();

                $id = $model->update($data, $contrasenia->id_contrasenia);

                if ($id != 0) {
                    setSession('contrasenia_expiro', false);

                    $model = new UsuariosModel();

                    $usuario = $model->getById($id_usuario);

                    $correos = array(
                        $usuario->nombre => $usuario->correo,
                        //'RECEPTOR DE PRUEBA' => 'chepelcr@outlook.com',
                        //$emisor->nombre => $emisor->correo,
                    );

                    $mensaje = 'Estimado ' . $usuario->nombre . ',
                            <br>
                            
                            Se ha cambiado su contraseña en la plataforma de Modas Laura. <br> Su nueva contraseña es "<b>' . $pass . '</b>".
                            <br>
                            <br>
                            Presione <a href="' . baseUrl() . '">aquí</a> para ingresar al sistema.
                            <br>
                            <br>
                            Saludos,
                            <br>
                            <br>
                            <b>Equipo de ' . getEnt('app.name') . '</b>';

                    $data = array(
                        'receptor' => $correos,
                        'asunto' => 'Cambio de contraseña',
                        'body' => $mensaje
                    );

                    $correo = new Correo();

                    if ($correo->enviarCorreo($data)) {
                        $data = array(
                            'estado' => 1
                        );

                        $model = new UsuariosModel();
                        $model->update($data, $id_usuario);

                        return array(
                            'success' => 'Se ha cambiado la contraseña correctamente',
                        );
                    } else {
                        return array(
                            'error' => 'No se pudo enviar el correo con la nueva contraseña',
                            'status' => 500
                        );
                    }
                } else {
                    return array(
                        'error' => 'No se pudo cambiar la contraseña',
                        'status' => 500
                    );
                }
            } else {
                return array(
                    'error' => 'La contraseña no cumple con los requisitos',
                    'status' => 400
                );
            }
        } else {
            return array(
                'error' => 'La contraseña actual no es correcta',
                'status' => 400
            );
        }
    } //Fin del metodo para cambiar la contrasenia

    public function enviarContraseniaTemporal($id_usuario) {
        $model = new UsuariosModel();
        $usuario = $model->getById($id_usuario);

        if ($usuario) {
            $data = $this->enviar_contrasenia_temporal($usuario);
            $estado = $data['estado'];

            if ($estado == 1) {
                return array(
                    'estado' => 1,
                    'mensaje' => 'Se ha enviado un correo electronico con la nueva contraseña.'
                );
            } else {
                return array(
                    'error' => $data['mensaje'],
                    'status' => 500
                );
            }
        } //Fin de validacion de usuario

        else {
            return array(
                'error' => 'No se encontro el usuario',
                'status' => 404
            );
        }
    }

    public function enviarContraseniaTemporalPorCorreo($correo) {
        $usuariosModel = new UsuariosModel();
        $usuario = $usuariosModel->getByEmail($correo);

        //Si el usuario existe inserte la data
        if ($usuario) {
            $data = $this->enviar_contrasenia_temporal($usuario);
            $estado = $data['estado'];

            if ($estado == 1) {
                return array(
                    'estado' => 1,
                    'mensaje' => 'Se ha enviado un correo electronico con la nueva contraseña.'
                );
            } else {
                return array(
                    'error' => $data['mensaje'],
                    'status' => 500
                );
            }
        } //Fin de la validacion del usuario

        return array(
            'error' => 'No se encontro el usuario',
            'status' => 404
        );
    }

    /**Enviar una contrasenia temporal a un usuario por correo electronico */
    private function enviar_contrasenia_temporal($usuario) {
        $pass = generar_password_complejo(8);

        $contraseniaModel = new ContraseniaModel();
        $contrasenia = $contraseniaModel->contrasenia($usuario->id_usuario);

        if ($contrasenia) {
            $data = array(
                'contrasenia' => encriptar_texto($pass),
                'fecha_expiracion' => date('Y-m-d H:i:s')
            );

            $contraseniaModel = new ContraseniaModel();
            $id = $contraseniaModel->update($data, $contrasenia->id_contrasenia);
        } //Fin de validacion de contrasenia

        else {
            $data = array(
                'id_usuario' => $usuario->id_usuario,
                'contrasenia' => encriptar_texto($pass),
                'fecha_expiracion' => date('Y-m-d H:i:s'),
                'estado' => 1
            );

            $contraseniaModel = new ContraseniaModel();
            $id = $contraseniaModel->insert($data);
        } //Fin de validacion de contrasenia

        if ($id != 0) {
            $correos = array(
                $usuario->nombre => $usuario->correo,
                //'RECEPTOR DE PRUEBA' => 'chepelcr@outlook.com',
                //$emisor->nombre => $emisor->correo,
            );

            $mensaje = 'Estimado ' . $usuario->nombre . ',
			<br>
			
			Su clave temporal es "<b>' . $pass . '</b>", debe cambiarla la proxima vez que inicie sesión.
			<br>

			Presione el siguiente enlace para iniciar sesión:
			<br>
			<a href="' . baseUrl() . '">Iniciar sesion</a>
			<br>
			<br>
			Saludos,
			<br>
			<br>
			<b>Equipo de Modas Laura</b>';

            $data = array(
                'receptor' => $correos,
                'asunto' => 'Cambio de contraseña',
                'body' => $mensaje
            );

            $correo = new Correo();

            if ($correo->enviarCorreo($data))
                return array(
                    'estado' => 1,
                    'mensaje' => 'Se ha enviado un correo electronico con la nueva contraseña.'
                );

            else
                return array(
                    'estado' => 0,
                    'mensaje' => 'No se ha podido enviar el correo electronico con la nueva contraseña.'
                );
        } //Fin de validacion de id

        else {
            return array(
                'estado' => 0,
                'mensaje' => 'No se ha podido actualizar la contraseña.'
            );
        }
    } //Fin del metodo para enviar una contrasenia temporal
}
