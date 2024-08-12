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
            <div class="col-md-12">
                <div class="form-group">
                    <label for="id_articulo" class="text-left">Código de venta</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-barcode"></i>
                            </span>
                        </div>
                        <input onblur="validar(this.value, 'producto')" class="form-control inp codigo_venta" type="number"
                            name="codigo_venta">
                    </div>
                </div>
            </div>

            <!-- Codigo interno -->
            <div class="col-md-12">
                <div class="form-group">
                    <label for="id_articulo" class="text-left">Código interno</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-cart-arrow-down"></i>
                            </span>
                        </div>
                        <input class="form-control inp codigo_interno" type="number" name="codigo_interno">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>