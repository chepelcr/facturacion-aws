<?php
namespace App\Controllers;

use App\Models\UbicacionesModel;

class Ubicacion extends BaseController
{
    /**Obtener todas las provincias */
    public function provincias()
    {
        $ubicacionesModel = new UbicacionesModel();
        $provincias = $ubicacionesModel->provincias();

        return json_encode($provincias);
    }//Fin de la funcion provincias

    /**Obtener los cantones para una provincia */
    public function cantones()
    {
        if(getSegment(3))
        {
            $ubicacionesModel = new UbicacionesModel();

            return json_encode($ubicacionesModel->cantones(getSegment(3)));
        }

        return json_encode(false);
    }//Fin de la funcion

    /**Obtener todos los distritos para un canton */
    public function distritos()
    {
        $ubicacionesModel = new UbicacionesModel();

        if(getSegment(3) && getSegment(4))
        {
            return json_encode($ubicacionesModel->distritos(getSegment(3), getSegment(4)));
        }

        return json_encode(false);
    }//Fin de validacion

    /**Obtener todos los distritos para un canton */
    public function barrios()
    {
        $ubicacionesModel = new UbicacionesModel();

        if(getSegment(3) && getSegment(4) && getSegment(5))
        {
            $ubicacionesModel->where('cod_provincia', getSegment(3))->where('cod_canton', getSegment(4))->where('cod_distrito', getSegment(5));

            return json_encode($ubicacionesModel->getAll());
        }//Fin de validacion

        return json_encode(false);
    }//Fin de la funcion
}//Fin de la clase
