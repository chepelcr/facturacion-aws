<?php
    namespace App\Models;

    use Core\Model;

    class ProductosCompraModel extends Model
    {
        protected $tableName = 'productos';
        
        protected $primaryKey = 'id_producto';

        protected $tableView = 'productos_compras_view';
        
        protected $tableFields = [
            'id_unidad',
            'codigo_cabys',
            'codigo_venta',
            'tipo_producto',
            'descripcion',
            'impuesto',
            'valor unitario',
            'id_empresa',
            'fecha_creacion',
            'fecha_actualizacion',
            'fecha_eliminacion',
            'estado'
        ];

        protected $autoIncrement = true;

        protected $auditorias = true;
    }
