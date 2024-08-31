<?php
//Usar la base para el modelo que tenemos creado
namespace App\Models;

use Core\Model;

/** Modelo para la tabla de usuarios */
class UnidadesMedidaModel extends Model
{
	protected $tableName = 'unidades_medida';
	protected $primaryKey = 'id_unidad';

	protected $tableFields = [
		'descripcion',
		'simbolo',
	];

	

	protected $autoIncrement = true;

	protected $auditorias = true;
}//Fin de la clase
?>