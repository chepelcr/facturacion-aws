<!-- Descuentos -->
<div class="card card-descuentos">
    <div class="card-header">
        <div class="row d-flex justify-content-between">
            <div class="col-md-2">
                <h4 class="card-title align-content-center">
                    <i class="fas fa-percent"></i> Descuentos
                </h4>
            </div>

            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group" data-toggle="tooltip" title="Total de descuentos">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                            </div>
                            <input class="form-control form-control-sm total_discount_money" value="0" disabled readonly>
                        </div>
                    </div>

                    <!-- Agregar descuento -->
                    <div class="col-md-3">
                        <button type="button" class="btn btn-outline-primary btn-sm btn-block inp" onclick="agregar_descuento_producto()" data-toggle="tooltip" title="Agregar descuento">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>

                    <!-- Mininizar -->
                    <div class="col-md-3">
                        <button type="button" class="btn btn-outline-danger btn-sm btn-block" data-card-widget="collapse" data-toggle="tooltip" title="Ver descuentos">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-body">
        <table class="discounts table table-bordered table-striped">
            <thead>
                <tr>
                    <th class="col-6 ivois-label">Motivo de descuento</th>
                    <th class="col-2 ivois-label">%</th>
                    <th class="col-3 ivois-label">Monto</th>
                    <th class="col-1 ivois-label">Acciones</th>
                </tr>
            </thead>

            <tbody>
                <tr class="discountLine">
                    <td colspan="4">
                        <div class="row">
                            <!-- Motivo -->
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-align-justify"></i>
                                            </span>
                                        </div>
                                        <input class="form-control form-control-sm inp discount-inp discount_reason" type="text" name="discounts[0][reason]" placeholder="Motivo de descuento">
                                    </div>
                                </div>
                            </div>

                            <!-- Porcentaje -->
                            <div class="col-2">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-percent"></i>
                                            </span>
                                        </div>

                                        <input class="form-control form-control-sm discount-inp discount_percentage inp" name="discounts[0][percentage]" min="0" type="number" max="100" value="0">
                                    </div>
                                </div>
                            </div>

                            <!-- Monto descuento -->
                            <div class="col-3">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </span>
                                        </div>

                                        <input class="form-control form-control-sm discount_amount_money" value="0" disabled readonly>
                                        <input value="0" class="discount_amount" type="hidden">
                                    </div>
                                </div>
                            </div>

                            <!-- Acciones -->
                            <div class="col-1">
                                <div class="form-group">
                                    <button type="button" class="btn btn-outline-danger btn-sm btn-block btn-dlt inp" disabled onclick="eliminar_descuento_producto(this)">
                                        <i class="fa fa-trash"></i>
                                    </button>
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