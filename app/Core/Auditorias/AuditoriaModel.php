<?php

namespace Core\Auditorias;

use Core\Model;

class AuditoriaModel extends Model
{
	protected $tableName = "auditoria";
	protected $primaryKey = "id_auditoria";

	protected $tableView = "auditorias_view";

	protected $tableFields = [
		'id_fila',
		'tabla',
		'id_usuario',
		'accion',
		'created_at'
	];

	protected $tableExtraViewFields = [
		'nombre_usuario',
	];

	protected $autoIncrement = true;
}
