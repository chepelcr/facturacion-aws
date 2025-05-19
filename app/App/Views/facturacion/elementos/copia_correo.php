<div class="card card-correos">
    <div class="card-header">
        <div class="row d-flex justify-content-between">
            <div class="col-md-6">
                <h5 class="card-title align-content-center">
                    <i class="fa-solid fa-paper-plane"></i> Enviar copia de correo
                </h5>
            </div>

            <div class="col-md-2">
                <!-- Mininizar -->
                <button type="button" class="btn btn-outline-danger btn-sm btn-block" data-card-widget="collapse" data-toggle="tooltip" title="Ver">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="row email-copies">
            <div class="col-md-4 col-correo">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    </div>
                    <input type="email" class="form-control form-control-sm ccEmail" name="copyEmails[0]" placeholder="Correo electrónico">
                    <!--Boton de vaciar correo -->
                    <div class="input-group-append">
                        <button type="button" class="btn btn-outline-danger btn-sm btn-block delete-email" data-toggle="tooltip" disabled title="Elmininar" onclick="vaciarCorreo(this)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-md-1 addCopyEmail">
                <!-- Boton de agregar correo -->
                <button type="button" class="btn btn-outline-success btn-sm btn-block addEmailButton" disabled data-toggle="tooltip" title="Agregar copia" onclick="agregarCorreo()">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
    </div>
</div>