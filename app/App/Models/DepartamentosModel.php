<?php
//Usar la base para el modelo que tenemos creado
namespace App\Models;

use Core\Model;

/** Modelo para la tabla de departamentos */
class DepartamentosModel extends Model
{
    protected $tableName = 'departamentos';
    protected $primaryKey = 'id_departamento';

    protected $tableFields = [
        'nombre',
        'numero_departamento',
        'numero_proveedor',
        'fecha_creacion',
        'fecha_modificacion',
        'fecha_eliminacion',
        'estado',
    ];

    protected $autoIncrement = true;
    protected $auditorias = true;
} //Fin de la clase
