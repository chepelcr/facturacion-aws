<?php

namespace App\Services;

use App\Api\ConfigurationsApi;

/**
 * Clase que se encarga de enviar o recibir información de la configuración de Hacienda, para un contribuyente.
 */
class AutenticacionService
{

    /**
     * @var ConfigurationsApi $configurationApi API de configuraciones.
     */
    private $configurationApi;

    /**
     * Constructor de la clase
     */
    public function __construct()
    {
        $this->configurationApi = new ConfigurationsApi();
    }

    /**
     * Obtener las configuraciones de un contribuyente.
     * @param int $idContribuyente ID del contribuyente.
     */
    public function obtenerConfiguracionesPorIdContribuyente($idContribuyente)
    {
        return $this->configurationApi->get_configurations_by_taxpayer_id($idContribuyente);
    }

    /**
     * Actualizar las configuraciones de un contribuyente.
     * @param int $idContribuyente ID del contribuyente.
     * @param array $configuraciones Configuraciones a actualizar.
     */
    public function actualizarConfiguracionesPorIdContribuyente($idContribuyente, $configuraciones)
    {
        if ($configuraciones['notifyProcessingDocuments'] == '1') {
            $configuraciones['notifyProcessingDocuments'] = true;
        } else {
            $configuraciones['notifyProcessingDocuments'] = false;
        }

        if ($configuraciones['notifyReceivedDocuments'] == '1') {
            $configuraciones['notifyReceivedDocuments'] = true;
        } else {
            $configuraciones['notifyReceivedDocuments'] = false;
        }

        return $this->configurationApi->update_configurations_by_taxpayer_id($idContribuyente, $configuraciones);
    }

    /**
     * Validar si la llave criptográfica es correcta.
     * @param int $idContribuyente ID del contribuyente.
     * @param string $llaveCriptografica Llave criptográfica a validar.
     */
    public function validarLlaveCriptografica($idContribuyente, $llaveCriptografica)
    {
        return $this->configurationApi->validate_cryptographic_key($idContribuyente, $llaveCriptografica);
    }
}
