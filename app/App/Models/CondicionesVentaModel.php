<?php

namespace App\Models;

use Core\Model;

/** Modelo para la tabla de categorias */
class CondicionesVentaModel extends Model
{
	protected $tableName = 'condiciones_venta';
	protected $primaryKey = 'id_condicion';

	protected $tableFields = [
		'codigo',
		'nombre',
		'created_at',
		'updated_at'
	];



	protected $autoIncrement = true;

	protected $auditorias = true;
} //Fin de la clase
