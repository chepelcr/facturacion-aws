<?php

namespace App\Models;

use Core\Model;

/** Modelo para la tabla de tipo de cambio del dolar */
class TipoCambioModel extends Model
{
    protected $tableName = 'tipo_cambio_historico';
    protected $primaryKey = 'id_tipo_cambio';

    protected $tableFields = [
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
}//Fin de la clase
