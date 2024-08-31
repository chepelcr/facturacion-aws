<?php

namespace App\Models;

use Core\Model;

/** Modelo para la tabla de formatos de supermercados de Walmart */
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
} //Fin de la clase
