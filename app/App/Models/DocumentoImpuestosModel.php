<?php
namespace App\Models;

use Core\Model;

/** Modelo para la tabla de impuestos de las lineas de detalle de un documento electronico */
class DocumentoImpuestosModel extends Model
{
	protected $tableName = 'documentos_impuestos';
	protected $primaryKey = 'id_impuesto';

	protected $tableFields = [
        'id_detalle',
        'codigo',
        'codigo_tarifa',
        'tarifa',
        'monto',
        'tipo_documento_exoneracion',
        'numero_documento_exoneracion',
        'nombre_institucion_exoneracion',
        'fecha_emision_exoneracion',
        'porcentaje_exoneracion',
        'monto_exoneracion',
	];

    protected $autoIncrement = true;
    protected $auditorias = true;

    

    /**Obtener todos los impuestos de una linea de detalle */
    public function obtener($id_detalle)
    {
        $this->where('id_detalle', $id_detalle);

        return $this->getAll();
    }//Fin del método obtener
}//Fin de la clase
?>