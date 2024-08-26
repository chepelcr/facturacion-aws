<?php

use App\Librerias\Correo;
use App\Models\ContraseniaModel;
use App\Models\EmpresasModel;
use App\Models\UbicacionesModel;
use App\Models\UsuariosModel;

/** Validar si el usuario ha iniciado sesion */
function is_login() {
	return getSession();
	//return true;
} //Fin de la validacion para el login

/**Generar una contraseña aleatoriamente */
function generar_password_complejo($largo) {
	$cadena_base =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
	$cadena_base .= '0123456789';
	$cadena_base .= '!@#&';

	$password = '';
	$limite = strlen($cadena_base) - 1;

	for ($i = 0; $i < $largo; $i++)
		$password .= $cadena_base[rand(0, $limite)];

	return $password;
} //Fin del metodo para generar una contraseña aleatoriamente

/**
 * Encriptar un texto 
 * @param string $texto Texto a encriptar
 * @return string Texto encriptado
 */
function encriptar_texto($texto) {
	$key = getEnt('app.config.key');
	$texto = $texto . $key;

	return password_hash($texto, PASSWORD_DEFAULT);
} //Fin del metodo para encriptar un texto

//Validar si un texto esta vacio
function validar($texto) {
	if ($texto && $texto != '') {
		return true;
	}

	return false;
} //Fin de la funcion para validar si un texto esta vacio

/**Validar la contrasenia de un usuario */
function validatePassword($id_usuario, $pswd) {
	$pswd = $pswd . getEnt('app.config.key');

	$contraseniaModel = new ContraseniaModel();
	$contraseniaModel->where('id_usuario', $id_usuario);

	$contrasenia = $contraseniaModel->fila();

	//Si la contrasenia esta bloqueada
	if ($contrasenia->bloqueado == 1) {
		//Validar fecha de bloqueo
		if ($contrasenia->fecha_desbloqueo > date('Y-m-d H:i:s')) {
			return 3;
		}
	} elseif (password_verify($pswd, $contrasenia->contrasenia)) {
		//Si la fecha de expiracion es menor a la fecha actual
		if ($contrasenia->fecha_expiracion < date('Y-m-d H:i:s')) {
			return 2;
		} //Fin de validacion de expiracion

		//Si la contrasenia esta bloqueada
		elseif ($contrasenia->bloqueado == 1) {
			//Validar fecha de bloqueo
			if ($contrasenia->fecha_desbloqueo < date('Y-m-d H:i:s')) {
				//Desbloquear la contrasenia
				$data = array(
					'bloqueado' => 0,
					'intentos_fallidos' => 0,
					'fecha_bloqueo' => null,
					'fecha_desbloqueo' => null
				);

				$contraseniaModel = new ContraseniaModel();
				$contraseniaModel->update($data, $contrasenia->id_contrasenia);

				return 1;
			} //Fin de validacion de fecha de bloqueo

			return 3;
		} //Fin de validacion de bloqueo

		else {
			return 1;
		}
	} //Fin de validacion de contrasenia

	//Si la contrasenia no coincide
	else {
		//Aumentar los interntos fallidos
		$contrasenia->intentos_fallidos = $contrasenia->intentos_fallidos + 1;

		//Si el usuario tiene mas de 5 intentos fallidos
		if ($contrasenia->intentos_fallidos >= 5) {
			//Bloquear la cuenta
			$data = array(
				'intentos_fallidos' => $contrasenia->intentos_fallidos,
				'bloqueado' => 1,
				'fecha_bloqueo' => date('Y-m-d H:i:s'),
				'fecha_desbloqueo' => date('Y-m-d H:i:s', strtotime('+1 minutes'))
			);

			$contraseniaModel = new ContraseniaModel();
			$contraseniaModel->update($data, $contrasenia->id_contrasenia);

			return 3;
		} //Fin de validacion de intentos

		//Actualizar los intentos fallidos
		$data = array(
			'intentos_fallidos' => $contrasenia->intentos_fallidos
		);

		$contraseniaModel = new ContraseniaModel();
		$contraseniaModel->update($data, $contrasenia->id_contrasenia);

		return 0;
	} //Fin de actualizacion de intentos fallidos
} //Fin del metodo para validar la contraseña

/**Enviar una contrasenia temporal a un usuario por correo electronico */
function enviar_contrasenia_temporal($usuario) {
	$pass = generar_password_complejo(8);

	$contraseniaModel = new ContraseniaModel();
	$contrasenia = $contraseniaModel->contrasenia($usuario->id_usuario);

	if ($contrasenia) {
		$data = array(
			'contrasenia' => encriptar_texto($pass),
			'fecha_expiracion' => date('Y-m-d H:i:s')
		);

		$contraseniaModel = new ContraseniaModel();
		$data = $contraseniaModel->update($data, $contrasenia->id_contrasenia);
	} //Fin de validacion de contrasenia

	else {
		$data = array(
			'id_usuario' => $usuario->id_usuario,
			'contrasenia' => encriptar_texto($pass),
			'fecha_expiracion' => date('Y-m-d H:i:s'),
			'estado' => 1
		);

		$contraseniaModel = new ContraseniaModel();
		$data = $contraseniaModel->insert($data);
	} //Fin de validacion de contrasenia

	if (!is_object($data)) {
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

		if ($correo->enviarCorreo($data)) {
			$data = array(
				'status' => 200,
				'mensaje' => 'Se ha enviado un correo electronico con la nueva contraseña.'
			);
		} else {
			$data = array(
				'status' => 500,
				'error' => 'No se ha podido enviar el correo electronico con la nueva contraseña.',
			);
		}
	} else {
		$data = array(
			'status' => 500,
			'error' => 'No se ha podido actualizar la contraseña.'
		);
	}

	return $data;
} //Fin del metodo para enviar una contrasenia temporal

