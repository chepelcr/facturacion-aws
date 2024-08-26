<?php

namespace App\Controllers;

use App\Librerias\Correo;
use App\Librerias\Hacienda;
use App\Librerias\Myqr;
use App\Librerias\Pdf_Manager;
use App\Librerias\Reportes;
use App\Models\ClientesModel;
use App\Models\ConsecutivosModel;
use App\Models\DocumentoModel;
use App\Models\EmpresasModel;
use App\Models\ProductosModel;
use App\Models\TipoCambioModel;
use Core\Config\Header;
use DOMDocument;

class Documentos extends BaseController
{
    /**Cargar los documentos electronicos */
    public function index()
    {
        if (is_login()) {
            $script = cargar('cargar_inicio_modulo("documentos");');

            $data = array(
                'script' => $script,
            );

            return $this->inicio($data);
        } //Fin de la validacion

        else
            redirect(baseUrl('login'));
    } //Fin de la funcion index

    /**Abrir el submodulo de ventas*/
    public function facturacion()
    {
        if (is_login()) {
            $script = cargar('cargar_inicio_modulo("documentos"); agregar_documento("factura");');

            $data = array(
                'script' => $script,
            );

            return $this->inicio($data);
        } //Fin de la validacion

        else
            redirect(baseUrl('login'));
    } //Fin de la funcion facturacion

    /**Cargar documentos emitidos */
    public function emitidos()
    {
        if (is_login()) {
            $script = cargar('cargar_inicio_modulo("documentos");');

            $data = array(
                'script' => $script,
            );

            return $this->inicio($data);
        } //Fin de la validacion

        else
            redirect(baseUrl('login'));
    } //Fin de la funcion emitidos

    /**Abrir el submodulo de importar */
    public function importar()
    {
        if (is_login()) {
            if (getSegment(3) == 'form') {
                return view('facturacion/elementos/importar');
            } else {
                $script = cargar('importar_documentos();');

                $data = array(
                    'script' => $script,
                );

                return $this->inicio($data);
            }
        } //Fin de la validacion

        else
            redirect(baseUrl('login'));
    } //Fin de la funcion importar

    /**Validar el estado los documentos que se encuentran en proceso en el ministerio de hacienda */
    public function validar_documentos()
    {
        if (!is_login()) {
            return json_encode(array(
                'error' => 'login',
                'status' => 'warning'
            ));
        } //Fin de la validacion de login

        $hacienda = new Hacienda();

        $documentoModel = model('documento');
        $documentos = $documentoModel->obtener('proceso');

        $validados = true;

        foreach ($documentos as $documento) {
            $validar = json_decode($hacienda->validar($documento->clave), true);

            if (isset($validar['xml']['ind-estado'])) {
                $fecha_gmt = date('Y-m-d\TH:i:s', strtotime('-6 hours'));

                if ($validar['xml']['ind-estado'] != "procesando") {
                    $json = json_decode(json_encode(simplexml_load_string(base64_decode($validar['xml']['respuesta-xml']))));

                    $data_validado = array(
                        'valido_atv' => $json->Mensaje,
                        'detalle_atv' => $json->DetalleMensaje,
                        'fecha_valido' => $fecha_gmt,
                    );

                    $documentosModel = model('documento');
                    $documentosModel->update($data_validado, $documento->id_documento);

                    $hacienda->enviar_documento($documento->id_documento);

                    $validados = true;
                }

                if ($validar['xml']['ind-estado'] == "procesando") {
                    $validados = false;
                }
            } else
                $validados = false;
        } //Fin del ciclo de documentos

        if ($validados) {
            $data = array(
                'status' => 'success',
            );
        } else {
            $data = array(
                'status' => 'error',
            );
        }

        return json_encode($data);
    } //Fin de la funcion validar_documentos

    /**Obtener los indicadores de compra y venta desde el banco central */
    public function indicadores()
    {
        return json_encode(obtenerInidicadores(getSegment(3)));
    } //Fin de la funcion indicadores

