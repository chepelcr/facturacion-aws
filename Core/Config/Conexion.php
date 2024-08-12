<?php
	namespace Core\Config;

	use \PDO;
	
	class Conexion
	{
		private static $instance = null;
		
		private function __construct(){}

		private function __clone(){}
		
		public static function getConnect(){
			if (!isset(self::$instance)) {
				$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;

				$dbGroup = getEnt("database.db_group");
		
				$host = getEnt('database.'.$dbGroup.'.host');
				$database = getEnt('database.'.$dbGroup.'.name');
		
				$user = getEnt('database.'.$dbGroup.'.user');
				$pswd = getEnt('database.'.$dbGroup.'.pswd');

				$port = getEnt('database.'.$dbGroup.'.port');
			
				if($port != ""){
					$dsn = "mysql:host=$host;port=$port;dbname=$database";
				} else {
					$dsn = "mysql:host=$host;dbname=$database";
				}
				self::$instance = new PDO($dsn, $user, $pswd, $pdo_options);
			}//Fin de validacion de instancia de conexion

			//Poner el conjunto de caracteres a utf8
			self::$instance->exec("SET NAMES utf8");

			//Retornar la instancia de conexion
			return self::$instance;
		}//Fin de getConnect

		public static function connectToPlanetScale(){
			// Use env variables to connect to the database
			$dsn = "mysql:host={$_ENV["DATABASE_HOST"]};dbname={$_ENV["DATABASE"]}";
			
			$options = array(
				PDO::MYSQL_ATTR_SSL_CA => "/etc/ssl/certs/ca-certificates.crt",
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
			);
			
			$pdo = new PDO($dsn, $_ENV["DATABASE_USERNAME"], $_ENV["DATABASE_PASSWORD"], $options);

			$pdo->exec("SET NAMES utf8");

			// Query to fetch list of tables
			$query = "SHOW TABLES";
			$stmt = $pdo->query($query);
			$tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

			if (!empty($tables)) {
				echo "Tables in the database:\n";
				foreach ($tables as $table) {
					echo "- $table\n";
				}
			} else {
				echo "Successfully ran the query. No tables were found in the database.\n";
			}

			self::$instance = $pdo;

			return self::$instance;
		}
	}
	
?>
