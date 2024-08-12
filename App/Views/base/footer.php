<!-- Main Footer -->
<footer class="main-footer">
    <div class="row">
        <div class="col-md-9">
            <!-- Default to the left -->
            <div class="row">
                <div class="col-md-2 col-sm-12" data-toggle="tooltip" title="Tipo de cambio">
                    <button type="button" class="btn btn-dark btn-block btn-sm float-right" onclick="obtener_tipo_cambio()" id="btn_cambio">
                        <i class="fas fa-dollar-sign"></i>
                    </button>
                </div>

                <div class="col-md-3 col-sm-12" data-toggle="tooltip" title="Compra">
                    <!-- Compra -->
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                        </div>
                        <input class="form-control form-control-sm form-control-plaintext" value="0" disabled readonly id="tipo_compra">
                    </div>
                </div>

                <div class="col-md-3 col-sm-12" data-toggle="tooltip" title="Venta">
                    <!-- Venta -->
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                        </div>
                        <input class="form-control form-control-sm form-control-plaintext" value="0" disabled readonly id="tipo_venta">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                <strong><a href="<?= baseUrl() ?>">JCampos & IFZ S.A | 2024</a></strong>
            </div>
        </div>
    </div>
</footer>