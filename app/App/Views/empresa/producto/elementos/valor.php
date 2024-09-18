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
                    <label for="precio" class="card-title">Valor unitario</label>

                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                        </div>
                        <input type="text" class="form-control unitPrice" placeholder="Valor unitario" disabled readonly>
                    </div>
                </div>
            </div>

            <!-- Valor neto (sin impuestos ni descuentos) -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="netValue" class="card-title">Valor neto</label>
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                        </div>
                        <input type="text" class="form-control netValue inp" placeholder="Valor neto">
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
                        <input type="text" class="form-control salePrice inp" disabled readonly placeholder="Valor total" name="salePrice">
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
                        <input type="text" class="form-control total_discount_money" placeholder="Descuentos" disabled readonly>
                        <input type="hidden" class="total_discount">
                    </div>
                </div>
            </div>

            <!-- Valor con descuentos (subtotal) -->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="valor_con_descuentos" class="card-title">Subtotal</label>
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                        </div>
                        <input type="text" class="form-control subtotal_money" placeholder="Subtotal" disabled readonly>
                        <input type="hidden" class="subtotal">
                    </div>
                </div>
            </div>

            <!-- Impuesto -->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="impuesto" class="card-title">Impuesto</label>
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                        </div>
                        <input type="text" class="form-control taxValue" placeholder="Impuesto" disabled readonly>
                    </div>
                </div>
            </div>

            <!-- Valor total con impuestos -->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="valor_total_impuestos" class="card-title">Valor final</label>
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                        </div>
                        <input type="text" class="form-control totalValue" placeholder="Valor total con impuestos" disabled readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>