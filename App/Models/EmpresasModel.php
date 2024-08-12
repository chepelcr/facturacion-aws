<?php
namespace App\Models;

use Core\Model;

/**Manejador de la tabla Empresas */
class EmpresasModel extends Model
{
    protected $nombreTabla = 'empresas';
    protected $vistaTabla = 'empresas_view';

    protected $pk_tabla = 'id_empresa';

    protected $camposTabla = [
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
        //'fecha_creacion',
        //'fecha_modificacion',
        //'fecha_eliminacion',
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

    protected $dbGroup = 'seguridad';

    protected $auditorias = true;
    protected $autoIncrement = true;

    /**Obtener una empresa por numero de identificacion */
    public function getByIdentificacion($identificacion)
    {
        $this->where('identificacion', $identificacion);

        return $this->fila();
    }//Fin de la funcion para obtener una empresa por numero de identificacion

    /**Obtener la empresa del usuario que ha iniciado sesión 
     * @return object
     * @return boolean
     */
    function getEmpresa()
    {
        $empresa = $this->getById(getSession('id_empresa'));

        if(!$empresa)
        {
            return false;
        }

        else
        {
            foreach($empresa as $key => $value)
            {
                setSession('empresa_' . $key, $value);
            }
        }

        return $empresa;
    }//Fin de la funcion para obtener la empresa del usuario que ha iniciado sesión
}//Fin de la clase