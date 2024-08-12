<!-- Totales -->
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-2">
                <h5 class="card-title">
                    <i class="fa fa-dollar-sign"></i> Resumen
                </h5>
            </div>

            <!-- Descripcion -->
            <div class="col-md-5">
                <!-- Descripcion -->
                <div class="input-group input-group-sm" data-toggle="tooltip" title="Descripción">
                    <!-- Descripcion -->
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-align-justify"></i></span>
                    </div>

                    <input class="form-control form-control-sm inp-fct descripcion" type="text"
                        placeholder="Descripción" required readonly disabled>
                </div>
            </div>

            <!-- Cantidad -->
            <div class="col-md-1">
                <!-- Cantidad -->
                <div class="input-group input-group-sm" data-toggle="tooltip" title="Cantidad">
                    <!-- Cantidad -->
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                    </div>

                    <input class="form-control form-control-sm inp-fct cantidad cantidad-det" type="number"
                        placeholder="Cantidad" min="1">
                </div>
            </div>

            <!-- Total -->
            <div class="col-md-2">
                <div class="input-group input-group-sm" data-toggle="tooltip" title="Venta total">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                    </div>
                    <input class="form-control form-control-sm totalVL" value="0" disabled readonly>
                    <input value="0" class="totalL inp-fct" type="hidden" name="linea[total_linea][]" required>
                </div>
            </div>

            <div class="col-md-2">
                <!-- Mininizar -->
                <button type="button" class="btn btn-outline-danger btn-sm btn-block" data-card-widget="collapse"
                    data-toggle="tooltip" title="Ver resumen">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <!-- Precio unitario -->
                    <div class="col-md-4">
                        <div class="input-group input-group-sm" data-toggle="tooltip" title="Precio unitario">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                            </div>
                            <input class="form-control form-control-sm precioVL" value="0" disabled readonly>
                            <input value="0" class="precio calcular inp-fct" min="0" type="hidden"
                                name="linea[precio_unidad][]">
                        </div>
                    </div>

                    <!-- Neto -->
                    <div class="col-md-4">
                        <div class="input-group input-group-sm" data-toggle="tooltip" title="Valor neto">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                            </div>
                            <input class="form-control form-control-sm netoVL" value="0" disabled readonly>
                            <input value="0" class="neto" type="hidden" name="linea[monto_total][]">
                        </div>
                    </div>

                    <!-- Subtotal -->
                    <div class="col-md-4">
                        <div class="input-group input-group-sm" data-toggle="tooltip" title="Subtotal">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                            </div>
                            <input class="form-control form-control-sm subtotalVL" value="0" disabled readonly>
                            <input value="0" class="subtotal inp-fct" type="hidden" name="linea[sub_total][]">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->