<?php
//Usar la base para el modelo que tenemos creado
namespace App\Models;

use Core\Model;

/** Modelo para la tabla de ordenes de compra */
class OrdenesModel extends Model
{
	protected $tableName = 'ordenes';
	protected $primaryKey = 'id_orden';

	protected $tableFields = [
		'nombre',
		'numero_departamento',
		'numero_proveedor',
		'fecha_creacion',
		'fecha_modificacion',
		'fecha_eliminacion',
		'estado',
	];

	protected $autoIncrement = true;
	protected $auditorias = true;
} //Fin de la clase
