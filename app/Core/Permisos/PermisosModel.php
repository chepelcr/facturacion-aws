<?php

    namespace Core\Permisos;

    use Core\Model;

    /**Manejar los permisos de la aplicacion */
    class PermisosModel extends Model
    {
        protected $nombreTabla = "permisos_submodulos";
        protected $pkTabla = "id_permiso";

        protected $vistaTabla = 'permisos_view';

        

        protected $camposTabla = [
            'id_rol',
            'id_modulo',
            'id_submodulo',
            'id_accion',
            'icono',
            'objeto',
            'url',
            'fecha_crecion',
            'fecha_modificacion',
            'estado',
        ];

        protected $camposVista = [
            'nombre_rol',
            'nombre_modulo',
            'nombre_submodulo',
            'nombre_accion',
        ];

        protected $autoIncrement = true;

        protected $auditorias = true;

        /**Obtener todos los modulos de un rol */
        public function modulos($id_rol)
        {
            $this->vista('modulos_roles_view')->select('id_modulo')->select('nombre_modulo')->select('icono')->where('id_rol', $id_rol);

            $modulos = $this->getAll();

            foreach ($modulos as $modulo) {
                $permisosModel = new PermisosModel();
                $submodulos = $permisosModel->submodulos($id_rol, $modulo->id_modulo);

                $modulo->submodulos = $submodulos;
            }

            return $modulos;
        }//Fin de la funcion

        /**Obtener todos los submodulos para un modulo */
        public function submodulos($id_rol, $id_modulo)
        {
            $this->vista('submodulos_roles_view')->select('id_submodulo')->select('nombre_submodulo')->select('icono')->select('objeto')->select('url')->where('id_rol', $id_rol)->where('id_modulo', $id_modulo);
            $submodulos = $this->getAll();
            
            foreach ($submodulos as $submodulo) {
                $permisosModel = new PermisosModel();
                $acciones = $permisosModel->acciones($id_rol, $id_modulo, $submodulo->id_submodulo);

                $submodulo->acciones = $acciones;
            }

            return (object) $submodulos;
        }//Fin de la funcion

        public function acciones($id_rol, $id_modulo, $id_submodulo)
        {
            $this->select('id_permiso')->select('id_accion')->select('nombre_accion')->select('icono')->select('estado')->where('id_rol', $id_rol)->where('id_modulo', $id_modulo)->where('id_submodulo', $id_submodulo);
            $acciones = $this->getAll();

            return (object) $acciones;
        }//Fin de la funcion

        public function get_permiso($id_rol, $id_modulo, $id_submodulo, $id_accion)
        {
            $this->vista('permisos_submodulos');

            $this->select('id_permiso')->where('id_rol', $id_rol)->where('id_modulo', $id_modulo)->where('id_submodulo', $id_submodulo)->where('id_accion', $id_accion);
            $permiso = $this->fila();

            return $permiso->id_permiso;
        }//Fin de la funcion
    }//Fin de la clase