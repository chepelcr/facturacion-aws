<footer class="footer main-footer">
    <div class="row d-flex justify-content-between">
        <div class="col-md-2 col-sm-12 col-12">
            <div class="row">
                <div class="col-md-6 col-sm-12 col-12">
                    <!-- Default to the left -->
                    <button type="button" class="btn btn-dark btn-block btn-sm float-right" onclick="abrirTipoCambio()" data-toggle="tooltip" title="Ver tipo de cambio">
                        <i class="fas fa-dollar-sign"></i>
                    </button>
                </div>
                <div class="col-md-6 col-sm-12 col-12">
                    <!-- Default to the left -->
                    <button type="button" class="btn btn-success btn-block btn-sm float-right" onclick="migrar()" data-toggle="tooltip" title="Migrar a IVOIS">
                        <i class="fas fa-cloud-upload-alt"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-12 col-12">
            <button type="button" class="btn bg-transparent btn-sm float-right" data-toggle="tooltip" title="Recargar la página">
                <strong><a href="<?= baseUrl() ?>"><?= getEnt('app.name') ?> &copy; | 2024</a></strong>
            </button>
        </div>
    </div>
</footer>