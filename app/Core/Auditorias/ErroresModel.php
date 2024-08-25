<?php

namespace Core\Auditorias;

use Core\Model;

class ErroresModel extends Model
{
	protected $nombreTabla = "error";
	protected $pkTabla = "id_error";

	

	protected $camposTabla = [
		'sentencia',
		'controlador',
		'id_usuario',
		'createdAt'
	];

	protected $autoIncrement = true;
}
?>