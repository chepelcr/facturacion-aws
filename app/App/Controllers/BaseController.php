<?php

namespace App\Controllers;

use Core\Controller;

class BaseController extends Controller
{
    protected $helpers = ['login', 'modulos', 'facturacion'];

    public function inicio($data = array())
    {
        $data = (object) $data;



        if (is_login()) {
            setEmpresaData();
            
            if (getSession('contrasenia_expiro')) {
                $script = cargar('mensajeAutomatico("Atencion", "Su contraseña ha expirado, por favor cambiela.", "warning");
                                        
                                        cambio_contrasenia();');

                //Si la data tiene un script, concatena el script
                if (isset($data->script)) {
                    $data->script .= $script;
                } else {
                    $data->script = $script;
                }
            }

            $tiposDocumentosModel = model('tiposDocumentos');

            $data->modulos = getModulos();

            $data->facturacion = (object) array(
                'tipos_documentos' => $tiposDocumentosModel->obtener('documentos'),
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
