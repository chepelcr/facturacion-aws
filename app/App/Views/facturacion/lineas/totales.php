<!-- Totales -->
<div class="card">
    <div class="card-header">
        <div class="row d-flex justify-content-between">
            <div class="col-md-2">
                <h5 class="card-title align-content-center">
                    <i class="fa fa-dollar-sign"></i> Resumen
                </h5>
            </div>

            <div class="row">
                <!-- Total -->
                <div class="col-md-6">
                    <div class="input-group input-group-sm" data-toggle="tooltip" title="Venta total">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                        </div>
                        <input class="form-control form-control-sm totalVL" value="0" disabled readonly>
                        <input value="0" class="totalL inp-fct" type="hidden">
                    </div>
                </div>

                <div class="col-md-6">
                    <!-- Mininizar -->
                    <button type="button" class="btn btn-outline-danger btn-sm btn-block" data-card-widget="collapse" data-toggle="tooltip" title="Ver resumen">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <!-- Descripcion -->
            <div class="col-md-7">
                <div class="input-group input-group-sm" data-toggle="tooltip" title="Descripción">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-align-justify"></i></span>
                    </div>

                    <input class="form-control form-control-sm inp-fct description" type="text" placeholder="Descripción" readonly disabled>
                </div>
            </div>

            <!-- Unidad -->
            <div class="col-md-3">
                <div class="input-group input-group-sm" data-toggle="tooltip" title="Unidad">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-balance-scale"></i></span>
                    </div>

                    <select class="form-control form-control-sm inp-fct unitId">
                        <option value="">Selecccionar</option>
                        <?php foreach ($unidades_medida as $unit) : ?>
                            <option value="<?= $unit->unitId ?>"><?= $unit->description ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Cantidad -->
            <div class="col-md-2">
                <div class="input-group input-group-sm" data-toggle="tooltip" title="Cantidad">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                    </div>

                    <input class="form-control form-control-sm inp-fct quantity quantity-det" type="number" placeholder="Cantidad" min="1">
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <!-- Precio unitario -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="precio" class="card-title">Precio unitario</label>

                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                </div>
                                <input class="form-control form-control-sm salePrice_money" value="0" disabled readonly>
                                <input value="0" class="salePrice calcular" min="0" type="hidden" name="details[0][salePrice]">
                            </div>
                        </div>
                    </div>

                    <!-- Neto -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="neto" class="card-title">Total Neto</label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                </div>
                                <input class="form-control form-control-sm netoVL" value="0" disabled readonly>
                                <input value="0" class="neto" type="hidden">
                            </div>
                        </div>
                    </div>

                    <!-- Subtotal -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="subtotal" class="card-title">Subtotal</label>
                            <div class="input-group input-group-sm" data-toggle="tooltip" title="Subtotal">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                </div>
                                <input class="form-control form-control-sm subtotalVL" value="0" disabled readonly>
                                <input value="0" class="subtotal inp-fct" type="hidden">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->