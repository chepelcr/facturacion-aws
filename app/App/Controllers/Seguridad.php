<?php

namespace App\Controllers;

use App\Librerias\Correo;
use App\Models\CodigosPaisesModel;
use App\Models\EmpresasModel;
use App\Models\RolesModel;
use App\Models\TipoIdentificacionModel;
use App\Models\UsuariosModel;
use Core\Auditorias\AuditoriaModel;
use Core\Auditorias\ErroresModel;
use Core\Permisos\PermisosModel;
use Core\Permisos\SubmodulosAccionesModel;

/**
 * Descripción: Controlador para la entidad usuario
 */
class Seguridad extends BaseController {
	protected $isModulo = true;

	protected $nombre_modulo = 'seguridad';

	protected $objetos = ['usuarios', 'roles'];

	protected $campos_validacion = array(
		'usuarios' => 'identificacion',
		'roles' => 'nombre_rol'
	);

	protected $validacion_login = array(
		'usuarios' => true,
		'roles' => true,
	);

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

	/**Ontener todos los usuarios del sistema */
	public function usuarios() {
		if (!is_login()) {
			redirect(baseUrl('login'));
		}

		if (!validar_permiso('seguridad', 'usuarios', 'consultar')) {
			$error = $this->object_error(403, 'No tiene permiso para realizar esta acción');

			return  $this->error($error);
		}

		switch (getsegment(3)) {
			case 'listado':
				$usuariosModel = new UsuariosModel();
				$usuarios = $usuariosModel->getAll();

				$nombreTabla = 'seguridad/usuario/table';

				$data_tabla = array(
					'nombreTable' => $nombreTabla,
					'nombre_tabla' => 'listado_seguridad_usuarios',
					'dataTable' => array(
						'usuarios' => $usuarios
					)
				);

				$tiposIdentificacionMoodel = new TipoIdentificacionModel();
				$identificaciones = $tiposIdentificacionMoodel->getAll();

				$codigosPaisesModel = new CodigosPaisesModel();
				$codigos = $codigosPaisesModel->getAll();

				$datos_personales = array(
					'identificaciones' => $identificaciones,
					'codigos' => $codigos
				);

				$rolesModel = new RolesModel();
				$empresasModel = new EmpresasModel();

				$datos_usuario = array(
					'empresas' => $empresasModel->getAll(),
					'roles' => $rolesModel->getAll(),
				);

				$nombreForm = 'seguridad/usuario/form';

				$data_form = array(
					'dataForm' => array(
						'datos_personales' => $datos_personales,
						'datos_usuario' => $datos_usuario
					),
					'nombreForm' => $nombreForm,
					'nombre_form' => 'frm_seguridad_usuarios'
				);

				$data = array(
					'data_tabla' => $data_tabla,
					'data_form' => $data_form,
				);

				return $this->listado($data);
				break;

			default:
				$data = array(
					'script' => cargar("cargar_listado('seguridad', 'usuarios', '" . baseUrl('seguridad/usuarios/listado') . "');")
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

		switch (getsegment(3)) {
			case 'listado':
				$rolesModel = new RolesModel();
				$roles = $rolesModel->getAll();

				$nombreTabla = 'seguridad/rol/table';

				$data_tabla = array(
					'nombreTable' => $nombreTabla,
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
					'script' => cargar("cargar_listado('seguridad', 'roles', '" . baseUrl('seguridad/roles/listado') . "');")
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
					'script' => cargar('cargar_listado("seguridad", "auditorias", "' . baseUrl('seguridad/auditorias/listado') . '");')
				);

				return $this->inicio($data);
			}
		} //Fin de la validacion

		else {
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
				redirect(baseUrl('login'));
			}

			$data = array(
				'script' => cargar('cargar_listado("seguridad", "errores", "' . baseUrl('seguridad/errores/listado') . '");')
			);

			return $this->inicio($data);
		}
	} //Fin de la funcion para mostrar todos los errores

