<!-- Datos de contacto -->
<div class="card card-form">
    <div class="card-header">
        <h4 class="card-title">
            <i class="fas fa-address-book"></i> Información de contacto
        </h4>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- Telefono -->
            <div class="col-md-6 contacto">
                <div class="form-group">
                    <label>
                        Teléfono
                    </label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        </div>
                        <input class="form-control inp perfil telefono"  name="telefono" type="text" required max="9" min="8"
                            value="<?php if(isset($telefono)) echo $telefono?>" placeholder="Teléfono">
                    </div>
                </div>
            </div>
            <!-- Correo electronico -->
            <div class="col-md-6 contacto">
                <div class="form-group">
                    <label>
                        Correo electrónico
                    </label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        </div>
                        <input class="form-control inp perfil correo" name="correo" type="email" required max="100"
                            value="<?php if(isset($correo)) echo $correo?>" placeholder="Correo electrónico">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>