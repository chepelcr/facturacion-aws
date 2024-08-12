<?php

namespace App\Librerias;

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**Clase para manejar el correo */
class Correo
{
    public function enviarCorreo($data)
    {
        $data = json_encode($data);

        $data = json_decode($data);

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = getEnt('app.CorreoElectronico');                     //SMTP username
            $mail->Password   = getEnt('app.Contrasena');                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom(getEnt('app.CorreoElectronico'), 'Vilma Corella Artavia');

            /**
             * Data para un receptor
             * 
             *  $data = array(
             *      'Juan'=>'juan@mail.com'
             *  );
             * 
             * Data para varios repectores
             *   $data = array(
             *       'Juan'=>'juan@mail.com',
             *       'Daniel'=>'daniel@mail.com'
             *   );

             * $data[receptor]= $data;

             * $mail->addAddress($correo, $nombre);
             * 
             */

            $receptor = $data->receptor;

            foreach ($receptor as $nombre => $correo) {
                //pasar nomnbre a string
                $nombre = (string) $nombre;

                $mail->addAddress($correo, $nombre);
            } //Fin del ciclo para insertar los receptores


            //Copia de correo
            if (isset($data->CC)) {
                $CC = $data->CC;

                //Insertar los receptores al correo
                foreach ($CC as $nombre => $correo) {
                    //pasar nomnbre a string
                    $nombre = (string) $nombre;

                    $mail->addCC($correo, $nombre);
                }
            } //Fin de la validacion de copia de correo

            //$mail->addBCC('bcc@example.com');

            /**
             * $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
             */
            //Attachments
            if (isset($data->adjuntos)) {
                $adjuntos = $data->adjuntos;
                foreach ($adjuntos as $nombreArchivo => $ubicacion) {
                    //Pasar nombre de archivo a string
                    $nombreArchivo = (string) $nombreArchivo;

                    //Insertar los adjuntos
                    $mail->addAttachment($ubicacion, $nombreArchivo);
                } //Fin del ciclo
            } //Fin de la validacion de archivos adjuntos


            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->CharSet = 'UTF-8';

            $mail->Subject = $data->asunto;
            $mail->Body    = $data->body;
            //'This is the HTML message body <b>in bold!</b>'

            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            if ($mail->send()) {

                insertAuditoria(0, 'correo', 'Correo enviado');

                return true;
            }
        } catch (Exception $ex) {
            $id_usuario = getSession('id_usuario');

            if (!$id_usuario) {
                $id_usuario = 0;
            }
            
            $message = "Su mensaje no se ha enviado: {$mail->ErrorInfo}";

            insertError($message, 'correo');

            return false;
        }
    } //Fin de la funcion para enviar un correo
}//Fin de la clase
