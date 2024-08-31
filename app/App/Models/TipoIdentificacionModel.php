<?php

namespace App\Models;

use Core\Model;

/** Modelo para la tabla de usuarios */
class TipoIdentificacionModel extends Model
{
	protected $tableName = 'tipos_identificaciones';
	protected $primaryKey = 'id_tipo_identificacion';

	protected $tableFields = [
		'tipo_identificacion',
	];
} //Fin de la clase
