<?php

namespace Core\Config;

use Core\Aws\AwsSecretsService;
use \PDO;

class Conexion {
	private static $instance = NULL;

	private function __construct() {
		//Evita que se construya la clase
	}

	private function __clone() {
		//Evita que se cree una nueva instancia de la clase
	}

	public static function getConnect() {
		if (!isset(self::$instance)) {
			$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;

			$conexionInfo = AwsSecretsService::getSecret(getEnt('app.config.database'));

			$host = $conexionInfo['host'];
			$database = $conexionInfo['dbname'];
			$user = $conexionInfo['username'];
			$pswd = $conexionInfo['password'];
			$port = $conexionInfo['port'];

			$dsn = "mysql:host=$host;port=$port;dbname=$database";

			self::$instance = new PDO($dsn, $user, $pswd, $pdo_options);
		} //Fin de validacion de instancia de conexion

		//Poner el conjunto de caracteres a utf8
		self::$instance->exec("SET NAMES utf8");

		//Retornar la instancia de conexion
		return self::$instance;
	} //Fin de getConnect
}
