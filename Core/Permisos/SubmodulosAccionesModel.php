<?php
    namespace Core\Permisos;

    use Core\Model;

    /**Manejar los submodulos de la aplicacion */
    class SubmodulosAccionesModel extends Model
    {
        protected $nombreTabla = "submodulos_acciones";

        protected $vistaTabla = 'submodulos_acciones_view';

        

        protected $camposTabla = [
            'id_modulo',
            'id_submodulo',
            'id_accion',
        ];

        protected $camposVista = [
            'nombre_modulo',
            'nombre_submodulo',
            'nombre_accion',
        ];

        protected $auditorias = true;

        /**Obtener todos los modulos de la aplicacion */
        public function modulos()
        {
            $this->vista('modulos')->select('id_modulo')->select('nombre_modulo')->select('icono');

            $modulos = $this->getAll();

            foreach ($modulos as $modulo) {
                $permisosModel = new SubmodulosAccionesModel();
                $submodulos = $permisosModel->submodulos($modulo->id_modulo);

                $modulo->submodulos = $submodulos;
            }

            return $modulos;
        }//Fin de la funcion

        /**Obtener todos los submodulos para un modulo */
        public function submodulos($id_modulo)
        {
            $this->vista('submodulos_view')->select('id_submodulo')->select('nombre_submodulo')->select('icono')->select('objeto')->select('url')->where('id_modulo', $id_modulo);
            $submodulos = $this->getAll();
            
            foreach ($submodulos as $submodulo) {
                $permisosModel = new SubmodulosAccionesModel();
                $acciones = $permisosModel->acciones($id_modulo, $submodulo->id_submodulo);

                $submodulo->acciones = $acciones;
            }

            return (object) $submodulos;
        }//Fin de la funcion

        public function acciones($id_modulo, $id_submodulo)
        {
            $this->select('id_accion')->select('nombre_accion')->select('icono')->where('id_modulo', $id_modulo)->where('id_submodulo', $id_submodulo);
            $acciones = $this->getAll();

            return (object) $acciones;
        }//Fin de la funcion

    }//Fin de la clase