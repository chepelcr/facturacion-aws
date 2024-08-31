<?php

namespace App\Models;

use Core\Model;

/**Codigos de los paises */
class CodigosPaisesModel extends Model {
    protected $tableName = 'codigos_paises';
    protected $primaryKey = 'cod_pais';

    protected $tableFields = [
        'nombre',
        'iso3',
        'codigo_telefono',
        'iso_code'
    ];

    /**
     * Obtener un pais por su codigo ISO
     */
    public function getByIsoCode($iso_code) {
        $this->where('iso_code', $iso_code);
        return $this->fila();
    }
}//Fin de la clase