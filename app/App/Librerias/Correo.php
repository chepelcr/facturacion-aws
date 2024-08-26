<?php

namespace App\Librerias;

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function

use Core\Aws\SesMailer;
use PHPMailer\PHPMailer\Exception;

/**Clase para manejar el correo */
class Correo {
    public function enviarCorreo($data) {
        $data = json_encode($data);

        $data = json_decode($data);

        //Create an instance; passing `true` enables exceptions
        $mail = new SesMailer(true);

        try {
            $receptor = $data->receptor;

            foreach ($receptor as $nombre => $correo) {
                //pasar nomnbre a string
                $nombre = (string) $nombre;

                $mail->addAddress($correo, $nombre);
            } //Fin del ciclo para insertar los receptores


            //Copia de correo
            if (isset($data->CC)) {
                $cc = $data->CC;

                //Insertar los receptores al correo
                foreach ($cc as $nombre => $correo) {
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


            $mail->Subject = $data->asunto;
            $mail->Body    = $data->body;
            //'This is the HTML message body <b>in bold!</b>'

            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            if ($mail->send()) {
                $id_usuario = getSession('id_usuario');

                if (!$id_usuario)
                    $id_usuario = 0;

                $data = array(
                    'id_fila' => '0',
                    'tabla' => 'correo',
                    'id_usuario' => $id_usuario,
                    'accion' => 'Correo enviado'
                );

                insertAuditoria($data);

                return array(
                    'estado' => 1,
                    'mensaje' => 'Su mensaje ha sido enviado'
                );
            }
        } catch (Exception $ex) {
            $id_usuario = getSession('id_usuario');

            if (!$id_usuario)
                $id_usuario = 0;

            $message = "Su mensaje no se ha enviado: {$mail->ErrorInfo}";

            $messagecomplet = $message;

            $data = array(
                'sentencia' => $messagecomplet,
                'controlador' => 'correo',
                'id_usuario' => $id_usuario
            );

            insertError($data);

            return array(
                'estado' => 0,
                'error' => $message
            );
        }
    } //Fin de la funcion para enviar un correo
}//Fin de la clase
