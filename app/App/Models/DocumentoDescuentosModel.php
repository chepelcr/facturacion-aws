<?php
namespace App\Models;

use Core\Model;

/** Modelo para la tabla de descuentos */
class DocumentoDescuentosModel extends Model
{
	protected $tableName = 'documentos_descuentos';
	protected $primaryKey = 'id_descuento';

	protected $tableFields = [
        'id_detalle',
        'monto',
        'motivo',
	];    

    protected $autoIncrement = true;

    

    protected $auditorias = true;

    /**Obtener todos los descuentos de una linea de detalle */
    public function obtener($id_detalle)
    {
        $this->where('id_detalle', $id_detalle);

        return $this->getAll();
    }//Fin del método obtener
}//Fin de la clase
?>