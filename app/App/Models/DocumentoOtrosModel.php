<?php
//Usar la base para el modelo que tenemos creado
namespace App\Models;

use Core\Model;

/** Modelo para la tabla de usuarios */
class DocumentoOtrosModel extends Model
{
	protected $tableName = 'documentos_otros';
	protected $primaryKey = 'id_documento_otro';

	protected $tableFields = [
		'id_documento',
        'codigo',
        'valor',
        'fecha_creacion',
	];

    protected $autoIncrement = true;

    

    protected $auditorias = true;
}//Fin de la clase
?>