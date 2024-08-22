<?php

namespace App\Services;

use App\Librerias\Hacienda;

use App\Api\DetailsApi;
use App\Api\CustomersApi;
use App\Api\DataServiceApi;
use App\Api\DocumentsApi;
use App\Api\LocationsApi;
use App\Api\TaxpayersApi;
use App\Librerias\Indicador;
use App\Librerias\Reportes;

/**
 * Servicio para la gestion de documentos
 */
class DocumentosService
{
    public function buscarCliente($idCliente)
    {
        $customersApi = new CustomersApi(getTaxpayerId());

        return $customersApi->getCustomerById($idCliente);
    }

    /**
     * Validar los documentos que se encuentran en proceso
     */
    public function validarDocumentos()
    {
        $hacienda = new Hacienda();

        $documentoModel = model('document');
        $documentos = $documentoModel->obtener('proceso');

        $validados = 'inicio';
        $status = 'success';
        $htmlStatusCode = '200';

        foreach ($documentos as $document) {
            $hacienda->setClave($document->documentKey);
            $validar = json_decode($hacienda->validar());

            if (isset($validar['xml']['ind-estado'])) {
                $fecha_gmt = date('Y-m-d\TH:i:s');

                if ($validar['xml']['ind-estado'] != "procesando") {
                    $json = json_decode(json_encode(simplexml_load_string(base64_decode($validar['xml']['respuesta-xml']))));

                    $data_validado = array(
                        'valido_atv' => $json->Mensaje,
                        'detalle_atv' => $json->DetalleMensaje,
                        'fecha_valido' => $fecha_gmt,
                    );

                    $documentosModel = model('document');
                    $documentosModel->update($data_validado, $document->idDocumento);

                    $hacienda->enviar_documento($document->idDocumento);

                    if ($validados != 'procesando') {
                        $validados = 'validado';
                    }
                } else {
                    $validados = 'procesando';
                    $status = 'warning';

                    //Colocar el codigo de html
                    $htmlStatusCode = '202';
                }
            } //Fin de validacion de estado
        } //Fin del ciclo de documentos

        return json_encode(array(
            'validados' => $validados,
            'status' => $status,
            'htmlStatusCode' => $htmlStatusCode,
        ));
    } //Fin del metodo

    public function recibirRespuestaHacienda($documentKey, $respuesta)
    {
        //Decodificar la documentKey
        $documentKey = base64_decode($documentKey);

        $hacienda = new Hacienda($documentKey);

        $hacienda->validar_respuesta($respuesta);
    }

    /**
     * Enviar un document a hacienda
     * @param int $idDocumento Id del document
     * @return array Retorna el resultado del envio
     */
    public function enviarDocumento($idDocumento, $email = null)
    {
        $documentsApi = new DocumentsApi(getTaxpayerId());

        if ($email) {
            $result = $documentsApi->sendDocumentNotification($idDocumento, $email);
        } else {
            $result = $documentsApi->resendDocumentNotification($idDocumento);
        }

        if (!isset($result->error)) {
            $data = array(
                'status' => '200',
                'mensaje' => 'Notificación enviada correctamente',
            );
        } else {
            $data = array(
                'error' => 'Error al enviar notificación',
                'status' => '500',
            );
        }

        return $data;
    }

    private function filterDocumentsByDate($documents, $startDate, $endDate)
    {
        $documentos = array();

        foreach ($documents as $document) {
            $fecha_emision = strtotime($document->saleDate);

            if ($fecha_emision >= strtotime($startDate) && $fecha_emision <= strtotime($endDate)) {
                $documentos[] = $document;
            }
        }

        return $documentos;
    }

    public function cargarDocumentos($documentTypeId, $issuerFilter, $reportType = null, $startDate = '', $endDate = '')
    {
        $documentsApi = new DocumentsApi(getTaxpayerId());

        $filter = '';

        /*if($documentTypeId != 'all'){
            $filter .= 'documentType:' . $documentTypeId;
        }

        //$model->documentos($tipo_documento);

        if($issuerFilter == 'emitidos') {
            $filter .= ',issuerIdNumber:' . getTaxpayerId();
        } elseif($issuerFilter == 'recibidos') {
            $filter .= ',receiverIdNumber:' . getTaxpayerId();
        }*/

        switch ($reportType) {
            case 'all':
                $startDate = null;
                $endDate = null;
                break;

                //Documentos que se hayan emitidos desde hace 7 dias
            case 'semanal':
                //Hace 7 dias
                $startDate = strtotime('-7 days');
                $endDate = strtotime(date('Y-m-d'));

                break;

            case 'semana_anterior':
                $startDate = strtotime('last monday', strtotime('last week'));
                $endDate = strtotime('last sunday', strtotime('last week'));

                break;

            case 'semana':
                $weekDay = date('w');

                //Si el dia es lunes
                if ($weekDay == 1) {
                    $startDate = strtotime(date('Y-m-d'));
                } else {
                    $startDate = strtotime('last monday');
                }

                $endDate = strtotime(date('Y-m-d'));
                break;

                //Obtener los documentos del mes actual
            case 'mes':
                $startDate = strtotime(date('Y-m-01'));
                $endDate = strtotime(date('Y-m-t'));

                break;

            case 'mes_anterior':
                $startDate = strtotime('first day of last month');
                $endDate = strtotime('last day of last month');
                break;

            case 'busqueda':
                $startDate = strtotime($startDate);
                $endDate = strtotime($endDate);
                break;

            default:
                $startDate = strtotime(date('Y-m-d'));
                $endDate = strtotime(date('Y-m-d'));
                break;
        }

        $documentos = $documentsApi->getDocumentsByFilter($filter);

        if (isset($documentos->error)) {
            return $documentos;
        }

        if ($startDate && $endDate) {
            $documentos = $this->filterDocumentsByDate($documentos, $startDate, $endDate);
        }

        $dataServiceApi = new DataServiceApi();
        $documentTypes = $dataServiceApi->getDocumentTypesByCountry(getCountryCode());

        $dataView = array(
            'documentos' => $documentos,
            'reportType' => $reportType,
            'documentTypes' => $documentTypes,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'documentTypeId' => $documentTypeId,
        );

        return view('facturacion/table/documentos', $dataView);
    }

    public function validarDocumento($idDocumento)
    {
        $model = model('document');

        $document = $model->obtener($idDocumento);

        if ($document) {
            $hacienda = new Hacienda($document->documentKey);

            $validar = json_decode($hacienda->validar());

            if (isset($validar['xml']['ind-estado'])) {
                $fecha_gmt = date('Y-m-d\TH:i:s', strtotime('-6 hours'));

                if ($validar['xml']['ind-estado'] != "procesando") {
                    $json = json_decode(json_encode(simplexml_load_string(base64_decode($validar['xml']['respuesta-xml']))));

                    $data_validado = array(
                        'valido_atv' => $json->Mensaje,
                        'detalle_atv' => $json->DetalleMensaje,
                        'fecha_valido' => $fecha_gmt,
                    );

                    $documentosModel = model('document');
                    $documentosModel->update($data_validado, $idDocumento);

                    $correo_enviado = $hacienda->enviar_documento($idDocumento);

                    return json_encode(array(
                        'documentKey' => $idDocumento,
                        "validar_estado" => $validar['xml']['ind-estado'],
                        "mensaje" => $json->Mensaje,
                        "validar_mensaje" => $json->DetalleMensaje,
                        'estado' => 'success',
                        'correo_enviado' => $correo_enviado,
                    ));
                } else {
                    return json_encode(array(
                        'documentKey' => $idDocumento,
                        "validar_estado" => $validar['xml']['ind-estado'],
                        "mensaje" => "2",
                        "validar_mensaje" => "Procesando document",
                        'estado' => 'warning',
                        'correo_enviado' => false,
                    ));
                }
            } else {
                return json_encode(array(
                    'documentKey' => $idDocumento,
                    "validar_estado" => 'procesando',
                    "mensaje" => "2",
                    "validar_mensaje" => "Procesando document",
                    'estado' => 'warning',
                    'correo_enviado' => false,
                ));
            }
        }
    }

