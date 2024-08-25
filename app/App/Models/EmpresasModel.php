<?php
namespace App\Models;

use Core\Model;

/**Manejador de la tabla Empresas */
class EmpresasModel extends Model
{
    protected $nombreTabla = 'empresas';
    protected $vistaTabla = 'empresas_view';

    protected $pkTabla = 'id_empresa';

    protected $camposTabla = [
        'identificacion',
        'id_tipo_identificacion',
        'razon',
        'nombre_comercial',
        'cod_actividad',
        'nombre_actividad',
        'id_ubicacion',
        'otras_senas',
        'telefono',
        'cod_pais',
        'correo',
        'estado'
    ];

    protected $camposVista = [
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

    /**Obtener un cliente por numero de identificacion */
    public function getByIdentificacion($identificacion)
    {
        $this->where('identificacion', $identificacion);

        return $this->fila();
    }

    function getEmpresa()
    {
        return $this->getById(getSession('id_empresa'));
    }
}//Fin de ` la clase