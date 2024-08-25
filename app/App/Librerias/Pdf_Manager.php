<?php

namespace App\Librerias;

use Dompdf\Dompdf;

class Pdf_Manager extends Dompdf
{
    /**Ver un archivo en pdf */
    public function load_view($view, $data = array())
    {
        $dompdf = new Dompdf(array('isPhpEnabled' => true, 'isRemoteEnabled' => true));
        $dompdf->setPaper("letter");
        $html = view($view, $data);
        $dompdf->loadHtml($html);
        $dompdf->render();

        ob_end_clean();

        $dompdf->stream($data["nombre_archivo"], array("Attachment" => 0)); // en navegador
    }

    public function load_ticket($view, $data = array())
    {
        $html = view($view, $data);

        $dompdf = new Dompdf(array('isPhpEnabled' => true, 'isRemoteEnabled' => true));


        //$dompdf->setPaper('b7', 'portrait');

        $paperSize = array(0, 0, 249.48, 354.38);
        $dompdf->setPaper($paperSize, 'portrait');

        $dompdf->loadHtml($html);
        $dompdf->render();

        $pageCount = $dompdf->getCanvas()->get_page_count();

        unset($dompdf);

        $dompdf = new Dompdf(array('isPhpEnabled' => true, 'isRemoteEnabled' => true));
        $paperSize = array(0, 0, 249.48, 354.38 * $pageCount);

        $dompdf->setPaper($paperSize, 'portrait');
        $dompdf->loadHtml($html);
        $dompdf->render();
        
        ob_end_clean();

        $dompdf->stream($data["nombre_archivo"], array("Attachment" => 0)); // en navegador
    }

    /**Descargar un archivo en pdf */
    public function download_view($view, $data = array())
    {
        $dompdf = new Dompdf(array('isPhpEnabled' => true, 'isRemoteEnabled' => true));
        $dompdf->setPaper("letter");
        $html = view($view, $data);
        $dompdf->loadHtml($html);
        $dompdf->render();

        //Poner el header para descargar el archivo
        header('Content-Type: application/Force-Download');
        header('Content-Disposition: attachment; filename="' . $data['nombre_archivo'] . '.pdf"');

        ob_end_clean();

        $dompdf->stream($data["nombre_archivo"], array("Attachment" => 1)); // en 
    }

    public function temp_view($view, $data = array())
    {
        $dompdf = new Dompdf(array('isPhpEnabled' => true, 'isRemoteEnabled' => true));
        $html = view($view, $data);
        $dompdf->loadHtml($html);
        $dompdf->render();
        $output = $dompdf->output();
        return $output;
    }

    public function preview($view, $data = array())
    {
        $dompdf = new DOMPDF(array('isPhpEnabled' => true));
        $html = view($view, $data);
        $dompdf->loadHtml($html);
        $dompdf->render();
        return base64_encode($dompdf->output());
    }

    /**Guardar un archivo pdf en el sistema */
    public function save_view($view, $data = array())
    {
        $dompdf = new Dompdf(array('isPhpEnabled' => true));
        $html = view($view, $data);
        $dompdf->loadHtml($html);
        $dompdf->render();

        $folder = "archivos/";

        if (!is_dir($folder)) {
            mkdir($folder);
        }

        $file = location($folder . $data['nombre_archivo']);

        //Si el archivo existe, lo elimina
        if (file_exists($file)) {
            unlink($file);
        }

        $output = $dompdf->output();
        file_put_contents($file, $output);
    }
}
