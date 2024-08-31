<footer class="footer main-footer">
    <div class="row d-flex justify-content-between">
        <div class="col-md-1 col-sm-6 col-6">
            <!-- Default to the left -->
            <button type="button" class="btn btn-dark btn-block btn-sm float-right" onclick="abrirTipoCambio()" data-toggle="tooltip" title="Ver tipo de cambio">
                <i class="fas fa-dollar-sign"></i>
            </button>
        </div>
        <div class="col-md-2 col-sm-6 col-6">
            <button type="button" class="btn bg-transparent btn-sm float-right" data-toggle="tooltip" title="Recargar la página">
                <strong><a href="<?= baseUrl() ?>"><?= getEnt('app.name') ?> &copy; | 2024</a></strong>
            </button>
        </div>
    </div>
</footer>