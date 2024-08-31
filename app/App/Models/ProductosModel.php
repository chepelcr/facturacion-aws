<?php
    namespace App\Models;

    use Core\Model;

    class ProductosModel extends Model
    {
        protected $tableName = 'productos';
        protected $primaryKey = 'id_producto';

        protected $tableView = 'productos_view';

        protected $tableFields = [
            'id_unidad',
            'unidad_empaque',
            'id_empresa',
            'id_categoria',
            'codigo_cabys',
            'codigo_venta',
            'codigo_interno',
            'descripcion',
            'impuesto',
            'porcentaje_descuento',
            'descuento',
            'valor_unitario',
            'valor_impuesto',
            'valor_total',
            'fecha_creacion',
            'fecha_modificacion',
            'fecha_eliminacion',
            'estado'
        ];

        protected $tableExtraViewFields = [
            'simbolo_unidad',
            'nombre_unidad',
            'nombre_categoria',
        ];

        

        protected $autoIncrement = true;

        protected $auditorias = true;

        public function obtener($id = 'all')
        {
            //var_dump($id);
            switch ($id) {
                case 'inactivos':
                    $this->vista('productos_inactivos');
                    return $this->getAll();
                    break;

                    case 'all':
                    $this->vista('productos_view');
                    return $this->getAll();
                    break;

                    case 'activos':
                    $this->where('estado', '1');
                    return $this->getAll();

                default:
                    return $this->getById($id);
            }

            return false;
        }

        /**Obtener un producto por GNL */
        public function getByGnl($gnl)
        {
            $this->where('codigo_venta', $gnl);
            
            return $this->fila();
        }
    }
