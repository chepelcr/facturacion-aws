<?php

namespace App\Librerias;

use Core\Aws\AwsS3Service;
use Dompdf\Dompdf;

use Core\Config\Header;

class Pdf_Manager {

    /**Ver un archivo en pdf */
    public function load_view($view, $data = array()) {
        $dompdf = new Dompdf(array('isPhpEnabled' => true, 'isRemoteEnabled' => true));
        $dompdf->setPaper("letter");
        $html = view($view, $data);
        $dompdf->loadHtml($html);
        $dompdf->render();

        ob_end_clean();

        Header::pdf();

        $dompdf->stream($data["nombre_archivo"], array("Attachment" => 0)); // en navegador
    }

    /**Descargar un archivo en pdf */
    public function download_view($view, $data = array()) {
        $dompdf = new Dompdf(array('isPhpEnabled' => true, 'isRemoteEnabled' => true));
        $dompdf->setPaper("letter");
        $html = view($view, $data);
        $dompdf->loadHtml($html);
        $dompdf->render();

        //Poner el header para descargar el archivo
        header('Content-Type: application/Force-Download');
        header('Content-Disposition: attachment; filename="' . $data['nombre_archivo'] . '.pdf"');

        ob_end_clean();

        $dompdf->stream($data["nombre_archivo"], array("Attachment" => 1)); // para descargar
    }

    public function temp_view($view, $data = array()) {
        $dompdf = new Dompdf(array('isPhpEnabled' => true, 'isRemoteEnabled' => true));
        $html = view($view, $data);
        $dompdf->loadHtml($html);
        $dompdf->render();
        $output = $dompdf->output();
        return $output;
    }

    public function preview($view, $data = array()) {
        $dompdf = new DOMPDF(array('isPhpEnabled' => true));
        $html = view($view, $data);
        $dompdf->loadHtml($html);
        $dompdf->render();
        return base64_encode($dompdf->output());
    }

    /**
     * Almacenar un archivo en pdf en AWS S3
     */
    public function save_view($view, $data = array()) {
        $dompdf = new Dompdf(array('isPhpEnabled' => true));
        $html = view($view, $data);
        $dompdf->loadHtml($html);
        $dompdf->render();

        $output = $dompdf->output();

        upload_file_to_s3($output, $data['nombre_archivo'], 'application/pdf');
    }
}
