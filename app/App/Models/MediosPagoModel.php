<?php

namespace App\Models;

use Core\Model;

/** Modelo para la tabla de categorias */
class CondicionesVentaModel extends Model
{
	protected $nombreTabla = 'medios_pago';
	protected $pkTabla = 'id_medio_pago';

	protected $camposTabla = [
		'codigo',
		'nombre',
		'created_at',
		'updated_at'
	];



	protected $autoIncrement = true;

	protected $auditorias = true;
} //Fin de la clase
