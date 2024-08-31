<?php

namespace App\Librerias;

use App\Models\TipoCambioModel;
use Core\Aws\AwsSecretsService;
use Exception;
use \SoapClient;

class Indicador {

    // Constantes de tipo de cambio
    const COMPRA = 317;
    const VENTA = 318;

    private static $bccrInfo;

    // Tipo de cambio que se quiere obtener (COMPRA por defecto)
    private $tipo = self::COMPRA;

    // Fecha actual
    private static $fecha;

    function __construct() {
        self::__init();
    }

    private static function __init() {
        self::$fecha = date("d/m/Y");

        if (!isset(self::$bccrInfo)) {
            self::$bccrInfo = AwsSecretsService::getSecret(getEnt('app.config.bccr'));
        }
    }

    public function obtenerIndicadorEconomico($tipo = 'CRC') {
        if ($tipo == 'CRC') {
            $this->tipo = self::COMPRA;
        } else {
            $this->tipo = self::VENTA;
        }
        return $this->obtenerPorGet();
    } //Fin de la función obtenerIndicadorEconomico

    private function obtenerPorGet() {
        /*
         * object(SimpleXMLElement)#68 (1) {
         *  [0]=> string(42) "<Datos_de_INGC011_CAT_INDICADORECONOMIC />" 
         * }
         * 
         * /**
         * <string xmlns="http://ws.sdde.bccr.fi.cr">
            *  &lt;Datos_de_INGC011_CAT_INDICADORECONOMIC&gt;
                * &lt;INGC011_CAT_INDICADORECONOMIC&gt;
                    * &lt;COD_INDICADORINTERNO&gt;317&lt;/COD_INDICADORINTERNO&gt;
                    * &lt;DES_FECHA&gt;2022-04-25T00:00:00-06:00&lt;/DES_FECHA&gt;
                    * &lt;NUM_VALOR&gt;658.99000000&lt;/NUM_VALOR&gt;
                * &lt;/INGC011_CAT_INDICADORECONOMIC&gt;
            * &lt;/Datos_de_INGC011_CAT_INDICADORECONOMIC&gt;
         * </string>
         */

        $tipoCambioModel = new TipoCambioModel();
        $tipo_cambio = $tipoCambioModel->obtener($this->tipo);

        try {
            $bccrInfo = self::$bccrInfo;

            $indEconomWsUrl = $bccrInfo['host'] . "/" . $bccrInfo['function_id'] . "?Indicador=" . $this->tipo . "&FechaInicio=" . self::$fecha . "&FechaFinal=" . self::$fecha . "&Nombre=" . $bccrInfo['name'] . "&SubNiveles=N&CorreoElectronico=" . $bccrInfo['email'] . "&Token=" . $bccrInfo['token'];

            //Obtiene la informacion del WebService
            $xml = simplexml_load_file($indEconomWsUrl);

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

            $tipoCambioModel = new TipoCambioModel();
            $tipoCambioModel->update($data, $tipo_cambio->id_tipo_cambio);

            return $valor;
        } catch (Exception $e) {
            $messagecomplet = "No se ha podido obtener el tipo de cambio del BCCR. " . $e->getMessage();

            insertError($messagecomplet, 'Indicadores');

            return $tipo_cambio->tipo_cambio;
        }
    } //Fin de la funcion para obtener el tipo de cambio del BCCR
} //Fin de la clase
