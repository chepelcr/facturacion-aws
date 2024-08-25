<?php
    namespace App\Models;

    use Core\Model;

    class LotesModel extends Model
    {
        protected $nombreTabla = 'lotes';
        
        protected $pkTabla = 'id_lote';

        protected $vistaTabla = 'lotes_produccion_view';

        protected $camposTabla = [
            'tipo_lote',
            'valor_total',
            'fecha_creacion',
            'fecha_modificacion',
            'estado'
        ];
    }