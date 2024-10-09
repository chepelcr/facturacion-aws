<?php

namespace App\Services;

use App\Api\ProductsApi;
use App\Api\DataServiceApi;

use App\Models\CategoriasModel;
use App\Validations\ProductValidations;

class ProductosService extends BaseService {

    /**
     * Obtener los datos de los productos
     * @param string $id Identificador del producto
     * @param string $filters Filtros de busqueda
     * @return object|array Datos de los productos
     * @throws \Exception
     */
    public function getData($id = 'all', $filters = array()) {
        $productosApi = new ProductsApi(getTaxpayerId());

        if ($id == 'all') {

            if (isset($filters['search'])) {
                $data = $productosApi->getProductsBySearchFilter($filters['search']);
            } elseif (isset($filters['status']) && $filters['status'] != 'all') {
                $search = 'status:' . $filters['status'];
                $data = $productosApi->getProductsBySearchFilter($search);
            } else {
                $data = $productosApi->getProductsByTaxpayerId();
            }

            return $data;
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
        $productosApi = new ProductsApi(getTaxpayerId());

        return $productosApi->changeProductStatus($id, $data);
    }

    /**
     * Obtener la vista de los productos
     * @param string $filters Filtros de busqueda
     * @return string | object Vista de los productos
     */
    public function getProductsListView($filters = '') {
        $productos = $this->getData('all', $filters);

        if (isset($productos->error)) {
            return $productos;
        }

        if (isset($filters['status'])) {
            $estado = $filters['status'];
        } else {
            $estado = 'all';
        }

        if (isset($filters['search'])) {
            # Separar los valores de la busqueda en un array (vienen separados por comas)
            $search = explode(',', $filters['search']);

            # Si existe el campo statusId en search, se asigna a la variable estado
            if (isset($search['id_estado'])) {
                $estado = $search['id_estado'];
            }
        }

        $tableName = 'empresa/producto/table';

        $data_tabla = array(
            'nombreTable' => $tableName,
            'nombre_tabla' => 'listado_empresa_productos',
            'dataTable' => array(
                'products' => $productos
            ),
            'status' => $estado
        );

        $dataServiceApi = new DataServiceApi();

        $categoriasModel = new CategoriasModel();
        $categorias = $categoriasModel->getAll();

        $unidades = $dataServiceApi->getMeasurementUnits();
        $codigos = $dataServiceApi->getCodesByCountry(getCountryCode());
        $productTypes = $dataServiceApi->getProductTypes();

        $taxTypes = $dataServiceApi->getTaxTypesByCountry(getCountryCode());
        $taxRates = $dataServiceApi->getTaxRatesByCountry(getCountryCode());

        $nombreForm = 'empresa/producto/form';

        $datos_generales = array(
            'categorias' => $categorias,
            'unidades' => $unidades,
        );

        $data_codigos = array(
            'codigos' => $codigos
        );

        $data_hacienda = array(
            'productos' => $productTypes
        );

        $data_impuestos = array(
            'taxTypes' => $taxTypes,
            'taxRates' => $taxRates
        );

        $data_form = array(
            'dataForm' => array(
                'datos_generales' => $datos_generales,
                'data_codigos' => $data_codigos,
                'data_hacienda' => $data_hacienda,
                'data_impuestos' => $data_impuestos
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

    public function validarExistencia($data) {
        #$productosApi = new ProductsApi(getEnt('taxpayerId'));

        #return $productosApi->validateProductExistence($data);
    }

    /**
     * Actualizar un producto
     * @param string $id Identificador del producto
     * @param array $data Datos del producto
     */
    public function update($id, $data) {
        $productosApi = new ProductsApi(getTaxpayerId());

        $data = ProductValidations::validateProductStructure($data);

        if(isset($data['error'])){
            return (object) $data;
        }

        return $productosApi->updateProduct($id, $data);
    }

    /**
     * Crear un producto
     * @param array $data Datos del producto
     */
    public function create($data) {
        $productosApi = new ProductsApi(getTaxpayerId());

        $data = ProductValidations::validateProductStructure($data);

        if(isset($data['error'])){
            return $data;
        }

        return $productosApi->saveProduct($data);
    }
}