    public function enviarHacienda($idDocumento)
    {
        $documentoModel = model('document');
        $document = $documentoModel->obtener($idDocumento);

        if ($document) {
            $hacienda = new Hacienda($document->documentKey);

            $enviar = json_decode($hacienda->enviar());

            if ($enviar->status >= 200 && $enviar->status < 300) {
                //Obtener la fecha en gmt-6
                $fecha_gmt = date('Y-m-d\TH:i:s', strtotime('-6 hours'));

                $data_envio = array(
                    'envio_atv' => 1,
                    'fecha_envio' => $fecha_gmt,
                );

                $documentosModel = model('document');
                $documentosModel->update($data_envio, $document->id_documento);

                sleep(4);

                $validar = json_decode($hacienda->validar(), true);

                if (isset($validar['xml']['ind-estado'])) {
                    if ($validar['xml']['ind-estado'] != "procesando") {
                        $json = json_decode(json_encode(simplexml_load_string(base64_decode($validar['xml']['respuesta-xml']))));

                        $data_validado = array(
                            'valido_atv' => $json->Mensaje,
                            'fecha_valido' => $fecha_gmt,
                            'detalle_atv' => $json->DetalleMensaje,
                        );

                        $documentosModel = model('document');
                        $documentosModel->update($data_validado, $document->id_documento);

                        $correo_enviado = $hacienda->enviar_documento($document->id_documento);

                        return json_encode(array(
                            'documentKey' => $document->id_documento,
                            "enviar" => $enviar->status,
                            "validar_estado" => $validar['xml']['ind-estado'],
                            "mensaje" => $json->Mensaje,
                            "validar_mensaje" => $json->DetalleMensaje,
                            "correo_enviado" => $correo_enviado,
                            'estado' => 'success',
                        ));
                    } else {
                        return json_encode(array(
                            'documentKey' => $document->id_documento,
                            "enviar" => $enviar->status,
                            "validar_estado" => $validar['xml']['ind-estado'],
                            "mensaje" => "Procesando",
                            "validar_mensaje" => "El document se encuentra en proceso de validación",
                            "correo_enviado" => false,
                            'estado' => 'warning',
                        ));
                    }
                } else {
                    return json_encode(array(
                        'documentKey' => $document->id_documento,
                        "enviar" => $enviar->status,
                        "validar_estado" => 'procesando',
                        "mensaje" => "Procesando",
                        "validar_mensaje" => 'El document se encuentra en proceso de validación',
                        "correo_enviado" => false,
                        'estado' => 'error',
                    ));
                }
            } else {
                return json_encode(array(
                    'documentKey' => $document->id_documento,
                    "enviar" => $enviar->status,
                    "validar_estado" => "",
                    "mensaje" => "Error",
                    "error" => 'Se ha generado un error al enviar la factura al Ministerio de Hacienda',
                    "correo_enviado" => false,
                    'estado' => 'error',
                ));
            }
        }
    }

    /**
     * Obtener los productos de un contribuyente
     */
    public function getProductos()
    {
        $detailsApi = new DetailsApi(getTaxpayerId());

        $productos = $detailsApi->getProductsByTaxpayerId();

        $dataView = array(
            'productos' => $productos,
        );

        return view('facturacion/table/productos', $dataView);
    }

    /**
     * Obtener los clientes de un contribuyente
     */
    public function getCustomers($documentTypeCode)
    {
        $customersApi = new CustomersApi(getTaxpayerId());

        //Si el código del tipo de document es 01 o 08 se obtienen solo los clientes nacionales
        if ($documentTypeCode == '01' || $documentTypeCode == '08') {
            $clientes = $customersApi->getNationalCustomersByTaxpayerId();
        } elseif ($documentTypeCode == '09') {
            //Si es  09 se obtienen solo los clientes extranjeros
            $clientes = $customersApi->getForeignCustomersByTaxpayerId();
        } else {
            $clientes = $customersApi->getCustomersByTaxpayerId();
        }

        if (isset($clientes->error)) {
            return $clientes;
        } else {
            $dataView = array(
                'clientes' => $clientes,
            );

            return view('facturacion/table/clientes', $dataView);
        }
    }

