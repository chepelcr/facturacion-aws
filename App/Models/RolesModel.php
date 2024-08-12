<?php

namespace App\Models;

use Core\Model;
use Core\Permisos\PermisosModel;

/**
 * Modelo para el acceso a la base de datos y funciones CRUD de la tabla: Roles
*/
class RolesModel extends Model
{
	protected $nombreTabla = "roles";
	protected $pk_tabla = "id_rol";

	protected $dbGroup = 'seguridad';

	protected $camposTabla = [
		'nombre_rol',
		'estado',
		'fecha_creacion',
	];

	protected $autoIncrement = true;

	protected $auditorias = true;

	/**Obtener un rol de la base de datos */
	public function obtener($id)
	{
		if($id == 'all')
		{
			return $this->getAll();
		}
		else
		{
			$rol = $this->getById($id);

			$permisosModel = new PermisosModel();

			$rol->modulos = (object) $permisosModel->modulos($id);
			
			return $rol;
		}

		return null;
	}
}
?>