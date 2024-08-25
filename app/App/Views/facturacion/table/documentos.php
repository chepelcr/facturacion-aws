<div class="card">
    <div class="card-body scroll_vertical" style="max-height: 450px; overflow-y: auto;">
        <table class="table table-bordered table-hover text-center" id="documentos">
            <thead class="bg-gray-dark">
                <tr>
                    <th>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" onclick="check_documentos(this)" id="check_documentos">
                            <label class="custom-control-label" for="check_documentos"></label>
                        </div>
                    </th>
                    <th hidden></th>
                    <th class="col-1" data-toggle="tooltip" title="Estado"><i class="fas fa-building"></i></th>
                    <th class="col-2">Fecha</th>
                    <th class="col-5">Consecutivo</th>
                    <th class="col-2">Total</th>
                    <th class="col-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <form id="frm_reporte_documentos">
                    <?php //var_dump($documentos);
                    foreach ($documentos as $key => $documento) :
                        $fecha = date('d/m/Y', strtotime($documento->fecha));
                        //Obtener la fecha de inicio mas antigua en y-m-d
                        if ($key == 0) {
                            $fecha_inicio = date('Y-m-d', strtotime($documento->fecha));
                        }
                    ?>
                        <tr>
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input chk-dct" value="<?= $documento->id_documento ?>" id="documento_<?= $documento->id_documento ?>" name="documento[]">
                                    <label class="custom-control-label" for="documento_<?= $documento->id_documento ?>"></label>
                                </div>
                            </td>
                            <td hidden>
                                <?= $documento->receptor_comercial ?>
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-md-12">
                                        <?php
                                        if ($documento->envio_atv == '1') {
                                            if ($documento->valido_atv == '1') {
                                                //Mostrar circulo verde
                                                echo '<i class="fas fa-check-circle text-success" title="Validado" data-toggle="tooltip"></i>';
                                                //Mostrar etiqueta oculta
                                                echo '<span class="d-none">Validado</span>';
                                            } elseif ($documento->valido_atv == '3') {
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
                            <td><?= $fecha ?></td>
                            <td><?= $documento->consecutivo ?></td>
                            <td>¢ <?= number_format($documento->total_comprobante, "2", ",", ".") ?></td>
                            <td>
                                <div class="dropdown dropleft">
                                    <!-- Imprimir -->
                                    <button onclick="location.href='<?= baseUrl('documentos/descargar_pdf/' . $documento->id_documento) ?>';" type="button" data-toggle="tooltip" data-placement="top" title="Descargar documento" class="btn btn-danger btn-descargar">
                                        <i class="fas fa-download"></i>
                                    </button>

                                    <!-- Ver PDF en nueva pestania-->
                                    <button onclick="verPdf('<?= $documento->id_documento ?>');" type="button" data-toggle="tooltip" data-placement="top" title="Ver documento" class="btn btn-info btn-ver">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    <?php
                                        if($documento->valido_atv != '3'):
                                    ?>

                                    <button type="button" class="btn btn-dark nav-opciones dropdown-toggle dropdown-toggle-split" id="nv-opc_doc" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>

                                    <div class="dropdown-menu dropdown-menu-right p-0">
                                        <div class="dropdown-item p-1">
                                            <div class="row">
                                                <?php
                                                if ($documento->envio_atv == '1') {
                                                    //Mostrar boton de enviar
                                                    echo '<div class="col-md-6">
                                                            <button onclick="enviar_hacienda(' . $documento->id_documento . ');" type="button" data-toggle="tooltip" title="Enviar documento" class="btn btn-success btn-enviar btn-block">
                                                                <i class="fas fa-paper-plane"></i>
                                                            </button>
                                                        </div>';

                                                    //Mostrar boton de editar
                                                    echo '<div class="col-md-6">
                                                            <button disabled onclick="editar_documento(' . $documento->id_documento . ');" type="button" data-toggle="tooltip" title="Editar documento" class="btn btn-warning btn-editar btn-block">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                        </div>';
                                                }

                                                
                                                ?>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                        endif;
                                    ?>
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

                if (isset($fecha_inicio) && isset($fecha_fin)) {
                    $fecha_inicio = $fecha_inicio;
                    $fecha_fin = $fecha_fin;
                } else {
                    //Fecha_fin
                    $fecha_fin = $fecha_hoy;

                    switch ($tipo_reporte) {
                        case 'diarios':
                            $fecha_inicio = $fecha_hoy;
                            break;

                        case 'semanal':
                            $fecha_inicio = date('Y-m-d', strtotime('-7 days'));
                            //Fecha de hoy menos 1 dia
                            $fecha_fin = date('Y-m-d', strtotime('-1 days', strtotime($fecha_hoy)));
                            break;

                        case 'semana_anterior':
                            //Obtener el lunes de la semana anterior
                            $fecha_inicio = date('Y-m-d', strtotime('last monday -7 days'));

                            //Obtener el domingo de esta semana
                            $fecha_fin = date('Y-m-d', strtotime('last sunday'));
                            break;

                        case 'semana':
                            //Obtener el lunes de esta semana
                            $fecha_inicio = date('Y-m-d', strtotime('last monday'));
                            break;

                        case 'mes':
                            $fecha_inicio = date('Y-m-01');
                            break;

                        case 'mes_anterior':
                            $fecha_inicio = date('Y-m-01', strtotime('-1 month'));
                            $fecha_fin = date('Y-m-t', strtotime('-1 month'));
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
                                <select class="form-control form-control-sm" onchange="cargar_documentos(this.value)" name="tipo_reporte" id="tipo_reporte">
                                    <option value="all" <?php if (isset($tipo_reporte) && $tipo_reporte == 'all') echo 'selected' ?>>
                                        Todos</option>
                                    <option value="diarios" <?php if (isset($tipo_reporte) && $tipo_reporte == 'diarios') echo 'selected' ?>>
                                        Diario
                                    </option>
                                    <option value="semanal" <?php if (isset($tipo_reporte) && $tipo_reporte == 'semanal') echo 'selected' ?>>
                                        Ultima semana
                                    </option>
                                    <option value="semana" <?php if (isset($tipo_reporte) && $tipo_reporte == 'semana') echo 'selected' ?>>Esta
                                        semana
                                    </option>
                                    <option value="mes" <?php if (isset($tipo_reporte) && $tipo_reporte == 'mes') echo 'selected' ?>>
                                        Este mes</option>
                                    <option value="semana_anterior" <?php if (isset($tipo_reporte) && $tipo_reporte == 'semana_anterior') echo 'selected' ?>>
                                        Semana
                                        anterior</option>
                                    <option value="mes_anterior" <?php if (isset($tipo_reporte) && $tipo_reporte == 'mes_anterior') echo 'selected' ?>>
                                        Mes
                                        anterior</option>
                                    <option value="buscar" <?php if (isset($tipo_reporte) && $tipo_reporte == 'buscar') echo 'selected' ?>>
                                        Busqueda
                                    </option>
                                </select>
                            </div>
                        </div>

                        <!-- Fecha de inicio -->
                        <div class="col-md-3">
                            <div class="input-group">
                                <label class="text-left pr-1">Fecha de inicio:</label>
                                <input class="form-control form-control-sm" id="fecha_inicio" type="date" name="fecha_inicio" value="<?php echo $fecha_inicio; ?>" max="<?php echo $fecha_fin; ?>" min="<?= $fecha_inicio ?>" onchange="asignar_fecha(this)">
                            </div>
                        </div>

                        <!-- Fecha de fin -->
                        <div class="col-md-3">
                            <div class="input-group">
                                <label class="text-left pr-1">Fecha de fin:</label>
                                <input class="form-control form-control-sm" id="fecha_fin" type="date" name="fecha_fin" value="<?= $fecha_fin ?>" max="<?= $fecha_fin ?>" min="<?= $fecha_inicio ?>">
                            </div>
                        </div>

                        <!-- Tipo de documento -->
                        <div class="col-md-2">
                            <div class="input-group">
                                <label class="text-left pr-1">Documento:</label>
                                <select class="form-control form-control-sm" id="id_tipo_documento" name="id_tipo_documento" onchange="cargar_documentos('busqueda')">
                                    <option value="all">Todos</option>
                                    <?php foreach ($tipos_documentos as $tipo_documento) : 
                                        if($tipo_documento->tipo_documento == 'E'):
                                    ?>
                                        <option value="<?= $tipo_documento->id_tipo_documento ?>" <?php if ($tipo_documento->id_tipo_documento == $id_tipo_documento) echo 'selected' ?>>
                                            <?= $tipo_documento->descripcion ?></option>
                                    <?php 
                                        endif;
                                    endforeach;
                                    ?>
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