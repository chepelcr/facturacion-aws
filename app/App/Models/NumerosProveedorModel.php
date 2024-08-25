<?php
//Usar la base para el modelo que tenemos creado
namespace App\Models;

use Core\Model;

/** Modelo para la tabla de usuarios */
class NumerosProveedorModel extends Model
{
	protected $nombreTabla = 'numeros_proveedor';
	protected $pkTabla = 'id_proveedor';

	protected $camposTabla = [
		'departamento',
        'cod_pais',
        'fecha_creacion',
        'estado',
	];

	

	protected $autoIncrement = true;

	protected $auditorias = true;
}//Fin de la clase
?>