<?php

namespace App\Controllers;

use App\Librerias\Pdf_Manager;
use App\Services\DocumentosService;

class Documentos extends BaseController
{
    private $documentosService;

    public function __construct()
    {
        parent::__construct();
        $this->documentosService = new DocumentosService();
    }

    /**Cargar los documentos electronicos */
    public function index()
    {
        //if (is_login()) {
        $script = cargar('cargar_inicio_modulo("documentos");');

        $data = array(
            'script' => $script,
        );

        return $this->inicio($data);
        /*} //Fin de la validacion

        else {
            redirect(baseUrl('login'));
        }*/
    } //Fin de la funcion index

    /**Abrir el submodulo de ventas*/
    public function facturacion()
    {
        if (is_login()) {
            $script = cargar('cargar_inicio_modulo("documentos"); agregar_documento(1);');

            $data = array(
                'script' => $script,
            );

            return $this->inicio($data);
        } else {
            redirect(baseUrl('login'));
        }
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
        } else {
            redirect(baseUrl('login'));
        }
    } //Fin de la funcion emitidos

    /**Validar el estado los documentos que se encuentran en proceso en el ministerio de hacienda */
    public function validar_documentos()
    {
        if (!is_login()) {
            $data = array(
                'error' => 'login',
                'estado' => 'warning',
                'codigo' => '505',
            );

            return $this->error($data);
        } else {
            return $this->documentosService->validarDocumentos();
        }
    } //Fin de la funcion validar_documentos

    /**Obtener los indicadores de compra y venta desde el banco central */
    public function indicadores()
    {
        $indicador = getSegment(3);
        return $this->documentosService->obtenerIndicadores($indicador);
    } //Fin de la funcion indicadores

    /**Enviar un document por correo electronico */
    public function enviar_documento()
    {
        if (is_login()) {
            if (getSegment(3)) {
                //Validar si se envia un correo por $_GET
                if (isset($_GET['email'])) {
                    $data = $this->documentosService->enviarDocumento(getSegment(3), $_GET['email']);
                } else {
                    $data = $this->documentosService->enviarDocumento(getSegment(3));
                }
            } else {
                $data = array(
                    'error' => 'No se ha enviado un documento para notificar',
                    'status' => '400',
                );
            }

            if (isset($data['error'])) {
                return $this->error($data);
            } else {
                return json_encode($data);
            }
        } else {
            redirect(baseUrl('login'));
        }
    }

    /**Cargar los documentos de la empresa */
    public function cargar_documentos()
    {
        if (is_login()) {
            if (isset($_GET['reportType']) && isset($_GET['documentTypeId']) && isset($_GET['startDate']) && isset($_GET['endDate'])) {
                $tipoReporte = $_GET['reportType'];
                $documentType = $_GET['documentTypeId'];
                $startDate = $_GET['startDate'];
                $endDate = $_GET['endDate'];
            } else {
                $tipoReporte = 'all';
                $documentType = 'all';
                $startDate = null;
                $endDate = null;
            }

            $issuerFilter = getSegment(3);

            $documentsView = $this->documentosService->cargarDocumentos($documentType, $issuerFilter, $tipoReporte, $startDate, $endDate);

            if(isset($documentsView->error)) {
                return $this->error($documentsView);
            } else {
                return $documentsView;
            }
        } else {
            $error = array(
                'error' => 'No ha iniciado sesión',
                'estado' => 'warning',
                'codigo' => '505',
            );

            return $this->error($error);
        }
    }

    /**
     * Obtener la vista para ver un PDF
     */
    public function ver_pdf()
    {
        if (is_login()) {
            $documentUrl = $_GET['documentUrl'];

            return $this->documentosService->getPdf($documentUrl);
        }
    }

    /**Validar el estado de un document en el ministerio de hacienda */
    public function validar_documento()
    {
        if (is_login()) {
            if (getSegment(3)) {
                $id_documento = getSegment(3);

                return $this->documentosService->validarDocumento($id_documento);
            } else {
                $data = array(
                    'error' => 'El document solicitado no existe',
                    'estado' => 'warning',
                    'codigo' => '404',
                );

                return $this->error($data);
            }
        } else {
            $data = array(
                'error' => 'No ha iniciado sesión',
                'estado' => 'warning',
                'codigo' => '505',
            );

            return $this->error($data);
        }
    }

    /**Enviar un document al ministerio de hacienda */
    public function enviar_hacienda()
    {
        if (!is_login()) {
            $error = array(
                'estado' => 'error',
                'error' => 'login',
                'codigo' => '505',
            );

            return $this->error($error);
        } else {
            $id_documento = getSegment(3);

            return $this->documentosService->enviarHacienda($id_documento);
        }
    } //Fin de la function para enviar un document al ministerio de hacienda


    /**Esperar la respuesta del Ministerio de Hacienda 
     * @header Content-Type: application/json
     * @post {
            "documentKey": "50601011600310112345600100010100000000011999999999",
            "fecha": "2016-01-01T00:00:00-0600",
            "ind-estado": "aceptado",
            "respuesta-xml": "PD94bWwgdmVyc2lvbj0iMS4wIiA/Pg0KDQo8ZG9tYWluIHhtbG5zPSJ1cm46amJvc3M6ZG9tYWluOjQuMCI+DQogICAgPGV4dGVuc2lvbnM+DQogICAgICAgIDxleHRlbnNpb24gbW9kdWxlPSJvcmcuamJvc3MuYXMuY2x1c3RlcmluZy5pbmZpbmlzcGFuIi8+DQogICAgICAgIDxleHRlbnNpb24gbW9kdWxlPSJvcmcuamJvc3MuYXMuY2x1c3RlcmluZy5qZ3JvdXBzIi8+DQogICAgICAgIDxleHRlbnNpb24gbW9kdWxlPSJvcmcuamJvc3MuYXMuY29ubmVjdG9yIi8+DQogICAgICAgIDxleHRlbnNpb24gbW..."
            }
     */
    public function esperar_respuesta()
    {
        //Colocar el header para que el navegador sepa que es un json
        header('Content-Type: application/json');

        $documentKey = getSegment(3);
        $respuesta = post();

        $this->documentosService->recibirRespuestaHacienda($documentKey, $respuesta);
    }

    /**Obtener todos los productos */
    public function get_productos()
    {
        if (is_login()) {
            return $this->documentosService->getProductos();
        } else {
            $error = array(
                'error' => 'No ha iniciado sesión',
                'estado' => 'warning',
                'codigo' => '505',
            );

            return $this->error($error);
        }
    } //Fin de la funcion get_productos

    /**Obtener todos los clientes */
    public function get_clientes()
    {
        if (is_login()) {
            $documentTypeCode = $_GET['documentTypeCode'];

            $response = $this->documentosService->getCustomers($documentTypeCode);

            if (isset($response->error)) {
                return $this->error($response);
            } else {
                return $response;
            }
        } else {
            $error = array(
                'error' => 'No ha iniciado sesión',
                'status' => '505',
            );

            return $this->error($error);
        }
    } //Fin de la funcion get_clientes

    /**
     * Crear un document electronico
     */
    public function crear_documento()
    {
        if (is_login()) {
            $documentTypeId = getSegment(3);

            $numero_documento = $_GET['documentNumber'];

            $data = $this->documentosService->crearDocumento($documentTypeId, $numero_documento);

            if (isset($data['error'])) {
                return $this->error($data);
            } else {
                return $data;
            }
        } else {
            return redirect(baseUrl('login'));
        }
    }

    /**Buscar un cliente por identificacion */
    public function buscar_cliente()
    {
        if (is_login()) {
            if (getSegment(3)) {
                $customerId = getSegment(3);
                $data = $this->documentosService->buscarCliente($customerId);
            } else {
                $data = (object) array(
                    'error' => 'No se encontro el cliente',
                    'estado' => 'warning',
                    'codigo' => '404',
                );
            }
        } else {
            $data = (object) array(
                'error' => 'No ha iniciado sesión',
                'estado' => 'warning',
                'codigo' => '505',
            );
        }

        //Si no viene un error
        if (!isset($data->error)) {
            return json_encode($data);
        } else {
            return $this->error($data);
        }
    } //Fin de la funcion buscar_cliente

    /**
     * Almacenar un document electrónico
     * @header Content-Type: application/json
     * @param array $data Documento electrónico
     * @return string
     */
    public function guardar($data)
    {
        if (is_login()) {
            //var_dump($data);

            //return;

            $response = $this->documentosService->guardarDocumento($data);

            //var_dump($response);

            if (isset($response->error)) {
                return $this->error($response);
            } else {
                return json_encode($response);
            }
        } else {
            $error = array(
                'error' => 'No ha iniciado sesión',
                'estado' => 'warning',
                'codigo' => '505',
            );

            return $this->error($error);
        }
    }


    /**Obtener el modal de agregar los elementos de Walmart */
    public function get_walmart()
    {
        if (is_login()) {
            return $this->documentosService->getWalmart();
        } else {
            $error = array(
                'error' => 'No ha iniciado sesion',
                'estado' => 'error',
                'codigo' => 505
            );

            return $this->error($error);
        }
    } //Fin de la funcion get_walmart

    /**Descargar un archivo zip */
    /*public function descargar_zip()
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
    } //Fin de la funcion  para descargar un archivo zip */

    /**Buscar un producto por codigo en la base de datos */
    public function buscar_producto()
    {
        if (is_login()) {
            if (getSegment(3)) {
                $code = getSegment(3);
                $data = $this->documentosService->getProductByCode($code);
            } else {
                $data = array(
                    'error' => 'No se ha enviado un codigo',
                    'estado' => 'error',
                    'codigo' => 400
                );
            }
        } else {
            $data = array(
                'error' => 'No ha iniciado sesion',
                'estado' => 'error',
                'codigo' => 505
            );
        }


        if (isset($data->error)) {
            return $this->error($data);
        } else {
            return json_encode($data);
        }
    } //Fin de la funcion buscar_producto

    public function reporte()
    {
        if (is_login()) {
            $documentos = $_POST['documentos'];

            $data = $this->documentosService->getReporteZip($documentos);
        } else {
            $data = array(
                'error' => 'Debe iniciar sesión para continuar',
                'estado' => 'error',
                'codigo' => 505
            );
        }

        if (isset($data['error'])) {
            return $this->error($data);
        } else {
            return json_encode($data);
        }
    } //Fin de la funcion descargar_reporte
}//Fin de la clase