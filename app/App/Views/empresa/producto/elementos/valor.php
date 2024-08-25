<!-- Comercial (Valor unitario, impuesto y valor total) -->
<div class="card card-form">
    <div class="card-header">
        <h4 class="card-title">
            <i class="fas fa-dollar-sign"></i> Valor comercial
        </h4>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="valor_unitario">Valor unitario</label>
                    <input type="number" class="form-control inp valor_unitario" name="valor_unitario" placeholder="Valor unitario">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="impuesto">Impuesto</label>
                    <input type="number" class="form-control valor_impuesto" disabled readonly placeholder="Impuesto">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="valor_total">Valor total</label>
                    <input type="text" class="form-control valor_total" id="" disabled readonly placeholder="Valor total">
                </div>
            </div>
        </div>
    </div>
</div>