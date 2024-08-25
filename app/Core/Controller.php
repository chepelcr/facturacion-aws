<?php

namespace Core;

class Controller
{
    /** Archivos de ayuda creados por el usuario */
    protected $helpers = [];

    /**Archivos de ayuda predeterminados */
    private $base_helpers = ['auditorias', 'views', 'session', 'core'];

    /**Modelo de la aplicacion */
    private Model $model;

    /**Nombre del objeto que usara el controlador en la solicitud */
    protected $modelName = '';

    /**Determinar si el controlador es un modulo general */
    protected $isModulo = false;

    /**Nombre del modulo que contendra los submodulos */
    protected $nombre_modulo = '';

    /**Campos para la validacion de objetos de un modulo
     * 
     * $campos_validacion = array(
     *      'objeto_1' = 'nombre_campo',
     *      'objeto_2' = 'nombre_campo',)
     */
    protected $campos_validacion = array();

    /**Nombre del campo que se usará para la validacion de un objeto */
    protected $campo_validacion = null;

    /** Objetos que componen el controlador, si es un modulo
     * 
     * $objetos = ['objeto_1', 'objeto_2', 'objeto_3'];
     */
    protected $objetos = array();

    /**Validar si el usuario debe iniciar sesion para acceder al controlador
     * 
     * $validacion_login = true;
     * $validacion_login = true;
     * 
     * Si el controlador es un modulo, se usara un array con el nombre de los objetos
     * 
     * $validacion_login = array(
     *      'objeto_1' => true,
     *      'objeto_2' => false,);
     */
    protected $validacion_login = false;

    public function __construct()
    {
        load_helpers($this->base_helpers);
        load_helpers($this->helpers, 'App');
    } //Fin del constructor

    public function error($error = array())
    {
        $nombreVista = 'base/error';

        $dataView = array(
            'error' => $error,
        );

        return view($nombreVista, $dataView);
    } //Fin de la funcion error

    /**Establecer un modelo en el controlador */
    public function model($modelName = '')
    {
        if ($modelName != '') {
            $this->modelName = $modelName;
        }

        $modelName = 'App\\Models\\' . ucfirst($this->modelName) . 'Model';

        $this->model = new $modelName();
        return $this->model;
    } //Fin de la funcion

    /**Enviar un error en formato json */
    protected function object_error($codigo, $mensaje)
    {
        $error = array(
            'codigo' => $codigo,
            'error' => $mensaje
        );

        return (object) $error;
    } //Fin de la funcion

    /**Enviar un error en formato json */
    private function data_error($codigo, $mensaje)
    {
        $error = array(
            'error' => array(
                'codigo' => $codigo,
                'error' => $mensaje
            )
        );

        return json_encode($error);
    } //Fin de la funcion

