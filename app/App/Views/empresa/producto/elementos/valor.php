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
                    <input type="text" class="form-control unitPrice inp valor_vX" placeholder="Valor unitario">
                    <input type="hidden" name="unitPrice" class="unitPrice inp precio">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="impuesto">Impuesto</label>
                    <input type="text" class="form-control valor taxValue" disabled readonly placeholder="Impuesto">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="valor_total">Valor total</label>
                    <input type="text" class="form-control valor salePrice" disabled readonly placeholder="Valor total">
                    <input type="hidden" name="salePrice" class="salePrice inp precioVenta">
                </div>
            </div>
        </div>
    </div>
</div>