<?php

namespace Core\Auditorias;

use Core\Model;

class ErroresModel extends Model
{
	protected $nombreTabla = "error";
	protected $pk_tabla = "id_error";

	protected $dbGroup = 'seguridad';

	protected $camposTabla = [
		'sentencia',
		'controlador',
		'id_usuario',
		'createdAt'
	];

	protected $autoIncrement = true;
}
?>