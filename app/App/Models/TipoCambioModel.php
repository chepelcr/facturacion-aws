<?php
//Usar la base para el modelo que tenemos creado
namespace App\Models;

use Core\Model;

/** Modelo para la tabla de usuarios */
class TipoCambioModel extends Model
{
	protected $nombreTabla = 'tipo_cambio_historico';
	protected $pkTabla = 'id_tipo_cambio';

	protected $camposTabla = [
		'tipo_cambio',
		'fecha_cambio',
		'codigo_indicador',
		'cod_pais',
	];

	protected $autoIncrement = true;

	protected $auditorias = true;

	/**Obtener el tipo de cambio mas reciente por el codigo de indicador 
	 * @param int $id
	 * 
	 * @return object|array Objeto con el tipo de cambio o array con todos los tipos de cambio
	 */
	function obtener($id)
	{
		switch ($id) {
			case 'all':
				return $this->getAll();
				break;

			case 'CRC':
				return $this->where('codigo_indicador', 317)->fila();
				break;

			case 'USD':
				return $this->where('codigo_indicador', 318)->fila();
				break;

			default:
				return $this->where('codigo_indicador', $id)->fila();
				break;
		}
	}
} //Fin de la clase
