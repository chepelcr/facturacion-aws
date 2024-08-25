<?php
    namespace Core\Config;

    class Controllers
    {
        public function __construct($default_controller, $default_action)
        {
            load_helpers(['entorno','web']);

            $this->default_controller = $default_controller;
            $this->default_action = $default_action;
        }//Fin del constructor

        /**Controlador por defecto */
        protected $default_controller = '';

        /**Accoion que se realizara por defecto en todos los controladores */
        protected $default_action = '';

        /**Obtener la accion por defecto */
        public function getDefaultAction()
        {
            return $this->default_action;
        }//Fin de la funcion

        /**Ontener el controlador por defecto de la aplicacion */
        public function getDefaultController()
        {
            return $this->default_controller;
        }

        /** Funcion para listar los metodos de un controlador */
        public function listar_metodos($controller)
        {
            if(class_exists('App\\Controllers\\'.$controller))
                $metodos = get_class_methods("App\\Controllers\\".$controller);
            
            else
            {
                $controller = $this->getDefaultController();
                $metodos = get_class_methods('App\\Controllers\\'.$this->getDefaultController());
            }
            
            $data = array(
                $controller=>$metodos
            );

            return $data;
        }//Fin de la funcion para obtener los nombres de los metodos

        /**Verificar la accion que se debe realizar */
        public function accion()
        {
            if(getSegment(2))
                return getSegment(2);

            return $this->default_action;
        }//Fin de la funcion

        /**Obtener el controlador a ejecutar */
        public function controller()
        {
            if(getSegment(1))
                return getSegment(1);

            return $this->default_controller;
        }//Fin de la funcion para obtener un controlador
    }//Fin de la clase
