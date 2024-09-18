<?php

namespace Core;

/**
 * Clase abstracta que contiene los metodos base para la ejecución de solicitudes a una API REST
 * @author jcampos
 * @version 1.0
 */
abstract class RestApi {
    /**
     * Url base de la API
     */
    private $url = "";

    private $headers = array();

    private const ERROR_RESPONSE = "Ha ocurrido un error al realizar la solicitud";

    private $isArray = true;

    private $hasError = false;

    private $error = "";

    private $errorEnum;

    /**
     * Constructor de la clase
     * 
     * @param string $url Url base de la API
     * @param BaseEnum $errorEnum Enumeración de errores
     * @param string $contentType Tipo de contenido
     * @param boolean $isArray Indica si la respuesta es un arreglo
     */
    public function __construct($url, $errorEnum, $contentType = "application/json", $isArray = false) {
        $this->url = $url;
        $this->headers["Content-Type"] = $contentType;
        $this->isArray = $isArray;
        $this->errorEnum = $errorEnum;
    }

    /**
     * Agrega el token de acceso a la API
     */
    public function setBearerToken($token) {
        $this->headers["Authorization"] = "Bearer " . $token;
    }

    private function constructUrl($url) {
        return $this->url . $url;
    }

    public function addHeader($name, $value) {
        $this->headers[$name] = $value;
    }

    public function setContentType($contentType) {
        $this->headers["Content-Type"] = $contentType;
    }

    private function createHeaders() {
        if (count($this->headers) > 0) {
            foreach ($this->headers as $key => $value) {
                $headers[] = $key . ": " . $value;
            }
        }

        return $headers;
    }

    public function makeGetRequestUrl($url, $data = array()) {
        $url = $this->constructUrl($url);

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        //Transformar los datos a una cadena de consulta
        if (count($data) > 0) {
            $url .= "?" . http_build_query($data);
        }

        /*curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);*/

        # Agregar todos los headers
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->createHeaders());

        #Set timeout
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 15);

        $response = curl_exec($curl);

        $this->validateCurlResponse($curl, $response, $url);

        if ($this->hasError) {
            $response = $this->error;
            $response = json_decode($response, $this->isArray);
        } else {
            $response = json_decode($response, $this->isArray);
        }

        curl_close($curl);

        return $response;
    }

    private function validateCurlResponse($curl, $response, $url = "") {
        $this->hasError = false;

        $className = get_class($this);

        if (curl_errno($curl)) {
            $this->error = json_encode(array(
                "error" => self::ERROR_RESPONSE,
                "status" => "404",
                "url" => $url,
                "response" => $response
            ));

            insertError(curl_error($curl), $className);

            $this->hasError = true;
        } else {
            $info = curl_getinfo($curl);

            //Validar si la respuesta es un error y tiene mensaje
            if (isset($response) && isset($response->error) && isset($response->message)) {
                $message = $this->errorEnum::getMessageFromCode($response->message);

                if ($message != null) {
                    $response->message = $message;
                }

                $this->error = $response;

                $message = "Error: " . $response->error . " - " . $response->message . " - " . $url;

                insertError($message, $className);

                $this->hasError = true;
            } elseif ($info['http_code'] == 404) {
                $this->error = json_encode(array(
                    "error" => "No se encontró la página",
                    "status" => "404",
                    "url" => $url,
                    "response" => $response
                ));

                insertError("No se encontró la página: $url", $className);

                $this->hasError = true;
            } elseif ($info['http_code'] == 500) {
                $this->error = json_encode(array(
                    "error" => "Error interno del servidor",
                    "status" => "500",
                    "url" => $url,
                    "response" => $response
                ));

                insertError("Error interno del servidor: $url", $className);

                $this->hasError = true;
            } elseif ($info['http_code'] == 401) {
                $this->error = json_encode(array(
                    "error" => "No autorizado",
                    "status" => "401",
                    "url" => $url,
                    "response" => $response
                ));

                insertError("No autorizado: $url", $className);

                $this->hasError = true;
            } elseif ($info['http_code'] == 403) {
                $this->error = json_encode(array(
                    "error" => "Prohibido",
                    "status" => "403",
                    "url" => $url,
                    "response" => $response
                ));

                insertError("Prohibido: $url", $className);

                $this->hasError = true;
            } elseif ($info['http_code'] == 400) {
                $this->error = json_encode(array(
                    "error" => "Solicitud incorrecta",
                    "status" => "400",
                    "url" => $url,
                    "response" => $response
                ));

                insertError("Solicitud incorrecta: $url", $className);

                $this->hasError = true;
            } else {
                if (isset($response->error)) {
                    $this->error = json_encode(array(
                        "error" => $response->error,
                        "status" => $info['http_code'],
                        "url" => $url,
                        "response" => $response
                    ));

                    insertError($response->error, $className);

                    $this->hasError = true;
                }
            }
        }
    }

    /**
     * Crea una solicitud POST
     */
    public function makePostRequest($data, $url = "") {
        $url = $this->url . $url;

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        /*curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);*/

        # Agregar todos los headers
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->createHeaders());

        #Set timeout
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 15);

        $response = curl_exec($curl);

        $this->validateCurlResponse($curl, $response, $url);

        if ($this->hasError) {
            $response = $this->error;
            $response = json_decode($response, $this->isArray);
        } else {
            $response = json_decode($response, $this->isArray);
        }

        curl_close($curl);

        return $response;
    }

    /**
     * Crea una solicitud PUT
     */
    public function makePutRequest($data, $url = "") {
        $url = $this->url . $url;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        # Agregar todos los headers
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->createHeaders());

        #Set timeout
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 15);

        /*curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);*/

        $response = curl_exec($curl);

        $this->validateCurlResponse($curl, $response, $url);

        if ($this->hasError) {
            $response = $this->error;
            $response = json_decode($response, $this->isArray);
        } else {
            $response = json_decode($response, $this->isArray);
        }

        curl_close($curl);

        return $response;
    }

    public function makePatchRequest($data, $url = "") {
        $url = $this->url . $url;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PATCH");
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        # Agregar todos los headers
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->createHeaders());

        #Set timeout
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 15);

        /*curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);*/

        $response = curl_exec($curl);

        $this->validateCurlResponse($curl, $response, $url);

        if ($this->hasError) {
            $response = $this->error;
            $response = json_decode($response, $this->isArray);
        } else {
            $response = json_decode($response, $this->isArray);
        }

        curl_close($curl);

        return $response;
    }
}
