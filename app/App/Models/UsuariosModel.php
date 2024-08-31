<?php
//Usar la base para el modelo que tenemos creado
namespace App\Models;

use Core\Model;

/** Modelo para la tabla de usuarios */
class UsuariosModel extends Model
{
	protected $tableName = 'usuarios';
	protected $tableView = 'usuarios_view';

	protected $primaryKey = 'id_usuario';

	

	protected $tableFields = [
		'nombre',
		'nombre_usuario',
		'identificacion',
		'id_tipo_identificacion',
		'correo',
		'id_rol',
		'cod_pais',
		'id_empresa',
		'telefono',
		'fecha_registro',
		'fecha_actualizacion',
		'fecha_eliminacion',
		'estado'
	];

	protected $tableExtraViewFields = [
        'tipo_identificacion',
        'codigo_telefono',
        'nombre_pais',
		'nombre_empresa',
		'nombre_rol',
    ];

	protected $autoIncrement = true;

	protected $auditorias = true;

	public function getPerfil()
	{
		return $this->getById(getSession('id_usuario'));
	}
}//Fin de la clase
?>