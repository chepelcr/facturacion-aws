<?php
namespace App\Models;

use Core\Model;

/** Modelo para la tabla de categorias */
class CategoriasModel extends Model
{
	protected $nombreTabla = 'categorias';
	protected $pk_tabla = 'id_categoria';

	protected $camposTabla = [
		'nombre_categoria',
		'created_at',
		'updated_at'
	];

	protected $dbGroup = 'facturacion';

	protected $autoIncrement = true;

	protected $auditorias = true;
}//Fin de la clase
?>