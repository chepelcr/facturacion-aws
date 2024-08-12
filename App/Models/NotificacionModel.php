<?php
//Usar la base para el modelo que tenemos creado
namespace App\Models;

use Core\Model;

/** Modelo para la tabla de usuarios */
class TiendasModel extends Model
{
	protected $nombreTabla = 'notificaciones';
	
	protected $pkTabla = 'id_notificacion';

	protected $camposTabla = [
		'descripcion',
		'fecha',
		'estado',
	];

	protected $camposVista = [
		'id_usuario',
	];

	

	protected $autoIncrement = true;

	protected $auditorias = true;
}//Fin de la clase
?>