    /** Obtener filas de un objeto solicitado */
    public function obtener($id = '', $objeto = null)
    {
        $validacion_login = false;

        /**Validar si el controlador es un modulo */
        if ($this->isModulo) {
            //Si el objeto no es nulo, y se encuentra registrado en el modulo
            if (!is_null($objeto) && in_array($objeto, $this->objetos)) {
                //Validar si el usuario tiene que iniciar sesion para obtener los datos
                if (isset($this->validacion_login[$objeto]))
                    $validacion_login = $this->validacion_login[$objeto];

                //Se establece el nombre del modelo en el objeto entrante.
                $this->modelName = $objeto;
            } //Fin de la validacion

            //Si el objeto es nulo o no existe en el controlador
            else {
                //Si el objeto es nulo
                if (is_null($objeto)) {
                    $error = $this->object_error(1, 'No se ha indicado un objeto para la solicitud');
                }

                //Si el objeto indicado no existe en el modulo
                if (!is_null($objeto) && !in_array($objeto, $this->objetos)) {
                    $error = $this->object_error(2, 'El objeto indicado no se encuentra en el modulo');
                }

                return $this->error($error);
            } //Fin de la validacion
        } //Fin de validacion del modulo

        //Si el objeto no es un modulo
        else {
            //Si el objeto no es nulo
            if (!is_null($objeto)) {
                $error = $this->object_error(3, 'Tipo de solicitud no permitida');

                //Enviar un error al usuario
                return $this->error($error);
            } //Fin de la validacion

            $validacion_login = $this->validacion_login;
        } //Fin de la validacion de modulo

        $model = $this->model();

        switch ($id) {
            case 'all':
                if ($validacion_login) {
                    if ($this->isModulo)
                        if (validar_permiso($this->nombre_modulo, $objeto, 'consultar'))
                            return json_encode($model->obtener('all'));

                        //Si el usuario ya inicio sesion
                        elseif (is_login())
                            return json_encode($model->obtener('all'));

                        //Si el usuario no ha iniciado sesion
                        else {
                            return $this->data_error(4, 'Debe iniciar sesion para obtener la informacion');
                        }
                } //Fin de la validacion de login

                else
                    return json_encode($model->obtener('all'));
                break;

            case '':
                //Enviar un error al usuario
                return $this->data_error(1, 'Se ha generado un error en la solicitud');
                break;

            default:
                if ($validacion_login) {
                    if ($this->isModulo)
                        if (validar_permiso($this->nombre_modulo, $objeto, 'consultar'))
                            return json_encode($model->obtener($id));

                        //Si el usuario ya inicio sesion
                        elseif (is_login())
                            return json_encode($model->obtener($id));

                        //Si el usuario no ha iniciado sesion
                        else {
                            return $this->data_error(4, 'Debe iniciar sesion para obtener la informacion');
                        }
                } //Fin de la validacion de login

                else
                    return json_encode($model->obtener($id));
                break;
        } //Fin del switch

        return $this->data_error(1, 'Se ha generado un error en la solicitud');
    } //Fin de la funcion para obtener objetos de la aplicacion

    /**Validar si existe un objeto de la base de datos por código */
    public function validar($codigo = '', $objeto = null)
    {
        $validacion = false;

        if ($this->isModulo) {
            if (!is_null($objeto) && in_array($objeto, $this->objetos)) {
                $this->modelName = $objeto;

                if (isset($this->campos_validacion[$objeto]))
                    $this->campo_validacion = $this->campos_validacion[$objeto];
            } //Fin de la validacion del objeto

            //Retornar un error en el navegador
            else {
                return $this->data_error(1, 'Se ha generado un error en la solicitud');
            } //Fin del else
        } //Fin de validacion de modulo

        if (!is_null($this->campo_validacion)) {
            $campo_validacion = $this->campo_validacion;

            $model = $this->model();
            $model->where($campo_validacion, $codigo);

            if ($model->fila())
                $validacion = true;
        } //Fin de la validacion

        return json_encode($validacion);
    } //Fin de la validacion de un objeto

