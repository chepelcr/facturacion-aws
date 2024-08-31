<?php
namespace App\Models;

use Core\Model;

/** Modelo para la tabla de usuarios */
class TiposImpuestoModel extends Model
{
	protected $tableName = 'tipos_impuestos';
	protected $primaryKey = 'id_impuesto';

	protected $tableFields = [
		'descripcion',
		'porcentaje',
		'fecha_creacion',
		'fecha_modificacion',
		'fecha_eliminacion',
		'estado',
	];

	

	protected $auditorias = true;

	/**Obtener los tipos de impuestos activos o inactivos */
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