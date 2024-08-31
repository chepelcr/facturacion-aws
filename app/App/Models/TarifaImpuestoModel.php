<?php
namespace App\Models;

use Core\Model;

/** Modelo para la tabla de usuarios */
class TarifaImpuestoModel extends Model
{
	protected $tableName = 'tarifa_impuestos';
	protected $primaryKey = 'id_tarifa';

	protected $tableFields = [
		'porcentaje',
		'descripcion',
		'tipo_tarifa',
		'fecha_creacion',
		'fecha_modificacion',
		'fecha_eliminacion',
		'estado',
	];

	

	protected $auditorias = true;

	/**Obtener todas las tarifas de impuestos del MH */
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