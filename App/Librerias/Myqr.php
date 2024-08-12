<?php

namespace App\Librerias;
use PHPQRCode\QRcode;

class Myqr extends QRcode {
    
    public function generarQR() {

        $qr = new QRcode();
        $contenido = 'www.jrtec.cl/verificar/documento/6';
        $logo = '../archivos/logo.png';

        $qr = new QRcode();
        $path = tempnam(sys_get_temp_dir(), "FOO");

        $qr->png($contenido, $path,QR_ECLEVEL_H, 5);

        $QR = imagecreatefrompng($path);
        $logo = imagecreatefromstring(file_get_contents($logo));

        //imagecolortransparent($logo , imagecolorallocatealpha($logo , 0, 0, 0, 127));
        //imagealphablending($logo , false);
        //imagesavealpha($logo , true);

        $QR_width = imagesx($QR);
        $QR_height = imagesy($QR);

        $logo_width = imagesx($logo);
        $logo_height = imagesy($logo);

        $logo_qr_width = $QR_width/3;
        $scale = $logo_width/$logo_qr_width;
        $logo_qr_height = $logo_height/$scale;

        imagecopyresampled($QR, $logo, $QR_width/3, $QR_height/3, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);

        imagepng($QR,$path);
        $png = file_get_contents($path);
        unlink($path);
        return base64_encode($png);

    }
    public function codigoQR($data) {
        $contenido = $data['url'];
       // $contenido = base_url()."/informes/verInforme/".$data['id_informe']."/".$data['codigo'];
        $qr = new QRcode();
        $path = tempnam(sys_get_temp_dir(), "FOO");
        $qr->png($contenido, $path,QR_ECLEVEL_H, 5);
        $QR = imagecreatefrompng($path);
        imagepng($QR,$path);
        $png = file_get_contents($path);
        unlink($path);
        return base64_encode($png);
    }
}

?>
