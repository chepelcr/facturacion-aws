<?php

namespace App\Models;

use Core\Model;

/** Modelo para la tabla de categorias */
class CategoriasModel extends Model
{
	protected $tableName = 'categorias';
	protected $primaryKey = 'id_categoria';

	protected $tableFields = [
		'nombre_categoria',
		'created_at',
		'updated_at'
	];

	protected $autoIncrement = true;

	protected $auditorias = true;
} //Fin de la clase