/**Obtener el perfil del usuario que ha iniciado sesion */
function getPerfil() {
	if (is_login()) {
		$usuariosModel = new UsuariosModel();
		$perfil = $usuariosModel->getPerfil();

		$datos_personales = array(
			'nombre' => $perfil->nombre,
			'identificacion' => $perfil->identificacion,
			'id_tipo_identificacion' => $perfil->id_tipo_identificacion,
			'cod_pais' => $perfil->cod_pais,
			'identificaciones' => array(
				(object) array(
					'id_tipo_identificacion' => $perfil->id_tipo_identificacion,
					'tipo_identificacion' => $perfil->tipo_identificacion
				),
			),
			'codigos' =>
			array(
				(object) array(
					'cod_pais' => $perfil->cod_pais,
					'nombre' => $perfil->nombre_pais
				),
			),
		);

		$datos_contacto = array(
			'telefono' => $perfil->telefono,
			'correo' => $perfil->correo,
		);

		$datos_usuario = array(
			'nombre_usuario' => $perfil->nombre_usuario,
			'id_empresa' => $perfil->id_empresa,
			'empresas' => array(
				(object) array(
					'id_empresa' => $perfil->id_empresa,
					'nombre' => $perfil->nombre_empresa
				),
			),
			'id_rol' => $perfil->id_rol,
			'roles' => array(
				(object) array(
					'id_rol' => $perfil->id_rol,
					'nombre_rol' => $perfil->nombre_rol
				),
			),
		);

		$arrayPerfil = array(
			'datos_personales' => $datos_personales,
			'datos_contacto' => $datos_contacto,
			'datos_usuario' => $datos_usuario,
		);

		return $arrayPerfil;
	}

	return false;
} //Fin del metodo para obtener el perfil del usuario

/**Obtener la empresa del usuario que ha iniciado sesión */
function getEmpresa() {
	if (is_login()) {
		$empresasModel = new EmpresasModel();
		$empresa = $empresasModel->getEmpresa();

		$datos_personales = array(
			'nombre' => $empresa->nombre,
			'identificacion' => $empresa->identificacion,
			'id_tipo_identificacion' => $empresa->id_tipo_identificacion,
			'cod_pais' => $empresa->cod_pais,
			'identificaciones' => array(
				(object) array(
					'id_tipo_identificacion' => $empresa->id_tipo_identificacion,
					'tipo_identificacion' => $empresa->tipo_identificacion
				),
			),
			'codigos' =>
			array(
				(object) array(
					'cod_pais' => $empresa->cod_pais,
					'nombre' => $empresa->nombre_pais
				),
			),
		);

		$datos_contacto = array(
			'telefono' => $empresa->telefono,
			'correo' => $empresa->correo,
		);

		$provinciasModel = new UbicacionesModel();
		$provincias = $provinciasModel->provincias();

		$provinciasModel = new UbicacionesModel();
		$cantones = $provinciasModel->cantones($empresa->cod_provincia);

		$provinciasModel = new UbicacionesModel();
		$distritos = $provinciasModel->distritos($empresa->cod_provincia, $empresa->cod_canton);

		$provinciasModel = new UbicacionesModel();
		$barrios = $provinciasModel->barrios($empresa->cod_provincia, $empresa->cod_canton, $empresa->cod_distrito);

		$dataProvincias = array(
			'cod_provincia' => $empresa->cod_provincia,
			'provincia' => $empresa->provincia,
			'provincias' => $provincias,
			'cod_canton' => $empresa->cod_canton,
			'canton' => $empresa->canton,
			'cantones' => $cantones,
			'cod_distrito' => $empresa->cod_distrito,
			'distrito' => $empresa->distrito,
			'distritos' => $distritos,
			'cod_barrio' => $empresa->cod_barrio,
			'barrio' => $empresa->barrio,
			'barrios' => $barrios,
		);

		$datos_empresa = array(
			'nombre_comercial' => $empresa->nombre_comercial,
		);

		$datos_empresa = array(
			'id_empresa' => $empresa->id_empresa,
			'datos_personales' => $datos_personales,
			'datos_contacto' => $datos_contacto,
			'dataProvincias' => $dataProvincias,
			'datos_empresa' => $datos_empresa,
			'actividades_economicas' => array(
				(object) array(
					'cod_actividad' => $empresa->cod_actividad,
					'nombre_actividad' => $empresa->nombre_actividad
				),
			),
		);

		return $datos_empresa;
	}
	return false;
}

function setEmpresaData() {
	$empresaModel = new EmpresasModel();

	$empresa = $empresaModel->getEmpresa();

	$dataEmpresa = array(
		'empresa_identificacion' => $empresa->identificacion,
		'empresa_nombre' => $empresa->nombre,
		'empresa_nombre_comercial' => $empresa->nombre_comercial,
		'empresa_cod_actividad' => $empresa->cod_actividad,
		'empresa_nombre_actividad' => $empresa->nombre_actividad,
	);

	setDataSession($dataEmpresa);
}
