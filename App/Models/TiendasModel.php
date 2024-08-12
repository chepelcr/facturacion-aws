<?php
//Usar la base para el modelo que tenemos creado
namespace App\Models;

use Core\Model;

/** Modelo para la tabla de usuarios */
class TiendasModel extends Model
{
	protected $nombreTabla = 'tiendas';
	protected $pk_tabla = 'id_tienda';

	protected $camposTabla = [
		'nombre',
        'id_formato',
        'cod_pais',
        'gln',
        'fecha_creacion',
		'fecha_modificacion',
		'fecha_eliminacion',
        'estado',
	];

	protected $dbGroup = 'walmart';

	protected $autoIncrement = true;

	protected $auditorias = true;

    /**Obtener todas las tiendas o puntos de venta */
	public function obtener($id = 'all')
    {
        //var_dump($id);
        switch ($id) {
            case 'inactivos':
                $this->where('estado', 0);
                return $this->getAll();
                break;

            case 'activos':
                $this->where('estado', 1);
                return $this->getAll();
                break;

            case 'all':
                return $this->getAll();
                break;

            default:
                return $this->getById($id);
        }
    }
}//Fin de la clase
?>