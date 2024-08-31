<?php

namespace App\Models;

use Core\Model;

/** Modelo para la tabla de categorias */
class CondicionesVentaModel extends Model
{
	protected $tableName = 'medios_pago';
	protected $primaryKey = 'id_medio_pago';

	protected $tableFields = [
		'codigo',
		'nombre',
		'created_at',
		'updated_at'
	];



	protected $autoIncrement = true;

	protected $auditorias = true;
} //Fin de la clase
