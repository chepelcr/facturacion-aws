<?php

namespace App\Models;

use Core\Model;

/** Modelo para la tabla de usuarios */
class TipoIdentificacionModel extends Model
{
	protected $nombreTabla = 'tipos_identificaciones';
	protected $pkTabla = 'id_tipo_identificacion';

	protected $camposTabla = [
		'tipo_identificacion',
	];
} //Fin de la clase
