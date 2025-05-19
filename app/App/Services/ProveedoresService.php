<?php

namespace App\Services;

use App\Api\ProvidersApi;
use App\Api\DataServiceApi;
use App\Api\LocationsApi;

/**
 * Servicio de proveedores
 */
class ProveedoresService extends BaseService {

    /**
     * Crear un proveedor
     * @param array $data Datos del proveedor
     */
    public function create($data) {
        $identification = $data['identification']['number'];
        $identification = desformatear_cedula($identification);

        $data['identification']['number'] = $identification;

        $personalPhone = $data['personalPhone'];

        if (!isset($personalPhone["phoneNumber"]) || $personalPhone["phoneNumber"] == "") {
            unset($data['personalPhone']);
        }

        $providersApi = new ProvidersApi(getTaxpayerId());

        return $providersApi->saveProvider($data);
    }

    /**
     * Obtiene los datos de los proveedores
     */
    public function getData($id = 'all', $filters = array()) {
        $providersApi = new ProvidersApi(getTaxpayerId());

        if ($id == 'all') {
            if (isset($filters['search'])) {
                $search = $filters['search'];
            } elseif (isset($filters['status']) && $filters['status'] != 'all') {
                $search = 'status:' . $filters['status'];
            } else {
                $search = 'status:1';
            }

            return $providersApi->getProviders($search);
        } else {
            return $providersApi->getProviderById($id);
        }
    }

    /**
     * Cambiar el estado de un proveedor
     */
    public function changeStatus($id, $data) {
        $providersApi = new ProvidersApi(getTaxpayerId());

        return $providersApi->changeProviderStatus($id, $data);
    }

    /**
     * Actualizar un proveedor
     */
    public function update($id, $data, $reinsert = false) {
        $providersApi = new ProvidersApi(getTaxpayerId());

        $identification = $data['identification']['number'];
        $identification = desformatear_cedula($identification);

        $data['identification']['number'] = $identification;

        $personalPhone = $data['personalPhone'];

        if (!isset($personalPhone["phoneNumber"]) || $personalPhone["phoneNumber"] == "") {
            unset($data['personalPhone']);
        }

        return $providersApi->update($id, $data, $reinsert);
    }

    /**
     * Obtiene la vista de los proveedores
     */
    public function getProvidersListView($filters = array()) {
        $proveedores = $this->getData('all', $filters);

        if (isset($proveedores->error)) {
            return $proveedores;
        }

        if (isset($filters['status'])) {
            $estado = $filters['status'];
        } else {
            $estado = 'all';
        }

        $tableName = 'empresa/cliente/table';

        $data_tabla = array(
            'nombreTable' => $tableName,
            'nombre_tabla' => 'listado_empresa_proveedores',

            'dataTable' => array(
                'clientes' => $proveedores,
            ),
            'status' => $estado,
        );

        $dataServiceApi = new DataServiceApi();
        $locationsApi = new LocationsApi();

        $identificaciones = $dataServiceApi->getIdentificationTypesByCountry(getCountryCode());
        $customerTypes = $dataServiceApi->getCustomerTypes();

        $provincias = $locationsApi->get_states_by_iso_code(getCountryCode());
        $countries = $locationsApi->get_countries();

        $dataProvincias = array(
            'states' => $provincias,
            'countries' =>  $countries
        );

        $datos_personales = array(
            'identificaciones' => $identificaciones,
            'countries' => $countries,
            'customerTypes' => $customerTypes,
            'isProvider' => true
        );

        $nombreForm = 'empresa/cliente/form';

        $datos_contacto = array(
            'countries' =>  $countries
        );

        $data_form = array(
            'dataForm' => array(
                'dataProvincias' => $dataProvincias,
                'datos_personales' => $datos_personales,
                'datos_contacto' => $datos_contacto
            ),
            'nombreForm' => $nombreForm,
            'nombre_form' => 'frm_empresa_proveedores'
        );

        $data = array(
            'data_tabla' => $data_tabla,
            'data_form' => $data_form,
        );

        return listado($data);
    }

    /**
     * Validar si ya existe un proveedor en la plataforma
     */
    public function validarExistencia($data) {
        $providersApi = new ProvidersApi(getTaxpayerId());

        $idNumber = $data['idNumber'];
        $countryCode = $data['nationality'];

        $search = "idNumber:$idNumber,nationality:$countryCode";

        $data = $providersApi->getProviders($search);

        if (isset($data->error)) {
            $data = array(
                'status' => 0
            );
        } else {
            $data = array(
                'data' => $data,
                'status' => 1
            );
        }

        return $data;
    }
}
