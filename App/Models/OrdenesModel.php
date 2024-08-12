<?php
//Usar la base para el modelo que tenemos creado
namespace App\Models;

use Core\Model;

/** Modelo para la tabla de ordenes de compra */
class OrdenesModel extends Model
{
	protected $nombreTabla = 'ordenes';
	protected $pk_tabla = 'id_orden';

	protected $camposTabla = [
		'nombre',
		'numero_departamento',
		'numero_proveedor',
        'fecha_creacion',
		'fecha_modificacion',
		'fecha_eliminacion',
        'estado',
	];

	protected $dbGroup = 'walmart';

	protected $autoIncrement = true;
	protected $auditorias = true;
}//Fin de la clase
?>