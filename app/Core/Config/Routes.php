<?php

namespace Core\Config;

use Core\Aws\AwsAppConfig;
use Core\Config\Controllers;
use Core\Controller;

/**Clase para manejar el routeo del controlador y acciones */
class Routes {
    private $default_controller = '';

    private $default_action = '';

    protected $estado = 200;

    protected Controller $controller;

    public function __construct() {
        $this->init_load();
    }

    /**Carga inicial de la aplicacion */
    private function init_load() {
        #require_once '../vendor/autoload.php';
        require_once '../Core/helper/load_helper.php';

        //AwsAppConfig::setConfigurations();

        load_helper('entorno');

        //Colocar la zona horaria de la aplicacion
        date_default_timezone_set('America/Costa_Rica');
    } //Fin de la funcion

    public function setDefault($controller, $action) {
        $this->default_controller = $controller;
        $this->default_action = $action;

        return $this;
    } //Fin del metodo para establecer el controlador y funcion por defecto

    /**Obtener un controlador de la aplicacion */
    private function getController($controllerName) {
        $controllerName = "App\\Controllers\\" . $controllerName;
        $this->controller = new $controllerName();

        return $this->controller;
    } //Fin del metodo

    /**función que llama al controlador y su respectiva acción, que son pasados como parámetros */
    private function call($controllerName, $action) {
        /**Obtener un controlador */
        $controller = $this->getController($controllerName);

        /**Validar el tipo de solicitud que entra a la aplicacion */
        switch ($action) {
                /**Si se va a guardar un objeto */
            case 'guardar':
                /**Si la solicitud contiene datos */
                if (post()) {
                    if (getSegment(3)) {
                        $controller->setObjectName(getSegment(3));
                        echo $controller->guardar($_POST);
                    } else {
                        echo $controller->guardar($_POST);
                    }
                } else {
                    $this->estado = 400;
                    $error = $this->data_error('No se ha enviado datos para guardar');

                    echo $controller->error($error);
                }

                break;

                //Obtener una fila especifica del objeto solicitado
                //http://localhost/controlador/update/objeto/id
            case 'update':
                if (post()) {
                    if (getSegment(3) && getSegment(4)) {
                        $controller->setObjectName(getSegment(3));

                        //Si el segmento 5 es diferente de vacio, y se llama 'reinsertar'
                        if (getSegment(5) == 'reinsertar') {
                            echo $controller->update(getSegment(4), $_POST, true);
                        } else {
                            echo $controller->update(getSegment(4), $_POST);
                        }
                    } elseif (getSegment(3)) {
                        echo $controller->update(getSegment(3), $_POST);
                    } else {
                        $this->estado = 400;

                        $error = $this->data_error('No se ha enviado el id del objeto a actualizar');
                        echo $controller->error($error);
                    }
                } else {
                    $this->estado = 400;

                    $error = $this->data_error('No se ha enviado datos para actualizar');
                    echo $controller->error($error);
                }
                break;

                //Activar un objeto especifico
                //http://localhost/controlador/change_status/objeto/id
            case 'change_status':
                $status = post('status');

                if (!$status) {
                    $this->estado = 400;
                    $error = $this->data_error('No se ha enviado el estado del objeto a actualizar');

                    echo $controller->error($error);
                    break;
                }

                if (getSegment(3) && getSegment(4)) {
                    $controller->setObjectName(getSegment(3));

                    echo $controller->change_status(getSegment(4), $status);
                } elseif (getSegment(3)) {
                    echo $controller->change_status(getSegment(3), $status);
                } else {

                    $this->estado = 400;

                    $error = $this->data_error('No se ha enviado el id del objeto a actualizar');
                    echo $controller->error($error);
                }
                break;

            case 'obtener':
                if (getSegment(3) && getSegment(4)) {
                    //http://localhost/controlador/obtener/objeto/id
                    echo $controller->obtener(getSegment(4), getSegment(3));
                } elseif (getSegment(3)) {
                    // http://localhost/controlador/obtener/all

                    echo $controller->obtener(getSegment(3));
                } else {
                    //http://localhost/controlador/obtener
                    echo $controller->obtener();
                }
                break;

            case 'validar':
                /**Validar si un campo una fila especifica del objeto solicitado 
                 *
                 * http://localhost/controlador/validar/id/objeto
                 */
                if (getSegment(4)) {
                    $controller->setObjectName(getSegment(4));
                    echo $controller->validar(getSegment(3));
                }
                /**Realizar la accion por defecto del metodo */
                else {
                    echo $controller->validar(getSegment(3));
                }
                break;

            case 'health':
                echo json_encode(array('status' => 'UP'));
                break;

            default:
                echo $controller->{$action}();
                break;
        } //Fin del switch
    } //Fin de la funcion

    /**Realizar una solicitud a la aplicacion */
    public function llamar() {
        $default_controller = $this->default_controller;
        $default_action = $this->default_action;

        $controllers = new Controllers($default_controller, $default_action);

        $controller = $controllers->controller();
        $action = $controllers->accion();

        if ($controller == 'health') {
            $status = array(
                'status' => 'UP'
            );

            echo json_encode($status);
        } elseif ($controller != 'error') {
            //Poner la primera letra en mayuscula
            $controller = ucfirst($controller);

            $lista_controller = $controllers->listar_metodos($controller);

            //verifica que el controlador obtenido desde la url esté dentro del arreglo controllers
            if (array_key_exists($controller, $lista_controller)) {
                //verifica que el arreglo controllers con la clave que es la variable controller del index exista la acción
                if (in_array($action, $lista_controller[$controller])) {
                    //llama  la función call y le pasa el controlador a llamar y la acción (método) que está dentro del controlador
                    $this->call($controller, $action);
                } else {
                    $this->estado = 404;
                    $mensaje = 'La pagina solicitada no esta disponible';

                    $error = $this->data_error($mensaje);

                    echo $this->error($controllers->getDefaultController(), $error);
                } //Fin del else
            } else {
                $this->estado = 404;
                $mensaje = 'La pagina solicitada no esta disponible';

                $error = $this->data_error($mensaje);

                echo $this->error($controllers->getDefaultController(), $error);
            } //Fin de la validacion
        } //Fin de la validacion

        //Si el controlador es error
        else {
            $this->estado = 404;
            $mensaje = 'Se ha generado un error';

            $error = $this->data_error($mensaje);

            echo $this->error($controllers->getDefaultController(), $error);
        }
    } //Fin de la funcion

    private function data_error($mensaje) {
        $error = array(
            'status' => $this->estado,
            'message' => $mensaje,
            'error' => 'Not Found',
            'timestamp' => date('Y-m-d H:i:s')
        );

        $data = json_encode($error);

        return json_decode($data);
    } //Fin de la funcion

    /**Mostrar la p[agina por defecto de la aplicacion */
    public function error($controller, $error) {
        //crea el controlador
        $controller = $this->getController($controller);

        return $controller->error($error);
    } //Fin de la funcion para mostrar la pagina de error por defecto de la aplicacion
}//Fin de la clase
