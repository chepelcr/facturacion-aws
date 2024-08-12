<?php

use Core\Auditorias\Auditorias;

function insertError($error, $controlador) {
    $data = array(
        'sentencia'=>$error,
        'controlador'=>$controlador,
        'id_usuario'=>getSession('id_usuario') ?? 0,
    );

    $auditorias = new Auditorias();
    $auditorias->insertError($data);
}//Fin de la funcion

function insertAuditoria($idFila, $tabla, $accion) {
    $data = array(
        'id_fila' => $idFila,
        'tabla' => $tabla,
        'id_usuario' => getSession('id_usuario') ?? 0,
        'accion' => $accion
    );

    $auditorias = new Auditorias();
    $auditorias->insertAuditoria($data);
}//Fin de la funcion
