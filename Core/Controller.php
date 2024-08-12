<?php
    namespace Core;
    
    abstract class Controller
    {
        /** Archivos de ayuda creados por el usuario */
        protected $helpers = [];

        /**Archivos de ayuda predeterminados */
        private $baseHelpers = ['auditorias', 'views', 'session', 'core'];

        /**Nombre del objeto que usara el controlador en la solicitud */
        protected $modelName = '';

        /**Determinar si el controlador es un modulo general */
        protected $isModulo = false;

        /**Nombre del modulo que contendra los submodulos */
        protected $nombreModulo = '';

        /**Campos para la validacion de objetos de un modulo
         * 
         * $validationFields = array(
         *      'objeto_1' = 'nombre_campo',
         *      'objeto_2' = 'nombre_campo',)
         */
        protected $validationFields = array();
        
        /**Nombre del campo que se usará para la validacion de un objeto */
        #protected $campo_validacion = null;

        /** Objetos que componen el controlador, si es un modulo
         * 
         * $objetos = ['objeto_1', 'objeto_2', 'objeto_3'];
         */
        protected $objetos = array();

        /**Validar si el usuario debe iniciar sesion para acceder al controlador
         * 
         * $loginValidation = true;
         * $loginValidation = true;
         * 
         * Si el controlador es un modulo, se usara un array con el nombre de los objetos
         * 
         * $loginValidation = array(
         *      'objeto_1' => true,
         *      'objeto_2' => false,);
         */
        protected $loginValidation;

        public function __construct()
        {
            load_helpers($this->baseHelpers);
            load_helpers($this->helpers, 'App');
        }//Fin del constructor

        public function setObjectName($name)
        {
            $this->modelName = $name;
        }//Fin de la funcion

        public function error($error = array())
        {
            $error = (object) $error;

            //Poner el header en el codigo de error
            header('HTTP/1.0 '.$error->status.$error->error);

            return json_encode($error);
        }//Fin de la funcion error

        /**Establecer un modelo en el controlador */
        protected function getService($modelName = '')
        {
            $modelName = 'App\\Services\\'.ucfirst($modelName).'Service';

            return new $modelName();
        }//Fin de la funcion

        /**Enviar un error para una vista de error*/
        protected function object_error($codigo, $mensaje)
        {
            $error = array(
                'codigo'=>$codigo,
                'error'=>$mensaje
            );
            
            return (object) $error;
        }//Fin de la funcion

        /**Enviar un error en formato json */
        private function dataError($codigo, $mensaje)
        {
            $error = array(
                'error'=>array(
                    'codigo'=>$codigo,
                    'error'=>$mensaje
                )
            );

            return json_encode($error);
        }//Fin de la funcion

        /** Obtener filas de un objeto solicitado */
        public function obtener($id = '', $objeto = null) {
            //Valida si el controlador es un modulo
            if($this->isModulo) {
                //Si el objeto no es nulo, y se encuentra registrado en el modulo
                if(!is_null($objeto) && in_array($objeto, $this->objetos)) {
                    //Validar si el usuario tiene que iniciar sesion para obtener los datos
                    if(isset($this->loginValidation[$objeto])) {
                        $loginValidation = $this->loginValidation[$objeto];
                    } else {
                        $loginValidation = false;
                    }
                }//Fin de la validacion

                //Si el objeto es nulo o no existe en el controlador
                else {
                    //Si el objeto es nulo
                    if(is_null($objeto)) {
                        $error = $this->object_error(1, 'No se ha indicado un objeto para la solicitud');
                    }
                    
                    //Si el objeto indicado no existe en el modulo
                    if(!is_null($objeto) && !in_array($objeto, $this->objetos)) {
                        $error = $this->object_error(2, 'El objeto indicado no se encuentra en el modulo');
                    }

                    return $this->error($error);
                }//Fin de la validacion
            }//Fin de validacion del modulo

            //Si el objeto no es un modulo
            else {
                //Si el objeto no es nulo
                if(!is_null($objeto)) {
                    $error = $this->object_error(3, 'Tipo de solicitud no permitida');

                    //Enviar un error al usuario
                    return $this->error($error);
                }//Fin de la validacion
            }//Fin de la validacion de modulo
            

            if($id == '') {
                return $this->dataError(1, 'Se ha generado un error en la solicitud');
            } else {
                if($this->isModulo) {
                    $service = $this->getService($objeto);
                } else {
                    $service = $this->getService($this->nombreModulo);
                }

                # Validar si la variable _GET no esta vacia
                if(empty($_GET)) {
                    $getObj = $_GET;
                } else {
                    $getObj = array();
                }

                if($loginValidation) {
                    if(validar_permiso($this->nombreModulo, $objeto, 'consultar')) {
                        return json_encode($service->getData($id, $getObj));
                    } elseif(is_login()) {
                        return $this->dataError(3, 'No tiene permisos para realizar esta accion');
                    } else {
                        return $this->dataError(4, 'Debe iniciar sesion para obtener la informacion');
                    }
                } else {
                    return json_encode($service->getData($id, $getObj));
                }
            }
        }//Fin de la funcion para obtener objetos de la aplicacion

        /**Validar si existe un objeto de la base de datos por código */
        public function validar($id = null) {
            
            $validacion = false;
            $objeto = $this->modelName;
            

            if($this->isModulo) {
                //Si el objeto no es nulo, y se encuentra registrado en el modulo
                if(in_array($objeto, $this->objetos)) {
                    //Validar si el usuario tiene que iniciar sesion para obtener los datos
                    if(isset($this->loginValidation[$objeto])) {
                        $loginValidation = $this->loginValidation[$objeto];
                    } else {
                        $loginValidation = false;
                    }
                }//Fin de la validacion

                //Retornar un error en el navegador
                else {
                    return $this->dataError(1, 'Se ha generado un error en la solicitud');
                }//Fin del else

                $service = $this->getService($objeto);
            }//Fin de validacion de modulo

            else {
                if(!is_null($objeto)) {
                    return $this->dataError(2, 'Tipo de solicitud no permitida');
                }//Fin de la validacion

                $service = $this->getService($this->nombreModulo);
            }//Fin de la validacion de modulo

            if($this->isModulo && $loginValidation) {
                if(validar_permiso($this->nombreModulo, $objeto, 'consultar')) {
                    $validacion = $service->validarExistencia($_GET);
                } elseif(is_login()) {
                    return $this->dataError(3, 'No tiene permisos para realizar esta accion');
                } else {
                    return $this->dataError(4, 'Debe iniciar sesion para obtener la informacion');
                }
            } else {
                $validacion = $service->validarExistencia($id);
            }

            return json_encode($validacion);
        }//Fin de la validacion de un objeto

        /**Desactivar un objeto de la base de datos */
        public function desactivar($id = '') {
            $objeto = $this->modelName;
            $loginValidation = false;

            /**Validar si el controlador es un modulo */
            if($this->isModulo) {
                //Si el objeto no es nulo, y se encuentra registrado en el modulo
                if(!is_null($objeto) && in_array($objeto, $this->objetos)) {
                    //Validar si el usuario tiene que iniciar sesion para obtener los datos
                    if(isset($this->loginValidation[$objeto])) {
                        $loginValidation = $this->loginValidation[$objeto];
                    }

                    //Se establece el nombre del modelo en el objeto entrante.
                    $this->modelName = $objeto;
                }//Fin de la validacion

                //Si el objeto es nulo o no existe en el controlador
                else {
                    //Si el objeto es nulo
                    if(is_null($objeto)) {
                        return json_encode(array(
                            'error' => 'No se ha indicado un objeto para la solicitud'
                        ));
                    }
                    
                    //Si el objeto indicado no existe en el modulo
                    if(!is_null($objeto) && !in_array($objeto, $this->objetos)) {
                        return json_encode(array(
                            'error' => 'El objeto indicado no se encuentra en el modulo'
                        ));
                    }
                }//Fin de la validacion
            }//Fin de validacion del modulo

            //Si el objeto no es un modulo
            else {
                //Si el objeto no es nulo
                if(!is_null($objeto)) {
                    return json_encode(array(
                        'error' => 'Tipo de solicitud no permitida'
                    ));
                }//Fin de la validacion

                $loginValidation = $this->loginValidation;
            }//Fin de la validacion de modulo

            if($id != '') {
                $data = array(
                    'status' => 2
                );

                if($loginValidation) {
                    //Si el usuario ya inicio sesion
                    if(is_login()) {
                        if(!validar_permiso($this->nombreModulo, $objeto, 'modificar')) {
                            return json_encode(array(
                                'error' => 'No tiene permisos para realizar esta accion'
                            ));
                        } else {
                            $service = $this->getService($objeto);
                            return json_encode($service->changeStatus($id, $data));
                        }
                    }//Fin de validacion de login
                }//Fin de la validacion

                else {
                    $service = $this->getService($objeto);
                    return json_encode($service->changeStatus($id, $data));
                }//Fin de la validacion de login
            }//Fin de la validacion de id

            else {
                return json_encode(array(
                    'error' => 'No se ha indicado un id para la solicitud'));
            }
        }//Fin de la funcion para desactivar un objeto

        /**Activar un objeto de la base de datos */
        public function activar($id = '') {
            $objeto = $this->modelName;
            $loginValidation = false;

            /**Validar si el controlador es un modulo */
            if($this->isModulo) {
                //Si el objeto no es nulo, y se encuentra registrado en el modulo
                if(!is_null($objeto) && in_array($objeto, $this->objetos)) {
                    //Validar si el usuario tiene que iniciar sesion para cambiar el estado del objeto
                    if(isset($this->loginValidation[$objeto])) {
                        $loginValidation = $this->loginValidation[$objeto];
                    }

                    //Se establece el nombre del modelo en el objeto entrante.
                    $this->modelName = $objeto;
                }//Fin de la validacion

                //Si el objeto es nulo o no existe en el controlador
                else {
                    //Si el objeto es nulo
                    if(is_null($objeto)) {
                        $error = $this->dataError(1, 'No se ha indicado un objeto para la solicitud');
                    }
                    
                    //Si el objeto indicado no existe en el modulo
                    if(!is_null($objeto) && !in_array($objeto, $this->objetos)) {
                        $error = $this->dataError(2, 'El objeto indicado no se encuentra en el modulo');
                    }

                    return $this->error($error);
                }//Fin de la validacion
            }//Fin de validacion del modulo

            //Si el objeto no es un modulo
            else {
                //Si el objeto no es nulo
                if(!is_null($objeto)) {
                    return $this->dataError(3, 'Tipo de solicitud no permitida');
                }//Fin de la validacion

                $loginValidation = $this->loginValidation;
            }//Fin de la validacion de modulo

            if($id!='') {
                $data = array(
                    'status' => 1
                );

                if($loginValidation) {
                    //Si el usuario ya inicio sesion
                    if(is_login()) {
                        if(!validar_permiso($this->nombreModulo, $objeto, 'modificar')) {
                            
                            return json_encode(array(
                                'error' => 'No tiene permisos para realizar esta accion'
                            ));
                        } else {
                            $service = $this->getService($objeto);
                            return json_encode($service->changeStatus($id, $data));
                        }
                    }//Fin de validacion de login
                }//Fin de la validacion

                else {
                    $service = $this->getService($objeto);
                    return json_encode($service->changeStatus($id, $data));
                }//Fin de la validacion de login
            }//Fin de la validacion de id

            else {
                return json_encode(array('error' => 'No se ha indicado un id para la solicitud'));
            }//Fin de la validacion de id
        }//Fin de la funcion para activar un objeto

        public function update($id, $data){
            return $this->dataError(1, 'Se ha generado un error en la solicitud');
        }

        /**
         * Guardar un objeto en la base de datos
         * @param array $data Datos del objeto a guardar
         * @return string
         
         */
        public function guardar($data){
            return $this->dataError(1, 'Se ha generado un error en la solicitud');
        }
    }//Fin de la clase
