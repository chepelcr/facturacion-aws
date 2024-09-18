<div class="card card-form">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-landmark"></i> Información de hacienda
        </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fas fa-minus"></i></button>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <!-- Codigo CABYS -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="codigo_cabys" class="text-left">
                        Código cabys
                    </label>

                    <div class="input-group">
                        <!-- Codigo Cabys -->
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-keyboard"></i>
                            </span>
                        </div>
                        <input class="form-control inp category_code" name="cabys" required max="13">

                        <!-- Buscar codigo -->
                        <div class="input-group-append">
                            <button class="btn btn-cabys" type="button" onclick="buscar_cabys()">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Select de tipo de producto -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="tipo_producto" class="text-left">Tipo de producto</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-cart-plus"></i>
                            </span>
                        </div>
                        <select class="form-control inp category_productType_id cabys">
                            <option value="">Seleccionar</option>
                            <?php foreach ($productos as $tipo_producto) : ?>
                                <option value="<?= $tipo_producto->id ?>">
                                    <?= $tipo_producto->description ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Impuesto sugerido -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="impuesto" class="text-left">Impuesto sugerido</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-percent"></i></i></span>
                        </div>
                        <input readonly class="form-control inp cabys category_suggestedTax" type="number" max="100">
                    </div>
                </div>
            </div>

            <!-- Descripción del producto -->
            <div class="col-md-12">
                <div class="form-group">
                    <label for="descripcion_cabys" class="text-left">
                        Descripción del producto
                    </label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-id-card"></i>
                            </span>
                        </div>
                        <input class="form-control inp cabys category_description">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>