<?php

namespace App\Librerias;

use App\Models\TipoCambioModel;
use Exception;
use \SoapClient;

class Indicador
{

    // Constantes de tipo de cambio
    const COMPRA = 317;
    const VENTA = 318;

    // URL del WebService
    private $indEconomWs; #= "https://gee.bccr.fi.cr/Indicadores/Suscripciones/WS/wsindicadoreseconomicos.asmx";

    // Funcion que se va a utilizar del WebService
    private $indEconomFunc; # = "ObtenerIndicadoresEconomicosXML";

    // Tipo de cambio que se quiere obtener (COMPRA por defecto)
    private $tipo = self::COMPRA;

    // Fecha actual
    private $fecha = "";

    public function __construct()
    {
        $this->fecha = date("d/m/Y");
        $this->indEconomWs = "https://gee.bccr.fi.cr/Indicadores/Suscripciones/WS/wsindicadoreseconomicos.asmx";
        $this->indEconomFunc = "ObtenerIndicadoresEconomicosXML";
    }

    public function obtenerIndicadorEconomico($tipo = 'CRC')
    {
        if ($tipo == 'CRC') {
            $this->tipo = self::COMPRA;
        } else {
            $this->tipo = self::VENTA;
        }

        $tipoCambioModel = new TipoCambioModel();
        $tipoCambio = $tipoCambioModel->obtener($this->tipo);

        $data_cambio = $this->obtenerPorGet();

        if ($data_cambio) {
            $tipoCambioModel = new TipoCambioModel();
            $tipoCambioModel->update($data_cambio, $tipoCambio->id_tipo_cambio);

            return $data_cambio->tipo_cambio;
        }

        return $tipoCambio->tipoCambio;
    } //Fin de la función obtenerIndicadorEconomico

    private function obtenerPorGet()
    {
        try {
            $correo = getEnt('bccr.CorreoElectronico');
            $token = getEnt('bccr.Token');
            $nombre = getSession('nombre');

            $urlWS = $this->indEconomWs . "/" . $this->indEconomFunc . "?Indicador=" . $this->tipo . "&FechaInicio=" . $this->fecha . "&FechaFinal=" . $this->fecha . "&Nombre=$nombre&SubNiveles=N&CorreoElectronico=$correo&Token=$token";

            //Colocar el tiempo maximo para el simplexml_load_file
            ini_set('default_socket_timeout', 15);

            $xml = simplexml_load_file($urlWS);

            //Si no se pudo obtener respuesta en el tiempo establecido
            if ($xml === false) {
                return false;
            }

            //Obtiene el string del XML
            $xmlString = $xml->asXML();

            //Obtiene el valor del XML
            $xmlString = str_replace("<string xmlns=\"http://ws.sdde.bccr.fi.cr\">", "", $xmlString);
            $xmlString = str_replace("</string>", "", $xmlString);

            /**El resultado es 
             * &lt;Datos_de_INGC011_CAT_INDICADORECONOMIC&gt;
             * &lt;INGC011_CAT_INDICADORECONOMIC&gt;
             * &lt;COD_INDICADORINTERNO&gt;317&lt;/COD_INDICADORINTERNO&gt;
             * &lt;DES_FECHA&gt;2022-04-25T00:00:00-06:00&lt;/DES_FECHA&gt;
             * &lt;NUM_VALOR&gt;658.99000000&lt;/NUM_VALOR&gt;
             * &lt;/INGC011_CAT_INDICADORECONOMIC&gt;
             */

            //Obtiene el valor del XML
            $xmlString = str_replace("&lt;", "<", $xmlString);
            $xmlString = str_replace("&gt;", ">", $xmlString);

            //Convertir el XML a un objeto
            $xml = simplexml_load_string($xmlString);

            //Obtiene el valor del XML
            $valor = $xml->INGC011_CAT_INDICADORECONOMIC->NUM_VALOR;

            //Convertir el valor a float con dos decimales

            $valor = floatval($valor);
            $valor = number_format($valor, 2, '.', '');

            //Colocar la fecha tipo YYYY-MM-DD
            $fecha = date("Y-m-d", strtotime($xml->INGC011_CAT_INDICADORECONOMIC->DES_FECHA));

            $data = array(
                'fecha_cambio' => $fecha,
                'tipo_cambio' => $valor
            );

            return (object) $data;
        } catch (Exception $e) {
            $messagecomplet = "No se ha podido obtener el tipo de cambio del BCCR. " . $e->getMessage();

            insertError($messagecomplet, 'Indicadores');
        }

        return false;
    } //Fin de la funcion para obtener el tipo de cambio del BCCR
} //Fin de la clase
