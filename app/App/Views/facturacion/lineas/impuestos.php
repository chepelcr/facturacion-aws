<!-- Impuestos -->
<div class="card card-impuestos">
    <div class="card-header">
        <div class="row d-flex justify-content-between">
            <div class="col-md-2">
                <h5 class="card-title align-content-center">
                    <i class="fa-solid fa-building-columns"></i> Impuestos
                </h5>
            </div>

            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group input-group-sm" data-toggle="tooltip" title="Total de impuestos">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                            </div>
                            <input class="form-control form-control-sm ivNetoVL" value="0" disabled readonly>
                            <input value="0" class="ivNeto inp-fct" type="hidden">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <!-- Agregar impuesto -->
                        <button type="button" class="btn btn-outline-primary btn-sm btn-block btn-add-imp" onclick="agregar_impuesto(this)" data-toggle="tooltip" title="Agregar impuesto">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <div class="col-md-3">
                        <!-- Mininizar -->
                        <button type="button" class="btn btn-outline-danger btn-sm btn-block" data-card-widget="collapse" data-toggle="tooltip" title="Ver impuestos">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="card-body">
        <table class="taxesTable table table-bordered table-striped">
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
                <tr class="taxLine">
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
                                        <select class="form-control form-control-sm taxTypes" name="details[0][taxes][0][taxTypeId]" onchange="activar_porcentajes(this)">
                                            <option value="">Seleccione un impuesto</option>
                                            <?php foreach ($taxTypes as $taxType) : ?>
                                                <option value="<?= $taxType->taxId ?>" data-code="<?= $taxType->code ?>">
                                                    <?= $taxType->description ?></option>
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
                                        <select class="form-control form-control-sm taxRates" name="details[0][taxes][0][taxRateId]" disabled onchange="colocar_tarifa(this)">
                                            <option value="">No aplica</option>
                                            <?php foreach ($taxRates as $taxRate) : ?>
                                                <option value="<?= $taxRate->rateId ?>" data-percentage="<?= $taxRate->percentage ?>" data-rateTypeId="<?= $taxRate->rateTypeId ?>" data-code="<?= $taxRate->code ?>">
                                                    <?= $taxRate->description ?></option>
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
                                        <input value="0" class="form-control form-control-sm taxPercentage impuesto_number inp-fct calcular" type="text" name="details[0][taxes][0][rate]" placeholder="13%">
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

                                        <input class="form-control form-control-sm money_value tax_amount_money" value="0" disabled readonly>

                                        <input value="0" class="tax_amount hide_num" type="hidden">
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
                                            <button type="button" class="btn btn-outline-info btn-block btn-sm" title="Exonerar" data-toggle="tooltip" onclick="exonerar_impuesto(this)">
                                                <i class="fa fa-cog"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Eliminar impuesto -->
                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-outline-danger btn-block btn-sm btn-elm" title="Eliminar impuesto" onclick="eliminar_impuesto(this)" data-toggle="tooltip" disabled>
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.row -->

                        <!-- Opciones de impuesto Collapse -->
                        <div class="collapse collapse_impuesto">
                            <div class="card card-body">
                                <div class="row">
                                    <!-- Recorrer Tipo de exoneracion -->
                                    <div class="col-md-2">
                                        <div class="input-group input-group-sm" data-toggle="tooltip" title="Tipo de exoneración">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-money-bill"></i></span>
                                            </div>

                                            <!-- Recorrer select de exoneracion -->
                                            <select class="form-control form-control-sm inp-fct excemption_documentType" name="details[0][taxes][0][exemption][documentType]">
                                                <option value="">Seleccione un tipo de exoneración
                                                </option>
                                                <?php foreach ($exemptions as $exemption) : ?>
                                                    <option value="<?= $exemption->exemptionId ?>">
                                                        <?= $exemption->description ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Numero de autorizacion -->
                                    <div class="col-md-2">
                                        <div class="input-group input-group-sm" data-toggle="tooltip" title="Número de autorización">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                                            </div>

                                            <input placeholder="Numero de exoneración" class="form-control form-control-sm inp-fct impuesto_txt excemption_number" name="details[0][taxes][0][exemption][documentNumber]" type="text">

                                            <div class="input-group-append">
                                                <!-- Boton para eliminar el contenido del campo -->
                                                <button class="btn btn-danger inp btn-elm-excemption" disabled type="button" onclick="vaciarExoneracion(this)" data-toggle="tooltip" data-placement="top" title="Eliminar exoneración">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Nombre de institucion -->
                                    <div class="col-md-3">
                                        <div class="input-group input-group-sm" data-toggle="tooltip" title="Nombre de la institución">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-building"></i></span>
                                            </div>

                                            <input placeholder="Institución emisora" name="details[0][taxes][0][exemption][institutionName]" class="form-control form-control-sm impuesto_txt excemption_institutionName inp-fct" type="text">
                                        </div>
                                    </div>

                                    <!-- Fecha del emision -->
                                    <div class="col-md-2">
                                        <div class="input-group input-group-sm" data-toggle="tooltip" title="Fecha de emisión">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                            </div>

                                            <input name="details[0][taxes][0][exemption][issueDate]" class="form-control form-control-sm inp-fct impuesto_txt excemption_issueDate" type="date">
                                        </div>
                                    </div>

                                    <!-- Porcentaje -->
                                    <div class="col-md-1">
                                        <div class="input-group input-group-sm" data-toggle="tooltip" title="Porcentaje de exoneración">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-percent"></i></span>
                                            </div>
                                            <input value="0" placeholder="13%" class="form-control form-control-sm inp-fct calcular impuesto_number excemption_percentage" type="text" name="details[0][taxes][0][exemption][percentage]" min="0" max="100">
                                        </div>
                                    </div>

                                    <!-- Monto de exoneracion -->
                                    <div class="col-md-2">
                                        <div class="input-group input-group-sm" data-toggle="tooltip" title="Monto de exoneración">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                            </div>

                                            <input class="form-control form-control-sm inp-fct money_value excemption_amount_money" readonly disabled type="text">
                                            <input class="excemption_amount" type="hidden">
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