	/**Actualizar un objeto de la base de datos */
	public function update($id, $objeto = null) {
		if (is_login()) {
			if ($id == 'perfil' || $id == 'contrasenia')
				$objeto = 'usuarios';

			if (!is_null($objeto) && in_array($objeto, $this->objetos)) {
				switch ($objeto) {
					case 'usuarios':
						switch ($id) {
							case 'perfil':
								$id = getSession('id_usuario');

								$data = array(
									'nombre_usuario' => post('nombre_usuario'),
									'correo' => post('correo'),
									'telefono' => post('telefono'),
								);

								$model = $this->model('usuarios');

								if ($model->update($data, $id)) {
									setSession('nombre', post('nombre'));
									setSession('nombre_usuario', post('nombre_usuario'));
									setSession('correo', post('correo'));
									setSession('telefono', post('telefono'));

									return json_encode(array(
										'estado' => 1,
									));
								} //Fin de validacion de operacion

								else
									return json_encode(array(
										'error' => 'No se pudo actualizar el perfil',
									));
								break;

							case 'contrasenia':
								$id = getSession('id_usuario');

								return $this->actualizar_contrasenia($id, post('contra_nueva_conf'), post('contra_actual'));
								break;

							default:
								//Si el usuario no tiene permisos para modificar
								if (!validar_permiso($this->nombre_modulo, 'usuarios', 'modificar'))
									return json_encode(array(
										'error' => 'No tiene permisos para realizar esta acción.',
									));

								$data = array(
									'nombre_usuario' => post('nombre_usuario'),
									'correo' => post('correo'),
									'telefono' => post('telefono'),
									'id_rol' => post('id_rol'),
									'id_empresa' => post('id_empresa')
								);

								$model = model('usuarios');

								if ($model->update($data, $id))
									return json_encode(array(
										'estado' => 1,
										'success' => 'Se actualizó el usuario correctamente.',
									));

								else
									return json_encode(array(
										'error' => 'No se pudo actualizar el usuario',
									));
								break;
						} //Fin del switch de id
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
								$nombre_modulo = $modulo->nombre_modulo;

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

										if (post('permiso_' . $nombre_modulo . '_' . $nombre_submodulo . '_' . $nombre_accion)) {
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

											//var_dump($id_permiso);
											//var_dump('Estoy llegando a '.$nombre_modulo.'_'.$nombre_submodulo.'_'.$nombre_accion);
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

			else
				return json_encode(array(
					'error' => 'No se pudo actualizar el objeto',
				));
		} //Fin de la validacion de sesion

		return json_encode(array(
			'error' => 'Debe iniciar sesión para realizar esta acción',
		));
	} //Fin del metodo para actualizar un objeto

	/**Guardar un objeto en la base de datos */
	public function guardar($objeto = null) {
		if (is_login()) {
			if (!is_null($objeto) && in_array($objeto, $this->objetos)) {
				$model = $this->model($objeto);

				switch ($objeto) {
					case 'usuarios':
						//Validar el permiso de acceso
						if (validar_permiso($this->nombre_modulo, 'usuarios', 'insertar')) {
							$identificacion = post('identificacion');

							//Eliminar los guiónes del número de identificación
							$identificacion = desformatear_cedula($identificacion);

							$correo = post('correo');
							$model->where('correo', $correo);

							if (!$model->fila()) {
								$model = model('usuarios');
								$model->where('identificacion', $identificacion);
								if (!$model->fila()) {
									$model = model('usuarios');

									$data = array(
										'identificacion' => $identificacion,
										'id_tipo_identificacion' => post('id_tipo_identificacion'),
										'nombre' => post('nombre'),
										'cod_pais' => post('cod_pais'),
										'telefono' => post('telefono'),
										'correo' => post('correo'),
										'nombre_usuario' => post('nombre_usuario'),
										'id_rol' => post('id_rol'),
										'id_empresa' => post('id_empresa'),
									);

									$id = $model->insert($data);

									if ($id && $id != 0) {
										$pass = generar_password_complejo(10);
										//$pass = 1234;

										$data_pass = array(
											'id_usuario' => $id,
											'contrasenia' => encriptar_texto($pass),
											'fecha_expiracion' => date('Y-m-d H:i:s'),
											'estado' => 1
										);

										$model = $this->model('contrasenia');

										$id_contrasenia = $model->insert($data_pass);

										//Si el id de la contraseña es mayor a cero, se envia el correo
										if ($id_contrasenia != 0) {
											$mensaje = 'Estimado ' . post('nombre') . ',
													<br>
													
													Se ha completado su registro en la plataforma de Modas Laura, debe cambiar la contraseña la primera vez que inicia sesión.
													<br>
													<br>
													Usuario: <b>' . post('correo') . '</b> <br>
													Contraseña: <b>' . $pass . '</b> <br>
													<br>
													<br>

													Presione el siguiente enlace para iniciar sesión: <br>
													<a href="' . baseUrl() . '">Iniciar</a>
													
													Saludos,
													<br>
													<br>
													<b>Equipo de Modas Laura</b>';

											$correos = array(
												post('nombre') => post('correo')
											);

											$data = array(
												'receptor' => $correos,
												'asunto' => 'Registro de usuario',
												'body' => $mensaje
											);

											$correo = new Correo();

											if ($correo->enviarCorreo($data))
												return json_encode(array(
													'success' => 'El usuario se ha registrado correctamente',
												));
											else
												return json_encode(array(
													'error' => 'No se pudo enviar el correo, debe enviar una nueva contraseña al usuario',
												));
										} //Fin de validacion de id_contrasenia

										else
											return json_encode(array(
												'error' => 'No se pudo guardar la contraseña.',
											));
									} //Fin de validacion de id

									else
										return json_encode(array(
											'error' => 'No se pudo guardar el usuario.',
										));
								} //Fin de validacion de identificacion

								else
									return json_encode(array(
										'error' => 'Ya existe un usuario con la identificación ' . $identificacion,
									));
							} //Fin de validacion de correo
							else
								return json_encode(array(
									'error' => 'El correo ya se encuentra registrado.',
								));
						} //Fin de validacion de permiso

						else
							return json_encode(array(
								'error' => 'No tiene permisos para realizar esta acción.',
							));
						break;

					case 'roles':
						$data = array(
							'nombre_rol' => post('nombre_rol'),
						);

						$id = $model->insert($data);

						if ($id != 0) {
							$submodulos_acciones_model = new SubmodulosAccionesModel();

							$modulos = $submodulos_acciones_model->modulos();

							//Recorrer modulos
							foreach ($modulos as $modulo) {
								$nombre_modulo = $modulo->nombre_modulo;
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

										if (post('permiso_' . $nombre_modulo . '_' . $nombre_submodulo . '_' . $nombre_accion)) {
											$data = array(
												'estado' => 1
											);

											$model->update($data, $id_permiso);

											//var_dump('Estoy llegando a '.$nombre_modulo.'_'.$nombre_submodulo.'_'.$nombre_accion);
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

	/**Cambiar la contrasenia de un usuario */
	private function actualizar_contrasenia($id, $pass, $old_pass) {
		$id_usuario = $id;

		$model = $this->model('contrasenia');

		$contrasenia = $model->where('id_usuario', $id_usuario)->fila();

		$old_pass = $old_pass . getEnt('app.config.key');
		$newPass = $pass . getEnt('app.config.key');

		//Si la contrasenia actual es correcta
		if (password_verify($old_pass, $contrasenia->contrasenia)) {
			//Si la nueva contrasenia es igual a la actual
			if (password_verify($newPass, $contrasenia->contrasenia)) {
				return json_encode(array(
					'error' => 'La nueva contraseña no puede ser igual a la actual',
				));
			} elseif (validar($pass)) {
				$data = array(
					'contrasenia' => encriptar_texto($pass),
					'fecha_expiracion' => date('Y-m-d H:i:s', strtotime('+1 year')),
					'estado' => 1
				);

				$model = $this->model('contrasenia');

				$id = $model->update($data, $contrasenia->id_contrasenia);

				if ($id != 0) {
					setSession('contrasenia_expiro', false);

					$model = $this->model('usuarios');

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
							<b>Equipo de Modas Laura</b>';

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

						$model = model('usuarios');
						$model->update($data, $id_usuario);

						return json_encode(array(
							'success' => 'Se ha cambiado la contraseña correctamente',
						));
					} else
						return json_encode(array(
							'error' => 'No se pudo enviar el correo con la nueva contraseña',
						));
				} //Fin de validacion de envio

				else
					return json_encode(array(
						'error' => 'No se pudo cambiar la contraseña',
					));
			} //Fin de validacion de contrasenia nueva

			else
				return json_encode(array(
					'error' => 'La contraseña no cumple con los requisitos',
				));
		} //Fin de validacion de contrasenia correcta

		else
			return json_encode(array(
				'error' => 'La contraseña actual no es correcta',
			));
	} //Fin del metodo para cambiar la contrasenia

	/**Enviar una contraseña temporal a un usuario */
	public function enviar_contrasenia() {
		if (!is_login()) {
			return json_encode(array(
				'error' => 'No se ha iniciado sesión',
				'status' => 401
			));
		}

		if (getSegment(3)) {
			//Validar permiso
			if (!validar_permiso($this->nombre_modulo, 'usuarios', 'modificar')) {

				$error = array(
					'error' => 'No tiene permisos para realizar esta acción.',
					'status' => 403
				);

				return $this->error($error);
			}

			$id_usuario = getSegment(3);

			$model = $this->model('usuarios');
			$usuario = $model->getById($id_usuario);

			if ($usuario) {
				$estado = enviar_contrasenia_temporal($usuario);
			} //Fin de validacion de usuario

			else {
				$estado = array(
					'error' => 'No se encontro el usuario',
					'status' => 404
				);
			};
		} else {
			$estado = array(
				'error' => 'No se ha indicado el usuario',
				'status' => 400
			);
		}

		if (!isset($estado['error'])) {
			return json_encode(array(
				'success' => 'Se ha enviado una contraseña temporal al usuario',
				'status' => 200
			));
		} else {
			return $this->error($estado);
		}
	} //Fin del metodo para enviar una contraseña temporal
}//Fin de la clase