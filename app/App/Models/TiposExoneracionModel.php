<?php
namespace App\Models;

use Core\Model;

/** Modelo para la tabla de tipos de exoneraciones */
class TiposExoneracionModel extends Model
{
	

	protected $tableName = 'tipos_exoneracion';
	protected $primaryKey = 'codigo_exoneracion';

	protected $tableFields = [
		'descripcion',
		"fecha_creacion",
		'estado',
	];

	protected $auditorias = true;

	/**Obtener los tipos de exoneracion activos o inactivos */
	public function obtener($id = 'all')
	{
		switch ($id) {
			case 'all':
				return $this->getAll();
				break;
			case 'activos':
				$this->where('estado', '1');
				return $this->getAll();
				break;

			case 'inactivos':
				$this->where('estado', '0');
				return $this->getAll();
				break;

			default:
				return $this->getById($id);
				break;
			}//Fin del switch
	}//Fin de la función obtener
}//Fin de la clase
?>