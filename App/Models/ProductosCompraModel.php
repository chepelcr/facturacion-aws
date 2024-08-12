<?php
    namespace App\Models;

    use Core\Model;

    class ProductosCompraModel extends Model
    {
        protected $nombreTabla = 'productos';
        
        protected $pkTabla = 'id_producto';

        protected $vistaTabla = 'productos_compras_view';
        
        protected $camposTabla = [
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
