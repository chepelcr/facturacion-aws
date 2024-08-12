<div class="card card-form">
    <div class="card-header">
        <h4 class="card-title">
            <i class="fas fa-user-tie"></i> Comercial
        </h4>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- Nombre comercial -->
            <div class="col-md-12">
                <div class="form-group">
                    <label for="tradeName">Nombre de la Empresa</label>
                    <input type="text" class="form-control inp tradeName" name="tradeName" placeholder="Nombre de la empresa" value="<?= $tradeName ?? $businessName ?>">
                </div>
            </div>
            <!-- Logo -->
            <div class="col-md-12">
                <div class="form-group update_logo" hidden>
                    <label for="logo">Logo</label>
                    <input type="file" class="form-control inp logo" name="logo" accept="image/*">
                </div>

                <!-- Ver logo -->
                <div class="form-group watch_logo" hidden>
                    <label for="logo">Logo</label>
                    <div class="input-group">
                        <button type="button" disabled class="btn btn-primary" onclick="watch_logo(<?= $logoUrl ?? '' ?>)">
                            <i class="fas fa-eye"></i> Ver logo
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>