<!-- Informacion de partida arancelaria para exportacion -->
<div class="card card-form">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-box"></i> Partida arancelaria
        </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fas fa-minus"></i></button>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <!-- Valor de partida arancelaria -->
            <div class="col-md-12">
                <div class="form-group">
                    <label for="unitPrice" class="ivois-label">Partida arancelaria <?= !isset($isDetail) ? "(Opcional)" : "" ?></label>

                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa-solid fa-globe"></i></span>
                        </div>
                        <input type="text" class="form-control customsPart inp <?= isset($isDetail) ? "validar_linea inp-fct" : "" ?>" placeholder="Partida arancelaria"
                            data-toggle="tooltip" title="Partida arancelaria" name=<?php if (isset($isDetail)) {
                                                                                        echo "details[0][customsPart]";
                                                                                    } else {
                                                                                        echo "customsPart";
                                                                                    } ?>>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>