    /**Enviar un documento por correo electronico */
    public function enviar_documento()
    {
        if (is_login()) {
            $data = array(
                'status' => 'error',
                'error' => 'No se pudo enviar el documento',
            );

            if (getSegment(3)) {
                $id_documento = getSegment(3);

                $hacienda = new Hacienda();

                if ($hacienda->enviar_documento($id_documento)) {
                    $data = array(
                        'status' => 'success',
                        'mensaje' => 'Documento enviado correctamente',
                    );
                }
            }

            return json_encode($data);
        }

        return redirect(baseUrl());
    }

    /**Cargar los documentos de la empresa */
    public function cargar_documentos()
    {
        if (is_login()) {
            $model = new DocumentoModel();
            $model->empresa(getSession('id_empresa'));

            $id_tipo_documento = post('id_tipo_documento');

            $fecha_inicio = null;
            $fecha_fin = null;

            $model->tipo_documento($id_tipo_documento);

            //Validar si se estan consultando documentos emitidos o recibidos
            $tipo_documento = getSegment(3);

            $model->documentos($tipo_documento);

            if (getSegment(4)) {
                $tipo_reporte = getSegment(4);

                if ($tipo_reporte == 'busqueda') {
                    $documentos = $model->busqueda(post('fecha_inicio'), post('fecha_fin'));
                    $tipo_reporte = post('tipo_reporte');
                } else {
                    $documentos = $model->obtener($tipo_reporte);
                }
            } else {
                $tipo_reporte = 'diarios';
                $documentos = $model->obtener($tipo_reporte);
            }

            $model = model('tiposDocumentos');

            $dataView = array(
                'documentos' => $documentos,
                'tipo_reporte' => $tipo_reporte,
                'tipos_documentos' => $model->obtener('documentos'),
                'fecha_inicio' => $fecha_inicio,
                'fecha_fin' => $fecha_fin,
                'id_tipo_documento' => $id_tipo_documento,
            );

            return view('facturacion/table/documentos', $dataView);
        } else {
            $error = $this->object_error(505, 'No ha iniciado sesión');
            return $this->error($error);
        }
    }

    /**Validar el estado de un documento en el ministerio de hacienda */
    public function validar_documento()
    {
        if (is_login()) {
            if (getSegment(3)) {
                $id_documento = getSegment(3);

                $model = model('documento');

                $documento = $model->obtener($id_documento);

                if ($documento) {
                    $hacienda = new Hacienda();
                    $validar = json_decode($hacienda->validar($documento->clave), true);

                    if (isset($validar['xml']['ind-estado'])) {
                        $fecha_gmt = date('Y-m-d\TH:i:s', strtotime('-6 hours'));

                        if ($validar['xml']['ind-estado'] != "procesando") {
                            $json = json_decode(json_encode(simplexml_load_string(base64_decode($validar['xml']['respuesta-xml']))));

                            $data_validado = array(
                                'valido_atv' => $json->Mensaje,
                                'detalle_atv' => $json->DetalleMensaje,
                                'fecha_valido' => $fecha_gmt,
                            );

                            $documentosModel = model('documento');
                            $documentosModel->update($data_validado, $id_documento);

                            $correo_enviado = $hacienda->enviar_documento($id_documento);

                            return json_encode(array(
                                'clave' => $id_documento,
                                "validar_estado" => $validar['xml']['ind-estado'],
                                "mensaje" => $json->Mensaje,
                                "validar_mensaje" => $json->DetalleMensaje,
                                'estado' => 'success',
                                'correo_enviado' => $correo_enviado,
                            ));
                        } else {
                            return json_encode(array(
                                'clave' => $id_documento,
                                "validar_estado" => $validar['xml']['ind-estado'],
                                "mensaje" => "2",
                                "validar_mensaje" => "Procesando documento",
                                'estado' => 'warning',
                                'correo_enviado' => false,
                            ));
                        }
                    } else {
                        return json_encode(array(
                            'clave' => $id_documento,
                            "validar_estado" => 'procesando',
                            "mensaje" => "2",
                            "validar_mensaje" => "Procesando documento",
                            'estado' => 'warning',
                            'correo_enviado' => false,
                        ));
                    }
                }
            }

            return json_encode(array(
                'error' => 'El documento solicitado no existe',
                'estado' => 'warning',
            ));
        }

        return json_encode(array(
            'error' => 'No ha iniciado sesion',
            'estado' => 'info',
        ));
    }

