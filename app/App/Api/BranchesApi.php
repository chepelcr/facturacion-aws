<?php

namespace App\Api;

use App\Enums\BranchesEnum;

/**
 * Clase para consumir el API de sucursales de IVOIS
 * @author jcampos
 * @version 1.0
 * @package App\Api
 * @subpackage BranchesApi
 */
class BranchesApi extends IvoisApi {

    /**
     * Constructor de la clase que recibe el id del contribuyente
     * @param $taxpayerId Identificador del contribuyente
     */
    public function __construct($taxpayerId) {
        parent::__construct(getEnt("ivois.api.taxpayers.url") . $taxpayerId . getEnt("ivois.api.branches.url"));//, "http://172.0.0.0:8085");
    }

    /**
     * Obtiene el nombre del error para el modulo de sucursales
     */
    public function getErrorName($error) {
        $error = BranchesEnum::tryFrom($error);

        if ($error == null) {
            return 'Ha ocurrido un error al realizar la solicitud';
        } else {
            return $error->getName();
        }
    }

    /**
     * Obtiene una sucursal por su id
     * @param $id Identificador de la sucursal
     * @return object Sucursal
     */
    public function getBranchById($id) {
        $url = "/$id";
        return $this->makeGetRequestUrl($url);
    }

    /**
     * Obtener todos las sucursales de un contribuyente
     * @return array Lista de sucursales
     */
    public function getAllBranches() {
        return $this->makeGetRequestUrl('/all?page=0&size=999999');
    }


    /**
     * Obtener todos las sucursales de un contribuyente por su estado
     * @param $status Estado de la sucursal
     * @return array Lista de sucursales
     */
    public function getBranchesByStatus($status) {
        $url = "/all?page=0&size=999999&search=status:$status";

        return $this->makeGetRequestUrl($url);
    }

    /**
     * Cambiar el estado de una sucursal
     * @param $id Identificador de la sucursal
     * @param $data Datos a actualizar
     * @return object Sucursal actualizada
     */
    public function changeBranchStatus($id, $data) {
        $url = "/$id";
        return $this->makePatchRequest($data, $url);
    }

    

    /**
     * Almacenar una sucursal en la aplicación
     * @param $data Datos de la sucursal
     * @return object Sucursal almacenada
     */
    public function saveBranch($data) {
        return $this->makePostRequest($data);
    }
}
