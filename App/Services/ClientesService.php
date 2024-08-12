<?php

namespace App\Services;

use App\Api\CustomersApi;
use App\Api\DataServiceApi;
use App\Api\LocationsApi;

class ClientesService extends BaseService
{

    /**
     * Crear un cliente
     */
    public function create($data)
    {
        $identification = $data['identification']['number'];
        $identification = desformatear_cedula($identification);

        $data['identification']['number'] = $identification;

        $customersApi = new CustomersApi(getTaxpayerId());

        return $customersApi->saveCustomer($data);
    }

    /**
     * Obtiene los datos de los clientes
     */
    public function getData($id = 'all', $filters = array())
    {
        $customersApi = new CustomersApi(getTaxpayerId());

        if ($id == 'all') {
            if (!empty($filters) && isset($filters['id_estado']) && $filters['id_estado'] != 'all') {
                return $customersApi->getCustomersByStatus($filters['id_estado']);
            } else {
                return $customersApi->getCustomersByTaxpayerId();
            }
        } else {
            return $customersApi->getCustomerById($id);
        }
    }

    /**
     * Cambiar el estado de un cliente
     */
    public function changeStatus($id, $data)
    {
        $customersApi = new CustomersApi(getTaxpayerId());

        return $customersApi->changeCustomerStatus($id, $data);
    }

    /**
     * Actualizar un cliente
     */
    public function update($id, $data)
    {
        $customersApi = new CustomersApi(getTaxpayerId());

        $identification = $data['identification']['number'];
        $identification = desformatear_cedula($identification);

        $data['identification']['number'] = $identification;

        return $customersApi->updateCustomer($id, $data);
    }

    /**
     * Obtiene la vista de los clientes
     */
    public function getCustomersListView($filters = array())
    {
        $clientes = $this->getData('all', $filters);

        if (isset($clientes->error)) {
            return $clientes;
        }

        if (isset($filters['id_estado'])) {
            $estado = $filters['id_estado'];
        } else {
            $estado = 'all';
        }

        $nombreTabla = 'empresa/cliente/table';

        $data_tabla = array(
            'nombreTable' => $nombreTabla,
            'nombre_tabla' => 'listado_empresa_clientes',

            'dataTable' => array(
                'clientes' => $clientes,
            ),
            'id_estado' => $estado,
        );

        $dataServiceApi = new DataServiceApi();
        $identificaciones = $dataServiceApi->getIdentificationTypesByCountry(getCountryCode());

        $locationsApi = new LocationsApi();

        $provincias = $locationsApi->get_states_by_iso_code(getCountryCode());
        $countries = $locationsApi->get_countries();

        $dataProvincias = array(
            'states' => $provincias,
            'countries' =>  $countries
        );

        $datos_personales = array(
            'identificaciones' => $identificaciones,
            'countries' => $countries
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
    public function validarExistencia($idNumber)
    {
        $customersApi = new CustomersApi(getTaxpayerId());

        $exist = $customersApi->getCustomerByNationalityAndIdNumber(getEnt('ivois.taxpayer.nationality'), $idNumber);

        return array(
            'exists' => $exist,
            'status' => 1
        );
    }
}
