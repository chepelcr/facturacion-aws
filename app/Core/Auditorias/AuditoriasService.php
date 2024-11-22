<?php

namespace Core\Auditorias;

/**
 * Servicio que se encarga de manejar las auditorias
 * 
 * @package Core\Auditorias
 * @version 1.0
 * @author jcampos
 */
class AuditoriasService {

    /**
     * Obtener la vista de las auditorias
     */
    public function getAuditoriasView() {
        $auditoriaModel = new AuditoriaModel();

        $dataView = array(
            'auditorias' => $auditoriaModel->getAll(),
        );

        return view('seguridad/auditoria/listado', $dataView);
    }

    public function getErroresView() {
        $erroresModel = new ErroresModel();

        $errores = $erroresModel->getAll();

        $dataView = array(
            'errores' => $errores,
        );

        return view('seguridad/auditoria/errores', $dataView);
    }
}
