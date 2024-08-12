<?php

namespace Core;

class Mapper {
    /**
     * Nombre de los campos que van a ser convertidos.
     * 
     * [
     *  "ingles"=>"espaniol",
     *  "ingles"=>"espaniol"
     * ]
     */
    protected $json_fields;

    /**
     * Convertir la lista de datos de ingles a español
     */
    public function convert_fiels($data_list) {
        $new_data = [];

        for($i = 0; $i < count($data_list); $i++){
            $data = $this->convert_row($data_list[$i]);
            $new_data[] = $data;
        }

        return $new_data;
    }

    public function convert_row($data) {
        $data = json_decode($data, true);

        $new_data = [];
        
        # Se deben de cambiar los nombres de ingles a español con los definidos en la variable $json_fields
        foreach($this->json_fiels as $key => $value){
            $new_data[$value] = $data[$key];
        }
        
        # Codificar la data en json
        $new_data = json_encode($new_data);

        return $new_data;
    }
}