    /**Enviar un documento al ministerio de hacienda */
    public function enviar_hacienda()
    {
        if (!is_login()) {
            return json_encode(array(
                'status' => 'error',
                'error' => 'login'
            ));
        }

        $documentoModel = model('documento');
        $documento = $documentoModel->obtener(getSegment(3));

        if ($documento) {
            $hacienda = new Hacienda($documento->clave);

            $enviar = json_decode($hacienda->enviar());

            if ($enviar->status >= 200 && $enviar->status < 300) {
                //Obtener la fecha en gmt-6
                $fecha_gmt = date('Y-m-d\TH:i:s', strtotime('-6 hours'));

                $data_envio = array(
                    'envio_atv' => 1,
                    'fecha_envio' => $fecha_gmt,
                );

                $documentosModel = model('documento');
                $documentosModel->update($data_envio, $documento->id_documento);

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

                        $documentosModel = model('documento');
                        $documentosModel->update($data_validado, $documento->id_documento);

                        $correo_enviado = $hacienda->enviar_documento($documento->id_documento);

                        return json_encode(array(
                            'clave' => $documento->id_documento,
                            "enviar" => $enviar->status,
                            "validar_estado" => $validar['xml']['ind-estado'],
                            "mensaje" => $json->Mensaje,
                            "validar_mensaje" => $json->DetalleMensaje,
                            "correo_enviado" => $correo_enviado,
                            'estado' => 'success',
                        ));
                    } else {
                        return json_encode(array(
                            'clave' => $documento->id_documento,
                            "enviar" => $enviar->status,
                            "validar_estado" => $validar['xml']['ind-estado'],
                            "mensaje" => "Procesando",
                            "validar_mensaje" => "El documento se encuentra en proceso de validación",
                            "correo_enviado" => false,
                            'estado' => 'warning',
                        ));
                    }
                } else {
                    return json_encode(array(
                        'clave' => $documento->id_documento,
                        "enviar" => $enviar->status,
                        "validar_estado" => 'procesando',
                        "mensaje" => "Procesando",
                        "validar_mensaje" => 'El documento se encuentra en proceso de validación',
                        "correo_enviado" => false,
                        'estado' => 'error',
                    ));
                }
            } else {
                return json_encode(array(
                    'clave' => $documento->id_documento,
                    "enviar" => $enviar->status,
                    "validar_estado" => "",
                    "mensaje" => "Error",
                    "error" => 'Se ha generado un error al enviar la factura al Ministerio de Hacienda',
                    "correo_enviado" => false,
                    'estado' => 'error',
                ));
            }
        }
    } //Fin de la function para enviar un documento al ministerio de hacienda


    /**Esperar la respuesta del Ministerio de Hacienda 
     * @header Content-Type: application/json
     * @post {
            "clave": "50601011600310112345600100010100000000011999999999",
            "fecha": "2016-01-01T00:00:00-0600",
            "ind-estado": "aceptado",
            "respuesta-xml": "PD94bWwgdmVyc2lvbj0iMS4wIiA/Pg0KDQo8ZG9tYWluIHhtbG5zPSJ1cm46amJvc3M6ZG9tYWluOjQuMCI+DQogICAgPGV4dGVuc2lvbnM+DQogICAgICAgIDxleHRlbnNpb24gbW9kdWxlPSJvcmcuamJvc3MuYXMuY2x1c3RlcmluZy5pbmZpbmlzcGFuIi8+DQogICAgICAgIDxleHRlbnNpb24gbW9kdWxlPSJvcmcuamJvc3MuYXMuY2x1c3RlcmluZy5qZ3JvdXBzIi8+DQogICAgICAgIDxleHRlbnNpb24gbW9kdWxlPSJvcmcuamJvc3MuYXMuY29ubmVjdG9yIi8+DQogICAgICAgIDxleHRlbnNpb24gbW..."
            }
     */
    public function esperar_respuesta()
    {
        //Colocar el header para que el navegador sepa que es un json
        header('Content-Type: application/json');

        $clave = getSegment(3);

        //Decodificar la clave
        $clave = base64_decode($clave);

        $respuesta = post();

        $hacienda = new Hacienda($clave);

        $hacienda->validar_respuesta($respuesta);
    }

    /**Obtener todos los productos */
    public function get_productos()
    {
        if (is_login()) {
            $model = model('productos');

            $model->where('id_empresa', getSession('id_empresa'));

            $productos = $model->obtener('activos');

            $dataView = array(
                'productos' => $productos,
            );

            return view('facturacion/table/productos', $dataView);
        }

        $error = $this->object_error(505, 'No ha iniciado sesión');
        return $this->error($error);
    } //Fin de la funcion get_productos

    /**Obtener todos los clientes */
    public function get_clientes()
    {
        if (is_login()) {
            $model = model('clientes');

            $model->where('id_empresa', getSession('id_empresa'));

            $clientes = $model->obtener('activos');

            $dataView = array(
                'clientes' => $clientes,
            );

            return view('facturacion/table/clientes', $dataView);
        }

        $error = $this->object_error(505, 'No ha iniciado sesión');
        return $this->error($error);
    } //Fin de la funcion get_clientes

    /**Emitir un tiquete electronico */
    public function tiquete()
    {
        if (is_login()) {
            $id_tipo_documento = '04';

            $numero_documento = getSegment(3);

            return documento($id_tipo_documento, $numero_documento);
        } //Fin de la validacion

        else
            header('Location: ' . baseUrl());
    } //Fin de la funcion para emitir un tiquete electronico

    /**Emitir una factura electronica */
    public function factura()
    {
        if (is_login()) {

            $numero_documento = getSegment(3);

            $id_tipo_documento = '01';

            return documento($id_tipo_documento, $numero_documento);
        } //Fin de la validacion

        else
            header('Location: ' . baseUrl());
    } //Fin de la funcion para emitir una factura electronica

    /**Emitir una factura electronica de compra */
    public function factura_compra()
    {
        if (is_login()) {

            $numero_documento = getSegment(3);

            $id_tipo_documento = '08';

            return documento($id_tipo_documento, $numero_documento);
        } //Fin de la validacion

        else
            header('Location: ' . baseUrl());
    } //Fin de la funcion para emitir una factura electronica de compra

    /** Emitir una factura de exportacion */
    public function factura_exportacion()
    {
        if (is_login()) {
            $numero_documento = getSegment(3);

            $id_tipo_documento = '09';

            return documento($id_tipo_documento, $numero_documento);
        } else
            header('Location: ' . baseUrl());
    } //Fin de la funcion para emitir una factura de exportacion

    /**Emitir una nota de credito (03) */
    public function nota_credito()
    {
        if (is_login()) {

            $numero_documento = getSegment(3);

            $id_tipo_documento = '03';

            return documento($id_tipo_documento, $numero_documento);
        } //Fin de la validacion

        else
            header('Location: ' . baseUrl());
    } //Fin de la funcion para emitir una nota de credito

    /**Emitir una nota de debito (02) */
    public function nota_debito()
    {
        if (is_login()) {

            $numero_documento = getSegment(3);

            $id_tipo_documento = '02';

            return documento($id_tipo_documento, $numero_documento);
        } //Fin de la validacion

        else
            header('Location: ' . baseUrl());
    } //Fin de la funcion para emitir una nota de debito

    /**Obtener un boton para el nuevo documento */
    public function get_boton()
    {
        if (is_login()) {
            $numero_documento = getSegment(3);

            $boton = view('facturacion/elementos/boton', array('numero_documento' => $numero_documento));

            return $boton;
        } //Fin de la validacion

        else
            header('Location: ' . baseUrl());
    } //Fin de la funcion get_boton

    /**Buscar un cliente por identificacion */
    public function buscar_cliente()
    {
        if (is_login()) {
            if (getSegment(3)) {
                $identificacion = getSegment(3);
                $identificacion = desformatear_cedula($identificacion);

                $clientesModel = new ClientesModel();
                $cliente = $clientesModel->getByIdentificacion($identificacion);

                if ($cliente)
                    return json_encode($cliente);

                else
                    $data = array(
                        'error' => 'No se encontro el cliente',
                    );
            } else
                $data = array(
                    'error' => 'No se encontro el cliente',
                );
        } //Fin de la validacion

        else
            $data = array(
                'error' => 'No ha iniciado sesión'
            );

        return json_encode($data);
    } //Fin de la funcion buscar_cliente

    /**Obtener un documento en pdf */
    public function ver_pdf()
    {
        if (is_login()) {
            $clave = getSegment(3);

            //$dataPdf = $this->getPdfInfo($clave);

            $dataView = array(
                'clave' => $clave,
            );

            $nombreVista = 'facturacion/modal/imprimir_pdf';

            return view($nombreVista, $dataView);
        } else
            header('Location: ' . baseUrl());
    }

    /**Guardar un  documento electronico*/
    public function guardar($objeto = null)
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

            /**Validar si el documento tiene detalles */
            if ($cantidad_lineas == 0) {
                return json_encode(array(
                    "error" => "No se puede emitir un comprobante sin detalle",
                    'tipo' => 'detalles',
                    "estado" => "error"
                ));
            } //Fin de validacion de detalles

            $id_tipo_documento = post('id_tipo_documento');

            $moneda = post('moneda');
            $tipo_cambio = post('tipo_cambio');

            if (!$tipo_cambio) {
                $tipoCambioModel = new TipoCambioModel();
                $tipo_cambio = $tipoCambioModel->obtener($moneda);
            }

            //Medio de pago
            $medioPago = post('medio_pago');

            if (!isset($medioPago) || !$medioPago || $medioPago == '') {
                return json_encode(array(
                    'error' => 'Debe seleccionar al menos un medio de pago',
                    'estado' => 'error'
                ));
            }

            $condicion_venta = post('condicion_venta');

            if (!isset($condicion_venta) || !$condicion_venta || $condicion_venta == '') {
                return json_encode(array(
                    'error' => 'Debe seleccionar una condicion de venta',
                    'estado' => 'error'
                ));
            }

            $dias = 0;

            if ($condicion_venta == "02") {
                $dias = 30;
            }

            $consecutivosModel = new ConsecutivosModel();
            $consecutivo_object = $consecutivosModel->obtener_consecutivo($id_tipo_documento, getEnt('factura.ambiente'));

            $id_factura = $consecutivo_object->consecutivo;
            $factura = str_pad($id_factura, 10, "0", STR_PAD_LEFT);

            $sucursal = getent('factura.sucursal');
            $pv = getent('factura.punto_venta');

            //Rellenar con ceros 000 la sucursal
            $sucursal = str_pad($sucursal, 3, "0", STR_PAD_LEFT);

            //Rellenar con ceros 00000 el punto de venta
            $pv = str_pad($pv, 5, "0", STR_PAD_LEFT);

            $tipoDocumento = $id_tipo_documento;

            $consecutivo = $sucursal . $pv . $tipoDocumento . $factura;

            $notas = post('notas');

            $empresasModel = new EmpresasModel();
            $emisor = $empresasModel->getById(getSession('id_empresa'));

            $cod = $emisor->codigo_telefono;
            $ced = $emisor->identificacion;
            $cedulaEmisor = str_pad($ced, 12, "0", STR_PAD_LEFT);
            $situacion = "1";

            $codigoSeguridad = substr(str_shuffle("0123456789"), 0, 8);

            $clave = $cod . date('d') . date('m') . date('y') . $cedulaEmisor . $consecutivo . $situacion . $codigoSeguridad;

            $id_cliente = post('identificacion-cliente');

            //Si el tipo de documento es 01, 08 o 09 y no se ha seleccionado un cliente
            if ($id_tipo_documento == '01' || $id_tipo_documento == '08' || $id_tipo_documento == '09') {
                if (!isset($id_cliente) || $id_cliente == '') {
                    return json_encode(array(
                        'error' => 'Debe seleccionar un cliente',
                        'tipo' => 'cliente',
                        'estado' => 'error'
                    ));
                }
            }


            if(isset($id_cliente) && $id_cliente != ''){
                $id_cliente = desformatear_cedula($id_cliente);

                $clientesModel = new ClientesModel();
                $receptor = $clientesModel->getByIdentificacion($id_cliente);
            } else {
                $receptor = null;
            }

            //Validar el tipo de documento
            switch ($id_tipo_documento) {
                    /**Factura electronica */
                case '01':
                    //Validar si el cliente existe en la tabla de clientes
                    if (!isset($receptor)) {
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
                        'error' => 'Implementando documento',
                        'estado' => 'error'
                    ));
            }

            $stringXML .= '<Clave>' . $clave . '</Clave>
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

            /**Si el documento no es un tiquete electronico, no agregar la informacion del cliente al archivo XML */
            if ($id_tipo_documento != '04' && $receptor) {

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
                <MedioPago>' . $medioPago . '</MedioPago>
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

            /**Si el documento no es un tiquete electronico y hay un receptor asignado,
             * agregar informacion del cliente en la factura */
            if ($id_tipo_documento != '04' && $receptor) {
                $data_factura = array(
                    "consecutivo" => $consecutivo,
                    "tipo_documento" => $id_tipo_documento,
                    "clave" => $clave,
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
                    "medio_pago" => $medioPago,
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
                    "tipo_documento" => $id_tipo_documento,
                    "clave" => $clave,
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
                    "medio_pago" => $medioPago,
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

                //Validar el tipo de documento
                switch ($id_tipo_documento) {
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

                if ($enviar->status >= 200 && $enviar->status < 300) {
                    //Obtener la fecha en gmt-6
                    $fecha_gmt = date('Y-m-d\TH:i:s', strtotime('-6 hours'));

                    $data_envio = array(
                        'envio_atv' => 1,
                        'fecha_envio' => $fecha_gmt,
                    );

                    $documentosModel = model('documento');
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

                            $documentosModel = model('documento');
                            $documentosModel->update($data_validado, $id_documento);

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
                    } else {
                        return json_encode(array(
                            'clave' => $id_documento,
                            "enviar" => $enviar->status,
                            "validar_estado" => 'procesando',
                            "mensaje" => "Procesando",
                            "validar_mensaje" => 'El documento se encuentra en proceso de validación',
                            "correo_enviado" => false,
                            'estado' => 'error',
                        ));
                    }
                } else {
                    return json_encode(array(
                        'clave' => $id_documento,
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

    /**Obtener el modal de agregar los elementos de Walmart */
    public function get_walmart()
    {
        if (is_login()) {
            return view('facturacion/modal/walmart', getInfoWalmart());
        } else
            return json_encode(array(
                'error' => 'No ha iniciado sesion'
            ));
    } //Fin de la funcion get_walmart

    /**Descargar un documento en pdf */
    public function descargar_pdf()
    {
        if (is_login()) {
            $clave = getSegment(3);

            $pdf = new Pdf_Manager();

            $dataPdf = $this->getPdfInfo($clave);

            if ($dataPdf) {
                $pdf->download_view("pdfs/facturaPDF", $dataPdf);
            } //Fin de la validacion del documento

            else {
                return $this->error(array(
                    'error' => 'Documento no encontrado',
                    'codigo' => '404',
                    'status' => 'error'
                ));
            }
        } else {
            return redirect(baseUrl('login'));
        }
    } //Fin de la funcion para descargar un documento

    /**Descargar un archivo zip */
    public function descargar_zip()
    {
        if (is_login()) {
            if (getSegment(3)) {
                $nombre_archivo = getSegment(3);
                $ruta = location('archivos\\reportes\\' . $nombre_archivo);

                if (file_exists($ruta)) {
                    header('Content-Type: application/Force-Download');
                    header('Content-Disposition: attachment; filename="' . $nombre_archivo . '"');
                    header('Content-Length: ' . filesize($ruta));
                    readfile($ruta);

                    unlink($ruta);

                    exit;
                }
            }
        }

        header('Location: ' . baseUrl());
    } //Fin de la funcion  para descargar un archivo zip

    private function getPdfInfo($clave)
    {

        $qr = new Myqr();

        $DocumentosModel = new DocumentoModel();

        $documento = $DocumentosModel->obtener($clave);

        if ($documento) {
            $detalles = $documento->detalles;

            $dataQR = array(
                'url' => baseUrl("documentos/pdf/" . $clave),
            );

            $qrCodigo = $qr->codigoQR($dataQR);

            $arrContextOptions = array(
                "ssl" => array(
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                ),
            );

            $logoImg = file_get_contents(getFile('dist/img/logo.png'), false, stream_context_create($arrContextOptions));

            $logo = base64_encode($logoImg);

            $nombreArchivo = "/pdf/Documento " . $documento->clave . ".pdf";

            return array(
                'nombre_archivo' => $nombreArchivo,
                'documento' => $documento,
                'detalles' => $detalles,
                "qrCodigo" => $qrCodigo,
                "logo" => $logo,
            );
        } else {
            return false;
        }
    }

    /** Ver un documento pdf en el navegador */
    public function pdf()
    {
        $clave = getSegment(3);
        $dataPdf = $this->getPdfInfo($clave);

        if ($dataPdf) {
            Header::pdf();

            $pdf = new Pdf_Manager();
            $pdf->load_view("pdfs/facturaPDF", $dataPdf);
        } else {
            return $this->error(array(
                'error' => 'Documento no encontrado',
                'codigo' => '404',
                'status' => 'error'
            ));
        }
    } //Fin del metodo para generar un pdf

    public function pdf_ticket()
    {
        $clave = getSegment(3);
        $dataPdf = $this->getPdfInfo($clave);

        if ($dataPdf) {
            Header::pdf();

            $pdf = new Pdf_Manager();
            $pdf->load_ticket("pdfs/impresionPDF", $dataPdf);
        } else {
            return $this->error(array(
                'error' => 'Documento no encontrado',
                'codigo' => '404',
                'status' => 'error'
            ));
        }
    } //Fin del metodo para generar un pdf

    /**Buscar un producto por codigo en la base de datos */
    function buscar_producto()
    {
        if (is_login()) {
            if (getSegment(3)) {
                $productosModel = new ProductosModel();
                return json_encode($productosModel->getByGnl(getSegment(3)));
            }

            return false;
        } else
            return json_encode(array(
                'error' => 'Debe iniciar sesión para continuar'
            ));
    } //Fin de la funcion buscar_producto

    public function reporte()
    {
        if (is_login()) {
            $claves = array();

            $reporte = new Reportes();

            foreach ($_POST['documentos'] as $key => $value) {
                $id_documento = $_POST['documentos'][$key];

                $claves[] = $id_documento;
            }

            return json_encode($reporte->generar_reporte_documentos($claves, getSegment(3)));
        } else
            return json_encode(array(
                'error' => 'Debe iniciar sesión para continuar',
            ));
    } //Fin de la funcion descargar_reporte
}//Fin de la clase