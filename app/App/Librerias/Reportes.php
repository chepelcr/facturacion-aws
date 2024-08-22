<?php

namespace App\Librerias;

use ZipArchive;

class Reportes
{
    /**Generar un documento en pdf */
    public function generar_pdf($clave)
    {
        $pdf = new Pdf_Manager();
        $qr = new Myqr();

        $DocumentosModel = model('documento');
        $documento =  $DocumentosModel->obtener($clave);

        if ($documento) {
            $detalles =  $documento->detalles;

            $dataQR = array(
                'url' => baseUrl('documentos/pdf/' . $clave),
            );

            $arrContextOptions = array(
                "ssl" => array(
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                ),
            );

            $logoImg = file_get_contents(baseUrl('files/dist/img/logo.png'), false, stream_context_create($arrContextOptions));

            $logoImg = base64_encode($logoImg);

            $dataPdf = array(
                'nombre_archivo' => "pdf\\" . $documento->clave . ".pdf",
                'documento' => $documento,
                'detalles' => $detalles,
                "qrCodigo" => $qr->codigoQR($dataQR),
                "logo" => $logoImg,
            );
            $pdf->save_view("pdfs/facturaPDF", $dataPdf);
        } else {
            echo "Documento no existe";
        }
    }

    public function generar_reporte_documentos($claves = array(), $tipo = 'descarga')
    {
        //Crear un nuevo archivo zip vacio
        $zip = new ZipArchive();

        //Nombre del reporte con la fecha
        $nombre_reporte = 'reporte_' . date('Y-m-d') . '.zip';

        //Ruta del archivo zip
        $ruta_zip = location('archivos\\reportes\\' . $nombre_reporte);

        $documentosModel = model('documento');

        $claves_reporte = array();

        foreach ($claves as $clave) {
            $documento = $documentosModel->obtener($clave);

            if ($documento) {
                $claves_reporte[] = $documento->clave;

                $this->generar_pdf($clave);
            } //Fin de validacion de documento
        } //Fin de ciclo claves

        //Crear el archivo zip
        if ($zip->open($ruta_zip, ZipArchive::CREATE) === TRUE) {
            //Recorrer las claves
            foreach ($claves_reporte as $clave) {
                $zip->addFile(location('archivos\\pdf\\' . $clave . '.pdf'), 'DOC_' . $clave . '.pdf');
            }

            //Cerrar el archivo zip
            $zip->close();

            //Validar si el archivo existe
            if (file_exists($ruta_zip)) {
                if ($tipo == 'descarga') {

                    return array(
                        'nombre_archivo' => $nombre_reporte,
                        'ruta_archivo' => $ruta_zip,
                    );
                } else {
                    //enviar el correo
                    $cuerpo = '<h1>Reporte generado</h1>
                        <br>
                        <p>El reporte fue generado con exito</p>';

                    if (getEnt('factura.ambiente') == 'stag') {
                        $correos = array(
                            'RECEPTOR DE PRUEBA' => 'chepelcr@outlook.com',
                        );
                    } else {
                        $correos = array(
                            getSession('nombre') => getSession('correo'),
                        );
                    }

                    $adjuntos = array(
                        $nombre_reporte => $ruta_zip,
                    );

                    $data = array(
                        'receptor' => $correos,
                        'asunto' => 'Reporte electronico',
                        'body' => $cuerpo,
                        'adjuntos' => $adjuntos,
                    );

                    $mail = new Correo();

                    if ($mail->enviarCorreo($data)) {
                        //Eliminar el archivo zip
                        unlink($ruta_zip);

                        //Eliminar los archivos pdf
                        foreach ($claves_reporte as $clave) {
                            unlink(location('archivos\\pdf\\' . $clave . '.pdf'));
                        }

                        return array(
                            'message' => 'Se envio el reporte correctamente',
                            'status' => 'success',
                        );
                    } else {
                        return array(
                            'error' => 'No se pudo enviar el correo',
                            'status' => 'error',
                            'codigo' => '500'
                        );
                    }
                }
            }
        }

        return array(
            'error' => 'No se pudo generar el archivo',
            'status' => 'error',
            'codigo' => '500'
        );
    }
}
