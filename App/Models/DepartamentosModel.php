<?php
//Usar la base para el modelo que tenemos creado
namespace App\Models;

use Core\Model;

/** Modelo para la tabla de departamentos */
class DepartamentosModel extends Model
{
    protected $nombreTabla = 'departamentos';
    protected $pk_tabla = 'id_departamento';

    protected $camposTabla = [
        'nombre',
        'numero_departamento',
        'numero_proveedor',
        'fecha_creacion',
        'fecha_modificacion',
        'fecha_eliminacion',
        'estado',
    ];

    protected $dbGroup = 'walmart';

    protected $autoIncrement = true;
    protected $auditorias = true;
}//Fin de la clase
?>