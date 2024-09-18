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
                            <input value="0" class="ivNeto inp" type="hidden">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <!-- Agregar impuesto -->
                        <button type="button" class="btn btn-outline-primary btn-sm btn-block btn-add-imp" onclick="agregar_impuesto_producto(this)" data-toggle="tooltip" title="Agregar impuesto">
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
                                        <select class="form-control form-control-sm taxTypes" name="taxes[0][taxTypeId]" onchange="activar_porcentajes_producto(this)">
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
                                        <select class="form-control form-control-sm taxRates" name="taxes[0][taxRateId]" disabled onchange="colocar_tarifa_producto(this)">
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
                                        <input value="0" class="form-control form-control-sm taxPercentage impuesto_number inp calcular-producto" type="text" name="taxes[0][rate]" placeholder="13%">
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
                                <div class="form-group">
                                    <button type="button" class="btn btn-outline-danger btn-block btn-sm btn-elm" title="Eliminar impuesto" onclick="eliminar_impuesto_producto(this)" data-toggle="tooltip" disabled>
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- /.row -->
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->