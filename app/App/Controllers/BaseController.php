<?php

namespace App\Controllers;

use Core\Controller;
use App\Api\DataServiceApi;
use App\Services\DocumentosService;

/**
 * Clase base para los controladores de la aplicación
 * @package App\Controllers
 * @version 1.0.0
 * @author jcampos
 * @subpackage BaseController
 */
abstract class BaseController extends Controller
{
    protected $helpers = ['login', 'modulos', 'facturacion', 'data'];

    const LOCATION = "'Location: '";

    public function inicio($data = array())
    {
        $data = (object) $data;

        if (is_login()) {
            if (getSession('contrasenia_expiro')) {
                $script = cargar('Toast.fire({
                                            icon: "warning",
                                            title: "Su contraseña ha expirado",
                                            timer: 2000
                                        }).then((result) => {
                                            cambio_contrasenia();
                                        });');

                //Si la data tiene un script, concatena el script
                if (isset($data->script)) {
                    $data->script .= $script;
                } else {
                    $data->script = $script;
                }
            }

            $dataServiceApi = new DataServiceApi();

            $data->modulos = getModulos();

            $infoAgregar = array(
                'documentTypes' => $dataServiceApi->getDocumentTypesByCountry(getCountryCode()),
            );

            $data->facturacion = (object) array(
                'infoAgregar' => $infoAgregar
            );

            return view('layout', $data);
        } //Fin de la validacion

        else
            header('Location: ' . baseUrl('login'));
    } //Fin de la funcion index

    protected function listado($data)
    {
        return view('base/listado', $data);
    }

    public function update($id, $data, $reinsert = false){
        $error = $this->object_error('400', 'La acción no está permitida');
        return $this->error($error);
    }
}//Fin de la clase
