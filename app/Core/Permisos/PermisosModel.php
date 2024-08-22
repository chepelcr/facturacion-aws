<?php

namespace Core\Permisos;

use Core\Model;

/**
 * Manejar los permisos de la aplicacion 
 * 
 * @package Core\Permisos\
 * @version 1.0.0
 * @author JCampos
 */
class PermisosModel extends Model
{
    protected $nombreTabla = "permisos_submodulos";
    protected $pk_tabla = "id_permiso";

    protected $vistaTabla = 'permisos_view';

    protected $dbGroup = 'seguridad';

    protected $camposTabla = [
        'id_rol',
        'id_modulo',
        'id_submodulo',
        'id_accion',
        'nombre_vista',
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

    /** 
     * Obtener todos los modulos de un rol 
     * 
     * @param int $id_rol ID del rol a consultar
     * @return array Modulos del rol
     */
    public function modulos($id_rol)
    {
        $this->vista('modulos_roles_view');

        $this->select('id_modulo');
        $this->select('nombre_modulo');
        $this->select('nombre_vista');
        $this->select('icono');
        $this->where('id_rol', $id_rol);

        $modulos = $this->getAll();

        foreach ($modulos as $modulo) {
            $permisosModel = new PermisosModel();
            $submodulos = $permisosModel->submodulos($id_rol, $modulo->id_modulo);

            $modulo->submodulos = $submodulos;
        }

        return $modulos;
    } //Fin de la funcion

    /**
     * Obtener todos los submodulos para un modulo 
     * 
     * @param int $id_rol ID del rol a consultar
     * @param int $id_modulo ID del modulo a consultar
     * 
     * @return array Submodulos del modulo
     */
    public function submodulos($id_rol, $id_modulo)
    {
        $this->vista('submodulos_roles_view');

        $this->select('id_submodulo');
        $this->select('nombre_submodulo');
        $this->select('nombre_vista');
        $this->select('icono');
        $this->select('objeto');
        $this->select('url');

        $this->where('id_rol', $id_rol);
        $this->where('id_modulo', $id_modulo);

        $submodulos = $this->getAll();

        foreach ($submodulos as $submodulo) {
            $permisosModel = new PermisosModel();
            $acciones = $permisosModel->acciones($id_rol, $id_modulo, $submodulo->id_submodulo);

            $submodulo->acciones = $acciones;
        }

        return (object) $submodulos;
    } //Fin de la funcion

    /**
     * Obtener todas las acciones para un submodulo
     * 
     * @param int $id_rol ID del rol a consultar
     * @param int $id_modulo ID del modulo a consultar
     * @param int $id_submodulo ID del submodulo a consultar
     * 
     * @return array Acciones del submodulo
     */
    public function acciones($id_rol, $id_modulo, $id_submodulo)
    {
        $this->select('id_permiso');
        $this->select('id_accion');
        $this->select('nombre_accion');
        $this->select('icono');
        $this->select('estado');

        $this->where('id_rol', $id_rol);
        $this->where('id_modulo', $id_modulo);
        $this->where('id_submodulo', $id_submodulo);
        $acciones = $this->getAll();

        return (object) $acciones;
    } //Fin de la funcion

    /** 
     * Retonar el id del permiso para un rol, modulo, submodulo y accion
     * 
     * @param int $id_rol ID del rol
     * @param int $id_modulo ID del modulo
     * @param int $id_submodulo ID del submodulo
     * @param int $id_accion ID de la accion
     * 
     * @return int|false ID del permiso o false si no existe
     */
    public function get_permiso($id_rol, $id_modulo, $id_submodulo, $id_accion)
    {
        $this->vista('permisos_submodulos');

        $this->select('id_permiso');

        $this->where('id_rol', $id_rol);
        $this->where('id_modulo', $id_modulo);
        $this->where('id_submodulo', $id_submodulo);
        $this->where('id_accion', $id_accion);

        $permiso = $this->fila();

        if (!$permiso) {
            return false;
        }

        return $permiso->id_permiso;
    } //Fin de la funcion
}//Fin de la clase