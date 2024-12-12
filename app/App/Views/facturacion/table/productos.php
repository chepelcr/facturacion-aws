<div class="row row-cols-2 row-cols-md-2 row-cols-md-1 m-2">
    <?php foreach ($productos as $producto) : ?>
        <div class="col producto">
            <?php
            if (isset($producto->codes) && count($producto->codes) > 0) :
                $codes = $producto->codes;

                foreach ($codes as $saleCode) : ?>
                    <span class="d-none"><?= $saleCode->codeNumber ?></span>
            <?php
                endforeach;
            endif; ?>
            <div class=" card">
                <div class="card-header">
                    <h5 class="card-title">
                        <?= $producto->description ?>
                    </h5>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Precio de venta -->
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="precio">Precio</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                    </div>
                                    <input type="number" class="form-control form-control-sm salePrice" value="<?= $producto->salePrice; ?>">
                                </div>
                            </div>
                        </div>

                        <!-- Cantidad -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="cantidad">Cantidad</label>
                                <input type="number" class="form-control form-control-sm quantity" value="1" min="1">
                            </div>
                        </div>

                        <!-- Unidad de medida -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="unidad">Unidad</label>
                                <select class="form-control form-control-sm unidad">
                                    <?php $unidad = $producto->measurementUnit; ?>
                                    <option value="<?= $unidad->unitId; ?>"><?= $unidad->description; ?></option>
                                </select>
                            </div>
                        </div>

                        <!-- Botón de selección -->
                        <div class="col-md-12">
                            <button type="button" class="btn btn-sm btn-primary w-100" onclick="seleccionar_producto(this.value, this)" value="<?= $producto->productId ?>" data-toggle="tooltip" title="Seleccionar producto">
                                <i class="fa fa-plus"></i> Seleccionar articulo
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>