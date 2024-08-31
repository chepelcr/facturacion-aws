<?php
    namespace App\Models;

use Core\Model;

class ContraseniaModel extends Model
    {
        protected $tableName = 'contrasenia_usuarios';
        protected $primaryKey = 'id_contrasenia';

        

        protected $tableFields = [
            'id_usuario',
            'contrasenia',
            'fecha_expiracion',
            'intentos_fallidos',
            'bloqueado',
            'fecha_bloqueo',
            'fecha_desbloqueo',
            'fecha_creacion',
            'fecha_modificacion',
            'fecha_eliminacion',
            'estado'
        ];

        protected $autoIncrement = true;

        protected $auditorias = true;

        /**Obtener la contraseña de un usuario */
        public function contrasenia($id_usuario)
        {
            return $this->where('id_usuario', $id_usuario)->fila();
        }//Fin de la función contrasenia
    }