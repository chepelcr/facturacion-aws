<!-- Informacion de empaque -->
<div class="card card-form card-empaque">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-box"></i> Información de empaque
        </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fas fa-minus"></i></button>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="ivois-label" for="quantity">Unidades por empaque</label>
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-marker"></i>
                            </span>
                        </div>
                        <input class="form-control inp quantity" required name="quantity" type="number" value="1" min="1" max="999">
                    </div>
                </div>
            </div>

            <!-- Valor unitario (precio de venta / cantidad) -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="precio" class="ivois-label">Precio unitario</label>

                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                        </div>
                        <input type="text" class="form-control unitPrice inp" placeholder="Precio unitario" disabled readonly data-toggle="tooltip" title="Precio de venta / Cantidad">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>