<?php

namespace Core\Aws;

use Core\Aws\AwsSecretsService;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

/**
 * Clase que se encarga de configurar el correo electrónico para ser enviado a travez de AWS SES.
 * @package Core\Aws
 * @subpackage AwsSecretsService
 * @version 1.0
 * @author jcampos
 * 
 * - Best practices: http://media.amazonwebservices.com/AWS_Amazon_SES_Best_Practices.pdf -- includes iSP postmaster pages for many ISPs on last page.
 * - Header fields: http://docs.aws.amazon.com/ses/latest/DeveloperGuide/header-fields.html
 * ================================================================================= 
 * 
 */

class SesMailer extends PHPMailer {
    private static $host = null;

    private static $port = null;

    private static $user = null;

    private static $pass = null;

    /**
     * Constructor de la clase que se encarga de colocar los valores de configuración de PHP Mailer obtenidos desde AWS Secrets Manager
     */
    public function __construct($exceptions = null) {
        parent::__construct($exceptions);

        if (self::$host == null || self::$port == null || self::$user == null || self::$pass == null) {
            $secret = AwsSecretsService::getSecret(getEnt('app.email.secret'));

            self::$host = $secret['host'];
            self::$port = $secret['port'];
            self::$user = $secret['user'];
            self::$pass = $secret['password'];
        }

        $this->__init();
    }

    private function __init() {
        $this->CharSet = 'UTF-8';

        $this->IsSMTP(true);
        $this->SMTPDebug = SMTP::DEBUG_OFF;
        $this->SMTPAuth = true;
        $this->SMTPSecure = "tls";

        $this->Host = self::$host;
        $this->Port = self::$port;
        $this->Username = self::$user;
        $this->Password = self::$pass;

        /**
         * Default values common to local + SES. Constant defined in config.php
         * Used defensively only.
         * Those values would and should be overwritten by the code.
         * Apparently, the order matters (TBC.)
         **/
        $this->AddReplyTo(getEnt('app.email.reply'), getEnt('app.name'));
        $this->setFrom(getEnt('app.email.send'), getEnt('app.name'));
    }
}
