<!-- Totales -->
<div class="card">
    <div class="card-header">
        <div class="row d-flex justify-content-between">
            <div class="col-md-6">
                <h5 class="card-title align-content-center">
                    <i class="fa fa-dollar-sign"></i> Montos de la venta
                </h5>
            </div>

            <div class="col-md-2">
                <!-- Mininizar -->
                <button type="button" class="btn btn-outline-danger btn-sm btn-block" data-card-widget="collapse" data-toggle="tooltip" title="Ver resumen">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <!-- Cantidad -->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="cantidad" class="ivois-label">Cantidad a facturar</label>

                    <div class="input-group input-group-sm" data-toggle="tooltip" title="Cantidad">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                        </div>

                        <input class="form-control form-control-sm inp-fct quantity-det quantity-det-mod" name="details[0][quantity]" type="number" placeholder="Cantidad" min="1" max="99">
                    </div>
                </div>
            </div>

            <!-- Neto -->
            <div class="col-md-5">
                <div class="form-group">
                    <label for="neto" class="ivois-label">Total Neto</label>
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                        </div>
                        <input class="form-control form-control-sm netoVL" disabled readonly>
                        <input value="0" class="neto" type="hidden">
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="discount" class="ivois-label">Descuento</label>
                    <div class="input-group" data-toggle="tooltip" title="Total de descuentos">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                        </div>
                        <input class="form-control form-control-sm total_discount_money" value="0" disabled readonly>
                        <input value="0" class="total_discount inp-fct" type="hidden">
                    </div>
                </div>
            </div>

            <!-- Subtotal -->
            <div class="col-md-12" hidden>
                <div class="form-group">
                    <label for="subtotal" class="ivois-label">Subtotal</label>
                    <div class="input-group input-group-sm" data-toggle="tooltip" title="Subtotal">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                        </div>
                        <input class="form-control form-control-sm subtotalVL" value="0" disabled readonly>
                        <input value="0" class="subtotal inp-fct" type="hidden">
                    </div>
                </div>
            </div>

            <!-- Otros impuestos -->
            <div class="col-md-4 col-otros-impuestos" hidden>
                <div class="form-group">
                    <label for="otrosImpuestos" class="ivois-label">Otros impuestos</label>
                    <div class="input-group input-group-sm" data-toggle="tooltip" title="Otros impuestos">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                        </div>
                        <input class="form-control form-control-sm otrosImpuestosVL" value="0" disabled readonly>
                        <input value="0" class="otrosImpuestos inp-fct" type="hidden">
                    </div>
                </div>
            </div>

            <!-- Base imponible -->
            <div class="col-md-4" hidden>
                <div class="form-group">
                    <label for="baseImponible" class="ivois-label">Base imponible</label>
                    <div class="input-group input-group-sm" data-toggle="tooltip" title="Base imponible">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                        </div>
                        <input class="form-control form-control-sm baseImponibleVL" value="0" disabled readonly>
                        <input value="0" class="baseImponible inp-fct" type="hidden">
                    </div>
                </div>
            </div>

            <!-- I,V,A -->
            <div class="col-md-4 col-iva">
                <div class="form-group">
                    <label for="iva" class="ivois-label">Impuesto al valor agregado</label>
                    <div class="input-group input-group-sm" data-toggle="tooltip" title="Total de IVA">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                        </div>
                        <input class="form-control form-control-sm ivNetoVL" value="0" disabled readonly>
                        <input value="0" class="ivNeto inp-fct" type="hidden">
                    </div>
                </div>
            </div>

            <!-- Total -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="total" class="ivois-label">Total de la linea</label>
                    <div class="input-group input-group-sm" data-toggle="tooltip" title="Venta total">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                        </div>
                        <input class="form-control form-control-sm totalVL" value="0" disabled readonly>
                        <input value="0" class="totalL inp-fct" type="hidden">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->