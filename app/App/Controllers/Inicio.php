<?php 
	/**
	* Descripción: Controlador para la entidad Rol
	*/

namespace App\Controllers;

use App\Models\PuntosVentaModel;

class Inicio extends BaseController
	{
		/** Devolver el dash de la aplicacion */
		public function index()
		{
			if(is_login())
			{
				return $this->inicio();
			}//Fin de la validacion

			else
				header('Location: '.baseUrl('login'));
		}//Fin de la funcion index
	}//Fin de la clase
?>