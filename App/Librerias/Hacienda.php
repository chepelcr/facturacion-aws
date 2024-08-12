<?php

namespace App\Librerias;

use DOMDocument;
use Exception;

/**Libreria para el manejo de documentos electronicos con base en los requerimientos del MH */
class Hacienda
{
    /**Almacenar el token obtenido del ministerio de Hacienda */
    private $token = null;

    /**Hora en la que se obtuvo el token */
    private $token_time = null;

    private $clave = null;

    private $xml64 = null;

    public function __construct($clave = null)
    {
        $this->clave = $clave;
    }

    public function setClave($clave)
    {
        $this->clave = $clave;

        return $this;
    }

    /** Obtener un token del ministerio de hacienda */
    private function token()
    {
        /**Si han pasado mas de 5 minutos desde que se obtuvo el token */
        if(($this->token_time) && (time() - $this->token_time) > (5 * 60))
        {
            /**Se elimina el token */
            $this->token = null;
        }

        /**Si no existe el token */
        if(!$this->token)
        {
            /**Se obtiene el token */
            $data = array(
                'client_id' => getEnt('factura.clientID'),
                'client_secret' => "",
                'grant_type' => "password",
                'username' => getEnt('factura.userToken'),
                'password' => getEnt('factura.userPass')
            );

            //var_dump($data);
    
            $curl = curl_init(getEnt('factura.tokenURL'));
            curl_setopt($curl, CURLOPT_HEADER, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_HEADER, 'Content-Type: application/x-www-form-urlencoded');
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    
            $response = curl_exec($curl);
            $respuesta = json_decode($response);
            $status = curl_getinfo($curl);

            //var_dump($respuesta);

            curl_close($curl);
            
            $token = $respuesta->access_token;
        }

        /**Retornar el token */
        return $token;
    } //Fin de token


    /**Fimar un documento XML */
    public function firmar($stringXML) {
        try {
            $clave = $this->clave;

            $p12 = location(getEnt('factura.p12'));
            $pin = getEnt('factura.pin');

            $ruta = location("archivos\\xml\\firmados\\" . $clave . "_f.xml");

            $firmador = new Firmador();
            //firma y devuelve el base64_encode();
            
            $xml64 =  $firmador->firmarXml($p12, $pin, $stringXML, $firmador::TO_XML_FILE, $ruta);

            $this->xml64 = $xml64;

            return $xml64;
        }

        catch(Exception $e)
        {
            return false;
        }//Fin del catch
    } //Fin del firmador del documento

    /**Enviar un XML al ministerio de hacienda */
    public function enviar($callback = false)
    {
        $xml64 = $this->xml64;
        $clave = $this->clave;

        //Si el xml64 ES NULO
        if($xml64)
        {
            $leer = json_encode(simplexml_load_string(base64_decode($xml64)));
            $json = json_decode($leer);
            
        }

        else
        {
            $ruta = location("archivos\\xml\\firmados\\" . $clave . "_f.xml");
            $leer = json_encode(simplexml_load_file($ruta));
            $json = json_decode($leer);

            $xml64 = base64_encode(file_get_contents($ruta));
        }

        $data = json_encode(array(
            "clave" => $json->Clave,
            "fecha" => date('c'),
            "emisor" => array(
                "tipoIdentificacion" => $json->Emisor->Identificacion->Tipo,
                "numeroIdentificacion" => $json->Emisor->Identificacion->Numero,
            ),
            "comprobanteXml" => $xml64
        ));

        /**Validar si el json tiene receptor */
        if (isset($json->Receptor)) {
            //Agregar "receptor" al json
            $data = json_decode($data, true);
            $data->receptor = array(
                "tipoIdentificacion" => $json->Receptor->Identificacion->Tipo,
                "numeroIdentificacion" => $json->Receptor->Identificacion->Numero,
            );
            $data = json_encode($data);
        }

        if($callback)
        {
            //Agregar el campo "callbackUrl" => baseUrl("documentos/respuesta"),

            $data = json_decode($data);
            $data->callbackUrl = baseUrl("documentos/respuesta");
            $data = json_encode($data);
        }

        //Agregar el token
        $header = array(
            "Authorization: bearer " . $this->token(),
            "Content-Type: application/json",
        );

        $curl = curl_init(getEnt('factura.urlRecepcion'));
        
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        //ejecutar el curl
        $respuesta = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        //Si el status es 400, y la respuesta tiene un campo x-errror-clause que dice "El comprobante [$clave] ya fue recibido anteriormente."
        if($status == 400 && strpos($respuesta, "El comprobante [$clave] ya fue recibido anteriormente.") !== false)
        {
            $status = 200;
        }
        
        curl_close($curl);
        //obtener respuesta
        return json_encode(array('respuesta' => $respuesta, 'status' => $status));      //echo $status;
    } //Fin de enviarXml

    /**Validar un documento por clave */
    public function validar()
    {
        $clave = $this->clave;

        //token
        $header = array(
            "Authorization: bearer " . $this->token(),
            "Content-Type: application/json",
        );

        $curl = curl_init(getEnt('factura.urlRecepcion') . "/" . $clave);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        //ejecutar el curl
        $response = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        //obtener respuesta
        $xml = json_decode($response, true);

        if (isset($xml['respuesta-xml'])) {
            $respuesta_xml = $xml['respuesta-xml'];
            $stringXML = base64_decode($respuesta_xml);

            $salida = location("archivos\\xml\\respuesta\\" . $clave . ".xml");
            $doc = new DomDocument();
            $doc->preserveWhiteSpace = false;
            $doc->loadXml($stringXML);
            $doc->save($salida);
        }

        return json_encode(array('response' => $response, 'xml' => $xml));
    } //Fin de validar

