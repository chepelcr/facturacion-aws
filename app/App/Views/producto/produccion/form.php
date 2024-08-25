<div class="row">
    <div class="col-md-12">
        <?= view('producto/datos_generales')?>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <!-- Icono de codigos-->
                    <i class="fas fa-code"></i>
                    Códigos</h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <!-- GNL -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="id_articulo" class="text-left">Código de barras</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-barcode"></i>
                                    </span>
                                </div>
                                <input onblur="validarCodigo()" class="form-control inp" type="number" id="codigo_venta"
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
                                        <i class="fas fa-qrcode"></i>
                                    </span>
                                </div>
                                <input class="form-control inp" type="number" id="codigo_interno" name="codigo_interno">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <!-- Icono de institucion-->
                    <i class="fas fa-building"></i>
                    Ministerio de hacienda
                </h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <!-- Codigo cabys-->
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
                                <input class="form-control inp" readonly disabled id="codigo_cabys" name="codigo_cabys"
                                    required max="13">

                                <!-- Buscar codigo -->
                                <div class="input-group-append">
                                    <button id="btnCabys" class="btn" type="button" data-toggle="modal"
                                        data-target="#modalCABYS">
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
                                <input readonly disabled class="form-control inp" id="impuesto" name="impuesto"
                                    type="text" required max="100">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <?= view('producto/datos_compras')?>
    </div>
</div>