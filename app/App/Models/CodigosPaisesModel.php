<?php
    namespace App\Models;

    use Core\Model;

    /**Codigos de los paises */
    class CodigosPaisesModel extends Model
    {
        protected $tableName = 'codigos_paises';
        protected $primaryKey = 'cod_pais';

        protected $tableFields = [
            'nombre',
            'iso3',
            'codigo_telefono'
        ];
        
    }//Fin de la clase