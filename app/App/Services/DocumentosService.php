<?php

namespace App\Services;

use App\Librerias\Hacienda;

use App\Api\CustomersApi;
use App\Api\DataServiceApi;
use App\Api\DocumentsApi;
use App\Api\LocationsApi;
use App\Api\ProductsApi;
use App\Api\TaxpayersApi;
use App\Librerias\Indicador;
use App\Librerias\Reportes;
use App\Validations\DocumentValidations;

/**
 * Servicio para la gestion de documentos
 */
class DocumentosService {

    /**
     * Api de data service
     */
    private $dataServiceApi;

    /**
     * Api de documentos electronicos
     */
    private $documentsApi;

    /**
     * Constructor
     */
    public function __construct() {
        $this->dataServiceApi = new DataServiceApi();
        $this->documentsApi = new DocumentsApi(getTaxpayerId());
    }

    /**
     * Obtener la informacion de los clientes
     */
    public function buscarCliente($idCliente) {
        $customersApi = new CustomersApi(getTaxpayerId());

        return $customersApi->getCustomerById($idCliente);
    }

    /**
     * Validar los documentos que se encuentran en proceso
     */
    public function validarDocumentos() {
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

    public function recibirRespuestaHacienda($documentKey, $respuesta) {
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
    public function enviarDocumento($idDocumento, $email = null) {
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

    private function filterDocumentsByDate($documents, $startDate, $endDate) {
        $documentos = array();

        foreach ($documents as $document) {
            $fecha_emision = strtotime($document->saleDate);

            if ($fecha_emision >= strtotime($startDate) && $fecha_emision <= strtotime($endDate)) {
                $documentos[] = $document;
            }
        }

        return $documentos;
    }

    public function cargarDocumentos($documentTypeId, $issuerFilter, $reportType = null, $startDate = '', $endDate = '') {
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

    public function validarDocumento($idDocumento) {
        //$model = model('document');

        //$document = $model->obtener($idDocumento);

        /*if ($document) {
            $hacienda = new Hacienda($idDocumento);

            $validar = json_decode($hacienda->validar());

            if (isset($validar['xml']['ind-estado'])) {
                //$fecha_gmt = date('Y-m-d\TH:i:s', strtotime('-6 hours'));

                if ($validar['xml']['ind-estado'] != "procesando") {
                    $json = json_decode(json_encode(simplexml_load_string(base64_decode($validar['xml']['respuesta-xml']))));

                    $data_validado = array(
                        'valido_atv' => $json->Mensaje,
                        'detalle_atv' => $json->DetalleMensaje,
                        'fecha_valido' => $fecha_gmt,
                    );

                    //$documentosModel = model('document');
                    //$documentosModel->update($data_validado, $idDocumento);

                    //$correo_enviado = $hacienda->enviar_documento($idDocumento);

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
        }*/
    }

    public function enviarHacienda($idDocumento) {
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
    public function getProductos() {
        $detailsApi = new ProductsApi(getTaxpayerId());

        $productos = $detailsApi->getProductsByTaxpayerId();

        $dataView = array(
            'productos' => $productos,
        );

        return view('facturacion/table/productos', $dataView);
    }

    /**
     * Obtener los clientes de un contribuyente
     */
    public function getCustomers($documentTypeCode) {
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

    /**
     * Obtener la informacion de los clientes
     * 
     * @param string $numero_documento Numero de documento
     * @return array Informacion de los clientes
     */
    public function getInfoClientes($numero_documento) {
        $locationsApi = new LocationsApi();
        $dataServiceApi = new DataServiceApi();

        $countries = $locationsApi->get_countries();
        $identificationTypes = $dataServiceApi->getIdentificationTypesByCountry(getCountryCode());
        $states = $locationsApi->get_states_by_iso_code(getCountryCode());

        return array(
            'data_form' => array(
                'datos_personales' => array(
                    'identificaciones' => $identificationTypes,
                    'countries' => $countries
                ),
                'datos_contacto' => array(
                    'countries' => $countries,
                ),
                'data_ubicaciones' => array(
                    'countries' => $countries,
                    'states' => $states,
                ),
            ),
            'numero_documento' => $numero_documento,
        );
    }

    /**
     * Obtener la vista para un documento en PDF
     */
    public function getPdf($documentUrl) {
        $dataView = array(
            'documentUrl' => $documentUrl
        );

        return view('facturacion/modal/ver_pdf', $dataView);
    }

    /**
     * Buscar un producto por el codigo
     * 
     * @param string $code Codigo del producto
     * @return list Productos
     */
    public function getProductByCode($code) {
        //La variable search es un string que contiene los valores de busqueda separados por comas por ejemplo: "id_estado=1,id_categoria=2"
        $filters = array(
            'search' => "code_number:$code"
        );

        $productosService = new ProductosService();
        return $productosService->getData('all', $filters);
    }

    /**
     * Crear un documento
     * 
     * @param string $tipo_documento Tipo de documento
     * @param string $numero_documento Numero de documento
     * 
     * @return string Vista del documento
     */
    public function crearDocumento($tipo_documento, $numero_documento) {
        $nombreVista = 'facturacion/elementos/documento';

        $dataServiceApi = new DataServiceApi();
        $locationsApi = new LocationsApi();

        $countries = $locationsApi->get_countries();

        $documentType = $dataServiceApi->getDocumentTypeById(getCountryCode(), $tipo_documento);

        if (isset($documentType->error)) {
            return $documentType;
        }

        $documentVersions = $dataServiceApi->getDocumentVersionsByCountry(getCountryCode());
        $paymentTypes = $dataServiceApi->getPaymentTypesByCountry(getCountryCode());
        $unidadesMedida = $dataServiceApi->getMeasurementUnits();
        $saleConditions = $dataServiceApi->getSaleConditionsByCountry(getCountryCode());


        if ((is_array($documentVersions) && empty($documentVersions)) || isset($documentVersions->error)) {
            if (isset($documentVersions->error)) {
                return $documentVersions;
            } else {

                return array(
                    'error' => 'No se han encontrado versiones de documentos',
                    'status' => '400',
                );
            }
        }

        // Obtener el primer elemento del array
        $documentVersion = $documentVersions[0];

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

        $data_cliente = $this->getInfoClientes($numero_documento);

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
            'data_cliente' => $data_cliente,
        );

        return view($nombreVista, $dataView);
    }

    /**
     * Enviar un documento a la API de IVois
     * 
     * @param array $data Datos del documento
     * @return object Respuesta de la API
     */
    public function guardarDocumento($data) {
        $document = DocumentValidations::validateDocumentStructure($data);

        if (isset($document['error'])) {
            return $document;
        }

        $documentsApi = new DocumentsApi(getTaxpayerId());

        return $documentsApi->sendDocument($document);
    }

    /**
     * Obtener la vista para los documentos de walmart
     * 
     * @return string Vista de los documentos de walmart
     */
    public function getWalmart($documentTypeCode) {
        return view('facturacion/modal/walmart', $this->getInfoWalmart($documentTypeCode));
    }

    /**
     * Obtener los indicadores economicos del banco central
     * @param string $tipo Tipo de indicador economico
     * @return string Retorna los indicadores economicos
     */
    public function obtenerIndicadores($tipo = 'CRC') {
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
    private function getInfoWalmart($documentTypeCode) {

        if ($documentTypeCode == '01') {

            $tiendasModel = model('tiendas');
            $numerosProveedorModel = model('departamentos');

            $dataTiendas = array(
                'tiendas' => $tiendasModel->obtener('activos'),
            );

            return array(
                'numerosProveedor' => $numerosProveedorModel->getAll(),
                'dataTiendas' => $dataTiendas,
                'documentTypeCode' => $documentTypeCode,
            );
        } else {
            return array(
                'documentTypeCode' => $documentTypeCode,
            );
        }
    }

    public function getReporteZip($documentos) {
        $claves = array();

        $reporte = new Reportes();

        foreach ($documentos as $key => $value) {
            $id_documento = $documentos[$key];

            $claves[] = $id_documento;
        }

        return $reporte->generar_reporte_documentos($claves, getSegment(3));
    }
}
