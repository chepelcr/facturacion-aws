<?php

function getDocumentName($tipo_documento)
{
    switch ($tipo_documento) {
        case '01':
            echo 'Factura Electrónica';
            break;

        case '02':
            echo 'Nota de Débito Electrónica';
            break;

        case '03':
            echo 'Nota de Crédito Electrónica';
            break;

        case '04':
            echo 'Tiquete Electrónico';
            break;

        default:
            echo 'Documento electrónico';
            break;
    }
}

/**
 * Obtener la informacion de la empresa
 */
function getTaxpayerId()
{
    if (is_login()) {
        return getSession('id_empresa');
    } else {
        return null;
    }
}
