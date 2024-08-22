<div class="card card-form">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-qrcode"></i> Códigos
        </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fas fa-minus"></i></button>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <!-- GNL -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="slc_saleCode" class="text-left">Código de venta</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-barcode"></i>
                            </span>
                        </div>
                        <select class="form-control inp slc_code slc_saleCode" name="codes[0][codeTypeId]" required>
                            <option value="">Seleccionar</option>
                            <?php foreach ($codigos as $codigo) :
                                if ($codigo->code == '01') :
                            ?>
                                    <option value="<?= $codigo->codeTypeId ?>" data-code="<?= $codigo->code ?>">
                                        <?= $codigo->description ?>
                                    </option>
                            <?php
                                endif;
                            endforeach; ?>
                        </select>
                        <input class="form-control inp saleCode" type="text" name="codes[0][number]" required>
                    </div>
                </div>
            </div>

            <!-- Codigo interno -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="id_articulo" class="text-left">Código interno</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-cart-arrow-down"></i>
                            </span>
                        </div>
                        <select class="form-control inp slc_code slc_internalCode" name="codes[1][codeTypeId]" required>
                            <option value="">Seleccionar</option>
                            <?php foreach ($codigos as $codigo) :
                                if ($codigo->code == '04') :
                            ?>
                                    <option value="<?= $codigo->codeTypeId ?>" data-code="<?= $codigo->code ?>">
                                        <?= $codigo->description ?></option>
                            <?php
                                endif;
                            endforeach; ?>
                        </select>
                        <input class="form-control inp internalCode" type="text" name="codes[1][number]" required>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>