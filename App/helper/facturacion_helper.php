<?php

use App\Models\UbicacionesModel;
use App\Librerias\Indicador;

/**Obtener un nuevo documento */
function documento($tipo_documento, $numero_documento)
{
    $nombreVista = 'facturacion/elementos/documento';

    $tiposDocumentosModel = model('tiposDocumentos');
    $uniMedidaModel = model('unidadesMedida');
    $tiposReferenciaModel = model('tiposReferencia');
    $tiposImpuestoModel = model('tiposImpuesto');
    $tarifaImpuestoModel = model('tarifaImpuesto');
    $tiposExoneracionModel = model('tiposExoneracion');
    $condicionesVentaModel = model('condicionesVenta');

    $impuestos = array(
        'impuestos' => $tiposImpuestoModel->obtener('activos'),
        'tarifas' => $tarifaImpuestoModel->obtener('activos'),
        'exoneraciones' => $tiposExoneracionModel->obtener('activos'),
    );

    $modalLinea = array(
        'data_impuesto' => $impuestos
    );

    $modalCierreDocumento = array(
        'numero_documento' => $numero_documento,
        'tipo_documento' => $tipo_documento,
    );

    $data_referencias = array(
        'tipos_documentos' => $tiposDocumentosModel->obtener('referencias'),
        'codigos_referencia' => $tiposReferenciaModel->obtener('all'),
    );

    $empresa = getEmpresa();

    $tiposDocumentosModel = model('tiposDocumentos');

    $dataView = array(
        'id_tipo_documento' => $tipo_documento,
        'tipos_documentos' => $tiposDocumentosModel->obtener('documentos'),
        'condiciones_venta' => $condicionesVentaModel->obtener('all'),
        'empresa' => (object) $empresa,
        'unidades_medida' => $uniMedidaModel->getAll(),
        'numero_documento' => $numero_documento,
        'modalCierreDocumento' => $modalCierreDocumento,
        'data_referencias' => $data_referencias ?? null,
        'modalLinea' => $modalLinea,
    );

    return view($nombreVista, $dataView);
}

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
        return getEnt('ivois.api.taxpayer.id');
    } else {
        return null;
    }
}

/**Obtener la informacion de facturacion para los clientes */
function getInfoClientes()
{
    $ubicacionesModel = new UbicacionesModel();

    $tipoIdentificacionModel = model('tipoIdentificacion');
    $codigosPaisesModel = model('codigosPaises');

    $modalCliente = array(
        'buscar_cliente' => array(
            'dataForm' => array(
                'datos_personales' => array(
                    'identificaciones' => $tipoIdentificacionModel->getAll(),
                    'codigos' => $codigosPaisesModel->getAll(),
                ),

                'dataProvincias' => array(
                    'provincias' => $ubicacionesModel->provincias(),
                ),
            )
        ),
    );
    return $modalCliente;
}

/**Obtener la informacion para los documentos de walmart */
function getInfoWalmart()
{
    $tiendasModel = model('tiendas');
    $numerosProveedorModel = model('departamentos');

    $dataTiendas = array(
        'tiendas' => $tiendasModel->obtener('activos'),
    );

    $data = array(
        'numerosProveedor' => $numerosProveedorModel->getAll(),
        'dataTiendas' => $dataTiendas,
    );

    return $data;
}

function obtenerInidicadores($tipo = 'CRC')
{
    if ($tipo) {
        $indicadores = new Indicador();
        $tipo_cambio = $indicadores->obtenerIndicadorEconomico($tipo);

        $data = array(
            'tipo_cambio' => $tipo_cambio,
        );

        return $data;
    } else {
        $indicadores = new Indicador();
        $compra = $indicadores->obtenerIndicadorEconomico('CRC');
        $venta = $indicadores->obtenerIndicadorEconomico('USD');

        $data = array(
            'compra' => $compra,
            'venta' => $venta,
        );

        return $data;
    }
}
