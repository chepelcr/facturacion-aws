<?php

namespace App\Services;

use App\Api\ConfigurationsApi;
use App\Models\EmpresaAutenticacionModel;

/**
 * Clase que se encarga de enviar o recibir información de la configuración de Hacienda, para un contribuyente.
 */
class AutenticacionService {

    /**
     * @var ConfigurationsApi $configurationApi API de configuraciones.
     */
    private $configurationsModel;

    /**
     * Constructor de la clase
     */
    public function __construct() {
        //$this->configurationApi = new ConfigurationsApi();
        //$this->configurationsModel = new EmpresaAutenticacionModel();
    }

    /**
     * Obtener las configuraciones de un contribuyente.
     * @param int $idContribuyente ID del contribuyente.
     */
    public function obtenerConfiguracionesPorIdContribuyente($idContribuyente) {
        $this->configurationsModel = new EmpresaAutenticacionModel();

        //return $this->configurationApi->get_configurations_by_taxpayer_id($idContribuyente);
        return $this->configurationsModel->getById($idContribuyente);
    }

    /**
     * Actualizar las configuraciones de un contribuyente.
     * @param int $idContribuyente ID del contribuyente.
     * @param array $configuraciones Configuraciones a actualizar.
     */
    public function actualizarConfiguracionesPorIdContribuyente($idContribuyente, $configuraciones) {
        $taxpayer = $this->obtenerConfiguracionesPorIdContribuyente($idContribuyente);

        $data = array(
            'user_token' => $configuraciones['user_token'],
            'user_pass' => $configuraciones['user_pass'],
            'documento_sucursal' => $configuraciones['documento_sucursal'],
            'documento_punto_venta' => $configuraciones['documento_punto_venta']
        );

        $this->configurationsModel = new EmpresaAutenticacionModel();

        if ($taxpayer) {
            return $this->configurationsModel->update($data, $idContribuyente);
        } else {
            $configuraciones['id_empresa'] = $idContribuyente;
            return $this->configurationsModel->insert($data);
        }
    }

    /**
     * Insertar las configuraciones de un contribuyente.
     */

    /**
     * Validar si la llave criptográfica es correcta.
     * @param int $idContribuyente ID del contribuyente.
     * @param string $llaveCriptografica Llave criptográfica a validar.
     */
    public function actualizarP12($idContribuyente, $llaveCriptografica) {
        $data = array(
            'llave_p12' => array(
                'type' => 'blob',
                'data' => $llaveCriptografica['file_content']
            ),
            'llave_pin' => array(
                'type' => 'string',
                'data' => $llaveCriptografica['pin']
            )
        );

        $this->configurationsModel = new EmpresaAutenticacionModel();

        return $this->configurationsModel->updateComplexData($data, $idContribuyente);


        //return $this->configurationApi->validate_cryptographic_key($idContribuyente, $llaveCriptografica);
    }
}
