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
                        <?php if (isset($isDetail)) : ?>
                            <input value="0" class="netPrice form-control form-control-sm validar_linea" min="0" type="text" name="details[0][salePrice]">
                            <input value="0" class="originalSalePrice" type="hidden">
                        <?php else : ?>
                            <input type="text" class="form-control netValue inp" placeholder="Monto base (sin impuestos o descuentos)" data-toggle="tooltip" title="Sin impuestos o descuentos" disabled readonly>
                        <?php endif; ?>
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
                        <?php if (!isset($isDetail)) : ?>
                            <input type="text" class="form-control total_discount_money inp-product-money" placeholder="Descuentos" disabled readonly data-toggle="tooltip" title="Precio unitario * (% Descuentos / 100)">
                            <input type="hidden" class="total_discount">
                        <?php else : ?>
                            <input type="text" class="form-control detail_discount_total" placeholder="Descuentos" disabled readonly data-toggle="tooltip" title="Precio unitario * (% Descuentos / 100)">
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Valor con descuentos (subtotal) -->
            <div hidden>
                <div class="form-group">
                    <?php if (!isset($isDetail)) : ?>
                        <input type="hidden" class="subtotal">
                    <? else : ?>
                        <input type="hidden" class="detail_subtotal">
                    <?php endif; ?>
                </div>
            </div>

            <!-- Base imponible -->
            <div class="col-md-3 col-base-imponible">
                <div class="form-group">
                    <label for="baseImponible" class="ivois-label">Base imponible</label>
                    <div class="input-group input-group-sm" data-toggle="tooltip" title="Base imponible">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                        </div>
                        <!--<input class="form-control baseImponibleVL" disabled readonly>-->

                        <?php if (!isset($isDetail)) : ?>
                            <input value="0" class="base_imponible form-control baseAmount" type="text" name="baseAmount">
                        <?php else : ?>
                            <input value="0" class="detail_baseAmount form-control base_imponible calcular" type="text" name="details[0][baseAmount]">
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Otros impuestos -->
            <div class="col-md-3 col-other-taxes">
                <div class="form-group">
                    <label for="otrosImpuestos" class="ivois-label">Otros impuestos</label>
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                        </div>
                        <input type="text" class="form-control other_taxes" placeholder="Otros impuestos" disabled readonly data-toggle="tooltip" title="Otros impuestos">
                    </div>
                </div>
            </div>

            <!-- IVA -->
            <div class="col-md-3 col-iva">
                <div class="form-group">
                    <label for="impuesto" class="ivois-label">IVA</label>
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                        </div>

                        <?php if (!isset($isDetail)) : ?>
                            <input type="text" class="form-control taxValue inp-product-money" placeholder="Impuesto" disabled readonly data-toggle="tooltip" title="Precio base con descuentos * (% Impuestos / 100)">
                        <?php else : ?>
                            <input type="text" class="form-control detail_tax_total" placeholder="Impuesto" disabled readonly data-toggle="tooltip" title="Precio base con descuentos * (% Impuestos / 100)">
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Valor total con impuestos -->
            <div class="col-md-3 col-total">
                <div class="form-group">
                    <label for="valor_total_impuestos" class="ivois-label">Precio total de venta</label>
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                        </div>
                        <?php if (!isset($isDetail)) : ?>
                            <input type="text" class="form-control salePrice totalValue inp" placeholder="Valor total con impuestos" disabled readonly data-toggle="tooltip" title="Precio base con descuentos + Impuestos" name="salePrice">
                        <?php else : ?>
                            <input type="text" class="form-control inp-fct detail_total_value validar_linea" placeholder="Valor total con impuestos" data-toggle="tooltip" title="Precio base con descuentos + Impuestos">
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>