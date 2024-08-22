<form id="frm_configuracion_empresa">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <i class="fa-solid fa-circle-user"></i> Configuracion de Hacienda
                    </h4>

                    <div class="card-tools">
                        <button type=" button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Usuario de facturacion -->
                        <div class="col-md-12">
                            <div class="card card-frm">
                                <div class="card-header">
                                    <h4 class="card-title">
                                        <i class="fa-solid fa-circle-user"></i> Informacion de autenticación
                                    </h4>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <!-- Usuario -->
                                        <div class="col-md-8 autenticacion">
                                            <div class="form-group">
                                                <label for="biller_username">
                                                    Usuario
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fa-solid fa-user-tie"></i></span>
                                                    </div>
                                                    <input class="form-control inp inp_username" name="username" type="text" required value="<?= $username ?? "" ?>" placeholder="Usuario de facturación">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Contraseña -->
                                        <div class="col-md-4 autenticacion">
                                            <div class="form-group">
                                                <label for="biller_password">
                                                    Contraseña
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fa-solid fa-user-secret"></i></span>
                                                    </div>
                                                    <input class="form-control inp inp_password" name="password" type="password" required max="100" value="<?= $password ?? "" ?>" placeholder="Contraseña">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Informacion de notificaciones -->
                        <div class="col-md-12">
                            <div class="card card-frm">
                                <div class="card-header">
                                    <h4 class="card-title">
                                        <i class="fa-solid fa-circle-exclamation"></i> Notificaciones de documentos
                                    </h4>

                                    <div class="card-tools">
                                        <button type=" button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <!-- Notificaciones de emision -->
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 class="card-title">
                                                        <i class="fa-solid fa-circle-exclamation"></i> Emitidos
                                                    </h4>
                                                </div>

                                                <div class="card-body">
                                                    <div class="d-flex justify-content-around">
                                                        <!-- Aprobados -->
                                                        <button type="button" class="btn <?php if (isset($notifySentDocuments) && $notifySentDocuments == 1) : ?> btn-success <?php else : ?> btn-secondary <?php endif; ?>
                                                        inp btn-ntf btn-ntf-aprv" value="1" data-toggle="tooltip" title="Aprobados" onclick="cambiar_estado_notificacion(this.value)">
                                                            <i class="fa-solid fa-check"></i>
                                                        </button>

                                                        <!-- Rechazados -->
                                                        <button type="button" class="btn <?php if (isset($notifySentDocuments) && $notifySentDocuments == 2) : ?> btn-success <?php else : ?> btn-secondary <?php endif; ?>
                                                         inp btn-ntf btn-ntf-rjct" value="2" data-toggle="tooltip" title="Rechazados" onclick="cambiar_estado_notificacion(this.value)">
                                                            <i class="fa-solid fa-times"></i>
                                                        </button>

                                                        <!-- Ambos -->
                                                        <button type="button" class="btn <?php if (isset($notifySentDocuments) && $notifySentDocuments == 3) : ?> btn-success <?php else : ?> btn-secondary <?php endif; ?>
                                                        inp btn-ntf btn-ntf-all" value="3" data-toggle="tooltip" title="Ambos" onclick="cambiar_estado_notificacion(this.value)">
                                                            <i class="fa-solid fa-check"></i><i class="fa-solid fa-times"></i>
                                                        </button>

                                                        <!-- No notificar -->
                                                        <button type="button" class="btn <?php if (isset($notifySentDocuments) && $notifySentDocuments == 4) : ?> btn-success <?php else : ?> btn-secondary <?php endif; ?>
                                                        inp btn-ntf btn-ntf-none" value="4" data-toggle="tooltip" title="No notificar" onclick="cambiar_estado_notificacion(this.value)">
                                                            <i class="fa-solid fa-ban"></i>
                                                        </button>

                                                        <input type="hidden" name="notifySentDocuments" class="inp_notifySentDocuments inp" value="<?= $notifySentDocuments ?? "" ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Notificaciones de recepcion -->
                                        <div class="col-md-3">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 class="card-title">
                                                        <i class="fa-solid fa-circle-exclamation"></i> Recibidos
                                                    </h4>
                                                </div>

                                                <div class="card-body">
                                                    <div class="d-flex justify-content-around">
                                                        <!-- Recibidos -->
                                                        <button type="button" class="btn <?php if (isset($notifyReceivedDocuments) && $notifyReceivedDocuments) : ?> btn-success <?php else : ?> btn-secondary <?php endif; ?>
                                                        inp notifyReceivedDocuments" value="<?php if (isset($notifyReceivedDocuments) && $notifyReceivedDocuments) : ?>0<?php else : ?>1<?php endif; ?>" data-toggle="tooltip" title="Recibidos" onclick="estado_notificacion_recibido(this.value)">
                                                            <i class="fa-solid fa-check"></i>
                                                        </button>

                                                        <input type="hidden" name="notifyReceivedDocuments" class="inp_notifyReceivedDocuments inp" value="<?php if (isset($notifyReceivedDocuments) && $notifyReceivedDocuments) : ?>1<?php else : ?>0<?php endif; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Notificaciones de procesamiento -->
                                        <div class="col-md-3">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 class="card-title">
                                                        <i class="fa-solid fa-circle-exclamation"></i> En proceso
                                                    </h4>
                                                </div>

                                                <div class="card-body">
                                                    <div class="d-flex justify-content-around">
                                                        <!-- Procesados -->
                                                        <button type="button" class="btn <?php if (isset($notifyProcessingDocuments) && $notifyProcessingDocuments) : ?> btn-success <?php else : ?> btn-secondary <?php endif; ?>
                                                        inp notifyProcessingDocuments" value="<?php if (isset($notifyProcessingDocuments) && $notifyProcessingDocuments) : ?>0<?php else : ?>1<?php endif; ?>" data-toggle="tooltip" title="Procesados" onclick="estado_notificacion_proceso(this.value)">
                                                            <i class="fa-solid fa-check"></i>
                                                        </button>

                                                        <input type="hidden" name="notifyProcessingDocuments" class="inp_notifyProcessingDocuments inp" value="<?php if (isset($notifyProcessingDocuments) && $notifyProcessingDocuments) : ?>1<?php else : ?>0<?php endif; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Url de callback -->
                        <div class="col-md-12">
                            <div class="card card-frm">
                                <div class="card-header">
                                    <h4 class="card-title">
                                        <i class="fa-solid fa-circle-exclamation"></i> Url de callback
                                    </h4>

                                    <div class="card-tools">
                                        <!-- Info -->
                                        <button type="button" class="btn btn-tool" data-toggle="tooltip" title="Direccion a la que el Ministerio de Hacienda enviará la información de validación de un documento electrónico" disabled>
                                            <i class="fas fa-info-circle"></i>
                                        </button>

                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <!-- Url de callback -->
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="biller_callback_url">
                                                    Url de callback
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fa-solid fa-link"></i></span>
                                                    </div>
                                                    <input class="form-control inp inp_callbackUrl" name="callbackUrl" type="text" required value="<?= $callbackUrl ?? "" ?>" placeholder="Url de callback">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="row">
                                <?php if (validar_permiso('configuracion', 'documentos', 'modificar')) : ?>

                                    <!-- Guardar configuracion -->
                                    <div class="col-md-6 btn-grd">
                                        <button type="button" class="btn btn-primary btn-grd" onclick="guardar_configuracion()" hidden="true">
                                            <i class="fa-solid fa-save"></i> Guardar cambios
                                        </button>
                                    </div>

                                    <!-- Cancelar edicion -->
                                    <div class="col-md-6 btn-grd">
                                        <button type="button" class="btn btn-danger btn-grd" onclick="cancelar_edicion_configuracion()" hidden="true">
                                            <i class="fa-solid fa-times"></i> Cancelar
                                        </button>
                                    </div>

                                    <!-- Editar configuracion -->
                                    <div class="col-md-6 btn-edt">
                                        <button type="button" class="btn btn-warning btn-edt" onclick="editar_configuracion()">
                                            <i class="fa-solid fa-edit"></i> Editar
                                        </button>
                                    </div>
                                <?php endif; ?>

                                <!-- Ver configuracion -->
                                <div class="col-md-6 btn-edt">
                                    <button type="button" class="btn btn-info btn-edt btn-ver" onclick="ver_configuracion()">
                                        <i class="fa-solid fa-eye"></i> Ver
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<?php if (validar_permiso('configuracion', 'documentos', 'modificar')) : ?>
    <form id="frm_llave_criptografica">
        <div class="row">
            <!-- Certificado P12 -->
            <div class="col-md-12">
                <div class="card card-frm">
                    <div class="card-header">
                        <h4 class="card-title">
                            <i class="fa-solid fa-key"></i> Certificado P12
                        </h4>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Cambiar llave criptografica">
                                <i class="fa-solid fa-wrench"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <!-- Llave publica -->
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="biller_certificate">
                                        Llave criptografica
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
                                        </div>
                                        <input class="form-control inp biller_certificate" name="biller_certificate" type="file" accept=".p12" placeholder="Certificado P12">
                                    </div>
                                </div>
                            </div>

                            <!-- Contraseña de la llave -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="biller_certificate_pin">
                                        Contraseña
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                        </div>
                                        <input class="form-control inp biller_certificate_pin" name="biller_certificate_pin" type="password" placeholder="Contraseña" <?php if (isset($certificate->pin)) : ?> value="<?= $certificate->pin ?>" <?php endif; ?>>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="button" class="btn btn-primary" onclick="guardar_llave_criptografica()">
                            <i class="fa-solid fa-save"></i> Guardar llave criptografica
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
<?php endif; ?>