    /**Desactivar un objeto de la base de datos */
    public function desactivar($id = '', $objeto = null)
    {
        $validacion_login = false;

        /**Validar si el controlador es un modulo */
        if ($this->isModulo) {
            //Si el objeto no es nulo, y se encuentra registrado en el modulo
            if (!is_null($objeto) && in_array($objeto, $this->objetos)) {
                //Validar si el usuario tiene que iniciar sesion para obtener los datos
                if (isset($this->validacion_login[$objeto]))
                    $validacion_login = $this->validacion_login[$objeto];

                //Se establece el nombre del modelo en el objeto entrante.
                $this->modelName = $objeto;
            } //Fin de la validacion

            //Si el objeto es nulo o no existe en el controlador
            else {
                //Si el objeto es nulo
                if (is_null($objeto)) {
                    return json_encode(array(
                        'error' => 'No se ha indicado un objeto para la solicitud'
                    ));
                }

                //Si el objeto indicado no existe en el modulo
                if (!is_null($objeto) && !in_array($objeto, $this->objetos)) {
                    return json_encode(array(
                        'error' => 'El objeto indicado no se encuentra en el modulo'
                    ));
                }
            } //Fin de la validacion
        } //Fin de validacion del modulo

        //Si el objeto no es un modulo
        else {
            //Si el objeto no es nulo
            if (!is_null($objeto)) {
                return json_encode(array(
                    'error' => 'Tipo de solicitud no permitida'
                ));
            } //Fin de la validacion

            $validacion_login = $this->validacion_login;
        } //Fin de la validacion de modulo

        if ($id != '') {
            $data = array(
                'estado' => 0,
                'fecha_eliminacion' => date('Y-m-d H:i:s')
            );

            if ($validacion_login) {
                //Si el usuario ya inicio sesion
                if (is_login()) {
                    if (!validar_permiso($this->nombre_modulo, $objeto, 'modificar'))
                        return json_encode(array(
                            'error' => 'No tiene permisos para realizar esta accion'
                        ));

                    $model = $this->model();

                    $id = $model->update($data, $id);
                } //Fin de validacion de login
            } //Fin de la validacion

            else {
                $model = $this->model();

                $id = $model->update($data, $id);
            } //Fin de la validacion de login

            if ($id != 0)
                return json_encode(array(
                    'estado' => 1
                ));

            else {
                $error = $model->getError();

                return json_encode(array(
                    'error' => $error->sentencia
                ));
            } //Fin del else
        } //Fin de la validacion de id

        else
            return json_encode(array(
                'error' => 'No se ha indicado un id para la solicitud'
            ));
    } //Fin de la funcion para desactivar un objeto

    /**Activar un objeto de la base de datos */
    public function activar($id = '', $objeto = null)
    {
        $validacion_login = false;

        /**Validar si el controlador es un modulo */
        if ($this->isModulo) {
            //Si el objeto no es nulo, y se encuentra registrado en el modulo
            if (!is_null($objeto) && in_array($objeto, $this->objetos)) {
                //Validar si el usuario tiene que iniciar sesion para cambiar el estado del objeto
                if (isset($this->validacion_login[$objeto]))
                    $validacion_login = $this->validacion_login[$objeto];

                //Se establece el nombre del modelo en el objeto entrante.
                $this->modelName = $objeto;
            } //Fin de la validacion

            //Si el objeto es nulo o no existe en el controlador
            else {
                //Si el objeto es nulo
                if (is_null($objeto)) {
                    return $this->data_error(1, 'No se ha indicado un objeto para la solicitud');
                }

                //Si el objeto indicado no existe en el modulo
                if (!is_null($objeto) && !in_array($objeto, $this->objetos)) {
                    $error = $this->data_error(2, 'El objeto indicado no se encuentra en el modulo');
                }

                return $this->error($error);
            } //Fin de la validacion
        } //Fin de validacion del modulo

        //Si el objeto no es un modulo
        else {
            //Si el objeto no es nulo
            if (!is_null($objeto)) {
                return $this->data_error(3, 'Tipo de solicitud no permitida');
            } //Fin de la validacion

            $validacion_login = $this->validacion_login;
        } //Fin de la validacion de modulo

        if ($id != '') {
            $data = array(
                'estado' => 1,
                'fecha_eliminacion' => null
            );

            if ($validacion_login) {
                //Si el usuario ya inicio sesion
                if (is_login()) {
                    if (!validar_permiso($this->nombre_modulo, $objeto, 'modificar'))
                        return json_encode(array(
                            'error' => 'No tiene permisos para realizar esta accion'
                        ));

                    $model = $this->model();

                    $id = $model->update($data, $id);
                } //Fin de validacion de login
            } //Fin de la validacion

            else {
                $model = $this->model();

                $id = $model->update($data, $id);
            } //Fin de la validacion de login

            if ($id != 0)
                return json_encode(array(
                    'estado' => 1
                ));

            else {
                $error = $model->getError();

                return json_encode(array('error' => $error['sentencia']));
            } //Fin del else
        } //Fin de la validacion de id

        else {
            return json_encode(array('error' => 'No se ha indicado un id para la solicitud'));
        } //Fin de la validacion de id
    } //Fin de la funcion para activar un objeto

    public function update($id, $objeto = null)
    {
    }

    public function guardar($objeto = null)
    {
    }
}//Fin de la clase
