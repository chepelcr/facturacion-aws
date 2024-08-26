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
                                                    <input class="form-control inp inp_username" name="user_token" type="text" required value="<?= $user_token ?? "" ?>" placeholder="Usuario de facturación">
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
                                                    <input class="form-control inp inp_password" name="user_pass" type="password" required max="100" value="<?= $user_pass ?? "" ?>" placeholder="Contraseña">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Informacion de facturacion (sucursal y Punto de venta) -->
                        <div class="col-md-12">
                            <div class="card card-frm">
                                <div class="card-header">
                                    <h4 class="card-title">
                                        <i class="fa-solid fa-store"></i> Informacion de facturación
                                    </h4>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <!-- Sucursal -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="biller_branch">
                                                    Sucursal
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fa-solid fa-store"></i></span>
                                                    </div>
                                                    <input class="form-control inp inp_branch" name="documento_sucursal" type="text" required value="<?= $documento_sucursal ?? "" ?>" placeholder="Sucursal">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Punto de venta -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="biller_point_of_sale">
                                                    Punto de venta
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fa-solid fa-store"></i></span>
                                                    </div>
                                                    <input class="form-control inp inp_point_of_sale" name="documento_punto_venta" type="text" required value="<?= $documento_punto_venta ?? "" ?>" placeholder="Punto de venta">
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