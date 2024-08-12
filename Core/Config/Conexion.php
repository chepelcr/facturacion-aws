<?php
	namespace Core\Config;

	use \PDO;
	
	class Conexion
	{
		private static $instance=NULL;
		
		private function __construct(){}

		private function __clone(){}
		
		public static function getConnect($dbGroup = 'default'){
			$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
	
			$host = getEnt('database.'.$dbGroup.'.host');
			$database = getEnt('database.'.$dbGroup.'.name');
	
			$user = getEnt('database.'.$dbGroup.'.user');
			$pswd = getEnt('database.'.$dbGroup.'.pswd');

			$port = getEnt('database.'.$dbGroup.'.port');
			
			if (!isset(self::$instance[$dbGroup])) {
				self::$instance[$dbGroup] = new PDO('mysql:host='.$host.';dbname='.$database.';port='.$port, $user, $pswd, $pdo_options);
			}//Fin de validacion de instancia de conexion

			//Poner el conjunto de caracteres a utf8
			self::$instance[$dbGroup]->exec("SET NAMES utf8");

			//Retornar la instancia de conexion
			return self::$instance[$dbGroup];
		}//Fin de getConnect
	}
?>
