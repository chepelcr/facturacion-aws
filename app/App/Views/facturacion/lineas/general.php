<div class="card card-form">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-text-width"></i> Datos generales
        </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fas fa-minus"></i></button>
        </div>
    </div>

    <div class="card-body">
    <input type="hidden" class="form-control form-control-sm productId" name="details[0][productId]">

        <div class="row">
            <div class="col-md-12">
                <?= view('empresa/producto/elementos/info_general', $data_general) ?>
            </div>
        </div>
    </div>
</div>