    /**Enviar un documento por correo electronico */
    public function enviar_documento($id_documento)
    {
        $documentoModel = model('documento');

        $documento = $documentoModel->obtener($id_documento);

        if ($documento) {

            $CC = null;

            if ($documento->valido_atv < 3) {
                if ($documento->tipo_documento != '04' && (isset($documento->receptor_cedula) && $documento->receptor_cedula != '')) {
                    //enviar el correo
                    $cuerpo = '<h1>Documento generado</h1>';
                    $cuerpo .= "<p>Señores " . $documento->receptor_nombre . ",
                                    <br>
                                    <br>
                                    Se ha generado el documento con la clave " . $documento->clave . ".
                                    <br>
                                    <br>
                                    El documento ha sido aceptado por el Ministerio de Hacienda.
                                    <br>
                                    <br>
                                    <b>Att " . $documento->emisor_nombre . "</b>";

                    if (getEnt('factura.ambiente') != 'stag') {
                        $correos = array(
                            $documento->receptor_nombre => $documento->receptor_correo,
                        );

                        $CC = array(
                            $documento->emisor_nombre => $documento->emisor_correo,
                            'Gosocket' => 'cr@inbox.gosocket.net',
                        );
                    } else {
                        $correos = array(
                            'Receptor' => 'chepelcr@outlook.com'
                        );

                        $CC = array(
                            'GOSOCKET DE PRUEBA' => 'chepelcr70@gmail.com',
                        );
                    }
                } else {
                    //enviar el correo
                    $cuerpo = '<h1>Documento generado</h1>';
                    $cuerpo .= "<p>Señores " . $documento->emisor_nombre . ",
                                    <br>
                                    <br>
                                    Se ha generado el documento con la clave " . $documento->clave . ".
                                    <br>
                                    <br>
                                    El documento ha sido aceptado por el Ministerio de Hacienda.
                                    <br>
                                    <br>
                                    <b>Att " . $documento->emisor_nombre . "</b>";

                    if (getEnt('factura.ambiente') != 'stag') {
                        $correos = array(
                            $documento->emisor_nombre => $documento->emisor_correo,
                        );

                        $CC = array(
                            'Gosocket' => 'cr@inbox.gosocket.net',
                        );
                    } else {
                        $correos = array(
                            'Receptor' => 'chepelcr@outlook.com'
                        );

                        $CC = array(
                            'GOSOCKET DE PRUEBA' => 'chepelcr70@gmail.com',
                        );
                    }
                }
            } else {
                $cuerpo = '<h1>Error al validar factura</h1>';
                $cuerpo .= "<p>Señores " . $documento->emisor_nombre . ",
                                <br>
                                <br>
                                Se ha generado el documento con la clave " . $documento->clave . ".
                                <br>
                                <br>
                                El documento ha sido rechazado por el Ministerio de Hacienda.
                                <br>
                                <br>";
                $cuerpo .= "Error hacienda: " . $documento->detalle_atv;
                $cuerpo .= "<br>
                                <br>
                                <b>Att " . $documento->emisor_nombre . "</b>";

                if (getEnt('factura.ambiente') != 'stag') {
                    $correos = array(
                        $documento->emisor_nombre => $documento->emisor_correo,
                    );
                } else {
                    $correos = array(
                        'Receptor' => 'chepelcr@outlook.com'
                    );
                }
            }

            //Validar si existe el pdf en: location("archivos\\pdf\\" . $documento->clave . ".pdf")
            if (!file_exists(location("archivos\\pdf\\" . $documento->clave . ".pdf"))) {
                $reportes = new Reportes();
                $reportes->generar_pdf($documento->id_documento);
            }

            //Validar si exite el xml en: location("archivos\\xml\\respuesta\\" . $documento->clave . ".xml")
            if (!file_exists(location("archivos\\xml\\respuesta\\" . $documento->clave . ".xml"))) {
                $this->validar($documento->clave);
            }

            $adjuntos = array(
                $documento->clave . '.pdf' => location("archivos\\pdf\\" . $documento->clave . ".pdf"),
                $documento->clave . '.xml' => location("archivos\\xml\\firmados\\" . $documento->clave . "_f.xml"),
                $documento->clave . '_respuesta_MH.xml' => location("archivos\\xml\\respuesta\\" . $documento->clave . ".xml"),
            );

            $data = array(
                'receptor' => $correos,
                'asunto' => 'Documento electronico',
                'body' => $cuerpo,
                'adjuntos' => $adjuntos,
                'CC' => $CC,
            );

            $mail = new Correo();
            $correo_enviado = $mail->enviarCorreo($data);

            if($correo_enviado){
                $data_envio = array(
                    'correo_enviado' => 1,
                    'fecha_correo' => date('Y-m-d H:i:s'),
                );

                $documentoModel = model('documento');
                $documentoModel->update($data_envio, $id_documento);
            }

            return $correo_enviado;
        }

        return false;
    }//Fin de la funcion para enviar un documento por correo electronico

    public function validar_respuesta($respuesta)
    {
        $clave = $this->clave;
        $xml = json_decode($respuesta, true);

        if (isset($respuesta['respuesta-xml'])) {
            $respuesta_xml = $respuesta['respuesta-xml'];
            $stringXML = base64_decode($respuesta_xml);

            $salida = location("archivos\\xml\\respuesta\\" . $clave . ".xml");
            $doc = new DomDocument();
            $doc->preserveWhiteSpace = false;
            $doc->loadXml($stringXML);
            $doc->save($salida);
        }

        return json_encode(array('response' => $respuesta, 'xml' => $xml));
    }
}//Fin de la clase