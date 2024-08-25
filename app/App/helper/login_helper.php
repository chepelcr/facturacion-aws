<?php

use App\Api\LocationsApi;
use App\Models\ContraseniaModel;
use App\Api\TaxpayersApi;
use App\Models\UsuariosModel;

/**
 * Validar si un usuario ha iniciado sesion
 * @return boolean True si ha iniciado sesion, false en caso contrario
 */
function is_login()
{
	$session = getSession();

	if ($session) {
		return true;
	}

	return false;
	//return true;
} //Fin de la validacion para el login

/**
 * Generar una contraseña aleatoria
 * @param int $largo Longitud de la contraseña
 * @return string Contraseña generada
 */
function generar_password_complejo($largo)
{
	$cadena_base =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
	$cadena_base .= '0123456789';
	$cadena_base .= '!@#%&*';

	$password = '';
	$limite = strlen($cadena_base) - 1;

	for ($i = 0; $i < $largo; $i++)
		$password .= $cadena_base[rand(0, $limite)];

	return $password;
} //Fin del metodo para generar una contraseña aleatoriamente

/**
 * Encriptar un texto con una clave y password_hash
 * @param string $texto Texto a encriptar
 * @return string Texto encriptado
 */
function encriptar_texto($texto)
{
	$key = getEnt('app.config.key');
	$texto = $texto . $key;

	//El texto no debe ser desencriptado
	return password_hash($texto, PASSWORD_DEFAULT);
} //Fin del metodo para encriptar un texto

/**
 * Validar si un texto esta vacio
 * @param string $texto Texto a validar
 * @return boolean True si el texto no esta vacio, false en caso contrario
 */
function validar($texto)
{
	if ($texto && $texto != '') {
		return true;
	}

	return false;
} //Fin de la funcion para validar si un texto esta vacio

/**
 * Validar si la contraseña del usuario es correcta
 * @param int $id_usuario Identificador del usuario
 * @param string $pswd Contraseña del usuario
 * @return int 0 si la contraseña no coincide, 1 si la contraseña es correcta, 2 si la contraseña ha expirado, 3 si la contraseña esta bloqueada
 */
function validar_contrasenia($id_usuario, $pswd)
{
	$contraseniaModel = new ContraseniaModel();
	$contrasenia = $contraseniaModel->contrasenia($id_usuario);

	$pswd = $pswd . getEnt('app.config.key');

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
		} else {
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

/**
 * Obtener el perfil del usuario que ha iniciado sesion
 * @return array Datos del perfil del usuario
 */
function getPerfil()
{
	if (is_login()) {
		$usuariosModel = new UsuariosModel();
		$perfil = $usuariosModel->getById(getSession('id_usuario'));

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

/**
 * Obtener la empresa del usuario que ha iniciado sesion
 * @return array Datos de la empresa
 */
function getEmpresa()
{
	/*if (getSession('empresa')) {
		return json_decode(getSession('empresa'));
	} else {
		*/
	$idNumber = getEnt("ivois.api.taxpayer.idNumber");

	$taxpayersApi = new TaxpayersApi();
	$empresa = $taxpayersApi->getTaxpayerByNationalityAndIdNumber(getCountryCode(), $idNumber);

	$datos_personales = array(
		'businessName' => $empresa->businessName,
		'identification' => $empresa->identification,
		'nationality' => $empresa->nationality,
		'identificaciones' => array(
			(object) array(
				'typeId' => $empresa->identification->typeId,
				'description' => $empresa->identification->description
			),
		),
		'countries' => array(
			$empresa->nationality,
		),
	);

	$locationsApi = new LocationsApi();

	$countries = $locationsApi->get_countries();

	$datos_contacto = array(
		'personalPhone' => $empresa->personalPhone,
		'fax' => $empresa->fax ?? null,
		'businessPhone' => $empresa->businessPhone,
		'email' => $empresa->email,
		'countries' => $countries,
	);

	$residenceCountry = $empresa->residence->countryCode;

	$provincias = $locationsApi->get_states_by_iso_code($residenceCountry);
	$cantones = $locationsApi->get_counties_by_state_id_and_iso_code($empresa->residence->stateId, $residenceCountry);
	$distritos = $locationsApi->get_districts_by_county_id_and_state_id_and_iso_code($empresa->residence->countyId, $empresa->residence->stateId, $residenceCountry);
	$barrios = $locationsApi->get_neighborhoods_by_district_id_and_county_id_and_state_id_and_iso_code($empresa->residence->districtId, $empresa->residence->countyId, $empresa->residence->stateId, $residenceCountry);

	$dataProvincias = array(
		#'cod_provincia' => $empresa->residence->stateId,
		'countries' => $countries,
		'states' => $provincias,
		#'cod_canton' => $empresa->residence->countyId,
		#'canton' => $empresa->residence->countyName,
		'counties' => $cantones,
		#'cod_distrito' => $empresa->residence->districtId,
		#'distrito' => $empresa->residence->districtName,
		'districts' => $distritos,
		#'cod_barrio' => $empresa->residence->neighborhoodId,
		#'barrio' => $empresa->residence->neighborhoodName,
		'neighborhoods' => $barrios,
		'residence' => $empresa->residence
		#'otras_senas'=>$empresa->residence->address
	);

	$datos_empresa = array(
		'tradeName' => $empresa->tradeName,
	);

	$datos_empresa = array(
		'taxpayerId' => $empresa->taxpayerId,
		'datos_personales' => $datos_personales,
		'datos_contacto' => $datos_contacto,
		'dataProvincias' => $dataProvincias,
		'datos_empresa' => $datos_empresa,
		'activities' => $empresa->activities,
	);

	return $datos_empresa;
	//}
}//Fin de la funcion para obtener la empresa del usuario que ha iniciado sesión

/**
 * Obtiene el código de país del contribuyente
 * @return string Código de país
 */
function getCountryCode()
{
	return getEnt("ivois.api.taxpayer.nationality");
}
