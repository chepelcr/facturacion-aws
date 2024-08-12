<?php
namespace Core\Auditorias;

/**Clase para manejar las auditorias */
class Auditorias
{
    public function insertAuditoria($data)
    {
        $auditoriasModel = new AuditoriaModel();
        $auditoriasModel->insert($data);
    }

    public function insertError($data)
    {
        $erroresModel = new ErroresModel();

        $erroresModel->insert($data);
    }//Fin de la funcion
}//Fin de la clase