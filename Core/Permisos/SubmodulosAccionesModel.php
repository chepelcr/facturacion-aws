<?php

namespace Core\Permisos;

use Core\Model;

/** 
 * Manejar los modulos, submodulos y acciones de la aplicacion.
 * 
 * @package Core\Permisos\
 * @version 1.0.0
 * @author JCampos
 */
class SubmodulosAccionesModel extends Model
{
    protected $nombreTabla = "submodulos_acciones";

    protected $vistaTabla = 'submodulos_acciones_view';

    protected $dbGroup = 'seguridad';

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

    /**
     * Obtener todos los modulos de la aplicacion 
     * 
     * @return array Modulos de la aplicacion
     */
    public function modulos()
    {
        $this->vista('modulos');
        
        $this->select('id_modulo');
        $this->select('nombre_modulo');
        $this->select('icono');

        $modulos = $this->getAll();

        foreach ($modulos as $modulo) {
            $permisosModel = new SubmodulosAccionesModel();
            $submodulos = $permisosModel->submodulos($modulo->id_modulo);

            $modulo->submodulos = $submodulos;
        }

        return $modulos;
    } //Fin de la funcion

    /**
     * Obtener todos los submodulos para un modulo 
     * 
     * @param int $id_modulo ID del modulo a consultar
     * 
     * @return array Submodulos del modulo
     */
    public function submodulos($id_modulo)
    {
        $this->vista('submodulos_view');

        $this->select('id_submodulo');
        $this->select('nombre_submodulo');
        $this->select('icono');
        $this->select('objeto');
        $this->select('url');

        $this->where('id_modulo', $id_modulo);

        $submodulos = $this->getAll();

        foreach ($submodulos as $submodulo) {
            $permisosModel = new SubmodulosAccionesModel();
            $acciones = $permisosModel->acciones($id_modulo, $submodulo->id_submodulo);

            $submodulo->acciones = $acciones;
        }

        return (object) $submodulos;
    } //Fin de la funcion

    /**
     * Obtener todas las acciones para un submodulo
     * 
     * @param int $id_modulo ID del modulo a consultar
     * @param int $id_submodulo ID del submodulo a consultar
     * 
     * @return array Acciones del submodulo
     */
    public function acciones($id_modulo, $id_submodulo)
    {
        $this->select('id_accion');
        $this->select('nombre_accion');
        $this->select('icono');

        $this->where('id_modulo', $id_modulo);
        $this->where('id_submodulo', $id_submodulo);

        $acciones = $this->getAll();

        return (object) $acciones;
    } //Fin de la funcion

}//Fin de la clase