    /** Guardar un  document electronico (old)
     * @deprecated
     * @return string
     */
    private function old_guardar()
    {
        if (is_login()) {
            $cantidad_lineas = 0;

            $lineas = post('linea');

            $numero_lineas = $lineas['numero_linea'];
            $codigo_cabys = $lineas['codigo'];

            foreach ($numero_lineas as $linea) {
                $linea = (int) $linea - 1;

                //var_dump($linea);

                $codigo = $codigo_cabys[$linea];

                //Si el codigo no esta vacio
                if ($codigo != "") {
                    $cantidad_lineas++;
                } //Fin de validacion de codigo
            } //Fin del ciclo para recorrer las lineas

            /**Validar si el document tiene detalles */
            if ($cantidad_lineas == 0) {
                return json_encode(array(
                    "error" => "No se puede emitir un comprobante sin detalle",
                    'tipo' => 'detalles',
                    "estado" => "error"
                ));
            } //Fin de validacion de detalles

            $documentTypeId = post('documentTypeId');

            $moneda = post('moneda');
            $tipo_cambio = post('tipo_cambio');

            if (!$tipo_cambio) {
                $tipoCambioModel = new TipoCambioModel();
                $tipo_cambio = $tipoCambioModel->obtener($moneda);
            }

            //Efectivo
            $efectivo = post('efectivo');

            //Tarjeta
            $tarjeta = post('tarjeta');

            //Transferencia
            $transferencia = post('transferencia');

            //Otros
            $otros = post('otros');

            //Validar medio de pago
            if (!$efectivo && !$tarjeta && !$transferencia && !$otros)
                return json_encode(array(
                    'error' => 'Debe seleccionar al menos un medio de pago',
                    'estado' => 'error'
                ));

            else {
                if ($efectivo)
                    $medio_pago = $efectivo;
                else
                    if ($tarjeta)
                    $medio_pago = $tarjeta;
                else
                        if ($transferencia)
                    $medio_pago = $transferencia;
                else
                    $medio_pago = $otros;
            }

            $condicion_venta = post('condicion_venta');
            $dias = 0;

            if ($condicion_venta == "02") {
                $dias = 30;
            }

            $consecutivosModel = new ConsecutivosModel();
            $consecutivo_object = $consecutivosModel->obtener_consecutivo($documentTypeId, getEnt('factura.ambiente'));

            $id_factura = $consecutivo_object->consecutivo;
            $factura = str_pad($id_factura, 10, "0", STR_PAD_LEFT);

            $sucursal = getent('factura.sucursal');
            $pv = getent('factura.punto_venta');

            //Rellenar con ceros 000 la sucursal
            $sucursal = str_pad($sucursal, 3, "0", STR_PAD_LEFT);

            //Rellenar con ceros 00000 el punto de venta
            $pv = str_pad($pv, 5, "0", STR_PAD_LEFT);

            $tipoDocumento = $documentTypeId;

            $consecutivo = $sucursal . $pv . $tipoDocumento . $factura;

            $notas = post('notas');

            $empresasModel = new EmpresasModel();
            $emisor = $empresasModel->getById(getSession('id_empresa'));

            $cod = $emisor->codigo_telefono;
            $ced = $emisor->identificacion;
            $cedulaEmisor = str_pad($ced, 12, "0", STR_PAD_LEFT);
            $situacion = "1";

            $codigoSeguridad = substr(str_shuffle("0123456789"), 0, 8);

            $documentKey = $cod . date('d') . date('m') . date('y') . $cedulaEmisor . $consecutivo . $situacion . $codigoSeguridad;

            $id_cliente = post('identificacion-cliente');
            $id_cliente = desformatear_cedula($id_cliente);

            if ($documentTypeId != '04') {
                $clientesModel = new ClientesModel();
                $receptor = $clientesModel->getByIdentificacion($id_cliente);
            }

            //Validar el tipo de document
            switch ($documentTypeId) {
                    /**Factura electronica */
                case '01':
                    //Validar si el cliente existe en la tabla de clientes
                    if (!$receptor) {
                        return json_encode(array(
                            'error' => 'Debe indicar un cliente valido',
                            'tipo' => 'receptor',
                            'estado' => 'error'
                        ));
                    }

                    /**Validar si el cliente de la factura es walmart */
                    if ($receptor->nombre_comercial == 'Walmart') {
                        $numero_orden = post('numero_orden');
                        $numero_vendor = post('numero_vendor');
                        $enviar_gln = post('enviar_gln');

                        if (!$numero_orden || !$numero_vendor || !$enviar_gln) {
                            return json_encode(array(
                                'error' => 'Faltan datos para enviar a Walmart',
                                'tipo' => 'walmart',
                                'estado' => 'error'
                            ));
                        }

                        //Si el numero de orden no tiene 10 caracteres
                        if (strlen(post('numero_orden')) != 10)
                            return json_encode(array(
                                'error' => 'El numero de orden debe tener 10 caracteres',
                                'campo' => 'numero_orden',
                                'estado' => 'error'
                            ));

                        //Rellenar con 0 hasta 9 numero_vendor
                        $numero_vendor = str_pad(post('numero_vendor'), 9, "0", STR_PAD_LEFT);
                    } //Fin de la validacion de walmart

                    $stringXML = '<?xml version="1.0" encoding="utf-8"?>
                <FacturaElectronica 
                    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
                    xmlns:xsd="http://www.w3.org/2001/XMLSchema"
                    xmlns="https://cdn.comprobanteselectronicos.go.cr/xml-schemas/v4.3/facturaElectronica">';
                    break;

                    /**Nota de debito electronica */
                case '02':
                    $cantidad_referencias = 0;

                    if (isset($_POST['referencia_clave'])) {
                        foreach ($_POST['referencia_clave'] as $key => $value) {
                            if ($_POST['referencia_clave'][$key] != '') {
                                $cantidad_referencias++;
                            }
                        }
                    }

                    if ($cantidad_referencias == 0) {
                        return json_encode(array(
                            'error' => 'Debe ingresar al menos una referencia',
                            'estado' => 'error'
                        ));
                    }

                    $stringXML = '<?xml version="1.0" encoding="utf-8"?>
                <NotaDebitoElectronica
                    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                    xmlns:xsd="http://www.w3.org/2001/XMLSchema"
                    xmlns="https://cdn.comprobanteselectronicos.go.cr/xml-schemas/v4.3/notaDebitoElectronica">';
                    break;

                    /**Nota de credito electronica */
                case '03':
                    $cantidad_referencias = 0;

                    if (isset($_POST['referencia_clave'])) {
                        foreach ($_POST['referencia_clave'] as $key => $value) {
                            if ($_POST['referencia_clave'][$key] != '') {
                                $cantidad_referencias++;
                            }
                        }
                    }

                    if ($cantidad_referencias == 0) {
                        return json_encode(array(
                            'error' => 'Debe ingresar al menos una referencia',
                            'estado' => 'error'
                        ));
                    }

                    $stringXML = '<?xml version="1.0" encoding="utf-8"?>
                <NotaCreditoElectronica
                    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                    xmlns:xsd="http://www.w3.org/2001/XMLSchema"
                    xmlns="https://cdn.comprobanteselectronicos.go.cr/xml-schemas/v4.3/notaCreditoElectronica">';
                    break;

                    /**Tiquete electronico */
                case '04':
                    $stringXML = '<?xml version="1.0" encoding="utf-8"?>
                <TiqueteElectronico
                    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                    xmlns:xsd="http://www.w3.org/2001/XMLSchema"
                    xmlns="https://cdn.comprobanteselectronicos.go.cr/xml-schemas/v4.3/tiqueteElectronico">';

                    break;

                    /**Factura de compras */
                case '08':
                    $stringXML = '<?xml version="1.0" encoding="utf-8"?>
                <FacturaCompra
                    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                    xmlns:xsd="http://www.w3.org/2001/XMLSchema"
                    xmlns="https://cdn.comprobanteselectronicos.go.cr/xml-schemas/v4.3/facturaCompra">';

                    $empresa = $emisor;

                    $emisor = $receptor;
                    $receptor = $empresa;

                    break;

                default:
                    return json_encode(array(
                        'error' => 'Implementando document',
                        'estado' => 'error'
                    ));
            }

            $stringXML .= '<Clave>' . $documentKey . '</Clave>
            <CodigoActividad>' . $emisor->cod_actividad . '</CodigoActividad>
            <NumeroConsecutivo>' . $consecutivo . '</NumeroConsecutivo>
            <FechaEmision>' . date("c") . '</FechaEmision>
            <Emisor>
                <Nombre>' . $emisor->razon . '</Nombre>
                <Identificacion>
                    <Tipo>' . $emisor->id_tipo_identificacion . '</Tipo>
                    <Numero>' . $emisor->identificacion . '</Numero>
                </Identificacion>
                <NombreComercial>' . $emisor->nombre_comercial . '</NombreComercial>
                <Ubicacion>
                    <Provincia>' . $emisor->cod_provincia . '</Provincia>
                    <Canton>' . str_pad($emisor->cod_canton, 2, "0", STR_PAD_LEFT) . '</Canton>
                    <Distrito>' . str_pad($emisor->cod_distrito, 2, "0", STR_PAD_LEFT) . '</Distrito>
                    <Barrio>' . str_pad($emisor->cod_barrio, 2, "0", STR_PAD_LEFT) . '</Barrio>
                    <OtrasSenas>' . $emisor->otras_senas . '</OtrasSenas>
                </Ubicacion>
                <Telefono>
                    <CodigoPais>' . $emisor->codigo_telefono . '</CodigoPais>
                    <NumTelefono>' . $emisor->telefono . '</NumTelefono>
                </Telefono>
                <CorreoElectronico>' . $emisor->correo . '</CorreoElectronico>
            </Emisor>';

            /**Si el document no es un tiquete electronico, no agregar la informacion del cliente al archivo XML */
            if ($documentTypeId != '04' && $receptor) {

                $stringXML .= '<Receptor>
                <Nombre>' . $receptor->razon . '</Nombre>
                <Identificacion>
                    <Tipo>' . $receptor->id_tipo_identificacion . '</Tipo>
                    <Numero>' . $receptor->identificacion . '</Numero>
                </Identificacion>
                <NombreComercial>' . $receptor->nombre_comercial . '</NombreComercial>
                <Ubicacion>
                    <Provincia>' . $receptor->cod_provincia . '</Provincia>
                    <Canton>' . str_pad($receptor->cod_canton, 2, "0", STR_PAD_LEFT) . '</Canton>
                    <Distrito>' . str_pad($receptor->cod_distrito, 2, "0", STR_PAD_LEFT) . '</Distrito>
                    <Barrio>' . str_pad($receptor->cod_barrio, 2, "0", STR_PAD_LEFT) . '</Barrio>
                    <OtrasSenas>' . $receptor->otras_senas . '</OtrasSenas>
                </Ubicacion>
                <Telefono>
                    <CodigoPais>' . $receptor->codigo_telefono . '</CodigoPais>
                    <NumTelefono>' . $receptor->telefono . '</NumTelefono>
                </Telefono>
                <CorreoElectronico>' . $receptor->correo . '</CorreoElectronico>
            </Receptor>';
            }

            $stringXML .= '
                <CondicionVenta>' . $condicion_venta . '</CondicionVenta>
                <PlazoCredito>' . $dias . '</PlazoCredito>
                <MedioPago>' . $medio_pago . '</MedioPago>
                <DetalleServicio>';

            $totalServGravados = 0;
            $totalServExentos = 0;
            $totalServExonerado = 0;
            $totalMercanciasGravadas = 0;
            $totalMercanciasExentas = 0;
            $totalMercExonerada = 0;
            $totalGravado = 0;
            $totalExento = 0;
            $totalExonerado = 0;
            $totalVenta = 0;
            $totalDescuentos = 0;
            $totalVentaNeta = 0;
            $totalImpuesto = 0;
            $totalComprobante = 0;



            $codigo_venta = $lineas['codigo_venta'];


            $cantidad = $lineas['cantidad'];

            //var_dump($cantidad);

            $unidad = $lineas['unidad'];

            //var_dump($unidad);

            $detalle = $lineas['detalle'];

            //var_dump($detalle);

            $precio_unitario = $lineas['precio_unidad'];

            //var_dump($precio_unitario);

            $monto_total = $lineas['monto_total'];

            //var_dump($monto_total);

            $descuentos = post('descuento');

            $subtotal = $lineas['sub_total'];

            $montos_descuento = $descuentos['monto_descuento'];

            //var_dump($montos_descuento);

            $motivos_descuento = $descuentos['motivo_descuento'];

            //var_dump($motivos_descuento);

            $impuestos = post('impuesto');

            $codigos_impuesto = $impuestos['codigo_impuesto'];
            $codigos_tarifa = $impuestos['codigo_tarifa'];
            $tarifas = $impuestos['tarifa'];
            $montos_impuesto = $impuestos['monto_impuesto'];
            $tipos_exoneracion = $impuestos['exoneracion'];
            $numeros_exoneracion = $impuestos['numero_exoneracion'];
            $nombres_institucion = $impuestos['nombre_institucion'];
            $fechas_exoneracion = $impuestos['fecha_exoneracion'];
            $porcentajes_exoneracion = $impuestos['porcentaje_exoneracion'];
            $montos_exoneracion = $impuestos['monto_exoneracion'];

            $impuesto_neto = $lineas['impuesto_neto'];

            //var_dump($impuesto_neto);

            $total_linea = $lineas['total_linea'];

            $lineas_detalle = array();

            $numero_lineas_descuento = $descuentos['numero_linea'];
            $numero_lineas_impuesto = $impuestos['numero_linea'];

            foreach ($numero_lineas as $linea) {
                $linea = (int) $linea - 1;

                //var_dump($linea);

                $codigo = $codigo_cabys[$linea];

                //Si el codigo no esta vacio
                if ($codigo != "") {
                    $codigo_venta_linea = $codigo_venta[$linea];
                    $cantidad_linea = $cantidad[$linea];

                    $unidad_linea = $unidad[$linea];
                    $detalle_linea = $detalle[$linea];

                    $precio_unitario_linea = $precio_unitario[$linea];
                    $monto_total_linea = $monto_total[$linea];
                    $subtotal_linea = $subtotal[$linea];
                    $impuesto_neto_linea = $impuesto_neto[$linea];
                    $total_linea_linea = $total_linea[$linea];

                    $cantidad_lineas++;

                    $dataLinea = array(
                        'codigo' => $codigo,
                        'codigo_venta' => $codigo_venta_linea,
                        'cantidad' => $cantidad_linea,
                        'unidad' => $unidad_linea,
                        'detalle' => $detalle_linea,
                        'precio_unidad' => $precio_unitario_linea,
                        'monto_total' => $monto_total_linea,
                        'subtotal' => $subtotal_linea,
                        'linea' => $linea + 1,
                        'descuentos' => array(),
                        'impuestos' => array(),
                        'impuesto_neto' => $impuesto_neto_linea,
                        'total_linea' => $total_linea_linea,
                        'exonerada' => false,
                        'exenta' => false,
                    );

                    //Agregar informacion al string XML
                    $stringXML .= '
                        <LineaDetalle>
                            <NumeroLinea>' . $linea + 1 . '</NumeroLinea>
                            <Codigo>' . $codigo . '</Codigo>
                            <CodigoComercial>
                                <Tipo>01</Tipo>
                                <Codigo>' . $codigo_venta_linea . '</Codigo>
                            </CodigoComercial>
                            <Cantidad>' . $cantidad_linea . '</Cantidad>
                            <UnidadMedida>' . $unidad_linea . '</UnidadMedida>
                            <Detalle>' . $detalle_linea . '</Detalle>
                            <PrecioUnitario>' . $precio_unitario_linea . '</PrecioUnitario>
                            <MontoTotal>' . $monto_total_linea . '</MontoTotal>';

                    /*$stringXML .= '<Descuento>
                                <MontoDescuento>' . $_POST['monto_descuento'][$key] . '</MontoDescuento>
                                <NaturalezaDescuento>' . $_POST['motivo_descuento'][$key] . '</NaturalezaDescuento>
                            </Descuento>';*/

                    //Recorrer los descuentos
                    foreach ($numero_lineas_descuento as $linea_descuento => $numero_linea) {
                        $numero_linea = (int) $numero_linea - 1;

                        //Si el mumero de linea del descuento es igual al numero de linea del detalle
                        if ($numero_linea == $linea) {
                            $descuento = $montos_descuento[$linea_descuento];
                            $motivo = $motivos_descuento[$linea_descuento];

                            //Si el descuento es mayor a cero
                            if ($descuento > 0) {
                                //Si el motivo esta vacio
                                if ($motivo == "") {
                                    $motivo = "Descuento de sistema";
                                } //Fin de validacion del motivo

                                $dataLinea['descuentos'][] = array(
                                    'monto' => $descuento,
                                    'motivo' => $motivo
                                );

                                //Agregar el descuento al XML
                                $stringXML .= '<Descuento>
                                        <MontoDescuento>' . $descuento . '</MontoDescuento>
                                        <NaturalezaDescuento>' . $motivo . '</NaturalezaDescuento>
                                    </Descuento>';

                                //Sumar el descuento al total de descuentos
                                $totalDescuentos += $descuento;
                            } //Fin de validacion del descuento
                        } //Fin de validacion
                    } //Fin del ciclo para recorrer los descuentos

                    $stringXML .= '
                            <SubTotal>' . $subtotal_linea . '</SubTotal>';

                    //Agregar el subtotal al dataLinea
                    $dataLinea['subtotal'] = $subtotal_linea;

                    //Recorrer los impuestos
                    foreach ($numero_lineas_impuesto as $linea_impuesto => $numero_linea) {
                        $numero_linea = (int) $numero_linea - 1;

                        //Si el numero de linea del impuesto es igual al numero de linea del detalle
                        if ($numero_linea == $linea) {
                            $codigo_impuesto = $codigos_impuesto[$linea_impuesto];

                            if ($codigo_impuesto != "NA" && $codigo_impuesto != "") {
                                $monto_impuesto = $montos_impuesto[$linea_impuesto];
                                $codigo_tarifa = $codigos_tarifa[$linea_impuesto];

                                if ($codigo_tarifa == "NA") {
                                    $codigo_tarifa = "";
                                }

                                $tarifa = $tarifas[$linea_impuesto];
                                $monto_impuesto = $montos_impuesto[$linea_impuesto];

                                //Agregar el impuesto al XML
                                $stringXML .= '
                                    <Impuesto>
                                        <Codigo>' . $codigo_impuesto . '</Codigo>
                                        <CodigoTarifa>' . $codigo_tarifa . '</CodigoTarifa>
                                        <Tarifa>' . $tarifa . '</Tarifa>
                                        <Monto>' . $monto_impuesto . '</Monto>';

                                //Si la tarifa es 0
                                if ($tarifa == 0) {
                                    $dataLinea['exenta'] = true;
                                }

                                $tipo_exoneracion = $tipos_exoneracion[$linea_impuesto];

                                //Si el monto de exoneracion es mayor a cero
                                if ($tipo_exoneracion != 'NA') {
                                    $monto_exoneracion = $montos_exoneracion[$linea_impuesto];
                                    $numero_exoneracion = $numeros_exoneracion[$linea_impuesto];
                                    $fecha_exoneracion = $fechas_exoneracion[$linea_impuesto];
                                    $porcentaje_exoneracion = $porcentajes_exoneracion[$linea_impuesto];
                                    $nombre_institucion = $nombres_institucion[$linea_impuesto];

                                    $stringXML .= '
                                        <Exoneracion>
                                            <TipoDocumento>' . $tipo_exoneracion . '</TipoDocumento>
                                            <NumeroDocumento>' . $numero_exoneracion . '</NumeroDocumento>
                                            <NombreInstitucion>' . $nombre_institucion . '</NombreInstitucion>
                                            <FechaEmision>' . date('Y-m-d', strtotime($fecha_exoneracion)) . 'T00:00:00-06:00' . '</FechaEmision>
                                            <PorcentajeExoneracion>' . $porcentaje_exoneracion . '</PorcentajeExoneracion>
                                            <MontoExoneracion>' . $monto_exoneracion . '</MontoExoneracion>
                                        </Exoneracion>';

                                    //Agregar el impuesto a un array
                                    $dataImpuesto = array(
                                        'codigo' => $codigo_impuesto,
                                        'monto' => $monto_impuesto,
                                        'codigo_tarifa' => $codigo_tarifa,
                                        'tarifa' => $tarifa,
                                        'tipo_documento_exoneracion' => $tipo_exoneracion,
                                        'numero_documento_exoneracion' => $numero_exoneracion,
                                        'nombre_institucion_exoneracion' => $nombre_institucion,
                                        'fecha_emision_exoneracion' => $fecha_exoneracion,
                                        'porcentaje_exoneracion' => $porcentaje_exoneracion,
                                        'monto_exoneracion' => $monto_exoneracion
                                    );

                                    $dataLinea['exonerada'] = true;
                                } //Fin de validacion del monto de exoneracion

                                else {
                                    //Agregar el impuesto a un array
                                    $dataImpuesto = array(
                                        'codigo' => $codigo_impuesto,
                                        'monto' => $monto_impuesto,
                                        'codigo_tarifa' => $codigo_tarifa,
                                        'tarifa' => $tarifa
                                    );
                                } //Fin de validacion del monto de exoneracion

                                $stringXML .= '
                                    </Impuesto>';

                                //Agregar el impuesto al array
                                $dataLinea['impuestos'][] = $dataImpuesto;
                            }
                        } //Fin de validacion de numero de linea
                    } //Fin del ciclo para recorrer los impuestos

                    /*<ImpuestoNeto>' . $_POST['monto_impuesto'][$key] . '</ImpuestoNeto>
                        <MontoTotalLinea>' . $_POST['total_linea'][$key] . '</MontoTotalLinea>
                    </LineaDetalle>' */

                    //Agregar el total de la linea al XML
                    $stringXML .= '
                        <ImpuestoNeto>' . $impuesto_neto_linea . '</ImpuestoNeto>
                        <MontoTotalLinea>' . $total_linea_linea . '</MontoTotalLinea>
                    </LineaDetalle>';

                    //Sumar el impuesto al total de impuestos
                    $totalImpuesto += $impuesto_neto_linea;

                    $linea_exonerada = $dataLinea['exonerada'];
                    $linea_exenta = $dataLinea['exenta'];

                    //Agregar la linea al array de linea
                    $lineas_detalle[] = $dataLinea;

                    //var_dump($dataLinea);

                    //Si la linea no es exenta
                    if (!$linea_exenta && !$linea_exonerada) {
                        //Acumular en gravados
                        if ($unidad_linea == "Sp" || $unidad_linea == "Spe" || $unidad_linea == "Cm") {
                            //todos los servicios son gravados
                            $totalServGravados += $monto_total_linea;
                        } else {
                            //todas las mercancias son gravados
                            $totalMercanciasGravadas += $monto_total_linea;
                        }

                        //Agregar el total al total gravado
                        $totalGravado += $monto_total_linea;
                    } else {
                        //Si la linea no es exonerada
                        if ($linea_exonerada) {
                            //Acumular en exentos
                            if ($unidad_linea == "Sp" || $unidad_linea == "Spe" || $unidad_linea == "Cm") {
                                //todos los servicios son exonerados
                                $totalServExonerado += $monto_total_linea;
                            } else {
                                //todas las mercancias son exoneradas
                                $totalMercExonerada += $monto_total_linea;
                            }

                            //Agregar el total al total exonerado
                            $totalExonerado += $monto_total_linea;
                        } else {
                            //Acumular en exentos
                            if ($unidad_linea == "Sp" || $unidad_linea == "Spe" || $unidad_linea == "Cm") {
                                //todos los servicios son exentos
                                $totalServExentos += $monto_total_linea;
                            } else {
                                //todas las mercancias son exentos
                                $totalMercanciasExentas += $monto_total_linea;
                            }

                            //Agregar el total al total exento
                            $totalExento += $monto_total_linea;
                        }
                    }

                    //Agregar el total al total general
                    $totalVenta += $monto_total_linea;

                    //Agregar el subtotal a la venta neta
                    $totalVentaNeta += $subtotal_linea;

                    //Agregar el total de la linea al total del comprobante
                    $totalComprobante += $total_linea_linea;
                } //Fin de validacion de codigo
            } //Fin del ciclo para recorrer las lineas

            /**Si el document no es un tiquete electronico y hay un receptor asignado,
             * agregar informacion del cliente en la factura */
            if ($documentTypeId != '04' && $receptor) {
                $data_factura = array(
                    "consecutivo" => $consecutivo,
                    "tipo_documento" => $documentTypeId,
                    "documentKey" => $documentKey,
                    "codigo_seguridad" => $codigoSeguridad,
                    "emisor_cedula" => $emisor->identificacion,
                    "emisor_nombre" => $emisor->razon,
                    "emisor_tipo" => $emisor->id_tipo_identificacion,
                    "emisor_comercial" => $emisor->nombre_comercial,
                    "emisor_id_provincia" => $emisor->cod_provincia,
                    "emisor_id_canton" => $emisor->cod_canton,
                    "emisor_id_distrito" => $emisor->cod_distrito,
                    "emisor_id_barrio" => $emisor->cod_barrio,
                    "emisor_otras_senas" => $emisor->otras_senas,
                    "emisor_cod" => $emisor->codigo_telefono,
                    "emisor_telefono" => $emisor->telefono,
                    "emisor_correo" => $emisor->correo,
                    "receptor_nombre" => $receptor->nombre_comercial,
                    "receptor_cedula" => $receptor->identificacion,
                    "receptor_tipo" => $receptor->id_tipo_identificacion,
                    "receptor_comercial" => $receptor->nombre_comercial,
                    "receptor_id_provincia" => $receptor->cod_provincia,
                    "receptor_id_canton" => $receptor->cod_canton,
                    "receptor_id_distrito" => $receptor->cod_distrito,
                    "receptor_id_barrio" => $receptor->cod_barrio,
                    "receptor_otras_senas" => $receptor->otras_senas,
                    "receptor_cod" => $receptor->codigo_telefono,
                    "receptor_telefono" => $receptor->telefono,
                    "receptor_correo" => $receptor->correo,
                    "condicion_venta" => $condicion_venta,
                    "plazo_credito" => $dias,
                    "medio_pago" => $medio_pago,
                    "moneda" => $moneda,
                    "tipo_cambio" => $tipo_cambio,
                    "servicios_gravados" => $totalServGravados,
                    "servicios_exentos" => $totalServExentos,
                    "servicios_exonerados" => $totalServExonerado,
                    "mercancias_gravadas" => $totalMercanciasGravadas,
                    "mercancias_exentas" => $totalMercanciasExentas,
                    "mercancias_exoneradas" => $totalMercExonerada,
                    "total_gravado" => $totalGravado,
                    "total_exento" => $totalExento,
                    "total_exonerado" => $totalExonerado,
                    "total_venta" => $totalVenta,
                    "total_descuentos" => $totalDescuentos,
                    "total_venta_neta" => $totalVentaNeta,
                    "total_impuestos" => $totalImpuesto,
                    "total_comprobante" => $totalComprobante,
                    "notas" => $notas,
                    "envio_atv" => 0,
                    "valido_atv" => 0,
                    "id_usuario" => getSession('id_usuario'),
                    "id_empresa" => getSession('id_empresa'),
                );
            } else {
                $data_factura = array(
                    "consecutivo" => $consecutivo,
                    "tipo_documento" => $documentTypeId,
                    "documentKey" => $documentKey,
                    "codigo_seguridad" => $codigoSeguridad,
                    "emisor_cedula" => $emisor->identificacion,
                    "emisor_nombre" => $emisor->razon,
                    "emisor_tipo" => $emisor->id_tipo_identificacion,
                    "emisor_comercial" => $emisor->nombre_comercial,
                    "emisor_id_provincia" => $emisor->cod_provincia,
                    "emisor_id_canton" => $emisor->cod_canton,
                    "emisor_id_distrito" => $emisor->cod_distrito,
                    "emisor_id_barrio" => $emisor->cod_barrio,
                    "emisor_otras_senas" => $emisor->otras_senas,
                    "emisor_cod" => $emisor->codigo_telefono,
                    "emisor_telefono" => $emisor->telefono,
                    "emisor_correo" => $emisor->correo,
                    "condicion_venta" => $condicion_venta,
                    "plazo_credito" => $dias,
                    "medio_pago" => $medio_pago,
                    "moneda" => $moneda,
                    "tipo_cambio" => $tipo_cambio,
                    "servicios_gravados" => $totalServGravados,
                    "servicios_exentos" => $totalServExentos,
                    "servicios_exonerados" => $totalServExonerado,
                    "mercancias_gravadas" => $totalMercanciasGravadas,
                    "mercancias_exentas" => $totalMercanciasExentas,
                    "mercancias_exoneradas" => $totalMercExonerada,
                    "total_gravado" => $totalGravado,
                    "total_exento" => $totalExento,
                    "total_exonerado" => $totalExonerado,
                    "total_venta" => $totalVenta,
                    "total_descuentos" => $totalDescuentos,
                    "total_venta_neta" => $totalVentaNeta,
                    "total_impuestos" => $totalImpuesto,
                    "total_comprobante" => $totalComprobante,
                    "notas" => $notas,
                    "envio_atv" => 0,
                    "valido_atv" => 0,
                    "id_usuario" => getSession('id_usuario'),
                    "id_empresa" => getSession('id_empresa'),
                );
            } //

            //var_dump($data_factura);

            $documentosModel = model('document');

            $id_documento = $documentosModel->insert($data_factura);

            if ($id_documento) {
                //Recorrer lineas de detalle
                foreach ($lineas_detalle as $linea) {
                    $linea = (object) $linea;

                    $data_detalle = array(
                        "id_documento" => $id_documento,
                        "linea" => $linea->linea,
                        "codigo" => $linea->codigo,
                        "codigo_venta" => $linea->codigo_venta,
                        "cantidad" => $linea->cantidad,
                        "unidad_medida" => $linea->unidad,
                        "detalle" => $linea->detalle,
                        "precio_unidad" => $linea->precio_unidad,
                        "monto_total" => $linea->monto_total,
                        "sub_total" => $linea->subtotal,
                        "impuesto_neto" => $linea->impuesto_neto,
                        "total_linea" => $linea->total_linea,
                    );

                    $detalleModel = model('documentoDetalles');
                    $id_detalle = $detalleModel->insert($data_detalle);

                    //Si no se pudo insertar el detalle, se elimina el document
                    if (!$id_detalle) {
                        $documentosModel = model('document');
                        $documentosModel->delete($id_documento);

                        return json_encode(array(
                            'estado' => 'error',
                            'error' => 'Error al insertar el detalle de la factura',
                        ));
                    } //Fin de validacion de insertar detalle

                    else {
                        $impuestos_linea = $linea->impuestos;
                        $descuentos_linea = $linea->descuentos;

                        //Si hay impuestos en la linea
                        if (count($impuestos_linea) > 0) {
                            foreach ($impuestos_linea as $impuesto) {
                                $impuesto["id_detalle"] = $id_detalle;

                                //Insertar impuesto
                                $impuestosModel = model('documentoImpuestos');
                                if (!$impuestosModel->insert($impuesto)) {
                                    $documentosModel = model('document');
                                    $documentosModel->delete($id_documento);

                                    return json_encode(array(
                                        'estado' => 'error',
                                        'error' => 'Error al insertar el impuesto de la factura',
                                    ));
                                }
                            } //Fin de foreach de impuestos
                        } //Fin de validacion de impuestos

                        //Si hay descuentos en la linea
                        if (count($descuentos_linea) > 0) {
                            foreach ($descuentos_linea as $descuento) {
                                //Si el monto es mayor a 0, se inserta el descuento`
                                if ($descuento["monto"] > 0) {
                                    $descuento["id_detalle"] = $id_detalle;

                                    //Insertar descuento en la base de datos
                                    $descuentosModel = model('documentoDescuentos');
                                    if (!$descuentosModel->insert($descuento)) {
                                        $documentosModel = model('document');
                                        $documentosModel->delete($id_documento);

                                        return json_encode(array(
                                            'estado' => 'error',
                                            'error' => 'Error al insertar el descuento de la factura',
                                        ));
                                    }
                                } //Fin de validacion de monto
                            } //Fin de foreach de descuentos
                        } //Fin de validacion de descuentos
                    } //Fin de caso de insercion de detalle
                } //Fin de ciclo para insertar lineas de detalle

                $stringXML .= '
                </DetalleServicio>
                    <ResumenFactura>
                        <CodigoTipoMoneda>
                            <CodigoMoneda>' . $moneda . '</CodigoMoneda>';

                if ($moneda != 'CRC') {
                    $stringXML .= '<TipoCambio>' . $tipo_cambio . '</TipoCambio>';
                } else {
                    $stringXML .= '<TipoCambio>1</TipoCambio>';
                }

                $stringXML .= '
                    </CodigoTipoMoneda>
                    <TotalServGravados>' . $totalServGravados . '</TotalServGravados>
                    <TotalServExentos>' . $totalServExentos . '</TotalServExentos>
                    <TotalServExonerado>' . $totalServExonerado . '</TotalServExonerado>
                    <TotalMercanciasGravadas>' . $totalMercanciasGravadas . '</TotalMercanciasGravadas>
                    <TotalMercanciasExentas>' . $totalMercanciasExentas . '</TotalMercanciasExentas>
                    <TotalMercExonerada>' . $totalMercExonerada . '</TotalMercExonerada>
                    <TotalGravado>' . $totalGravado . '</TotalGravado>
                    <TotalExento>' . $totalExento . '</TotalExento>
                    <TotalExonerado>' . $totalExonerado . '</TotalExonerado>
                    <TotalVenta>' . $totalVenta . '</TotalVenta>
                    <TotalDescuentos>' . $totalDescuentos . '</TotalDescuentos>
                    <TotalVentaNeta>' . $totalVentaNeta . '</TotalVentaNeta>
                    <TotalImpuesto>' . $totalImpuesto . '</TotalImpuesto>
                    <TotalComprobante>' . $totalComprobante . '</TotalComprobante>
                </ResumenFactura>';

                //Validar el tipo de document
                switch ($documentTypeId) {
                    case '01':
                        if ($receptor->nombre_comercial == 'Walmart') {
                            $stringXML .= '
                            <Otros>
                                <OtroTexto codigo="WMNumeroVendedor">' . $numero_vendor . '</OtroTexto>
                                <OtroTexto codigo="WMNumeroOrden">' . $numero_orden . '</OtroTexto>
                                <OtroTexto codigo="WMEnviarGLN">' . $enviar_gln . '</OtroTexto>
                            </Otros>';

                            $data_otros = array(
                                array(
                                    "id_documento" => $id_documento,
                                    "codigo" => "WMNumeroVendedor",
                                    "valor" => $numero_vendor
                                ),
                                array(
                                    "id_documento" => $id_documento,
                                    "codigo" => "WMNumeroOrden",
                                    "valor" => $numero_orden
                                ),
                                array(
                                    "id_documento" => $id_documento,
                                    "codigo" => "WMEnviarGLN",
                                    "valor" => $enviar_gln
                                )
                            );

                            foreach ($data_otros as $key => $value) {
                                $documentosOtrosModel = model('documentoOtros');
                                $documentosOtrosModel->insert($value);
                            }
                        }
                        $stringXML .= '</FacturaElectronica>';
                        break;

                    case '02':
                        foreach ($_POST['referencia_clave'] as $key => $value) {
                            if ($_POST['referencia_clave'][$key] != '') {
                                $fecha = $_POST['referencia_fecha'][$key];

                                //Si la fecha esta vacia, se asigna la fecha (c) actual
                                if ($fecha == '' || !isset($fecha)) {
                                    $fecha = date('Y-m-d');
                                }

                                $stringXML .= '
                                <InformacionReferencia>
                                    <TipoDoc>' . $_POST['referencia_tipo_documento'][$key] . '</TipoDoc>
                                    <Numero>' . $_POST['referencia_clave'][$key] . '</Numero>
                                    <FechaEmision>' . date("c", strtotime($fecha)) . '</FechaEmision>
                                    <Codigo>' . $_POST['referencia_codigo'][$key] . '</Codigo>
                                    <Razon>' . $_POST['referencia_razon'][$key] . '</Razon>
                                </InformacionReferencia>';

                                $data_referencia = array(
                                    "id_documento"  => $id_documento,
                                    "referencia_tipo_documento"   => $_POST['referencia_tipo_documento'][$key],
                                    "referencia_clave"    => $_POST['referencia_clave'][$key],
                                    "referencia_fecha"   => $_POST['referencia_fecha'][$key],
                                    "referencia_codigo"  => $_POST['referencia_codigo'][$key],
                                    "referencia_razon"    => $_POST['referencia_razon'][$key],
                                );

                                //Insertar el detalle de referencia
                                $documentosReferenciasModel = model('documentoReferencias');
                                $documentosReferenciasModel->insert($data_referencia);
                            }
                        }

                        $stringXML .= '</NotaDebitoElectronica>';
                        break;

                    case '03':
                        foreach ($_POST['referencia_clave'] as $key => $value) {
                            if ($_POST['referencia_clave'][$key] != '') {
                                $fecha = $_POST['referencia_fecha'][$key];

                                $stringXML .= '
                                <InformacionReferencia>
                                    <TipoDoc>' . $_POST['referencia_tipo_documento'][$key] . '</TipoDoc>
                                    <Numero>' . $_POST['referencia_clave'][$key] . '</Numero>
                                    <FechaEmision>' . date("c", strtotime($fecha)) . '</FechaEmision>
                                    <Codigo>' . $_POST['referencia_codigo'][$key] . '</Codigo>
                                    <Razon>' . $_POST['referencia_razon'][$key] . '</Razon>
                                </InformacionReferencia>';

                                //Insertar el detalle de referencia
                                $documentosReferenciasModel = model('documentoReferencias');

                                $data_referencia = array(
                                    "id_documento"  => $id_documento,
                                    "referencia_tipo_documento"   => $_POST['referencia_tipo_documento'][$key],
                                    "referencia_clave"    => $_POST['referencia_clave'][$key],
                                    "referencia_fecha"   => $_POST['referencia_fecha'][$key],
                                    "referencia_codigo"  => $_POST['referencia_codigo'][$key],
                                    "referencia_razon"    => $_POST['referencia_razon'][$key],
                                );

                                $documentosReferenciasModel->insert($data_referencia);
                            }
                        }
                        $stringXML .= '</NotaCreditoElectronica>';
                        break;

                    case '04':
                        $stringXML .= '</TiqueteElectronico>';
                        break;
                }

                $hacienda = new Hacienda();

                $hacienda->setClave($documentKey);

                if (!$hacienda->firmar($stringXML)) {
                    $data = array(
                        "estado" => "error",
                        "error" => "Se ha generado un error al firmar el archivo XML, debe volver a intentarlo."
                    );

                    return json_encode($data);
                }

                //Actualzar el numero de consecutivo
                $consecutivosModel = new ConsecutivosModel();
                $consecutivosModel->actualizar_consecutivo($consecutivo_object->id_consecutivo, $consecutivo_object->consecutivo + 1);

                $enviar = json_decode($hacienda->enviar());

                if ($enviar->status >= 200 && $enviar->status < 300) {
                    //Obtener la fecha en gmt-6
                    $fecha_gmt = date('Y-m-d\TH:i:s', strtotime('-6 hours'));

                    $data_envio = array(
                        'envio_atv' => 1,
                        'fecha_envio' => $fecha_gmt,
                    );

                    $documentosModel = model('document');
                    $documentosModel->update($data_envio, $id_documento);

                    sleep(4);

                    $validar = json_decode($hacienda->validar(), true);

                    if (isset($validar['xml']['ind-estado'])) {
                        if ($validar['xml']['ind-estado'] != "procesando") {
                            $json = json_decode(json_encode(simplexml_load_string(base64_decode($validar['xml']['respuesta-xml']))));

                            $data_validado = array(
                                'valido_atv' => $json->Mensaje,
                                'fecha_valido' => $fecha_gmt,
                                'detalle_atv' => $json->DetalleMensaje,
                            );

                            $documentosModel = model('document');
                            $documentosModel->update($data_validado, $id_documento);

                            $correo_enviado = $hacienda->enviar_documento($id_documento);

                            return json_encode(array(
                                'documentKey' => $id_documento,
                                "enviar" => $enviar->status,
                                "validar_estado" => $validar['xml']['ind-estado'],
                                "mensaje" => $json->Mensaje,
                                "validar_mensaje" => $json->DetalleMensaje,
                                "correo_enviado" => $correo_enviado,
                                'estado' => 'success',
                            ));
                        } else {
                            return json_encode(array(
                                'documentKey' => $id_documento,
                                "enviar" => $enviar->status,
                                "validar_estado" => $validar['xml']['ind-estado'],
                                "mensaje" => "Procesando",
                                "validar_mensaje" => "El document se encuentra en proceso de validación",
                                "correo_enviado" => false,
                                'estado' => 'warning',
                            ));
                        }
                    } else {
                        return json_encode(array(
                            'documentKey' => $id_documento,
                            "enviar" => $enviar->status,
                            "validar_estado" => 'procesando',
                            "mensaje" => "Procesando",
                            "validar_mensaje" => 'El document se encuentra en proceso de validación',
                            "correo_enviado" => false,
                            'estado' => 'error',
                        ));
                    }
                } else {
                    return json_encode(array(
                        'documentKey' => $id_documento,
                        "enviar" => $enviar->status,
                        "validar_estado" => "",
                        "mensaje" => "Error",
                        "error" => 'Se ha generado un error al enviar la factura al Ministerio de Hacienda',
                        "correo_enviado" => false,
                        'estado' => 'warning',
                    ));
                }
            } //Fin de validacion de insercion y envio de correo

            else {
                return json_encode(array(
                    'error' => 'Error al insertar el document',
                    'estado' => 'error',
                ));
            }
        } //Fin de validacion de logueo

        else {
            $error = array(
                'error' => 'No ha iniciado sesion',
                'estado' => 'error',
                'codigo' => 505
            );

            return $this->error($error);
        }
    } //Fin de la funcion create

