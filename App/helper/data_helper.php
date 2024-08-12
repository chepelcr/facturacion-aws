<?php

/**
 * Funcion para eliminar los campos vacios de un objeto
 * @param $data array|object
 * @return array|object
 */
function deleteEmptyFields($data)
{
    foreach ($data as $key => $value) {
        //Si el objeto es un array
        if (is_array($value)) {
            //Si el array esta vacio
            if (empty($value)) {
                unset($data[$key]);
                //$data[$key] = [];
            } else {
                $data[$key] = deleteEmptyFields($value);
            }
        } elseif (is_object($value)) {
            //Si el objeto esta vacio
            if (empty((array) $value)) {
                unset($data->$key);
                //$data->$key = new stdClass();
            } else {
                $data->$key = deleteEmptyFields($value);
            }
        } //Si es un string
        elseif ($value == '') {
            $data->$key = '';
        }
    }

    return $data;
}
