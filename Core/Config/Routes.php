<?php

use Core\Config\Controllers;
use Core\Controller;

/**Clase para manejar el routeo del controlador y acciones */
class Routes
{
	private $default_controller = '';
	private $default_action = '';

	protected $estado = 200;
	protected Controller $controller;

	public function __construct()
	{
		$this->init_load();
	}

	/**Carga inicial de la aplicacion */
	private function init_load()
	{
		require_once '../vendor/autoload.php';
		require_once '../Core/helper/load_helper.php';
	}//Fin de la funcion

	public function setDefault($controller, $action)
	{
		$this->default_controller = $controller;
		$this->default_action = $action;

		return $this;
	}//Fin del metodo para establecer el controlador y funcion por defecto

	/**Obtener un controlador de la aplicacion */
	private function getController($controllerName)
	{
		$controllerName = "App\\Controllers\\".$controllerName;
		$this->controller = new $controllerName();

		return $this->controller;
	}//Fin del metodo

	/**función que llama al controlador y su respectiva acción, que son pasados como parámetros */
	private function call( $controllerName, $action )
	{
		/**Obtener un controlador */
		$controller = $this->getController($controllerName);

		/**Validar el tipo de solicitud que entra a la aplicacion */
		switch($action)
		{
			/**Si se va a guardar un objeto */
			case 'guardar':
				/**Si la solicitud contiene datos */
				if(post())
				{
					if (getSegment(3))
						echo $controller->guardar(getSegment(3));

					/**Realizar la accion por defecto del metodo */
					else
						echo $controller->guardar();
				}//Fin de la validacion de la solicitud

				else
					header('Location: '.baseUrl(getSegment(1)));
			break;
			
			//Obtener una fila especifica del objeto solicitado  
			//http://localhost/controlador/update/id/objeto
			case 'update':
				if(post())
				{
					if(getSegment(3)&&getSegment(4))
						echo $controller->update(getSegment(3), getSegment(4));

					/**Realizar la accion por defecto del metodo */
					elseif (getSegment(3))
						echo $controller->update(getSegment(3));
				}//Fin de la validacion de la solicitud

				else
					header('Location: '.baseUrl(getSegment(1)));
			break;

			//Activar un objeto especifico
			//http://localhost/controlador/activar/id/objeto
			case 'activar':
				if(getSegment(3)&&getSegment(4))
					echo $controller->activar(getSegment(3), getSegment(4));

				/**Realizar la accion por defecto del metodo */
				elseif (getSegment(3))
					echo $controller->activar(getSegment(3));

				else
					echo $controller->activar();
			break;

			//Desactivar un objeto especifico
			//http://localhost/controlador/desactivar/id/objeto
			case 'desactivar':
				if(getSegment(3)&&getSegment(4))
					echo $controller->desactivar(getSegment(3), getSegment(4));

				/**Realizar la accion por defecto del metodo */
				elseif (getSegment(3))
					echo $controller->desactivar(getSegment(3));

				else
					echo $controller->desactivar();
			break;

			case 'obtener':
				/**Obtener una fila especifica del objeto solicitado 
				 * 
				 * http://localhost/controlador/obtener/id/objeto
				*/
				if(getSegment(3)&&getSegment(4))
					echo $controller->obtener(getSegment(3), getSegment(4));

				/**Obtener todos los registros del modulo solicitado 
				 * 
				 * http://localhost/controlador/obtener/all
				*/
				elseif (getSegment(3))
					echo $controller->obtener(getSegment(3));

				/**Realizar la accion por defecto del metodo */
				else
					echo $controller->obtener();
			break;

			case 'validar':
				/**Validar si un campo una fila especifica del objeto solicitado 
				 * 
				 * http://localhost/controlador/validar/id/objeto
				*/
				if(getSegment(3)&&getSegment(4))
					echo $controller->validar(getSegment(3), getSegment(4));

				/**Obtener todos los registros del modulo solicitado 
				 * 
				 * http://localhost/controlador/obtener/all
				*/
				elseif (getSegment(3))
					echo $controller->validar(getSegment(3));

				/**Realizar la accion por defecto del metodo */
				else
					echo $controller->validar();
			break;
				
			default:
				echo $controller->{$action}();
			break;
		}//Fin del switch
	}//Fin de la funcion

	/**Realizar una solicitud a la aplicacion */
	public function llamar()
	{
		$default_controller = $this->default_controller;
		$default_action = $this->default_action;

		$controllers = new Controllers($default_controller, $default_action);

		$controller = $controllers->controller();
		$action = $controllers->accion();

		if($controller!='error')
		{
			//Poner la primera letra en mayuscula
			$controller = ucfirst($controller);

			$lista_controller = $controllers->listar_metodos($controller);

			//verifica que el controlador obtenido desde la url esté dentro del arreglo controllers
			if (array_key_exists($controller, $lista_controller))
			{
				//verifica que el arreglo controllers con la clave que es la variable controller del index exista la acción
				if (in_array($action, $lista_controller[$controller]))
				{
					//llama  la función call y le pasa el controlador a llamar y la acción (método) que está dentro del controlador
					$this->call( $controller, $action );
				}

				else
				{
					$this->estado = 404;
					$mensaje = 'La pagina solicitada no esta disponible';
					
					$error = $this->data_error($mensaje);
				
					echo $this->error($controllers->getDefaultController(), $error);
				}//Fin del else
			}

			else
			{
				$this->estado = 404;
				$mensaje = 'La pagina solicitada no esta disponible';

				$error = $this->data_error($mensaje);
			
				echo $this->error($controllers->getDefaultController(), $error);
			}//Fin de la validacion
		}//Fin de la validacion

		//Si el controlador es error
		else
		{
			$this->estado = 404;
			$mensaje = 'Se ha generado un error';

			$error = $this->data_error($mensaje);
			
			echo $this->error($controllers->getDefaultController(), $error);
		}
	}//Fin de la funcion

	private function data_error($mensaje)
        {
            $error = array(
                'codigo'=>$this->estado,
                'error'=>$mensaje
            );

            $data = json_encode($error);

            return json_decode($data);
        }//Fin de la funcion

	/**Mostrar la p[agina por defecto de la aplicacion */
	public function error($controller, $error)
	{
		//crea el controlador
		$controller = $this->getController($controller);

		return $controller->error($error);
	}//Fin de la funcion para mostrar la pagina de error por defecto de la aplicacion
}//Fin de la clase
?>
