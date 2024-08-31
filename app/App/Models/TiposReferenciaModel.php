<?php
namespace App\Models;

use Core\Model;

/** Modelo para la tabla de tipos de referencias */
class TiposReferenciaModel extends Model
{
	protected $tableName = 'tipos_referencia';
	protected $primaryKey = 'id_codigo';

	protected $tableFields = [
		'tipo_referencia',
		"fecha_creacion",
		'estado',
	];

	
	
	protected $auditorias = true;
}//Fin de la clase
?>