<?php
//Usar la base para el modelo que tenemos creado
namespace App\Models;

use Core\Model;

/** Modelo para la tabla de usuarios */
class DocumentoOtrosModel extends Model
{
	protected $nombreTabla = 'documentos_otros';
	protected $pkTabla = 'id_documento_otro';

	protected $camposTabla = [
		'id_documento',
        'codigo',
        'valor',
        'fecha_creacion',
	];

    protected $autoIncrement = true;

    

    protected $auditorias = true;
}//Fin de la clase
?>