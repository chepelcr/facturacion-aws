<?php

namespace App\Services;

use App\Api\BranchesApi;
use App\Librerias\Hacienda;

use App\Api\CustomersApi;
use App\Api\DataServiceApi;
use App\Api\DocumentsApi;
use App\Api\LocationsApi;
use App\Api\NotificationsApi;
use App\Api\ProductsApi;
use App\Api\ProvidersApi;
use App\Api\TaxpayersApi;
use App\Api\ValidationsApi;
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
     * Api de Ubicaciones
     */
    private $locationsApi;

    /**
     * Api de sucursales
     */
    private $branchesApi;

    /**
     * Api de validaciones de Hacienda
     */
    private $validationsApi;

    /**
     * Api de notificaciones de documento
     */
    private $notificationsApi;

    /**
     * Constructor
     */
    public function __construct() {
        $this->dataServiceApi = new DataServiceApi();
        $this->locationsApi = new LocationsApi();

        $this->documentsApi = new DocumentsApi(getTaxpayerId());
        $this->branchesApi = new BranchesApi(getTaxpayerId());

        $this->validationsApi = new ValidationsApi(getTaxpayerId());
        $this->notificationsApi = new NotificationsApi(getTaxpayerId());
    }

    /**
     * Obtener la informacion de los clientes
     */
    public function buscarCliente($idCliente, $isProvider = false) {
        if ($isProvider) {
            $providersApi = new ProvidersApi(getTaxpayerId());
            return $providersApi->getProviderById($idCliente);
        } else {
            $customersApi = new CustomersApi(getTaxpayerId());
            return $customersApi->getCustomerById($idCliente);
        }
    }

    public function recibirRespuestaHacienda($documentKey, $respuesta) {
        //Decodificar la documentKey
        $documentKey = base64_decode($documentKey);

        $hacienda = new Hacienda($documentKey);

        $hacienda->validar_respuesta($respuesta);
    }

    /**
     * Enviar una notificación de un documento a un correo electrónico o al correo del cliente
     * 
     * @param int $idDocumento Id del documento a enviar
     * @return array Retorna el resultado del envio
     */
    public function enviarDocumento($idDocumento, $email = null) {
        $notificationsApi = $this->notificationsApi;

        if ($email) {
            $result = $notificationsApi->sendDocumentNotification($idDocumento, $email);
        } else {
            $result = $notificationsApi->resendDocumentNotification($idDocumento);
        }

        return $result;
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

    public function cargarDocumentos($documentTypeId, $issuerFilter, $startDate, $endDate, $reportType = null) {
        $documentsApi = $this->documentsApi;


        if ($issuerFilter == "recibidos") {
            $received = true;
        } else {
            $received = false;
        }

        //$search = "";

        switch ($reportType) {
            case 'semanal':
                //Hace 7 dias
                $startDate = strtotime('-7 days');
                $endDate = strtotime(date('Y-m-d'));

                //$search = "saleDate:$startDate~$endDate";

                break;

            case 'semana_anterior':
                $startDate = strtotime('last monday', strtotime('last week'));
                $endDate = strtotime('last sunday', strtotime('last week'));

                //$search = "saleDate:$startDate~$endDate";

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

                //$search = "saleDate:$startDate~$endDate";
                break;

            //Obtener los documentos del mes actual
            case 'mes':
                $startDate = strtotime(date('Y-m-01'));
                $endDate = strtotime(date('Y-m-t'));

                //$search = "saleDate:$startDate~$endDate";

                break;

            case 'mes_anterior':
                $startDate = strtotime('first day of last month');
                $endDate = strtotime('last day of last month');

                //$search = "saleDate:$startDate~$endDate";
                break;

            case 'busqueda':
                $startDate = strtotime($startDate);
                $endDate = strtotime($endDate);


                break;

            default:
                $startDate = strtotime(date('Y-m-d'));
                $endDate = strtotime(date('Y-m-d'));

                $reportType = "diarios";
                break;
        }

        //Colocar las fechas en formato yyyy-mm-dd
        $startDate = date('Y-m-d', $startDate);
        $endDate = date('Y-m-d', $endDate);

        $search = "saleDate:$startDate~$endDate";

        $documentos = $documentsApi->getDocumentsByFilter($received, $documentTypeId, $search); //, $startDate, $endDate);

        if (isset($documentos->error)) {
            return $documentos;
        }

        /*if ($startDate && $endDate) {
            $documentos = $this->filterDocumentsByDate($documentos, $startDate, $endDate);
        }*/

        $dataServiceApi = $this->dataServiceApi;
        $documentTypes = $dataServiceApi->getDocumentTypesByCountry(getCountryCode());

        $dataView = array(
            'documentos' => $documentos,
            'received' => $received,
            'reportType' => $reportType,
            'documentTypes' => $documentTypes,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'documentTypeId' => $documentTypeId,
        );

        return view('facturacion/table/documentos', $dataView);
    }

    /**
     * Obtener la validacion de un documento electronico
     */
    public function validarDocumento($documentKey) {
        $validationsApi = $this->validationsApi;

        return $validationsApi->getDocumentValidation($documentKey);
    }

    /**
     * Obtener los productos de un contribuyente
     */
    public function getProductos() {
        $detailsApi = new ProductsApi(getTaxpayerId());

        $search = "status:1";
        $productos = $detailsApi->getProductsBySearchFilter($search);

        //$productos = $detailsApi->getProductsByTaxpayerId();

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
        $countryCode = getCountryCode();

        $search = "status:1";
        $isProvider = false;

        //Si el código del tipo de document es 01 o 08 se obtienen solo los clientes nacionales
        if ($documentTypeCode == '01' || $documentTypeCode == '08') {
            $search = "$search,nationality:$countryCode";

            if ($documentTypeCode == "08") {
                $providersApi = new ProvidersApi(getTaxpayerId());
                $clientes = $providersApi->getProviders($search);

                $isProvider = true;
            } else {
                $clientes = $customersApi->getCustomers($search);
            }
        } elseif ($documentTypeCode == '09') {
            //Si es  09 se obtienen solo los clientes extranjeros
            $search = "$search,nationality!$countryCode";
            $clientes = $customersApi->getCustomers($search);
        } else {
            $clientes = $customersApi->getCustomers($search);
        }

        if (isset($clientes->error)) {
            return $clientes;
        } else {
            $dataView = array(
                'clientes' => $clientes,
                'isProvider' => $isProvider
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
    public function getInfoClientes($numero_documento, $documentTypeCode) {
        $locationsApi = $this->locationsApi;
        $dataServiceApi = $this->dataServiceApi;

        $isProvider = false;

        //Si el documento es de tipo 01 o 08 solo se obtienen los paises con serviceStatus = 1, si es 09 se obtienen los paises con serviceStatus = 2 o si es otro tipo de documento se obtienen todos los paises
        if ($documentTypeCode == '01' || $documentTypeCode == '08') {
            $countries = $locationsApi->get_countries(1);

            if ($documentTypeCode == '08') {
                $isProvider = true;
            }
        } elseif ($documentTypeCode == '09') {
            $countries = $locationsApi->get_countries(2);
        } else {
            $countries = $locationsApi->get_countries();
        }

        $phoneCountries = $locationsApi->get_countries();

        $identificaciones = $dataServiceApi->getIdentificationTypesByCountry(getCountryCode());
        $customerTypes = $dataServiceApi->getCustomerTypes();

        //Si el documento es de tipo 01 o 08 se obtienen los estados del pais
        if (($documentTypeCode == '01' || $documentTypeCode == '08') && $documentTypeCode != '09') {
            $states = $locationsApi->get_states_by_iso_code(getCountryCode());
        } else {
            $states = array();
        }

        return array(
            'data_form' => array(
                'datos_personales' => array(
                    'identificaciones' => $identificaciones,
                    'countries' => $countries,
                    'customerTypes' => $customerTypes,
                    'customerTypeName' => 'receiver[customerType]',
                    'nationalityName' => 'receiver[nationality]',
                    'identificationTypeIdName' => 'receiver[identification][type]',
                    'identificationNumberName' => 'receiver[identification][number]',
                    'businessNameName' => 'receiver[businessName]',
                    'tradeNameName' => 'receiver[tradeName]',
                    'isProvider' => $isProvider
                ),
                'datos_contacto' => array(
                    'countries' => $phoneCountries,
                    'personalPhoneCountryCodeName' => 'receiver[personalPhone][countryCode]',
                    'personalPhoneNumberName' => 'receiver[personalPhone][number]',
                    'emailName' => 'receiver[email]',
                ),
                'dataProvincias' => array(
                    'states' => $states,
                    'stateName' => 'receiver[residence][stateId]',
                    'countyName' => 'receiver[residence][countyId]',
                    'districtName' => 'receiver[residence][districtId]',
                    //'neighborhoodName' => 'receiver[residence][neighborhoodId]',
                    'addressName' => 'receiver[residence][address]',
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

        $dataServiceApi = $this->dataServiceApi;
        $locationsApi = $this->locationsApi;
        $branchesApi = $this->branchesApi;

        $countries = $locationsApi->get_countries();

        $documentType = $dataServiceApi->getDocumentTypeById(getCountryCode(), $tipo_documento);

        if (isset($documentType->error)) {
            return $documentType;
        }

        $documentVersions = $dataServiceApi->getDocumentVersionsByCountry(getCountryCode());
        $paymentTypes = $dataServiceApi->getPaymentTypesByCountry(getCountryCode());
        $saleConditions = $dataServiceApi->getSaleConditionsByCountry(getCountryCode());
        $branches = $branchesApi->getBranchesByStatus(1);

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
        $productTypes = $dataServiceApi->getProductTypes();

        $referenceTypes = $dataServiceApi->getReferenceTypesByCountry(getCountryCode());
        $referenceCodes = $dataServiceApi->getReferenceCodesByCountry(getCountryCode());

        $discountTypes = $dataServiceApi->getDiscountTypesByCountry(getCountryCode());

        $impuestos = array(
            'taxTypes' => $taxTypes,
            'taxRates' => $taxRates,
            'exemptions' => $exemptions,
        );

        $descuentos = array(
            'discounts' => $discountTypes
        );

        $data_general = array(
            'data_general' => array(
                'unidades' => array(),
                'isDetail' => true,
            )
        );

        $data_hacienda = array(
            'isDetail' => true,
            'productTypes' => $productTypes,
        );

        $data_valor = array(
            'isDetail' => true,
        );

        $modalLinea = array(
            'data_impuesto' => $impuestos,
            'data_descuentos' => $descuentos,
            'data_general' => $data_general,
            'data_hacienda' => $data_hacienda,
            'data_valor' => $data_valor,
            'documentType' => $documentType,
        );

        $modalCierreDocumento = array(
            'numero_documento' => $numero_documento,
            'paymentTypes' => $paymentTypes,
            'branches' => $branches
        );

        $data_referencias = array(
            'referenceTypes' => $referenceTypes,
            'referenceCodes' => $referenceCodes,
        );

        $data_cliente = $this->getInfoClientes($numero_documento, $documentType->code);

        $taxpayersApi = new TaxpayersApi();
        $empresa = $taxpayersApi->getTaxpayerById(getTaxpayerId());

        $dataView = array(
            'documentType' => $documentType,
            'documentVersion' => $documentVersion,
            'countries' => $countries,
            'paymentTypes' => $paymentTypes,
            'saleConditions' => $saleConditions,
            'empresa' => (object) $empresa,
            'numero_documento' => $numero_documento,
            'modalCierreDocumento' => $modalCierreDocumento,
            'data_referencias' => $data_referencias,
            'modalLinea' => $modalLinea,
            'data_cliente' => $data_cliente,
        );

        return view($nombreVista, $dataView);
    }

    /**
     * Enviar un documento al API de Ivois
     * 
     * @param array $data Datos del documento
     * @return object Respuesta del API
     */
    public function guardarDocumento($data) {
        $document = DocumentValidations::validateDocumentStructure($data);

        if (isset($document['error'])) {
            return (object) $document;
        }

        $documentsApi = $this->documentsApi;

        return $documentsApi->sendDocument($document);
    }

    /**
     * Obtener la vista para los documentos de walmart
     * 
     * @return string Vista de los documentos de walmart
     */
    public function getWalmart($documentTypeCode = "01") {
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

        $tiendasModel = model('tiendas');
        $numerosProveedorModel = model('departamentos');

        $dataTiendas = array(
            'tiendas' => $tiendasModel->obtener('activos'),
        );

        if ($documentTypeCode == '01') {
            return array(
                'numerosProveedor' => $numerosProveedorModel->getAll(),
                'dataTiendas' => $dataTiendas,
                'documentTypeCode' => $documentTypeCode,
            );
        } elseif ($documentTypeCode == '03') {
            return array(
                'documentTypeCode' => $documentTypeCode,
            );
        }
    }

    /**
     * Generar un reporte de los documentos
     *
     * @param array $documentos Documentos a generar el reporte
     * @return string Retorna el reporte en formato zip
     */
    public function getReporteZip($documentos) {
        $claves = array();

        $reporte = new Reportes();

        foreach ($documentos as $key => $value) {
            $id_documento = $documentos[$key];

            $claves[] = $id_documento;
        }

        return $reporte->generar_reporte_documentos($claves, getSegment(3));
    }

    /**
     * Subir un documento al API de Ivois
     *
     * @param array $data Datos de los documentos
     * @return object Respuesta del API
     */
    public function subirDocumento($xml, $contentType) {

        //Codificar el xml en un string base64
        $xml = base64_encode($xml);

        $document = array(
            'data' => $xml,
            'contentType' => $contentType
        );

        $documentsApi = $this->documentsApi;

        return $documentsApi->uploadDocument($document);
    }

    /**
     * Obtener las sucursales activas
     *
     * @return array|object Sucursales activas u objeto de error
     */
    public function getSucursales() {
        return $this->branchesApi->getBranchesByStatus(1);
    }

    /**
     * Enviar validacion de receptor al API de Ivois
     *
     * @param array $data Datos del receptor
     * @return object Respuesta del API
     */
    public function validacionReceptor($data, $documentKey) {
        $documentsApi = $this->documentsApi;

        return $documentsApi->sendReceiverValidation($data, $documentKey);
    }

    /**
     * Se encarga de enviar los XML de los documentos de la carpeta a API de documentos
     * 
     * El formato de envio es el siguiente:
     * [{
     *  "data": $xml,
     *  "contentType": $contentType
     * },]
     * 
     * Se deben leer todos los archivos de la carpeta "firmados" que terminen en XML y ser agregado a la lista en el formato correspondiente. luego se debe hacer un post al API
     *
     * @return array
     */
    public function enviarDoumentosXml() {
        $documentsApi = $this->documentsApi;

        $carpeta = location('firmados/');

        $archivos = scandir($carpeta);

        $archivos_xml = array();

        foreach ($archivos as $archivo) {
            if (is_file($carpeta . $archivo) && pathinfo($carpeta . $archivo, PATHINFO_EXTENSION) == 'xml') {
                $archivos_xml[] = array(
                    'data' => base64_encode(file_get_contents($carpeta . $archivo)),
                    'contentType' => 'text/xml'
                );
            }
        }

        //var_dump($archivos_xml);

        return $documentsApi->uploadDocuments($archivos_xml);
    }
}
