<?php
//Usar la base para el modelo que tenemos creado
namespace App\Models;

use Core\Model;

/** Modelo para la tabla de usuarios */
class FormatosModel extends Model
{
	protected $tableName = 'formatos';
	protected $primaryKey = 'id_formato';

	protected $tableFields = [
		'nombre_formato',
		'fecha_creacion',
        'estado',
	];

	

	protected $autoIncrement = true;

	protected $auditorias = true;
}//Fin de la clase
?>