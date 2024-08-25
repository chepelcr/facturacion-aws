<?php

namespace Core\Aws;

use Core\Aws\AwsSecretsService;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

/* MYMAILER
 * Our own custom mailer class. Makes it easier to use default settings for all things email.
 *
 * Rules of thumb:
 * - Keep bounce rate under 5%.
 * - Keep complaint rate under 0.1%
 *
 * Tips:
 * - To check that the SPF and DKIM settings are correct, simply send an email (e.g.: to Gmail) and check its headers.
 * - Check URIBL.com and SURBL.org to check my links are not blacklisted.
 *
 * Documentation:
 * - Best practices: http://media.amazonwebservices.com/AWS_Amazon_SES_Best_Practices.pdf -- includes iSP postmaster pages for many ISPs on last page.
 * - Header fields: http://docs.aws.amazon.com/ses/latest/DeveloperGuide/header-fields.html
 * ================================================================================= */

class SesMailer extends PHPMailer
{
    private static $host = null;

    private static $port = null;

    private static $user = null;

    private static $pass = null;

    public function __construct($exceptions = null)
    {
        parent::__construct($exceptions);

        $this->CharSet = 'UTF-8';

        $this->IsSMTP(true);
        $this->SMTPDebug = SMTP::DEBUG_OFF;
        $this->SMTPAuth = true;
        $this->SMTPSecure = "tls";

        if(self::$host == null || self::$port == null || self::$user == null || self::$pass == null) {
            $secret = AwsSecretsService::getSecret(getEnt('app.email.secret'));

            self::$host = $secret['host'];
            self::$port = $secret['port'];
            self::$user = $secret['user'];
            self::$pass = $secret['pass'];
        }

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