    public function getInfoClientes()
    {
        $locationsApi = new LocationsApi();
        $dataServiceApi = new DataServiceApi();

        $countries = $locationsApi->get_countries();
        $identificationTypes = $dataServiceApi->getIdentificationTypesByCountry(getCountryCode());
        $states = $locationsApi->get_states_by_iso_code(getCountryCode());

        return array(
            'buscar_cliente' => array(
                'dataForm' => array(
                    'datos_personales' => array(
                        'identificaciones' => $identificationTypes,
                        'countries' => $countries
                    ),
                    'datos_contacto' => array(
                        'countries' => $countries,
                    ),
                    'dataProvincias' => array(
                        'countries' => $countries,
                        'states' => $states,
                    ),
                )
            ),
        );
    }

    public function getPdf($documentUrl)
    {
        $dataView = array(
            'documentUrl' => $documentUrl
        );

        return view('facturacion/modal/ver_pdf', $dataView);
    }

    public function getProductByCode($code)
    {
        //La variable search es un string que contiene los valores de busqueda separados por comas por ejemplo: "id_estado=1,id_categoria=2"
        $filters = "code_number:$code";

        $productosService = new ProductosService();
        return $productosService->getData('all', $filters);
    }

    public function crearDocumento($tipo_documento, $numero_documento)
    {
        $nombreVista = 'facturacion/elementos/documento';

        $dataServiceApi = new DataServiceApi();
        $locationsApi = new LocationsApi();

        $countries = $locationsApi->get_countries();

        $documentType = $dataServiceApi->getDocumentTypeById(getCountryCode(), $tipo_documento);

        $documentVersions = $dataServiceApi->getDocumentVersionsByCountry(getCountryCode());
        $paymentTypes = $dataServiceApi->getPaymentTypesByCountry(getCountryCode());
        $unidadesMedida = $dataServiceApi->getMeasurementUnits();
        $saleConditions = $dataServiceApi->getSaleConditionsByCountry(getCountryCode());

        // Obtener el primer elemento del array
        $documentVersion = $documentVersions[0];

        if (isset($documentType->error)) {
            return array(
                'error' => 'El tipo de documento no existe',
                'status' => 'error',
                'codigo' => '404'
            );
        }

        $taxTypes = $dataServiceApi->getTaxTypesByCountry(getCountryCode());
        $taxRates = $dataServiceApi->getTaxRatesByCountry(getCountryCode());
        $exemptions = $dataServiceApi->getExonerationTypesByCountry(getCountryCode());

        $referenceTypes = $dataServiceApi->getReferenceTypesByCountry(getCountryCode());
        $referenceCodes = $dataServiceApi->getReferenceCodesByCountry(getCountryCode());

        $impuestos = array(
            'taxTypes' => $taxTypes,
            'taxRates' => $taxRates,
            'exemptions' => $exemptions,
        );

        $dataTotales = array(
            'unidades_medida' => $unidadesMedida,
        );

        $modalLinea = array(
            'data_impuesto' => $impuestos,
            'data_totales' => $dataTotales,
        );

        $modalCierreDocumento = array(
            'numero_documento' => $numero_documento,
            'paymentTypes' => $paymentTypes,
        );

        $data_referencias = array(
            'referenceTypes' => $referenceTypes,
            'referenceCodes' => $referenceCodes,
        );

        $taxpayersApi = new TaxpayersApi();
        $empresa = $taxpayersApi->getTaxpayerById(getTaxpayerId());

        $dataView = array(
            'documentType' => $documentType,
            'documentVersion' => $documentVersion,
            'countries' => $countries,
            'paymentTypes' => $paymentTypes,
            'saleConditions' => $saleConditions,
            'empresa' => (object) $empresa,
            'unidades_medida' => $unidadesMedida,
            'numero_documento' => $numero_documento,
            'modalCierreDocumento' => $modalCierreDocumento,
            'data_referencias' => $data_referencias,
            'modalLinea' => $modalLinea,
        );

        return view($nombreVista, $dataView);
    }

