<div class="card">
    <div class="card-body scroll_vertical card-facturacion">
        <table class="table table-bordered table-hover text-center" id="documentos">
            <thead class="bg-gray-dark">
                <tr>
                    <th>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" onclick="check_documentos(this)" id="check_documentos">
                            <label class="custom-control-label" for="check_documentos"></label>
                        </div>
                    </th>
                    <th class="col-1" data-toggle="tooltip" title="Estado"><i class="fas fa-building"></i></th>
                    <th class="col-2">Fecha</th>
                    <th hidden></th>
                    <th class="col-5">Consecutivo</th>
                    <th class="col-2">Total</th>
                    <th class="col-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <form id="frm_reporte_documentos">
                    <?php
                    foreach ($documentos as $key => $documento) :
                        $documentUrl = getEnt('ivois.cdn.url') . "$documento->documentRoute/$documento->documentName.pdf";
                    ?>
                        <tr>
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input chk-dct" value="<?= $documento->documentId ?>" id="documento_<?= $documento->documentId ?>" name="documento[]">
                                    <label class="custom-control-label" for="documento_<?= $documento->documentId ?>"></label>
                                </div>
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-md-12">
                                        <?php
                                        if ($documento->atvValidation->sendDate != null) {
                                            if ($documento->atvValidation->validationStatus == '1') {
                                                //Mostrar circulo verde
                                                echo '<i class="fas fa-check-circle text-success" title="Validado" data-toggle="tooltip"></i>';
                                                //Mostrar etiqueta oculta
                                                echo '<span class="d-none">Validado</span>';
                                            } elseif ($documento->atvValidation->validationStatus == '3') {
                                                //Mostrar circulo rojo
                                                echo '<i class="fas fa-times-circle text-danger" title="Rechazado" data-toggle="tooltip"></i>';
                                                //Mostrar etiqueta oculta
                                                echo '<span class="d-none">Rechazado</span>';
                                            } else {
                                                //Mostrar circulo amarillo
                                                echo '<i class="fas fa-exclamation-circle text-warning" title="En proceso" data-toggle="tooltip"></i>';
                                                //Mostrar etiqueta oculta
                                                echo '<span class="d-none">En proceso</span>';
                                            }
                                        } else {
                                            //Mostrar circulo rojo
                                            echo '<i class="fas fa-exclamation-circle text-danger" title="Sin enviar" data-toggle="tooltip"></i>';
                                            //Poner etiqueta oculta
                                            echo '<span class="d-none">Sin enviar</span>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </td>
                            <td hidden>
                                <?= $documento->saleDate ?>
                            </td>
                            <td><?= date('d-m-Y', strtotime($documento->saleDate)) ?></td>
                            <td><?= $documento->consecutiveNumber ?></td>
                            <td><?= formatMoney($documento->summary->voucherTotal, $documento->summary->currencyCode->currencyCode) ?></td>
                            <td>
                                <div class="dropdown dropleft">
                                    <!-- Descargar -->
                                    <button onclick="descargarArchivo('<?= $documentUrl ?>', '<?= $documento->documentName ?>', 'pdf')" type="button" data-toggle="tooltip" data-placement="top" title="Descargar documento" class="btn btn-danger btn-descargar">
                                        <i class="fas fa-download"></i>
                                    </button>

                                    <!-- Ver PDF en el modal-->
                                    <button onclick="verPdf('<?= $documentUrl ?>');" type="button" data-toggle="tooltip" data-placement="top" title="Ver documento" class="btn btn-info btn-ver">
                                        <i class="fas fa-eye"></i>
                                    </button>


                                    <button type="button" class="btn btn-dark nav-opciones dropdown-toggle dropdown-toggle-split" id="nv-opc_doc" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>

                                    <div class="dropdown-menu dropdown-menu-right p-0">
                                        <div class="dropdown-item p-1">
                                            <div class="row">
                                                <?php
                                                if ($documento->atvValidation->validationStatus == '1') {
                                                ?>
                                                    <!-- Revalidar documento -->
                                                    <div class="col-md-12 pb-1">
                                                        <button onclick="validar_documento('<?= $documento->documentKey ?>');" type="button" data-toggle="tooltip" title="Revalidar documento" class="btn btn-warning btn-validar btn-block">
                                                            <i class="fas fa-check-circle"></i>
                                                        </button>
                                                    </div>

                                                    <!-- Notificar -->
                                                    <div class="col-md-4">
                                                        <button onclick="abrirModalNotificar('<?= $documento->documentKey ?>')" type="button" data-toggle="tooltip" title="Reenviar correo" class="btn btn-info btn-correo btn-block">
                                                            <i class="fas fa-envelope"></i>
                                                        </button>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <button onclick="emitir_nota_credito('<?= $documento->documentKey ?>');" type="button" data-toggle="tooltip" disabled title="Emitir nota de credito" class="btn btn-danger btn-nota-credito btn-block">
                                                            <i class="fas fa-funnel-dollar"></i>
                                                        </button>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <button onclick="emitir_nota_debito(' . $documento->documentKey . ');" type="button" data-toggle="tooltip" disabled title="Emitir nota de debito" class="btn btn-warning btn-nota-debito btn-block">
                                                            <i class="fas fa-coins"></i>
                                                        </button>
                                                    </div>

                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </form>
            </tbody>
        </table>
    </div>

    <div class="card-footer">
        <div class="row">
            <div class="col-md-12">
                <?php
                //Obtener fecha de hoy en gmt-6
                $fecha_hoy = date('Y-m-d\TH:i:s', strtotime('-6 hours'));

                //Poner la fecha en y-m-d
                $fecha_hoy = date('Y-m-d', strtotime($fecha_hoy));

                if (!isset($startDate) && !isset($endDate)) {
                    //Fecha_fin
                    $endDate = $fecha_hoy;

                    switch ($reportType) {
                        case 'diarios':
                            $startDate = $fecha_hoy;
                            break;

                        case 'semanal':
                            $startDate = date('Y-m-d', strtotime('-7 days'));
                            //Fecha de hoy menos 1 dia
                            $endDate = date('Y-m-d', strtotime('-1 days', strtotime($fecha_hoy)));
                            break;

                        case 'semana_anterior':
                            //Obtener el lunes de la semana anterior
                            $startDate = date('Y-m-d', strtotime('last monday -7 days'));

                            //Obtener el domingo de esta semana
                            $endDate = date('Y-m-d', strtotime('last sunday'));
                            break;

                        case 'semana':
                            //Obtener el lunes de esta semana
                            $startDate = date('Y-m-d', strtotime('last monday'));
                            break;

                        case 'mes':
                            $startDate = date('Y-m-01');
                            break;

                        case 'mes_anterior':
                            $startDate = date('Y-m-01', strtotime('-1 month'));
                            $endDate = date('Y-m-t', strtotime('-1 month'));
                            break;
                    }
                }
                ?>
                <form id="frm_filtro_documentos">
                    <div class="row">
                        <!-- Periodo -->
                        <div class="col-md-3">
                            <div class="input-group">
                                <label class="text-left pr-1">Reporte:</label>
                                <select class="form-control form-control-sm" onchange="cargar_documentos(this.value)" name="reportType" id="reportType">
                                    <option value="all" <?php if (isset($reportType) && $reportType == 'all') echo 'selected' ?>>
                                        Todos</option>
                                    <option value="diarios" <?php if (isset($reportType) && $reportType == 'diarios') echo 'selected' ?>>
                                        Diario
                                    </option>
                                    <option value="semanal" <?php if (isset($reportType) && $reportType == 'semanal') echo 'selected' ?>>
                                        Ultima semana
                                    </option>
                                    <option value="semana" <?php if (isset($reportType) && $reportType == 'semana') echo 'selected' ?>>Esta
                                        semana
                                    </option>
                                    <option value="mes" <?php if (isset($reportType) && $reportType == 'mes') echo 'selected' ?>>
                                        Este mes</option>
                                    <option value="semana_anterior" <?php if (isset($reportType) && $reportType == 'semana_anterior') echo 'selected' ?>>
                                        Semana anterior</option>
                                    <option value="mes_anterior" <?php if (isset($reportType) && $reportType == 'mes_anterior') echo 'selected' ?>>
                                        Mes anterior</option>
                                    <option value="buscar" <?php if (isset($reportType) && $reportType == 'buscar') echo 'selected' ?>>
                                        Busqueda
                                    </option>
                                </select>
                            </div>
                        </div>

                        <!-- Fecha de inicio -->
                        <div class="col-md-3">
                            <div class="input-group">
                                <label class="text-left pr-1">Fecha de inicio:</label>
                                <input class="form-control form-control-sm" id="startDate" type="date" name="startDate" value="<?php echo $startDate; ?>" max="<?php echo $endDate; ?>" min="<?= $startDate ?>" onchange="asignar_fecha(this)">
                            </div>
                        </div>

                        <!-- Fecha de fin -->
                        <div class="col-md-3">
                            <div class="input-group">
                                <label class="text-left pr-1">Fecha de fin:</label>
                                <input class="form-control form-control-sm" id="endDate" type="date" name="endDate" value="<?= $endDate ?>" max="<?= $endDate ?>" min="<?= $startDate ?>">
                            </div>
                        </div>

                        <!-- Tipo de documento -->
                        <div class="col-md-2">
                            <div class="input-group">
                                <label class="text-left pr-1">Documento:</label>
                                <select class="form-control form-control-sm" id="documentTypeId" name="documentTypeId" onchange="cargar_documentos('busqueda')">
                                    <option value="all">Todos</option>
                                    <?php foreach ($documentTypes as $tipo_documento) :
                                        if ($tipo_documento->documentType == 'Emisión') : ?>
                                            <option value="<?= $tipo_documento->documentTypeId ?>" <?php if ($tipo_documento->documentTypeId == $documentTypeId) echo 'selected' ?>>
                                                <?= $tipo_documento->description ?></option>
                                    <?php endif;
                                    endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Opciones -->
                        <div class="col-md-1">
                            <button class="btn btn-primary btn-block btn-sm" data-toggle="tooltip" title="Buscar" id="btn_buscar" type="submit" onclick="cargar_documentos('busqueda')">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>