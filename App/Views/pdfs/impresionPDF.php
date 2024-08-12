<!DOCTYPE html>
<html>

<head>
    <title></title>

    <style>
        * {
            font-size: 14px;
            font-family: 'DejaVu Sans', serif;
        }

        h1 {
            font-size: 20px;
        }

        .ultimaLinea {
            border-top: 1px solid black;
            width: 100%;
        }
    </style>
</head>

<body>
    <table width="100%">
        <tr>
            <td align="center">
                <h1>
                    <?php
                    switch ($documento->tipo_documento) {
                        case '01':
                            echo 'Factura Electrónica';
                            break;

                        case '02':
                            echo 'Nota de Débito Electrónica';
                            break;

                        case '03':
                            echo 'Nota de Crédito Electrónica';
                            break;

                        case '04':
                            echo 'Tiquete Electrónico';
                            break;

                        default:
                            echo 'Documento electrónico';
                            break;
                    }
                    ?>
                </h1>
            </td>
        </tr>

        <tr>
            <td>
                <h3>Documento # <?= $documento->consecutivo ?></h3>
            </td>
        </tr>

        <tr>
            <td>
                Fecha: <?php
                        //Poner la fecha del documento en formato dd/mm/yyyy
                        $fecha = date_create($documento->fecha);
                        echo date_format($fecha, 'd/m/Y');
                        ?>
            </td>
        </tr>
    </table>

    <table width="100%">
        <tr>
            <td><u>Emisor</u></td>
        </tr>
        <tr>
            <td><b>Cedula</b>: <?= $documento->emisor_cedula; ?></td>
        </tr>
        <tr>
            <td><b>Nombre</b>: <?= $documento->emisor_nombre; ?></td>
        </tr>
        <tr>
            <td><b>Telefono</b>: <?= $documento->emisor_telefono; ?></td>
        </tr>
        <tr>
            <td><b>Correo</b>: <?= $documento->emisor_correo; ?></td>
        </tr>
        <tr>
            <td><b>Dirección</b>: <?= $documento->emisor_otras_senas; ?> </td>
        </tr>
        <?php
        if (isset($documento->receptor_cedula)) :
        ?>
            <tr>
                <td><u>Receptor</u></td>
            </tr>
            <tr>
                <td><b>Cedula</b>: <?= $documento->receptor_cedula; ?></td>
            </tr>
            <tr>
                <td><b>Nombre</b>: <?= $documento->receptor_nombre; ?></td>
            </tr>
            <tr>
                <td><b>Telefono</b>: <?= $documento->receptor_telefono; ?></td>
            </tr>
            <tr>
                <td><b>Correo</b>: <?= $documento->receptor_correo; ?></td>
            </tr>
            <tr>
                <td><b>Dirección</b>: <?= $documento->receptor_otras_senas; ?> </td>
            </tr>
        <?php endif; ?>
    </table>
    <br>

    <table width="100%">
        <tbody>
            <?php foreach ($detalles as $key => $linea) : ?>
                <tr>
                    <th colspan="7" align="left">Linea <?= $linea->linea ?></th>
                </tr>
                <tr>
                    <td colspan="1"><?= number_format($linea->cantidad, "2", ",", ".") ?></td>
                    <td colspan="6" align="right"><?= $linea->detalle ?></td>
                </tr>
                <tr>
                    <td colspan="3">
                        Precio unitario
                    </td>
                    <td colspan="4" align="right">
                        ¢ <?= number_format($linea->precio_unidad, "2", ",", ".") ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        Subtotal
                    </td>
                    <td colspan="4" align="right">
                        ¢ <?= number_format($linea->sub_total, "2", ",", ".") ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        Impuesto
                    </td>
                    <td colspan="4" align="right">
                        ¢ <?= number_format($linea->impuesto_neto, "2", ",", ".") ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        Total
                    </td>
                    <td colspan="4" align="right">
                        ¢ <?= number_format($linea->total_linea, "2", ",", ".") ?>
                    </td>
                </tr>
                <br>
            <?php endforeach ?>
        </tbody>

    </table>

    <table width="100%">
        <tbody>
            <tr>
                <th colspan="7" align="right">
                    <h3>Totales</h3>
                </th>
            </tr>

            <tr>
                <td colspan="3" align="right">Neto</td>
                <td colspan="4" align="right">¢ <?= number_format($documento->total_venta, "2", ",", ".") ?></td>
            </tr>
            <tr>
                <td colspan="3" align="right">Descuento</td>
                <td colspan="4" align="right">¢ <?= number_format($documento->total_descuentos, "2", ",", ".") ?></td>
            </tr>
            <tr>
                <td colspan="3" align="right">Subtotal</td>
                <td colspan="4" align="right">¢ <?= number_format($documento->total_venta_neta, "2", ",", ".") ?></td>
            </tr>
            <tr>
                <td colspan="3" align="right">IVA</td>
                <td colspan="4" align="right">¢ <?= number_format($documento->total_impuestos, "2", ",", ".") ?></td>
            </tr>
            <tr>
                <td colspan="3" align="right">Total</td>
                <td colspan="4" align="right">¢ <?= number_format($documento->total_comprobante, "2", ",", ".") ?></td>
            </tr>

            <tr>

            </tr>
        </tbody>
        <br>
        <tfoot>
            <tr>
                <td colspan="7" align="center">
                    <img src="data:image/png;base64,'<?= $qrCodigo ?>'" width="50%">
                </td>
            </tr>
        </tfoot>
    </table>


    <!-- Alinear footer en la parte de abajo -->
    <p>
        <small>Moneda: <?= $documento->moneda; ?></small><br>
        <small>Tipo Cambio: <?= number_format($documento->tipo_cambio, 2, ",", ".") ?></small><br>
        <small>Notas: <?= $documento->notas; ?></small>
        <br>
        <small><u>Total en dolares: <?= number_format(($documento->total_comprobante / $documento->tipo_cambio), 2, ",", ".") ?></u></small>

        <br><br>
        <small>Emitida conforme lo establecido en la resolución de Facturación Electrónica, N° DGT-R-48-2016 siete de
            octubre de dos mil dieciséis de la Dirección General de Tributación.</small><br><br><br><br><br>
    </p>
    <div class="ultimaLinea"></div>
</body>

</html>