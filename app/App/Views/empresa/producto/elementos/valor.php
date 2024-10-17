<!-- Comercial (Valor unitario, impuesto y valor total) -->
<div class="card card-form">
    <div class="card-header">
        <h4 class="card-title">
            <i class="fas fa-dollar-sign"></i> Valor del articulo
        </h4>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- Monto base (sin impuestos ni descuentos) -->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="netValue" class="ivois-label">Precio unitario</label>
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                        </div>
                        <input type="text" class="form-control netValue inp netPrice" name="netPrice" placeholder="Monto base (sin impuestos o descuentos)" data-toggle="tooltip" title="Sin impuestos o descuentos" disabled readonly>
                    </div>
                </div>
            </div>

            <!-- Descuentos -->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="descuentos" class="ivois-label">Descuentos</label>
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-percent"></i></span>
                        </div>
                        <input type="text" class="form-control total_discount_money inp-product-money" placeholder="Descuentos" disabled readonly data-toggle="tooltip" title="Precio base * (% Descuentos / 100)">
                        <input type="hidden" class="total_discount">
                    </div>
                </div>
            </div>

            <!-- Valor con descuentos (subtotal) -->
            <div hidden>
                <div class="form-group">
                    <input type="hidden" class="subtotal">
                </div>
            </div>

            <!-- Impuesto -->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="impuesto" class="ivois-label">Impuestos</label>
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                        </div>
                        <input type="text" class="form-control taxValue inp-product-money" placeholder="Impuesto" disabled readonly data-toggle="tooltip" title="Precio base con descuentos * (% Impuestos / 100)">
                    </div>
                </div>
            </div>

            <!-- Valor total con impuestos -->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="valor_total_impuestos" class="ivois-label">Precio total de venta</label>
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                        </div>
                        <input type="text" class="form-control totalValue inp" placeholder="Valor total con impuestos" disabled readonly data-toggle="tooltip" title="Precio base con descuentos + Impuestos">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>