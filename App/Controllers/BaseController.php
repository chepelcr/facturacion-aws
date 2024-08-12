<?php

namespace App\Controllers;

use Core\Controller;
use App\Api\DataServiceApi;
use App\Services\DocumentosService;

class BaseController extends Controller
{
    protected $helpers = ['login', 'modulos', 'facturacion', 'data'];

    const LOCATION = "'Location: '";

    public function inicio($data = array())
    {
        $data = (object) $data;

        if (is_login()) {
            if (getSession('contrasenia_expiro')) {
                $script = setScriptData('$(document).ready(function(){
                                    //Esperar 5 segundos para mostrar el modal
                                    setTimeout(function(){
                                        Toast.fire({
                                            icon: "warning",
                                            title: "Su contraseña ha expirado",
                                            timer: 2000
                                        }).then((result) => {
                                            cambio_contrasenia();
                                        });
                                    }, 6000);
                                });');

                //Si la data tiene un script, concatena el script
                if (isset($data->script)) {
                    $data->script .= $script;
                } else {
                    $data->script = $script;
                }
            }

            $dataServiceApi = new DataServiceApi();
            $documentsService = new DocumentosService();

            $data->modulos = getModulos();

            $infoAgregar = array(
                'documentTypes' => $dataServiceApi->getDocumentTypesByCountry(getCountryCode()),
            );

            $data->facturacion = (object) array(
                'infoAgregar' => $infoAgregar,
                'infoClientes' => $documentsService->getInfoClientes(),
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
}//Fin de la clase
