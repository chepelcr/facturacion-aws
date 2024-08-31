<?php

namespace Core\Auditorias;

use Core\Model;

class ErroresModel extends Model
{
	protected $tableName = "error";
	protected $primaryKey = "id_error";

	protected $tableFields = [
		'sentencia',
		'controlador',
		'id_usuario',
		'createdAt'
	];

	protected $autoIncrement = true;
}
