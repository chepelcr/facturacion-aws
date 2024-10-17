<div class="card card-form">
    <div class="card-header">
        <div class="row d-flex justify-content-between">
            <div class="col-md-6">
                <h3 class="card-title align-content-center">
                    <i class="fas fa-qrcode"></i> Códigos
                </h3>
            </div>

            <!-- Agregar codigo -->
            <div class="col-md-5">
                <div class="input-group">
                    <select class="form-control inp slc_codes form-control-sm">
                        <option value="">Agregar código</option>
                        <?php foreach ($codigos as $codigo) : ?>
                            <option value="<?= $codigo->codeTypeId ?>" data-description="<?= $codigo->description ?>" data-code="<?= $codigo->code ?>">
                                <?= $codigo->description ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <div class="input-group-append">
                        <!-- Boton para agregar código el contenido del campo -->
                        <button class="btn btn-success inp btn-sm" type="button" onclick="agregarCodigo()" data-toggle="tooltip" data-placement="top" title="Agregar código">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mininizar -->
            <div class="col-md-1">
                <button type="button" class="btn btn-outline-danger btn-sm btn-block" data-card-widget="collapse" data-toggle="tooltip" title="Ver Codigos" disabled>
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="card-body codes-container" hidden>
        <div class="row codes">

        </div>
    </div>
</div>