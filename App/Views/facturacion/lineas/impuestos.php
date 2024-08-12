<!-- Impuestos -->
<div class="card card-impuestos">
    <div class="card-header">
        <div class="row">
            <div class="col-md-2">
                <h5 class="card-title">
                    <i class="fa-solid fa-building-columns"></i>
                    Impuestos
                </h5>
            </div>

            <div class="col-md-6"></div>

            <div class="col-md-2">
                <div class="input-group input-group-sm" data-toggle="tooltip" title="Total de impuestos">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                    </div>
                    <input class="form-control form-control-sm ivNetoVL" value="0" disabled readonly>
                    <input value="0" class="ivNeto inp-fct" type="hidden" name="linea[impuesto_neto][]">
                </div>
            </div>

            <div class="col-md-2">
                <div class="row">
                    <div class="col-md-6">
                        <!-- Agregar impuesto -->
                        <button type="button" class="btn btn-outline-primary btn-sm btn-block"
                            onclick="agregar_impuesto(this)" data-toggle="tooltip" title="Agregar impuesto">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <div class="col-md-6">
                        <!-- Mininizar -->
                        <button type="button" class="btn btn-outline-danger btn-sm btn-block"
                            data-card-widget="collapse" data-toggle="tooltip" title="Ver impuestos">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-body">
        <table class="tabla_impuestos table table-bordered table-striped">
            <thead>
                <tr>
                    <th class="col-4">Tipo de impuesto</th>
                    <th class="col-2">Tarifa</th>
                    <th class="col-1">%</th>
                    <th class="col-3">Monto</th>
                    <th class="col-2">Acciones</th>
                </tr>
            </thead>

            <tbody>
                <tr class="linea_impuesto">
                    <td colspan="5">
                        <div class="row">
                            <!-- Tipo de impuesto -->
                            <div class="col-4">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-money-bill"></i></span>
                                        </div>

                                        <!-- Recorrer select de impuestos -->
                                        <select class="form-control form-control-sm imp"
                                            name="impuesto[codigo_impuesto][]" onchange="activar_porcentajes(this)">
                                            <option value="NA">Seleccione un impuesto</option>
                                            <?php foreach ($impuestos as $impuesto) : ?>
                                            <option value="<?= $impuesto->id_impuesto ?>">
                                                <?= $impuesto->descripcion ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Seleccionar porcentaje -->
                            <div class="col-2">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-percent"></i></span>
                                        </div>

                                        <!-- Recorrer los porcentajes de impuesto -->
                                        <select class="form-control form-control-sm tarifas"
                                            name="impuesto[codigo_tarifa][]" disabled onchange="colocar_tarifa(this)">
                                            <option value="NA">No aplica</option>
                                            <?php foreach ($tarifas as $porcentaje) : ?>
                                            <option value="<?= $porcentaje->id_tarifa ?>"
                                                data-porcentaje="<?= $porcentaje->porcentaje ?>"
                                                data-tipoTarifa="<?= $porcentaje->tipo_tarifa ?>">
                                                <?= $porcentaje->descripcion ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Mostrar porcentaje -->
                            <div class="col-1">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-percent"></i></span>
                                        </div>
                                        <input class="form-control form-control-sm impP imp_P inp-fct calcular"
                                            type="text" name="impuesto[tarifa][]" placeholder="13%">

                                    </div>
                                </div>
                            </div>

                            <!-- Monto impuesto -->
                            <div class="col-3">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                        </div>

                                        <input class="form-control form-control-sm VL impVL" value="0" disabled
                                            readonly>

                                        <input value="0" class="impuesto hide_num" type="hidden"
                                            name="impuesto[monto_impuesto][]">
                                    </div>
                                </div>
                            </div>

                            <!-- Acciones -->
                            <div class="col-2">
                                <!-- Opciones de impuesto -->
                                <div class="row d-flex justify-content-around">
                                    <!-- Exonerar impuesto -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-outline-info btn-block btn-sm"
                                                title="Exonerar" data-toggle="tooltip"
                                                onclick="exonerar_impuesto(this)">
                                                <i class="fa fa-cog"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Eliminar impuesto -->
                                    <div class="col-md-6 btn-elm" hidden>
                                        <div class="form-group">
                                            <button type="button" class="btn btn-outline-danger btn-block btn-sm"
                                                title="Eliminar impuesto" onclick="eliminar_impuesto(this)"
                                                data-toggle="tooltip">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Numero de linea -->
                                <input value="0" class="numero_linea" type="hidden" name="impuesto[numero_linea][]">
                            </div>
                        </div>
                        <!-- /.row -->

                        <!-- Opciones de impuesto Collapse -->
                        <div class="collapse collapse_impuesto">
                            <div class="card card-body">
                                <div class="row">
                                    <!-- Recorrer Tipo de exoneracion -->
                                    <div class="col-md-2">
                                        <div class="input-group input-group-sm" data-toggle="tooltip"
                                            title="Tipo de exoneración">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-money-bill"></i></span>
                                            </div>

                                            <!-- Recorrer select de exoneracion -->
                                            <select class="form-control form-control-sm inp-fct tp_exoneracion"
                                                name="impuesto[exoneracion][]">
                                                <option value="NA">Seleccione un tipo de exoneración
                                                </option>
                                                <?php foreach ($exoneraciones as $exoneracion) : ?>
                                                <option value="<?= $exoneracion->codigo_exoneracion ?>">
                                                    <?= $exoneracion->descripcion ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Numero de autorizacion -->
                                    <div class="col-md-2">
                                        <div class="input-group input-group-sm" data-toggle="tooltip"
                                            title="Número de autorización">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                                            </div>

                                            <input placeholder="Numero de exoneración"
                                                class="form-control form-control-sm inp-fct impuesto_txt num_exoneracion"
                                                name="impuesto[numero_exoneracion][]" type="text">
                                        </div>
                                    </div>

                                    <!-- Nombre de institucion -->
                                    <div class="col-md-3">
                                        <div class="input-group input-group-sm" data-toggle="tooltip"
                                            title="Nombre de la institución">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-building"></i></span>
                                            </div>

                                            <input placeholder="Institución"
                                                class="form-control form-control-sm impuesto_txt nombre_institucion nom_ins_vL inp-fct"
                                                type="text">
                                            <input type="hidden" name="impuesto[nombre_institucion][]"
                                                class="nombre_institucion impuesto_txt">
                                        </div>
                                    </div>

                                    <!-- Fecha del emision -->
                                    <div class="col-md-2">
                                        <div class="input-group input-group-sm" data-toggle="tooltip"
                                            title="Fecha de emisión">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i
                                                        class="fas fa-calendar-alt"></i></span>
                                            </div>

                                            <input
                                                class="form-control form-control-sm inp-fct impuesto_txt fecha_exoneracion fec_ex_VL"
                                                type="date">
                                            <input type="hidden" name="impuesto[fecha_exoneracion][]"
                                                class="impuesto_txt fecha_exoneracion">
                                        </div>
                                    </div>

                                    <!-- Porcentaje -->
                                    <div class="col-md-1">
                                        <div class="input-group input-group-sm" data-toggle="tooltip"
                                            title="Porcentaje de exoneración">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-percent"></i></span>
                                            </div>
                                            <input placeholder="13%"
                                                class="form-control form-control-sm inp-fct calcular imp_P porcentaje_exoneracion p_Ex_VL"
                                                type="text">
                                            <input type="text" name="impuesto[porcentaje_exoneracion][]" hidden
                                                class="imp_P porcentaje_exoneracion">
                                        </div>
                                    </div>

                                    <!-- Monto de exoneracion -->
                                    <div class="col-md-2">
                                        <div class="input-group input-group-sm" data-toggle="tooltip"
                                            title="Monto de exoneración">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                            </div>

                                            <input class="form-control form-control-sm inp-fct VL montExVL" readonly
                                                disabled type="text">
                                            <input class=" montEx hide_num" type="hidden"
                                                name="impuesto[monto_exoneracion][]" value="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->