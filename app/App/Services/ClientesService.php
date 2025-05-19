<?php

namespace App\Services;

use App\Api\CustomersApi;
use App\Api\DataServiceApi;
use App\Api\LocationsApi;

class ClientesService extends BaseService {

    /**
     * Crear un cliente
     * @param array $data Datos del cliente
     */
    public function create($data) {
        $identification = $data['identification']['number'];
        $identification = desformatear_cedula($identification);

        $data['identification']['number'] = $identification;

        $personalPhone = $data['personalPhone'];

        if (!isset($personalPhone["phoneNumber"]) || $personalPhone["phoneNumber"] == "") {
            unset($data['personalPhone']);
        }

        $customersApi = new CustomersApi(getTaxpayerId());

        return $customersApi->saveCustomer($data);
    }

    /**
     * Obtiene los datos de los clientes
     */
    public function getData($id = 'all', $filters = array()) {
        $customersApi = new CustomersApi(getTaxpayerId());

        if ($id == 'all') {
            if (isset($filters['search'])) {
                $search = $filters['search'];
            } elseif (isset($filters['status']) && $filters['status'] != 'all') {
                $search = 'status:' . $filters['status'];
            } else {
                $search = "status:1";
            }
            return $customersApi->getCustomers($search);
        } else {
            return $customersApi->getCustomerById($id);
        }
    }

    /**
     * Cambiar el estado de un cliente
     */
    public function changeStatus($id, $data) {
        $customersApi = new CustomersApi(getTaxpayerId());

        return $customersApi->changeCustomerStatus($id, $data);
    }

    /**
     * Actualizar un cliente
     */
    public function update($id, $data, $reinsert = false) {
        $customersApi = new CustomersApi(getTaxpayerId());

        $identification = $data['identification']['number'];
        $identification = desformatear_cedula($identification);

        $data['identification']['number'] = $identification;

        $personalPhone = $data['personalPhone'];

        if (!isset($personalPhone["phoneNumber"]) || $personalPhone["phoneNumber"] == "") {
            unset($data['personalPhone']);
        }

        return $customersApi->update($id, $data, $reinsert);
    }

    /**
     * Obtiene la vista de los clientes
     */
    public function getCustomersListView($filters = array()) {
        $clientes = $this->getData('all', $filters);

        if (isset($clientes->error)) {
            return $clientes;
        }

        if (isset($filters['status'])) {
            $estado = $filters['status'];
        } else {
            $estado = 1;
        }

        $tableName = 'empresa/cliente/table';

        $data_tabla = array(
            'nombreTable' => $tableName,
            'nombre_tabla' => 'listado_empresa_clientes',

            'dataTable' => array(
                'clientes' => $clientes,
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
            'customerTypes' => $customerTypes
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
            'nombre_form' => 'frm_empresa_clientes'
        );

        $data = array(
            'data_tabla' => $data_tabla,
            'data_form' => $data_form,
        );

        return listado($data);
    }

    /**
     * Validar si ya existe un cliente en la plataforma
     */
    public function validarExistencia($data) {
        $customersApi = new CustomersApi(getTaxpayerId());

        $idNumber = $data['idNumber'];
        $countryCode = $data['nationality'];

        $search = "idNumber:$idNumber,nationality:$countryCode";

        $data = $customersApi->getCustomers($search);

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
