<?php

namespace App\Models;

use Core\Model;

/** Modelo para la tabla de categorias */
class CondicionesVentaModel extends Model
{
	protected $nombreTabla = 'condiciones_venta';
	protected $pkTabla = 'id_condicion';

	protected $camposTabla = [
		'codigo',
		'nombre',
		'created_at',
		'updated_at'
	];



	protected $autoIncrement = true;

	protected $auditorias = true;
} //Fin de la clase
