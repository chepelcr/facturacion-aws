<?php
//Usar la base para el modelo que tenemos creado
namespace App\Models;

use Core\Model;

/** Modelo para la tabla de usuarios */
class UsuariosModel extends Model {
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
		'ivois_id'
	];

	protected $autoIncrement = true;
	protected $auditorias = true;

	/**
	 * Obtener un usuario por su correo
	 * @param string $email
	 * @return object
	 */
	public function getByEmail($email) {
		$this->where('correo', $email);
		return $this->fila();
	}

	/**
	 * Obtener un usuario por su identificación
	 * @param string $identification
	 * @return object
	 */
	public function getByIdentification($identification) {
		$this->where('identificacion', $identification);
		return $this->fila();
	}
}//Fin de la clase