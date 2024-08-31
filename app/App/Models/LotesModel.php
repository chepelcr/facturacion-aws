<?php
    namespace App\Models;

    use Core\Model;

    class LotesModel extends Model
    {
        protected $tableName = 'lotes';
        
        protected $primaryKey = 'id_lote';

        protected $tableView = 'lotes_produccion_view';

        protected $tableFields = [
            'tipo_lote',
            'valor_total',
            'fecha_creacion',
            'fecha_modificacion',
            'estado'
        ];
    }