<div class="card card-form">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-landmark"></i> Información Fiscal
        </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fas fa-minus"></i></button>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <!-- Select de tipo de producto -->
            <div class="col-md-12">
                <div class="form-group">
                    <label for="tipo_producto" class="ivois-label">Tipo de producto</label>
                    <div class="row input-group">
                        <?php foreach ($productTypes as $productType) : ?>
                            <div class="col-md-4 form-group">
                                <!-- Radio buttons -->
                                <div class="form-check form-check-inline">
                                    <input class="form-check form-check-input cabys ivois-radio productType-radio productType-<?php echo $productType->id; ?>" type="radio" value="<?php echo $productType->id; ?>" <?php if ($productType->id == 1) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?>>

                                    <label class="form-check form-check-label ivois-label" for="productType-<?php echo $productType->id; ?>"><?php echo $productType->description; ?></label>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Impuesto sugerido -->
            <div hidden>
                <input readonly class="form-control inp cabys category_suggestedTax" type="number" max="100">
            </div>

            <!-- Descripción del producto -->
            <div class="col-md-8">
                <div class="form-group">
                    <label for="descripcion_cabys" class="ivois-label">
                        Descripción del código cabys
                    </label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-id-card"></i>
                            </span>
                        </div>
                        <input class="form-control inp category_description">
                        <!-- Buscar codigo -->
                        <div class="input-group-append">
                            <button class="btn btn-cabys" type="button" onclick="buscar_cabys()">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

             <!-- Codigo CABYS -->
             <div class="col-md-4">
                <div class="form-group">
                    <label for="codigo_cabys" class="ivois-label">
                        Código cabys
                    </label>

                    <div class="input-group">
                        <!-- Codigo Cabys -->
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-keyboard"></i>
                            </span>
                        </div>
                        <input class="form-control inp category_code cabys" name="cabys" required max="13">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>