<?php

namespace App\Controllers;

use App\Models\UsuariosModel;

/** Clase para iniciar sesion en la aplicacion */
class Login extends BaseController
	{
		/** Funcion para mostrar el login */
		public function index()
		{
			if(!is_login())
				return view('seguridad/login/login');

			else
				//Cargar la pagina principal
				return redirect(baseUrl());
		}//Fin de la funcion

		/** Funcion para consultar si el usuario existe en la base de datos */
		public function consultar()
		{
			$respuesta = array(
				'estado' => 0,
				'error' => 'Usuario o contraseña incorrectos.'
			);

			//Validar si el usuario ha iniciado sesion
			if (!is_login())
			{
				$user = post('usuario');
				$pswd = post('contrasenia');

				$usuariosModel = new UsuariosModel();

				$usuariosModel->where('correo', $user);
			
				$usuario = $usuariosModel->fila();

				if($usuario && $usuario->estado != 0)
				{
					$estado_contrasenia = validatePassword($usuario->id_usuario, $pswd);

					//$estado_contrasenia = 1;

					//Validar si la contrasenia es correcta
					switch ($estado_contrasenia)
					{
						case '1':
							$data = array(
								'id_usuario'=>$usuario->id_usuario,
								'nombre_usuario'=>$usuario->nombre_usuario,
								'id_rol'=>$usuario->id_rol,
								'id_empresa'=>$usuario->id_empresa,
								'correo'=>$usuario->correo,
								'identificacion'=>$usuario->identificacion,
								'nombre'=>$usuario->nombre,
							);
							
							setDataSession($data);

							$respuesta = array(
								'estado' => '1',);
						break;

						case '2':
							$data = array(
								'id_usuario'=>$usuario->id_usuario,
								'nombre_usuario'=>$usuario->nombre_usuario,
								'id_rol'=>$usuario->id_rol,
								'id_empresa'=>$usuario->id_empresa,
								'correo'=>$usuario->correo,
								'identificacion'=>$usuario->identificacion,
								'nombre'=>$usuario->nombre,
								'contrasenia_expiro' => true,
							);
							
							setDataSession($data);

							$respuesta = array(
								'estado' => '2',
								'error' => 'La contraseña ha expirado, debe cambiarla para continuar.');
						break;

						case '3':
							$respuesta = array(
								'estado' => '3',
								'error' => 'Debe esperar un momento para volver a intentar.');
						break;
					}//Fin del switch
				}//Fin del if

				return json_encode($respuesta);
			}//Fin de la validacion
			
			else
				return $respuesta = array(
					'estado' => '1',);
					
		}//Fin de la funcion para consultar un usuario

		/**Salir de la aplicacion */
		public function salir()
		{
			destroy();

			return json_encode(array(
				'estado' => '1',
			));
		}//Fin de la funcion para salir de la aplicacion

		public function olvido(){
			if(!is_login())
				return view('seguridad/login/olvido');

			else
				//Cargar la pagina principal
				return redirect(baseUrl());
		}//Fin de la funcion

		/**Recuperar la contrasenia de un usuario */
		public function recuperar()
		{
			if(!is_login())
			{
				if(post('correo'))
				{
					$correo = post('correo');

					$usuariosModel = new UsuariosModel();

					$usuariosModel->where('correo', $correo);

					$usuario = $usuariosModel->fila();

					//Si el usuario existe inserte la data
					if($usuario)
					{
						return json_encode(enviar_contrasenia_temporal($usuario));
					}//Fin de la validacion del usuario

					return json_encode(
						array(
							'estado' => '0',
							'error' => 'El correo no existe.'
						)
					);
				}//Fin de la validacion

				return json_encode(
					array(
						'estado' => '0',
						'error' => 'No se ha ingresado el correo.'
					)
				);
			}//Fin de la validacion de logueo
			
			else
				return json_encode(
					array(
						'estado' => '0',
						'error' => 'Ya ha iniciado sesión.'
					)
				);
		}//Fin del metodo para recuperar la contrasenia
	}//Fin del controlador de login

?>