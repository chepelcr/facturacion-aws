<?php

/**
 * Descripción: Controlador para la entidad Rol
 */

namespace App\Controllers;

use App\Services\AutenticacionService;
use App\Services\ModulosService;
use App\Services\TaxpayersService;

/**
 * Controlador para el modulo de configuracion
 * @package App\Controllers
 * @subpackage Configuracion
 * @version 2.0
 * @autor jcampos
 */
class Configuracion extends BaseController {

    protected $isModulo = true;

    protected $nombreModulo = 'configuracion';

    protected $objetos = ['empresa', 'documentos', 'modulos'];

    /** Devolver el dash de la aplicacion */
    public function index() {
        if (is_login()) {
            $script = cargar("cargar_inicio_modulo('configuracion', 'Configuración');");

            $data = array(
                'script' => $script,
            );

            return $this->inicio($data);
        } //Fin de la validacion

        else {
            redirect(baseUrl('login'));
        }
    } //Fin de la funcion index

    /**
     * Entrar a la configuracion del modulo de administracion
     */
    public function empresa() {
        if (is_login()) {
            if (validar_permiso("configuracion", "empresa", "consultar")) {
                if (getSegment(3) == "listado") {
                    $taxpayersService = new TaxpayersService();

                    $formData = array(
                        'taxpayer' => $taxpayersService->getEmpresaData()
                    );

                    return view('configuracion/empresa', $formData);
                } else {
                    $script = cargar("cargar_listado('configuracion', 'empresa', 'Configuración', 'Empresa', ' " . baseUrl("configuracion/empresa/listado") . "');");

                    $data = array(
                        'script' => $script
                    );

                    return $this->inicio($data);
                }
            } else {
                $data = array(
                    'error' => 'No tiene permisos para acceder a la página.',
                    'status' => 403
                );

                return $this->error($data);
            }
        } else {
            redirect(baseUrl('login'));
        }
    } //Fin de la función empresa

    /**
     * Entrar a la configuracion del modulo de facturacion
     */
    public function documentos() {
        if (is_login()) {
            if (validar_permiso("configuracion", "documentos", "consultar")) {
                if (getSegment(3) == "listado") {
                    $autenticationService = new AutenticacionService();

                    $configuraciones = $autenticationService->obtenerConfiguracionesPorIdContribuyente(getTaxpayerId());

                    if (isset($configuraciones->error)) {
                        $data = array(
                            'error' => $configuraciones->error,
                            'status' => $configuraciones->status
                        );

                        return $this->error($data);
                    } else {
                        return view('configuracion/facturacion', $configuraciones);
                    }
                } else {
                    $script = cargar("cargar_listado('configuracion', 'documentos', 'Configuración', 'Documentos', ' " . baseUrl("configuracion/documentos/listado") . "');");

                    $data = array(
                        'script' => $script
                    );

                    return $this->inicio($data);
                }
            } else {
                if (getSegment(3) == "listado") {
                    $error = array(
                        'error' => 'No tiene permisos para acceder a la pagina.',
                        'status' => 403
                    );

                    return $this->error($error);
                } else {
                    $error = $this->object_error(500, 'No tiene permisos para consultar documentos.');

                    return $this->error($error);
                }
            }
        } else {
            redirect(baseUrl('login'));
        }
    } //Fin del metodo para entrar a la configuracion del modulo de facturacion

    /**
     * Actualizar la configuracion de la empresa
     */
    public function update($objeto, $data, $reinsert = false) {
        if (is_login()) {
            if ($objeto == 'hacienda' && validar_permiso('configuracion', 'documentos', 'modificar')) {
                $autenticationService = new AutenticacionService();

                if (isset($_FILES['certificate']) && $_FILES['certificate']['size'] > 0) {
                    $data['certificate'] = array(
                        'data' => base64_encode(file_get_contents($_FILES['certificate']['tmp_name'])),
                        'pin' => $data['certificate']['pin'],
                        'contentType' => $_FILES['certificate']['type'],
                        'name' => $_FILES['certificate']['name']
                    );
                } else {
                    unset($data['certificate']);
                }

                $response = $autenticationService->actualizarConfiguracionesPorIdContribuyente(getTaxpayerId(), $data);
            } else {
                $response = $this->object_error(500, 'No se ha enviado la información correcta para actualizar la configuración.');
            } //Fin de la validacion de permisos

            if (isset($response->error)) {
                $error = array(
                    'error' => $response->error,
                    'status' => $response->status
                );

                return $this->error($error);
            } else {
                return json_encode($response);
            }
        } else {
            redirect(baseUrl('login'));
        } //Fin de la validacion de login
    } //Fin del metodo para actualizar la configuracion de la empresa
} //Fin de la clase
