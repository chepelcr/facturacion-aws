<!-- Comercial (Valor unitario, impuesto y valor total) -->
<div class="card card-form">
    <div class="card-header">
        <h4 class="card-title">
            <i class="fas fa-dollar-sign"></i> Valor comercial
        </h4>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- Valor unitario (precio de venta / cantidad) -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="precio" class="card-title">Precio unitario</label>

                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                        </div>
                        <input type="text" class="form-control unitPrice inp-product-money" placeholder="Precio unitario" disabled readonly data-toggle="tooltip" title="Precio de venta / Cantidad">
                    </div>
                </div>
            </div>

            <!-- Monto base (sin impuestos ni descuentos) -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="netValue" class="card-title">Precio base</label>
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                        </div>
                        <input type="text" class="form-control netValue inp" placeholder="Monto base (sin impuestos o descuentos)" data-toggle="tooltip" title="Sin impuestos o descuentos" disabled readonly>
                    </div>
                </div>
            </div>

            <!-- Valor total -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="valor_total" class="card-title">Precio de venta</label>
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                        </div>
                        <input type="text" class="form-control salePrice inp" disabled readonly placeholder="Precio de venta (Con impuestos)" data-toggle="tooltip" title="Con impuestos" name="salePrice">
                    </div>
                </div>
            </div>

            <!-- Descuentos -->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="descuentos" class="card-title">Descuentos</label>
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
            <div class="col-md-3">
                <div class="form-group">
                    <label for="valor_con_descuentos" class="card-title">Precio base con descuentos</label>
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                        </div>
                        <input type="text" class="form-control subtotal_money inp-product-money" placeholder="Subtotal" disabled readonly data-toggle="tooltip" title="Precio de venta - Descuentos">
                        <input type="hidden" class="subtotal">
                    </div>
                </div>
            </div>

            <!-- Impuesto -->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="impuesto" class="card-title">Impuestos</label>
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
                    <label for="valor_total_impuestos" class="card-title">Precio total de venta</label>
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                        </div>
                        <input type="text" class="form-control totalValue inp-product-money" placeholder="Valor total con impuestos" disabled readonly data-toggle="tooltip" title="Precio base con descuentos + Impuestos">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>