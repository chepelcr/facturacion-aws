<?php
    namespace App\Models;

    use Core\Model;

    class LotesCompraModel extends Model
    {
        protected $tableName = 'lotes';
        
        protected $primaryKey = 'id_lote';

        protected $tableView = 'lotes_compra_view';

        protected $tableFields = [
            'tipo_lote',
            'valor_total',
            'fecha_creacion',
            'fecha_modificacion',
            'estado'
        ];
    }