<div class="card card-form">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-landmark"></i> Hacienda
        </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fas fa-minus"></i></button>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <!-- Codigo CABYS -->
            <div class="col-md-12">
                <div class="form-group">
                    <label for="codigo_cabys" class="text-left">Código
                        CABYS</label>
                    <div class="input-group ">
                        <!-- Codigo Cabys -->
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-keyboard"></i>
                            </span>
                        </div>
                        <input class="form-control inp codigo_cabys" name="codigo_cabys" required max="13">

                        <!-- Buscar codigo -->
                        <div class="input-group-append">
                            <button id="btnCabys" class="btn" type="button" onclick="buscar_cabys()">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Impuesto -->
            <div class="col-md-12">
                <div class="form-group">
                    <label for="impuesto" class="text-left">Impuesto al valor agregado (IVA)</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-percent"></i></i></span>
                        </div>
                        <input readonly class="form-control inp valor-producto impuesto" name="impuesto" type="number" required
                            max="100">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>