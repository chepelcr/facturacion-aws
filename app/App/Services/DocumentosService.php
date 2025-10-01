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
use App\Enums\CurrenciesEnum;
use App\Enums\DocumentTypesEnum;
use App\Enums\TaxTypesEnum;
use App\Librerias\Indicador;
use App\Librerias\Reportes;
use App\Models\ConsecutivosModel;
use App\Models\EmpresasModel;
use App\Models\TipoCambioModel;
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

    private $taxpayersApi;

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
        $this->taxpayersApi = new TaxpayersApi();
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
     * Create XML from API response document
     */
    private function createXmlFromResponse($document) {
        $docType = DocumentTypesEnum::tryFrom($document['documentType']);
        if (!$docType) {
            throw new \InvalidArgumentException('Unsupported document type');
        }

        $stringXML = '<?xml version="1.0" encoding="utf-8"?>\n'
            . '<' . $docType->getXmlRoot() . '\n'
            . '    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"\n'
            . '    xmlns:xsd="http://www.w3.org/2001/XMLSchema"\n'
            . '    xmlns="' . $docType->getXmlns(true) . '">';

        // Generate new key and consecutive number
        $consecutivosModel = new ConsecutivosModel();
        $consecutivo_object = $consecutivosModel->obtener_consecutivo($document['documentType'], getEnt('factura.ambiente'));
        $consecutivo = $this->createConsecutive($document['documentType'], $document['branchNumber'], $document['terminalNumber'], $consecutivo_object);
        $empresa = $this->taxpayersApi->getTaxpayerById(getTaxpayerId());
        $clave = $this->createKey($consecutivo, $empresa);

        $stringXML .= '<Clave>' . $clave . '</Clave>\n'
            . '<ProveedorSistemas>' . $document['issuer']['identification']['number'] . '</ProveedorSistemas>\n'
            . '<CodigoActividadEmisor>' . $document['activityCode'] . '</CodigoActividadEmisor>\n'
            . '<NumeroConsecutivo>' . $consecutivo . '</NumeroConsecutivo>\n'
            . '<FechaEmision>' . date('c', strtotime($document['saleDate'])) . '</FechaEmision>\n'
            . '<Emisor>\n'
            . '    <Nombre>' . $document['issuer']['name'] . '</Nombre>\n'
            . '    <Identificacion>\n'
            . '        <Tipo>' . $document['issuer']['identification']['code'] . '</Tipo>\n'
            . '        <Numero>' . $document['issuer']['identification']['number'] . '</Numero>\n'
            . '    </Identificacion>\n'
            . '    <NombreComercial>' . ($document['issuer']['tradeName'] ?? '') . '</NombreComercial>\n'
            . '    <Ubicacion>\n'
            . '        <Provincia>' . $document['issuer']['residence']['stateId'] . '</Provincia>\n'
            . '        <Canton>' . str_pad($document['issuer']['residence']['countyId'], 2, '0', STR_PAD_LEFT) . '</Canton>\n'
            . '        <Distrito>' . str_pad($document['issuer']['residence']['districtId'], 2, '0', STR_PAD_LEFT) . '</Distrito>\n'
            . '        <OtrasSenas>' . $document['issuer']['residence']['address'] . '</OtrasSenas>\n'
            . '    </Ubicacion>\n'
            . '    <Telefono>\n'
            . '        <CodigoPais>' . $document['issuer']['phone']['countryCode'] . '</CodigoPais>\n'
            . '        <NumTelefono>' . $document['issuer']['phone']['number'] . '</NumTelefono>\n'
            . '    </Telefono>\n'
            . '    <CorreoElectronico>' . $document['issuer']['email'] . '</CorreoElectronico>\n'
            . '</Emisor>';

        if (isset($document['receiver'])) {
            $stringXML .= '<Receptor>\n'
                . '    <Nombre>' . $document['receiver']['name'] . '</Nombre>\n'
                . '    <Identificacion>\n'
                . '        <Tipo>' . $document['receiver']['identification']['code'] . '</Tipo>\n'
                . '        <Numero>' . $document['receiver']['identification']['number'] . '</Numero>\n'
                . '    </Identificacion>\n'
                . '    <NombreComercial>' . ($document['receiver']['tradeName'] ?? '') . '</NombreComercial>';

            if (isset($document['receiver']['residence'])) {
                $stringXML .= '\n    <Ubicacion>';
                if ($document['documentType'] == '08' || (isset($document['receiver']['residence']['stateId']) && isset($document['receiver']['residence']['countyId']) && isset($document['receiver']['residence']['districtId']))) {
                    $stringXML .= '\n        <Provincia>' . $document['receiver']['residence']['stateId'] . '</Provincia>\n'
                        . '        <Canton>' . str_pad($document['receiver']['residence']['countyId'], 2, '0', STR_PAD_LEFT) . '</Canton>\n'
                        . '        <Distrito>' . str_pad($document['receiver']['residence']['districtId'], 2, '0', STR_PAD_LEFT) . '</Distrito>\n'
                        . '        <OtrasSenas>' . $document['receiver']['residence']['address'] . '</OtrasSenas>';
                } else {
                    $stringXML .= '\n        <OtrasSenas>' . $document['receiver']['residence']['address'] . '</OtrasSenas>';
                }
                $stringXML .= '\n    </Ubicacion>\n'
                    . '    <OtrasSenasExtranjero>' . ($document['receiver']['foreignAddress'] ?? $document['receiver']['residence']['address']) . '</OtrasSenasExtranjero>';
            }

            $stringXML .= '\n    <Telefono>\n'
                . '        <CodigoPais>' . $document['receiver']['phone']['countryCode'] . '</CodigoPais>\n'
                . '        <NumTelefono>' . $document['receiver']['phone']['number'] . '</NumTelefono>\n'
                . '    </Telefono>\n'
                . '    <CorreoElectronico>' . $document['receiver']['email'] . '</CorreoElectronico>\n'
                . '</Receptor>';
        }

        $stringXML .= '\n<CondicionVenta>' . $document['saleCondition'] . '</CondicionVenta>\n'
            . '<PlazoCredito>' . ($document['creditTerm'] ?? '0') . '</PlazoCredito>';

        $stringXML .= $this->createDetailsXmlFromResponse($document['details']);
        $stringXML .= $this->createSummaryXml($document);

        if (isset($document['otherFields']) && !empty($document['otherFields'])) {
            $stringXML .= '\n<Otros>';
            foreach ($document['otherFields'] as $field) {
                $stringXML .= '\n    <OtroTexto codigo="' . $field['code'] . '">' . $field['otherText'] . '</OtroTexto>';
            }
            $stringXML .= '\n</Otros>';
        }

        if (isset($document['references']) && !empty($document['references'])) {
            foreach ($document['references'] as $reference) {
                $stringXML .= '\n<InformacionReferencia>\n'
                    . '    <TipoDoc>' . $reference['type'] . '</TipoDoc>\n'
                    . '    <Numero>' . $reference['number'] . '</Numero>\n'
                    . '    <FechaEmision>' . date('c', strtotime($reference['date'])) . '</FechaEmision>\n'
                    . '    <Codigo>' . $reference['code'] . '</Codigo>\n'
                    . '    <Razon>' . $reference['reason'] . '</Razon>\n'
                    . '</InformacionReferencia>';
            }
        }

        $stringXML .= '</' . $docType->getXmlRoot() . '>';
        return $stringXML;
    }

    private function createDetailsXmlFromResponse($details) {
        $stringXML = '<DetalleServicio>';
        foreach ($details as $detail) {
            $stringXML .= '\n<LineaDetalle>\n'
                . '    <NumeroLinea>' . $detail['lineNumber'] . '</NumeroLinea>\n'
                . '    <CodigoCABYS>' . $detail['cabys'] . '</CodigoCABYS>';

            if (isset($detail['codes']) && !empty($detail['codes'])) {
                foreach ($detail['codes'] as $code) {
                    $stringXML .= '\n    <CodigoComercial>\n'
                        . '        <Tipo>' . $code['codeType'] . '</Tipo>\n'
                        . '        <Codigo>' . $code['number'] . '</Codigo>\n'
                        . '    </CodigoComercial>';
                }
            }

            $stringXML .= '\n    <Cantidad>' . $detail['quantity'] . '</Cantidad>\n'
                . '    <UnidadMedida>' . $detail['unitMeasure'] . '</UnidadMedida>\n'
                . '    <UnidadMedidaComercial>' . ($detail['commercialUnitMeasure'] ?? $detail['unitMeasure']) . '</UnidadMedidaComercial>\n'
                . '    <Detalle>' . $detail['description'] . '</Detalle>\n'
                . '    <PrecioUnitario>' . $detail['netPrice'] . '</PrecioUnitario>\n'
                . '    <MontoTotal>' . $detail['totalAmount'] . '</MontoTotal>';

            if (isset($detail['discounts']) && !empty($detail['discounts'])) {
                foreach ($detail['discounts'] as $discount) {
                    $stringXML .= '\n    <Descuento>\n'
                        . '        <MontoDescuento>' . $discount['amount'] . '</MontoDescuento>\n'
                        . '        <CodigoDescuento>' . $discount['discountType'] . '</CodigoDescuento>\n'
                        . '        <CodigoDescuentoOTRO>' . $discount['reason'] . '</CodigoDescuentoOTRO>\n'
                        . '        <NaturalezaDescuento>' . $discount['reason'] . '</NaturalezaDescuento>\n'
                        . '    </Descuento>';
                }
            }

            $stringXML .= '\n    <SubTotal>' . $detail['subtotal'] . '</SubTotal>\n'
                . '    <BaseImponible>' . $detail['baseAmount'] . '</BaseImponible>';

            if (isset($detail['taxes']) && !empty($detail['taxes'])) {
                foreach ($detail['taxes'] as $tax) {
                    $stringXML .= '\n    <Impuesto>\n'
                        . '        <Codigo>' . $tax['code'] . '</Codigo>\n'
                        . '        <CodigoTarifaIVA>' . ($tax['rateCode'] ?? '') . '</CodigoTarifaIVA>\n'
                        . '        <Tarifa>' . ($tax['rate'] ?? 0) . '</Tarifa>\n'
                        . '        <Monto>' . $tax['amount'] . '</Monto>';

                    if (isset($tax['exemption'])) {
                        $stringXML .= '\n        <Exoneracion>\n'
                            . '            <TipoDocumento>' . $tax['exemption']['type'] . '</TipoDocumento>\n'
                            . '            <NumeroDocumento>' . $tax['exemption']['number'] . '</NumeroDocumento>\n'
                            . '            <NombreInstitucion>' . $tax['exemption']['institution']['name'] . '</NombreInstitucion>\n'
                            . '            <FechaEmision>' . date('c', strtotime($tax['exemption']['issueDate'])) . '</FechaEmision>\n'
                            . '            <PorcentajeExoneracion>' . $tax['exemption']['percentage'] . '</PorcentajeExoneracion>\n'
                            . '            <MontoExoneracion>' . $tax['exemption']['amount'] . '</MontoExoneracion>\n'
                            . '        </Exoneracion>';
                    }

                    $stringXML .= '\n    </Impuesto>';
                }
            }

            $stringXML .= '\n    <ImpuestoAsumidoEmisorFabrica>' . ($detail['factoryAssumedTax'] ?? 0) . '</ImpuestoAsumidoEmisorFabrica>\n'
                . '    <ImpuestoNeto>' . $detail['netTax'] . '</ImpuestoNeto>\n'
                . '    <MontoTotalLinea>' . $detail['totalAmountLine'] . '</MontoTotalLinea>\n'
                . '</LineaDetalle>';
        }
        $stringXML .= '\n</DetalleServicio>';
        return $stringXML;
    }

    private function createSummaryXml($document) {
        $summary = $document['summary'];
        $stringXML = '\n<ResumenFactura>\n'
            . '    <CodigoTipoMoneda>\n'
            . '        <CodigoMoneda>' . $summary['currencyCode']['currencyCode'] . '</CodigoMoneda>\n'
            . '        <TipoCambio>' . $summary['currencyCode']['exchangeRate'] . '</TipoCambio>\n'
            . '    </CodigoTipoMoneda>\n'
            . '    <TotalServGravados>' . $summary['taxedServices'] . '</TotalServGravados>\n'
            . '    <TotalServExentos>' . $summary['taxFreeServices'] . '</TotalServExentos>\n'
            . '    <TotalServExonerado>' . $summary['exemptServices'] . '</TotalServExonerado>\n'
            . '    <TotalServNoSujeto>' . $summary['nonTaxableServices'] . '</TotalServNoSujeto>\n'
            . '    <TotalMercanciasGravadas>' . $summary['taxedMerchandise'] . '</TotalMercanciasGravadas>\n'
            . '    <TotalMercanciasExentas>' . $summary['taxFreeMerchandise'] . '</TotalMercanciasExentas>\n'
            . '    <TotalMercExonerada>' . $summary['exemptMerchandise'] . '</TotalMercExonerada>\n'
            . '    <TotalMercNoSujeta>' . $summary['nonTaxableMerchandise'] . '</TotalMercNoSujeta>\n'
            . '    <TotalGravado>' . $summary['taxedTotal'] . '</TotalGravado>\n'
            . '    <TotalExento>' . $summary['taxFreeTotal'] . '</TotalExento>\n'
            . '    <TotalExonerado>' . $summary['exemptTotal'] . '</TotalExonerado>\n'
            . '    <TotalNoSujeto>' . $summary['nonTaxableTotal'] . '</TotalNoSujeto>\n'
            . '    <TotalVenta>' . $summary['saleTotal'] . '</TotalVenta>\n'
            . '    <TotalDescuentos>' . $summary['discountTotal'] . '</TotalDescuentos>\n'
            . '    <TotalVentaNeta>' . $summary['netTotal'] . '</TotalVentaNeta>';
            
        // Add tax breakdown from details
        $taxSummary = $this->getXmlTaxSummary($document['details']);
        foreach ($taxSummary as $tax) {
            $stringXML .= '\n    <TotalDesgloseImpuesto>\n'
                . '        <Codigo>' . $tax['taxType'] . '</Codigo>\n'
                . '        <CodigoTarifaIVA>' . $tax['taxRateCode'] . '</CodigoTarifaIVA>\n'
                . '        <TotalMontoImpuesto>' . $tax['taxAmount'] . '</TotalMontoImpuesto>\n'
                . '    </TotalDesgloseImpuesto>';
        }
        
        $stringXML .= '\n    <TotalImpuesto>' . $summary['taxTotal'] . '</TotalImpuesto>\n'
            . '    <TotalImpAsumEmisorFabrica>' . ($summary['totalFactoryTax'] ?? 0) . '</TotalImpAsumEmisorFabrica>\n'
            . '    <TotalIVADevuelto>' . $summary['returnedTax'] . '</TotalIVADevuelto>\n'
            . '    <TotalOtrosCargos>' . $summary['otherChargesTotal'] . '</TotalOtrosCargos>';
            
        // Add payment methods from document
        if (isset($document['payments']) && !empty($document['payments'])) {
            foreach ($document['payments'] as $payment) {
                $stringXML .= '\n    <MedioPago>\n'
                    . '        <TipoMedioPago>' . $payment['type'] . '</TipoMedioPago>\n'
                    . '        <MedioPagoOtros>' . ($payment['otherType'] ?? '') . '</MedioPagoOtros>\n'
                    . '        <TotalMedioPago>' . $payment['amount'] . '</TotalMedioPago>\n'
                    . '    </MedioPago>';
            }
        }
        
        $stringXML .= '\n    <TotalComprobante>' . $summary['voucherTotal'] . '</TotalComprobante>\n'
            . '</ResumenFactura>';
            
        return $stringXML;
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

        // Buscar la versión 4.4
        $documentVersion = null;
        foreach ($documentVersions as $version) {
            if ($version->versionNumber === '4.4') {
                $documentVersion = $version;
                break;
            }
        }
        
        // Si no se encuentra la versión 4.4, usar la primera disponible
        if ($documentVersion === null) {
            $documentVersion = $documentVersions[0];
        }

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

        /*if (!isset($response->error)) {
            $hacienda = new Hacienda($response->documentKey, $response->attachments->xmlDocument->data);

            $enviar = json_decode($hacienda->enviar());

            if ($enviar->status >= 200 && $enviar->status < 300) {
                //Obtener la fecha en gmt-6
                $fecha_gmt = date('Y-m-d\TH:i:s', strtotime('-6 hours'));

                $response->envio_atv = 1;
                //$data_factura['fecha_envio'] = $fecha_gmt;

                sleep(4);

                $validar = json_decode($hacienda->validar(), true);
                
                if (isset($validar['xml']['ind-estado'])) {
                    if ($validar['xml']['ind-estado'] != "procesando") {
                        $json = json_decode(json_encode(simplexml_load_string(base64_decode($validar['xml']['respuesta-xml']))));


                        // $data_validado = array(
                        //     'valido_atv' => $json->Mensaje,
                        //     'fecha_valido' => $fecha_gmt,
                        //     'detalle_atv' => $json->DetalleMensaje,
                        // );

                        //$data_factura['valido_atv'] = $json->Mensaje;
                        //$data_factura['fecha_valido'] = $fecha_gmt;
                        //$data_factura['detalle_atv'] = $json->DetalleMensaje;

                        $response->valido_atv = $json->Mensaje;
                        $response->fecha_valido = $fecha_gmt;
                        $response->detalle_atv = $json->DetalleMensaje;

                        /*if ($json->Mensaje != "procesando") {
                            $validated = true;
                        }
                    }
                }

                /*if ($validated) {
                    //$correo_enviado = $hacienda->enviar_documento($id_documento);

                    /*return json_encode(array(
                        'clave' => $response->documentKey,
                        "enviar" => $enviar->status,
                        "validar_estado" => $validar['xml']['ind-estado'],
                        "mensaje" => $json->Mensaje,
                        "validar_mensaje" => $json->DetalleMensaje,
                        //"correo_enviado" => $correo_enviado,
                        'estado' => 'success',
                    ));


                } else {
                    /*return json_encode(array(
                        'clave' => $response->documentKey,
                        "enviar" => $enviar->status,
                        "validar_estado" => $validar['xml']['ind-estado'],
                        "mensaje" => "Procesando",
                        "validar_mensaje" => "El documento se encuentra en proceso de validación",
                        //"correo_enviado" => false,
                        'estado' => 'warning',
                    ));
                }
            }
        }*/

        //return $response;
    }

    private function createKey($consecutivo, $emisor) {
        $cod = $emisor->codigo_telefono;
        $ced = $emisor->identificacion;

        $cedulaEmisor = str_pad($ced, 12, "0", STR_PAD_LEFT);

        $situacion = "1";

        $codigoSeguridad = substr(str_shuffle("0123456789"), 0, 8);

        return $cod . date('d') . date('m') . date('y') . $cedulaEmisor . $consecutivo . $situacion . $codigoSeguridad;
    }

    private function createConsecutive($documentType, $branchNumber, $terminalNumber, $consecutivo_object) {

        $id_factura = $consecutivo_object->consecutivo;
        $factura = str_pad($id_factura, 10, "0", STR_PAD_LEFT);

        //Rellenar con ceros 000 la sucursal
        $sucursal = str_pad($branchNumber, 3, "0", STR_PAD_LEFT);

        //Rellenar con ceros 00000 el punto de venta
        $terminal = str_pad($terminalNumber, 5, "0", STR_PAD_LEFT);

        $tipoDocumento = $documentType;

        return $sucursal . $terminal . $tipoDocumento . $factura;
    }

    /**
     * Crear el XML para un documento electrónico y almacenarlo en la base de datos
     */
    public function guardar_old($data) {
        if (is_login()) {
            $document = DocumentValidations::validateDocumentStructure($data);

            if (isset($document['error'])) {
                return (object) $document;
            }

            $taxpayersApi = $this->taxpayersApi;

            $documentType = $document['documentType'];
            $currencyCode = $document['currency']['currencyCode'];

            $currency = CurrenciesEnum::tryFrom($currencyCode);

            //Validar si es igual a CRC para colocar 1, o USD para ir a buscar
            if ($currency == CurrenciesEnum::CRC) {
                $tipo_cambio = 1;
            } elseif ($currency == CurrenciesEnum::USD) {
                $tipoCambioModel = new TipoCambioModel();
                $tipo_cambio = $tipoCambioModel->obtener($currencyCode);
            } else {
                $tipo_cambio = $document['currency']['exchangeRate'];
            }

            $condicion_venta = $document['saleCondition'];

            if ($condicion_venta == "02") {
                $dias = $document['creditTerm'];
            } else {
                $dias = 0;
            }

            $notas = $document['annotations'];

            $empresa = $taxpayersApi->getTaxpayerById(getTaxpayerId());

            //$empresasModel = new EmpresasModel();
            //$empresa = $empresasModel->getById(getSession('id_empresa'));

            if ($documentType != '08') {
                $emisor = $empresa;
                $receptor = $document['receiver'];
            } else {
                $emisor = $document['receiver'];
                $receptor = $empresa;
            }

            // Validate activity code matches issuer activities
            $activityCodeValid = false;
            if (isset($emisor->activities) && is_array($emisor->activities)) {
                foreach ($emisor->activities as $activity) {
                    if ($activity->code == $document['activityCode']) {
                        $activityCodeValid = true;
                        break;
                    }
                }
            }
            
            if (!$activityCodeValid) {
                return (object) array(
                    'error' => 'Activity code does not match issuer activities',
                    'status' => '400'
                );
            }

            $docType = DocumentTypesEnum::tryFrom($documentType);
            if (!$docType) {
                return json_encode(array(
                    'error' => 'Implementando documento',
                    'estado' => 'error'
                ));
            }

            $stringXML = '<?xml version="1.0" encoding="utf-8"?>
            <' . $docType->getXmlRoot() . '
                xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                xmlns:xsd="http://www.w3.org/2001/XMLSchema"
                xmlns="' . $docType->getXmlns(true) . '">';

            $consecutivosModel = new ConsecutivosModel();
            $consecutivo_object = $consecutivosModel->obtener_consecutivo($documentType, getEnt('factura.ambiente'));

            $consecutivo = $this->createConsecutive($documentType, $document['branchNumber'], $document['terminalNumber'], $consecutivo_object);

            $clave = $this->createKey($consecutivo, $empresa);

            //Colocar el emisor
            $stringXML .= '<Clave>' . $clave . '</Clave>
            <CodigoActividad>' . $document['activityCode'] . '</CodigoActividad>
            <NumeroConsecutivo>' . $consecutivo . '</NumeroConsecutivo>
            <FechaEmision>' . date("c") . '</FechaEmision>
            <Emisor>
                <Nombre>' . $emisor->businessName . '</Nombre>
                <Identificacion>
                    <Tipo>' . $emisor->identification->code . '</Tipo>
                    <Numero>' . $emisor->identification->number . '</Numero>
                </Identificacion>
                <NombreComercial>' . (isset($emisor->tradeName) ? $emisor->tradeName : '') . '</NombreComercial>
                <Ubicacion>
                    <Provincia>' . $emisor->residence->stateId . '</Provincia>
                    <Canton>' . str_pad($emisor->residence->countyId, 2, "0", STR_PAD_LEFT) . '</Canton>
                    <Distrito>' . str_pad($emisor->residence->districtId, 2, "0", STR_PAD_LEFT) . '</Distrito>
                    <OtrasSenas>' . $emisor->residence->address . '</OtrasSenas>
                </Ubicacion>
                <Telefono>
                    <CodigoPais>' . (isset($emisor->businessPhone) ? $emisor->businessPhone->areaCode : $emisor->personalPhone->areaCode) . '</CodigoPais>
                    <NumTelefono>' . (isset($emisor->businessPhone) ? $emisor->businessPhone->number : $emisor->personalPhone->number) . '</NumTelefono>
                </Telefono>
                <CorreoElectronico>' . $emisor->email . '</CorreoElectronico>
            </Emisor>';

            /**Si el documento no es un tiquete electronico, no agregar la informacion del cliente al archivo XML */
            if (isset($receptor)) {

                $stringXML .= '<Receptor>
                    <Nombre>' . $receptor->businessName . '</Nombre>
                    <Identificacion>
                        <Tipo>' . $receptor->identification->code . '</Tipo>
                        <Numero>' . $receptor->identification->number . '</Numero>
                    </Identificacion>
                    <NombreComercial>' . (isset($receptor->tradeName) ? $receptor->tradeName : '') . '</NombreComercial>';
                
                // Location is optional for receiver
                if (isset($receptor->residence)) {
                    $stringXML .= '
                    <Ubicacion>';
                    
                    if ($documentType == '08' || (isset($receptor->residence->stateId) && isset($receptor->residence->countyId) && isset($receptor->residence->districtId))) {
                        $stringXML .= '
                        <Provincia>' . $receptor->residence->stateId . '</Provincia>
                        <Canton>' . str_pad($receptor->residence->countyId, 2, "0", STR_PAD_LEFT) . '</Canton>
                        <Distrito>' . str_pad($receptor->residence->districtId, 2, "0", STR_PAD_LEFT) . '</Distrito>';
                    }
                    
                    $stringXML .= '
                        <OtrasSenas>' . $receptor->residence->address . '</OtrasSenas>
                    </Ubicacion>';
                }
                
                $stringXML .= '
                    <Telefono>
                        <CodigoPais>' . (isset($receptor->businessPhone) ? $receptor->businessPhone->areaCode : $receptor->personalPhone->areaCode) . '</CodigoPais>
                        <NumTelefono>' . (isset($receptor->businessPhone) ? $receptor->businessPhone->number : $receptor->personalPhone->number) . '</NumTelefono>
                    </Telefono>
                    <CorreoElectronico>' . $receptor->email . '</CorreoElectronico>
                </Receptor>';
            }

            $stringXML .= '
                <CondicionVenta>' . $condicion_venta . '</CondicionVenta>
                <PlazoCredito>' . $dias . '</PlazoCredito>';

            //                <MedioPago>' . $medioPago . '</MedioPago>

            //Recorrer medios de pago
            $mediosPago = $document['payments'];

            foreach ($mediosPago as $medioPago) {
                $stringXML .= '<MedioPago>' . $medioPago['type'] . '</MedioPago>';
            }

            $lineas_detalle = $document['details'];
            $detailsXml = $this->createDetailsXml($document, $lineas_detalle);
            $stringXML .= $detailsXml;

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

            $lineas_detalle = $document['details'];

            $cantidad_lineas = 1;

            if (isset($lineas_detalle) && !empty($lineas_detalle)) {
                foreach ($lineas_detalle as $linea_detalle) {
                    var_dump($linea_detalle);

                    //Si el codigo no esta vacio
                    if (isset($linea_detalle['cabys']) && $linea_detalle['cabys'] != "") {
                        $codigo = $linea_detalle['cabys'];
                        $cantidad_linea = $linea_detalle['quantity'];

                        $unidad_linea = $linea_detalle['measurementUnit'];
                        $detalle_linea = $linea_detalle['description'];

                        $precio_unitario_linea = $linea_detalle['netPrice'];
                        /*$monto_total_linea = $linea_detalle['totalAmount'];
                        $subtotal_linea = $linea_detalle['subTotal'];
                        $impuesto_neto_linea = $linea_detalle['taxAmount'];
                        $total_linea_linea = $linea_detalle['totalLine'];*/

                        //$codigo_venta_linea = $linea_detalle['code'];

                        $dataLinea = array(
                            'codigo' => $codigo,
                            'codigo_venta' => $codigo_venta_linea,
                            'cantidad' => $cantidad_linea,
                            'unidad' => $unidad_linea,
                            'detalle' => $detalle_linea,
                            'precio_unidad' => $precio_unitario_linea,
                            'monto_total' => $monto_total_linea,
                            'subtotal' => $subtotal_linea,
                            'linea' => $cantidad_lineas,
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
                            <NumeroLinea>' . $cantidad_lineas . '</NumeroLinea>
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

                        if (isset($linea_detalle['descuentos']) && !empty($linea_detalle['descuentos'])) {
                            $descuentos = $linea_detalle['descuentos'];

                            //Recorrer los descuentos
                            foreach ($descuentos as $linea_descuento) {
                                $descuento = $linea_descuento['amount'];
                                $motivo = $linea_descuento['reason'];

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
                            } //Fin del ciclo para recorrer los descuentos
                        }

                        $stringXML .= '
                            <SubTotal>' . $subtotal_linea . '</SubTotal>';

                        //Agregar el subtotal al dataLinea
                        $dataLinea['subtotal'] = $subtotal_linea;

                        if (isset($linea_detalle['taxes']) && !empty($linea_detalle['taxes'])) {
                            $impuestos = $linea_detalle['taxes'];

                            //Recorrer los impuestos
                            foreach ($impuestos as $linea_impuesto) {

                                //$codigo_impuesto = $codigos_impuesto[$linea_impuesto];
                                $codigo_impuesto = $linea_impuesto['code'];

                                if ($codigo_impuesto != "NA" && $codigo_impuesto != "") {

                                    /*$monto_impuesto = $montos_impuesto[$linea_impuesto];
                                $codigo_tarifa = $codigos_tarifa[$linea_impuesto];*/

                                    $monto_impuesto = $linea_impuesto['amount'];
                                    $codigo_tarifa = isset($linea_impuesto['rateCode']) ? $linea_impuesto['rateCode'] : "NA";

                                    if ($codigo_tarifa == "NA") {
                                        $codigo_tarifa = "";
                                    }

                                    $tarifa = isset($linea_impuesto['rate']) ? $linea_impuesto['rate'] : 0;


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

                                    //$tipo_exoneracion = $tipos_exoneracion[$linea_impuesto];

                                    //Si el monto de exoneracion es mayor a cero
                                    if (isset($linea_impuesto['excemption']) && $linea_impuesto['excemption']['amount'] > 0) {
                                        $tipo_exoneracion = $linea_impuesto['excemption']['type'];

                                        $monto_exoneracion = $linea_impuesto['excemption']['amount'];
                                        $numero_exoneracion = $linea_impuesto['excemption']['number'];
                                        $fecha_exoneracion = $linea_impuesto['excemption']['date'];
                                        $porcentaje_exoneracion = $linea_impuesto['excemption']['percentage'];
                                        $nombre_institucion = $linea_impuesto['excemption']['institutionName'];

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
                            } //Fin del ciclo para recorrer los impuestos
                        }

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

                    $cantidad_lineas++;
                } //Fin del ciclo para recorrer las lineas
            }


            $stringXML .= '
                </DetalleServicio>
                    <ResumenFactura>
                        <CodigoTipoMoneda>
                            <CodigoMoneda>' . $currencyCode . '</CodigoMoneda>
                            <TipoCambio>' . $tipo_cambio . '</TipoCambio>
                        </CodigoTipoMoneda>';

            $stringXML .= '
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

            // $stringXML .= '
            //             <Otros>
            //                 <OtroTexto codigo="WMNumeroVendedor">' . $numero_vendor . '</OtroTexto>
            //                 <OtroTexto codigo="WMNumeroOrden">' . $numero_orden . '</OtroTexto>
            //                 <OtroTexto codigo="WMEnviarGLN">' . $enviar_gln . '</OtroTexto>
            //             </Otros>';

            //Validar si vienen otherFields y agregarlos a la factura
            if (isset($document['otherFields']) && count($document['otherFields']) > 0) {
                $stringXML .= '
                    <Otros>';

                foreach ($document['otherFields'] as $value) {
                    $stringXML .= '
                        <OtroTexto codigo="' . $value['code'] . '">' . $value['value'] . '</OtroTexto>';
                }
                $stringXML .= '
                    </Otros>';

                $other_fields = $document['otherFields'];
            }

            //Validar si vienen referencias para agregarlas
            if (isset($document['references']) && count($document['references']) > 0) {
                foreach ($document['references'] as $value) {
                    $stringXML .= '
                        <InformacionReferencia>
                            <TipoDoc>' . $value['type'] . '</TipoDoc>
                            <Numero>' . $value['number'] . '</Numero>
                            <FechaEmision>' . date("c", strtotime($value['date'])) . '</FechaEmision>
                            <Codigo>' . $value['code'] . '</Codigo>
                            <Razon>' . $value['reason'] . '</Razon>
                        </InformacionReferencia>';
                }

                $document_references = $document['references'];
            }

            $stringXML .= '</' . $docType->getXmlRoot() . '>';

            $hacienda = new Hacienda($clave);

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

            /**Si el documento no es un tiquete electronico y hay un receptor asignado,
             * agregar informacion del cliente en la factura */
            if (isset($receptor)) {
                $data_factura = array(
                    "consecutivo" => $consecutivo,
                    "tipo_documento" => $documentType,
                    "clave" => $clave,
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
                    "medio_pago" => $medioPago,
                    "moneda" => $currencyCode,
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
                    "tipo_documento" => $documentType,
                    "clave" => $clave,
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
                    "medio_pago" => $medioPago,
                    "moneda" => $currencyCode,
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
            }

            if ($enviar->status >= 200 && $enviar->status < 300) {
                //Obtener la fecha en gmt-6
                $fecha_gmt = date('Y-m-d\TH:i:s', strtotime('-6 hours'));

                $data_factura['envio_atv'] = 1;
                $data_factura['fecha_envio'] = $fecha_gmt;

                sleep(4);

                $validar = json_decode($hacienda->validar(), true);
                $validated = false;

                if (isset($validar['xml']['ind-estado'])) {
                    if ($validar['xml']['ind-estado'] != "procesando") {
                        $json = json_decode(json_encode(simplexml_load_string(base64_decode($validar['xml']['respuesta-xml']))));


                        // $data_validado = array(
                        //     'valido_atv' => $json->Mensaje,
                        //     'fecha_valido' => $fecha_gmt,
                        //     'detalle_atv' => $json->DetalleMensaje,
                        // );

                        $data_factura['valido_atv'] = $json->Mensaje;
                        $data_factura['fecha_valido'] = $fecha_gmt;
                        $data_factura['detalle_atv'] = $json->DetalleMensaje;

                        if ($json->Mensaje == "procesando") {
                            $validated = false;
                        } else {
                            $validated = true;
                        }
                    }
                }
            }

            $documentosModel = model('documento');

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

                    //Si no se pudo insertar el detalle, se elimina el documento
                    if (!$id_detalle) {
                        $documentosModel = model('documento');
                        $documentosModel->delete($id_documento);

                        return json_encode(array(
                            'status' => 'error',
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
                                    $documentosModel = model('documento');
                                    $documentosModel->delete($id_documento);

                                    return json_encode(array(
                                        'status' => 'error',
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
                                        $documentosModel = model('documento');
                                        $documentosModel->delete($id_documento);

                                        return json_encode(array(
                                            'status' => 'error',
                                            'error' => 'Error al insertar el descuento de la factura',
                                        ));
                                    }
                                } //Fin de validacion de monto
                            } //Fin de foreach de descuentos
                        } //Fin de validacion de descuentos
                    } //Fin de caso de insercion de detalle
                } //Fin de ciclo para insertar lineas de detalle

                //Si viene otros campos, insertarlos
                if (isset($other_fields)) {
                    foreach ($other_fields as $other_field) {
                        $data_otros = array(
                            "id_documento" => $id_documento,
                            "codigo" => $other_field['code'],
                            "valor" => $other_field['value']
                        );

                        $documentosOtrosModel = model('documentoOtros');
                        $documentosOtrosModel->insert($data_otros);
                    }
                }

                //Si vienen referencias
                if (isset($document_references)) {
                    foreach ($document_references as $reference) {
                        $data_referencia = array(
                            "id_documento" => $id_documento,
                            "referencia_tipo_documento" => $reference['referencia_tipo_documento'],
                            "referencia_clave" => $reference['referencia_clave'],
                            "referencia_fecha" => $reference['referencia_fecha'],
                            "referencia_codigo" => $reference['referencia_codigo'],
                            "referencia_razon" => $reference['referencia_razon'],
                        );

                        $documentosReferenciasModel = model('documentoReferencias');
                        $documentosReferenciasModel->insert($data_referencia);
                    }
                }


                if ($validated) {
                    $correo_enviado = $hacienda->enviar_documento($id_documento);

                    return json_encode(array(
                        'clave' => $id_documento,
                        "enviar" => $enviar->status,
                        "validar_estado" => $validar['xml']['ind-estado'],
                        "mensaje" => $json->Mensaje,
                        "validar_mensaje" => $json->DetalleMensaje,
                        "correo_enviado" => $correo_enviado,
                        'estado' => 'success',
                    ));
                } else {
                    return json_encode(array(
                        'clave' => $id_documento,
                        "enviar" => $enviar->status,
                        "validar_estado" => $validar['xml']['ind-estado'],
                        "mensaje" => "Procesando",
                        "validar_mensaje" => "El documento se encuentra en proceso de validación",
                        "correo_enviado" => false,
                        'estado' => 'warning',
                    ));
                }
            } //Fin de validacion de insercion y envio de correo

            else {
                return json_encode(array(
                    'error' => 'Error al insertar el documento',
                    'estado' => 'error',
                ));
            }
        } //Fin de validacion de logueo

        else
            return json_encode(array(
                'error' => 'No ha iniciado sesion'
            ));
    } //Fin de la funcion create

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

    /**
     * Create tax summary from document details
     */
    private function getXmlTaxSummary($details) {
        $taxSummaryList = [];
        
        foreach ($details as $detail) {
            if (isset($detail['taxes']) && !empty($detail['taxes'])) {
                foreach ($detail['taxes'] as $tax) {
                    $amount = $tax['amount'];
                    $taxType = TaxTypesEnum::tryFrom($tax['code']);
                    
                    // Apply business rules for amount calculation
                    if ($taxType && $taxType->isForBaseAmount() && !isset($detail['factoryTax'])) {
                        $amount = 0.0;
                    } elseif ($taxType && $taxType->isForFactoryTax() && !isset($detail['factoryTax'])) {
                        $amount = 0.0;
                    } elseif (isset($tax['exemption'])) {
                        $amount -= $tax['exemption']['amount'];
                    }
                    
                    $key = $tax['code'] . '_' . ($tax['rateCode'] ?? 'null');
                    
                    if (isset($taxSummaryList[$key])) {
                        $taxSummaryList[$key]['taxAmount'] += $amount;
                    } else {
                        $taxSummaryList[$key] = [
                            'taxType' => $tax['code'],
                            'taxRateCode' => $tax['rateCode'] ?? '',
                            'taxAmount' => $amount
                        ];
                    }
                }
            }
        }
        
        // Sort by tax type and rate code
        uasort($taxSummaryList, function($a, $b) {
            if ($a['taxType'] === $b['taxType']) {
                return strcmp($a['taxRateCode'], $b['taxRateCode']);
            }
            return strcmp($a['taxType'], $b['taxType']);
        });
        
        return array_values($taxSummaryList);
    }
}
