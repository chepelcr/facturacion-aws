<?php

namespace App\Models;

use Core\Model;

/** Modelo para la tabla de categorias */
class EmpresaAutenticacionModel extends Model {
	protected $tableName = 'empresa_autenticacion';
	protected $primaryKey = 'id_empresa';

	protected $tableFields = [
		'llave_p12',
		'llave_pin',
		'user_token',
		'user_pass',
		'documento_sucursal',
		'documento_punto_venta',
		'createdOn',
		'updatedOn'
	];

	protected $autoIncrement = true;

	protected $auditorias = true;
}//Fin de la clase