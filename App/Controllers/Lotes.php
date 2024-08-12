<?php

/**
 * Descripción: Controlador para la entidad libro
 */

namespace App\Controllers;

class Lotes extends BaseController
{
    public function index()
    {
        $nombreVista = 'lotes/produccion/listado';
        $nombreForm = 'lotes/produccion/form';

        $lotes = array();

        $dataModal = array(
            'nombreForm' => $nombreForm,
        );

        $dataView = array(
            'dataModal' => $dataModal
        );

        $data = array(
            'nombreVista' => $nombreVista,
            'dataView' => $dataView,
            'script' => '<script>
                                    $(document).ready(function(){
                                        cargar_listado("produccion", "lotes", ' . baseUrl('produccion/lotes/listado') . ');
                                    });
                                </script>'
        );

        return view('layout', $data);
    }

    /**Obtener los productos utilizados en la creacion de lotes */
    public function lotes()
    {
        $nombreVista = 'lotes/produccion/listado';
        $nombreForm = 'lotes/produccion/form';

        $productos = array();



        $dataModal = array(
            'nombreForm' => $nombreForm,
        );

        $dataView = array(
            'dataModal' => $dataModal,
            'articulos' => $productos
        );

        $data = array(
            'nombreVista' => $nombreVista,
            'dataView' => $dataView,
            'script' => '<script>
                                    $(document).ready(function(){
                                        cargar_listado("produccion", "lotes", ' . baseUrl('produccion/lotes/listado') . ');
                                    });
                                </script>'
        );

        if (getSegment(3) == 'listado') {
            return view($nombreVista, $dataView);
        }

        return view('layout', $data);
    } //Fin de la funcion para mostrar el listado
}//Fin de la clase
