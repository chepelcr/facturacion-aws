<?php
//Usar la base para el modelo que tenemos creado
namespace App\Models;

use Core\Model;

/** Modelo para la tabla de usuarios */
class TiendasModel extends Model
{
	protected $nombreTabla = 'tiendas';
	protected $pkTabla = 'id_tienda';

	protected $camposTabla = [
		'nombre',
        'id_formato',
        'cod_pais',
        'gnl',
        'fecha_creacion',
        'estado',
	];

	

	protected $autoIncrement = true;

	protected $auditorias = true;
}//Fin de la clase
?>