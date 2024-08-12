<?php

use Core\Auditorias\Auditorias;

function insertError($data)
{
    $auditorias = new Auditorias();
    $auditorias->insertError($data);
}//Fin de la funcion

function insertAuditoria($data)
    {
        $auditorias = new Auditorias();
        $auditorias->insertAuditoria($data);
    }//Fin de la funcion