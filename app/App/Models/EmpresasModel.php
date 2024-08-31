<?php

namespace App\Models;

use Core\Model;

/**Manejador de la tabla Empresas */
class EmpresasModel extends Model {
    protected $tableName = 'empresas';
    protected $tableView = 'empresas_view';

    protected $primaryKey = 'id_empresa';

    protected $tableFields = [
        'identificacion',
        'id_tipo_identificacion',
        'razon',
        'nombre_comercial',
        'cod_actividad',
        'id_ubicacion',
        'otras_senas',
        'telefono',
        'cod_pais',
        'correo',
        'taxpayer_id',
        //'fecha_creacion',
        //'fecha_modificacion',
        //'fecha_eliminacion',
        'estado'
    ];

    protected $tableExtraViewFields = [
        'tipo_identificacion',
        'nombre',
        'codigo_telefono',
        'nombre_pais',
        'cod_provincia',
        'cod_canton',
        'cod_distrito',
        'cod_barrio',
        'provincia',
        'canton',
        'distrito',
        'barrio',
    ];

    protected $auditorias = true;
    protected $autoIncrement = true;

    /**
     * Obtener una empresa por su id de contribuyente
     * 
     * @param string $taxpayer_id
     * @return object
     */
    public function getByTaxpayerId($taxpayer_id) {
        $this->where('taxpayer_id', $taxpayer_id);
        return $this->fila();
    }
}//Fin de la clase