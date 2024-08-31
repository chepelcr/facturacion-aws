<?php
//Usar la base para el modelo que tenemos creado
namespace App\Models;

use Core\Model;

/** Modelo para la tabla de usuarios */
class TiendasModel extends Model
{
	protected $tableName = 'notificaciones';
	
	protected $primaryKey = 'id_notificacion';

	protected $tableFields = [
		'descripcion',
		'fecha',
		'estado',
	];

	protected $tableExtraViewFields = [
		'id_usuario',
	];

	

	protected $autoIncrement = true;

	protected $auditorias = true;
}//Fin de la clase
?>