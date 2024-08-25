<!DOCTYPE html>
<html>

<head>
    <title></title>
</head>

<body>
    <table width="100%">
        <tr>
            <td>
                <img src="data:image/png;base64,<?= $logo ?>" width="50">
            </td>

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

            <td align="right">
                <img src="data:image/png;base64,'<?=$qrCodigo?>'" width="80%">
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <h3>Documento # <?=$documento->consecutivo?></h3>
            </td>

            <td align="right" colspan="1">
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
            <td><b>Cedula</b>: <?=$documento->emisor_cedula;?></td>
            <td><b>Nombre</b>: <?=$documento->emisor_nombre;?></td>
            <td><b>Telefono</b>: <?=$documento->emisor_telefono;?></td>
        </tr>
        <tr>
            <td><b>Correo</b>: <?=$documento->emisor_correo;?></td>
            <td colspan="2"><b>Dirección</b>: <?=$documento->emisor_otras_senas;?> </td>
        </tr>
        <?php
            if(isset($documento->receptor_cedula)):
        ?>
        <tr>
            <td><u>Receptor</u></td>
        </tr>
        <tr>
            <td><b>Cedula</b>: <?=$documento->receptor_cedula;?></td>
            <td><b>Nombre</b>: <?=$documento->receptor_nombre;?></td>
            <td><b>Telefono</b>: <?=$documento->receptor_telefono;?></td>
        </tr>
        <tr>
            <td><b>Correo</b>: <?=$documento->receptor_correo;?></td>
            <td colspan="2"><b>Dirección</b>: <?=$documento->receptor_otras_senas;?> </td>
        </tr>

        <?php endif; ?>
    </table>
    <br><br>

    <table width="100%">
        <tr>
            <th colspan="9" align="center">Detalles</th>
        </tr>
        <thead>
            <tr>
                <td colspan="1">#</td>
                <td colspan="5">Detalle</td>
                <td colspan="1">Cantidad</td>
                <td colspan="1">Unidad</td>
                <td colspan="1" align="right">Total</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($detalles as $key => $linea): ?>
            <tr>
                <td colspan="1"><?=$linea->linea?></td>
                <td colspan="5"><?=$linea->detalle?></td>
                <td colspan="1"><?=number_format($linea->cantidad,"2",",",".")?></td>
                <td colspan="1"><?=$linea->unidad_medida?></td>
                <td colspan="1" align="right">¢ <?=number_format($linea->total_linea,"2",",",".")?></td>
            </tr>
            <?php endforeach ?>

        </tbody>

        <br>

        <tfoot>
            <tr>
                <td colspan="7" align="right"></td>
                <td colspan="2" align="center">
                    <h3>Totales</h3>
                </td>
            </tr>

            <tr>
                <td colspan="8" align="right">Neto</td>
                <td colspan="1" align="right">¢ <?= number_format($documento->total_venta,"2",",",".")?></td>
            </tr>
            <tr>
                <td colspan="8" align="right">Descuento</td>
                <td colspan="1" align="right">¢ <?= number_format($documento->total_descuentos,"2",",",".")?></td>
            </tr>
            <tr>
                <td colspan="8" align="right">Subtotal</td>
                <td colspan="1" align="right">¢ <?= number_format($documento->total_venta_neta,"2",",",".")?></td>
            </tr>
            <tr>
                <td colspan="8" align="right">IVA</td>
                <td colspan="1" align="right">¢ <?= number_format($documento->total_impuestos,"2",",",".")?></td>
            </tr>
            <tr>
                <td colspan="8" align="right">Total</td>
                <td colspan="1" align="right">¢ <?= number_format($documento->total_comprobante,"2",",",".")?></td>
            </tr>
        </tfoot>
    </table>

    <!-- Colocar tabla alineada a la izquierda-->
    <table width="75%" align="left">
        <?php
            //Si las referencias del documento son mayor a cero, entonces se imprimen
            if(count((array)$documento->referencias) > 0):
        ?>
        <tr>
            <th colspan="9" align="center">Referencias</th>
        </tr>

        <thead>
            <tr>
                <td colspan="6">Clave</td>
                <td colspan="1" align="center">Fecha</td>
                <td colspan="1" align="right">Razón</td>

            </tr>
        </thead>

        <tbody>
            <?php foreach ($documento->referencias as $key => $referencia): 
                $fecha = date_create($referencia->referencia_fecha);
                $fecha = date_format($fecha, 'd/m/Y');
            ?>

            <tr>
                <td colspan="6"><small><?=$referencia->referencia_clave?></small></td>
                <td colspan="1"><small><?=$fecha?></small></td>
                <td colspan="1" align="right"><small><?=$referencia->referencia_razon?></small></td>
            </tr>
            <?php endforeach ?>
        </tbody>
        <?php endif; ?>
    </table>

    <!-- Tabla para agregar otros campos -->
    <table width="30%" align="right">
        <?php
            //Si las referencias del documento son mayor a cero, entonces se imprimen
            if(count((array)$documento->otros) > 0):
        ?>
        <tr>
            <th colspan="7" align="center">Otros Campos</th>
        </tr>

        <thead>
            <tr>
                <td colspan="6">Nombre</td>
                <td colspan="1" align="center">Valor</td>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($documento->otros as $key => $campo): ?>
            <tr>
                <td colspan="6"><small><?=$campo->codigo?></small></td>
                <td colspan="1" align="center"><small><?=$campo->valor?></small></td>
            </tr>
            <?php endforeach ?>
        </tbody>
        <?php endif; ?>
    </table>


    <!-- Alinear footer en la parte de abajo -->
    <div style="position: absolute; bottom: 0; width: 100%;">
        <small>Clave: <?=$documento->clave;?></small><br>
        <small>Moneda: <?=$documento->moneda;?></small><br>
        <small>Tipo Cambio: <?=number_format($documento->tipo_cambio,2,",",".") ?></small><br>
        <small>Notas: <?= $documento->notas;?></small>
        <br>
        <small><u>Monto a pagar en Dolares=
                <?=number_format(($documento->total_comprobante/$documento->tipo_cambio),2,",",".") ?></u></small>

        <br>
        <small>Emitida conforme lo establecido en la resolución de Facturación Electrónica, N° DGT-R-48-2016 siete de
            octubre de dos mil dieciséis de la Dirección General de Tributación.</small>
    </div>
</body>

</html>
