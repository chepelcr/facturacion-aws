<?php

namespace App\Services;

use App\Api\DetailsApi;
use App\Api\DataServiceApi;

use App\Models\CategoriasModel;

class ProductosService extends BaseService {

    /**
     * Obtener los datos de los productos
     * @param string $id Identificador del producto
     * @param string $filters Filtros de busqueda
     * @return object | array Datos de los productos
     * @throws \Exception
     */
    public function getData($id = 'all', $filters = '') {
        $productosApi = new DetailsApi(getTaxpayerId());

        if ($id == 'all') {
            if(!empty($filters)) {
                return $productosApi->getProductsBySearchFilter($filters);
            } else {
                return $productosApi->getProductsByTaxpayerId();
            }
        } else {
            return (object) $productosApi->getProductById($id);
        }
    }

    /**
     * Cambiar el estado de un producto
     * @param string $id Identificador del producto
     * @param array $data Datos del producto
     * @return object Respuesta de la API
     */
    public function changeStatus($id, $data) {
        $productosApi = new DetailsApi(getTaxpayerId());

        return $productosApi->changeProductStatus($id, $data);
    }

    /**
     * Obtener la vista de los productos
     * @param string $filters Filtros de busqueda
     * @return string | object Vista de los productos
     */
    public function getProductsListView($filters = '') {
        $productos = $this->getData('all', $filters);
 
        if(isset($productos->error)) {
            return $productos;
        }

        $estado = 'all';

        if(isset($filters['search'])) {
            # Separar los valores de la busqueda en un array (vienen separados por comas)
            $search = explode(',', $filters['search']);

            # Si existe el campo statusId en search, se asigna a la variable estado
            if(isset($search['id_estado'])) {
                $estado = $search['id_estado'];
            }
        }

        $nombreTabla = 'empresa/producto/table';

        $data_tabla = array(
            'nombreTable' => $nombreTabla,
            'nombre_tabla' => 'listado_empresa_productos',
            'dataTable' => array(
                 'articulos' => $productos
                ),
            'id_estado' => $estado
        );

        $dataServiceApi = new DataServiceApi();

        $categoriasModel = new CategoriasModel();
        $categorias = $categoriasModel->getAll();

        $unidades = $dataServiceApi->getMeasurementUnits();
        $codigos = $dataServiceApi->getCodesByCountry(getCountryCode());
        $productTypes = $dataServiceApi->getProductTypes();

        $nombreForm = 'empresa/producto/form';

        $datos_generales = array(
            'categorias'=>$categorias,
            'unidades'=>$unidades,
        );

        $data_codigos = array(
            'codigos' => $codigos
        );

        $data_hacienda = array(
            'productos' => $productTypes
        );

        $data_form = array(
            'dataForm' => array(
                'datos_generales' => $datos_generales,
                'data_codigos' => $data_codigos,
                'data_hacienda' => $data_hacienda
            ),
            'nombreForm' => $nombreForm,
            'nombre_form' => 'frm_empresa_productos'
        );

        $data = array(
            'data_tabla' => $data_tabla,
            'data_form' => $data_form,
            'extra_views' => array(
                'empresa/producto/elementos/cabys' => null
            ),
        );

        return listado($data);
    }

    public function validarExistencia($data){
        #$productosApi = new DetailsApi(getEnt('taxpayerId'));

        #return $productosApi->validateProductExistence($data);
    }

    /**
     * Actualizar un producto
     * @param string $id Identificador del producto
     * @param array $data Datos del producto
     */
    public function update($id, $data) {
        $productosApi = new DetailsApi(getTaxpayerId());

        return $productosApi->updateDetail($id, $data);
    }

    /**
     * Crear un producto
     * @param array $data Datos del producto
     
     */
    public function create($data) {
        $productosApi = new DetailsApi(getTaxpayerId());

        return $productosApi->saveProduct($data);
    }
}
