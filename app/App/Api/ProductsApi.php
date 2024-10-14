<?php

namespace App\Api;

use App\Enums\ProductsEnum;

/**
 * Clase para consumir el API de productos de un contribuyente de IVOIS
 * @package App\Api
 * @subpackage ProductsApi
 * @version 1.0
 * @author jcampos
 */
class ProductsApi extends IvoisApi {
    /**
     * Constructor de la clase que recibe el id del contribuyente
     * @param $taxpayerId Identificador del contribuyente
     */
    public function __construct($taxpayerId) {
        parent::__construct(getEnt("ivois.api.taxpayers.url") . $taxpayerId . getEnt("ivois.api.details.products.url")); //, "http://172.19.0.3:8088");
    }

    /**
     * Obtiene el nombre del error para el modulo de productos
     */
    public function getErrorName($error) {
        $error = ProductsEnum::tryFrom($error);

        if ($error == null) {
            return 'Ha ocurrido un error al realizar la solicitud';
        } else {
            return $error->getName();
        }
    }

    /**
     * Obtiene un producto por su id
     * @param $id Identificador del producto
     * @return object Producto
     */
    public function getProductById($id) {
        return $this->makeGetRequestUrl($id);
    }

    /**
     * Obtiene los productos de un contribuyente por su estado
     * @param $status Estado del producto
     * @return array Lista de productos
     */
    public function getProductsByTaxpayerId($status = 0) {
        return $this->makeGetRequestUrl("all?status=" . $status);
    }

    /**
     * Obtiene todos los productos de un contribuyente aplicando un filtro de busqueda
     * @param $searchFilter Filtro de busqueda ("code_number:$code", "name:$name", "description:$description")
     * @return array Lista de productos
     */
    public function getProductsBySearchFilter($searchFilter = '') {
        return $this->makeGetRequestUrl("all?search=" . $searchFilter);
    }

    /**
     * Almacena la información de un producto
     * @param $data Información del producto
     * @return object Producto
     */
    public function saveProduct($data) {
        return $this->makePostRequest($data);
    }

    /**
     * Actualiza la información de un producto por su id
     * @param $id Identificador del producto
     * @param $data Información del producto
     * @return object Producto
     */
    public function updateProduct($id, $data, $reinsert = false) {
        if ($reinsert) {
            $url = $id . "?reinsert=true";
        } else {
            $url = $id;
        }

        return $this->makePutRequest($data, $url);
    }

    /**
     * Cambia el estado de un producto
     * @param $id Identificador del producto
     * @param $data Datos a actualizar
     * @return object Producto actualizado
     */
    public function changeProductStatus($id, $data) {
        return $this->makePatchRequest($data, $id);
    }
}
