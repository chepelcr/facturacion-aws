<?php

use Core\Model;

/**Obtener un modelo de la aplicacion */
function model($model_name = null)
{
    if(isset($model_name))
    {
        //Poner la primer letra en mayuscula
        $model_name = ucfirst($model_name);

        $model_name = 'App\Models\\' . $model_name.'Model';

        //Crear una instancia del modelo
        $model = new $model_name();
        
        //Validar si el modelo devuelto es una instancia de Model
        if($model instanceof Model)
        {
            return $model;
        }
        else
        {
            return false;
        }
    }

    return false;
}//Fin de la funcion

/**Mostrar una imagen como un icono personalizado 
 * @param string $icono: Nombre de la imagen ubicada en la carpeta public/files/dist/img/icons
 * @param string $alt: Texto alternativo para la imagen
 * @param string $class: Clase CSS para la imagen
*/
function icono($icono, $alt, $class = null)
{
    return '<!-- Icono con imagen personalizada -->
        <img src="'.getFile('dist/img/icons/'.$icono).'" alt="'.$alt.'" class="img-fluid icn '.$class.'">';
}

/**Obtener la localizacion de la aplicacion para almacenar archivos
 * $carpeta: nombre de la carpeta
 * @return string
 */
function location($carpeta = '')
{
    if(getEnt('app.ambiente') == 'desarrollo')
    {
        //Transformar todos los / en \\
        $carpeta = str_replace('/', '\\', $carpeta);
        
        return getEnt('app.location') . $carpeta;
    }

    else {
        //Transformar todos los \\ en /
        $carpeta = str_replace('\\', '/', $carpeta);

        return getEnt('app.location') . $carpeta;
    }
}