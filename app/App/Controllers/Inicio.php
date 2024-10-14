<?php

/**
 * Descripción: Controlador para la entidad Rol
 */

namespace App\Controllers;

/**
 * Clase para manejar el modulo de inicio
 * @package App\Controllers
 * @subpackage Inicio
 * @version 2.0
 * @author jcampos
 */
class Inicio extends BaseController
{
    /** Devolver el dash de la aplicacion */
    public function index()
    {
        if (is_login()) {
            return $this->inicio();
        } else {
            header('Location: ' . baseUrl('login'));
        }
    } //Fin de la funcion index

    public function update($id, $data, $reinsert = false) {
        $error = $this->object_error('400', 'La acción no está permitida');
        return $this->error($error);
    }
} //Fin de la clase
