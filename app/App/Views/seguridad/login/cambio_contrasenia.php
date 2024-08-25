<div class="card card-dark bg-gradient-blue">
    <div class="card-header text-center">
        <img src="<?= getFile('dist/img/logo.png') ?>" width="100px">
    </div>

    <form id="frm_contrasenia" method="post">
        <div class="card-body bg-secondary">

            <p class="login-box-msg text-white">Cambio de contraseña</p>
            <?= view('seguridad/perfil/contrasenia')?>

        </div>
        <!-- /.card-body -->

        <div class="card card-footer bg-gradient-blue">
            <div class="row d-flex justify-content-around">
                <?php if(!getSession('contrasenia_expiro')): ?>
                <div class="col-3 text-center">
                    <!-- Salir -->
                    <button class="btn btn-secondary btn-block" data-toggle="tooltip" title="Volver" onclick="abrir_perfil()"
                        type="button">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                </div>
                <!-- /.col -->
                <?php endif; ?>

                <div class="col-9">
                    <button type="submit" class="fw-bold btn btn-danger btt-grd btn-block">Cambiar</button>
                </div>
                <!-- /.col -->
            </div>
        </div>
        <!-- /.card-footer-->
    </form>
</div>
<!-- /.card -->