    /**
     * Eliminar campos y filas que no contengan datos para enviar la informacion a la API de IVOIS
     */
    private function validateDocumentStructure($document)
    {
        $document = json_encode($document);
        //var_dump($document);

        $document = json_decode($document, true);
        //var_dump($document);

        //Si hay un receiver
        if (isset($document['receiver'])) {
            $receiver = $document['receiver'];

            $receiver = json_decode($receiver, true);

            $document['receiver'] = $receiver;
        }

        if (isset($document['details'])) {
            $details = $document['details'];
            $newDetails = array();

            /**
             * Validar que el detalle traiga los campos
             * 
             * {
			"productId": 10,
			"quantity": 5,
			"description":"Almohada",
			"salePrice": 1500.0
		} o descartar la linea
             */
            foreach ($details as $key => $detail) {
                //var_dump($detail);
                if ($detail['productId'] == "" && $detail['quantity'] == "0" && $detail['description'] == "" && $detail['salePrice'] == "0") {
                    unset($details[$key]);
                } else {
                    //Recorrer los descuentos de la linea si existen y validar que existan los campos o eliminar la linea
                    /**
                     * {
					"percentage": 10,
					"reason": "Centralizacion"
				}
                     */
                    if (isset($detail['discounts'])) {
                        $discounts = $detail['discounts'];
                        $newDiscounts = array();

                        foreach ($discounts as $key => $discount) {
                            //var_dump($discount);

                            if ($discount["reason"] != '' && $discount["percentage"] != '0') {
                                $newDiscounts[] = $discount;
                            }
                        }

                        //Si los descuentos no estan vacios, se agregan al detalle
                        if (count($newDiscounts) > 0) {
                            $detail['discounts'] = $newDiscounts;
                        } else {
                            unset($detail['discounts']);
                        }
                    }

                    // Se debe recorrer cada uno de los detalles del documento para eliminar lineas de descuentos o impuestos que se encuentren vacias

                    /**
                     * Formato de las lineas de impuestos
                     * 
                     * "taxes": [
				{
					"taxTypeId": 1,
					"taxRateId": 2,
					"rate":1
				}
			]
                     */
                    if (isset($detail['taxes'])) {
                        $taxes = $detail['taxes'];
                        $newTax = array();

                        foreach ($taxes as $key => $tax) {
                            if (($tax['taxTypeId'] != '' && $tax['taxRateId'] != '') || ($tax['taxTypeId'] != '' && $tax['rate'] != '0')) {
                                //var_dump("Validando impuesto");
                                if (isset($tax['exemption'])) {
                                    $exemption = $tax['exemption'];

                                    if ($exemption['documentType'] != '' && $exemption['documentNumber'] != '' && $exemption['institutionName'] != '' && $exemption['issueDate'] != '' && $exemption['percentage'] != '0') {
                                        $tax['exemption'] = $exemption;
                                    } else {
                                        unset($tax['exemption']);
                                    }
                                }

                                //var_dump($tax);

                                $newTax[] = $tax;
                            } else {
                                unset($taxes[$key]);
                            }
                        }

                        //var_dump($newTax);

                        //Si los impuestos no estan vacios, se agregan al detalle
                        if (count($newTax) > 0) {
                            $detail['taxes'] = $newTax;
                        } else {
                            unset($detail['taxes']);
                        }
                    }

                    $newDetails[] = $detail;
                }
            }

            $document['details'] = $newDetails;
        }

        // Validar si existen referencias en el documento y luego validar cada linea

        /**
         * "referenceType": 16,
			"referenceCode": "04",
			"referenceNumber": "1202125451245",
			"referenceReason": "Compra de papas.",
			"referenceDate": "2022-12-07"
         */

        if (isset($document['references'])) {
            $references = $document['references'];

            foreach ($references as $key => $reference) {
                if ($reference['referenceType'] == '' && $reference['referenceCode'] == '' && $reference['referenceNumber'] == '' && $reference['referenceReason'] == '' && $reference['referenceDate'] == '') {
                    unset($references[$key]);
                }
            }

            $document['references'] = $references;
        }

        /**
         * Validar que los pagos que se envian contengan informacion
         * 
         * {
			"type": 2,
			"amount": 7500.0
		}
         */

        if (isset($document['payments'])) {
            $payments = $document['payments'];
            $newPayments = array();

            foreach ($payments as $key => $payment) {
                //var_dump($payment);
                if ($payment['type'] != '' && $payment['amount'] != '') {
                    $newPayments[] = $payment;
                }
            }

            $document['payments'] = $newPayments;
        }

        //Validar la estructura de otros campos (otherFields)

        /**
         * {
			"code": "WMNumeroVendedor",
			"otherText": "019596262"
		},
         */
        if (isset($document['otherFields'])) {
            $otherFields = $document['otherFields'];

            foreach ($otherFields as $key => $otherField) {
                if ($otherField['code'] == '' && $otherField['otherText'] == '') {
                    unset($otherFields[$key]);
                }
            }

            $document['otherFields'] = $otherFields;
        }

        return $document;
    }

    /**
     * Enviar un documento a la API de IVois
     * 
     * @param array $data Datos del documento
     * @return  object Respuesta de la API
     */
    public function guardarDocumento($data)
    {
        $document = $this->validateDocumentStructure($data);

        $documentsApi = new DocumentsApi(getTaxpayerId());

        return $documentsApi->sendDocument($document);
    }

    public function getWalmart()
    {
        return view('facturacion/modal/walmart', $this->getInfoWalmart());
    }

    /**
     * Obtener los indicadores economicos del banco central
     * @param string $tipo Tipo de indicador economico
     * @return string Retorna los indicadores economicos
     */
    public function obtenerIndicadores($tipo = 'CRC')
    {
        if ($tipo) {
            $indicadores = new Indicador();
            $tipo_cambio = $indicadores->obtenerIndicadorEconomico($tipo);

            return json_encode(array(
                'tipo_cambio' => $tipo_cambio,
            ));
        } else {
            $indicadores = new Indicador();

            $compra = $indicadores->obtenerIndicadorEconomico('CRC');
            $venta = $indicadores->obtenerIndicadorEconomico('USD');

            return json_encode(array(
                'compra' => $compra,
                'venta' => $venta,
            ));
        }
    }

    /**Obtener la informacion para los documentos de walmart */
    private function getInfoWalmart()
    {
        $tiendasModel = model('tiendas');
        $numerosProveedorModel = model('departamentos');

        $dataTiendas = array(
            'tiendas' => $tiendasModel->obtener('activos'),
        );

        return array(
            'numerosProveedor' => $numerosProveedorModel->getAll(),
            'dataTiendas' => $dataTiendas,
        );
    }

    public function getReporteZip($documentos)
    {
        $claves = array();

        $reporte = new Reportes();

        foreach ($documentos as $key => $value) {
            $id_documento = $documentos[$key];

            $claves[] = $id_documento;
        }

        return $reporte->generar_reporte_documentos($claves, getSegment(3));
    }
}
