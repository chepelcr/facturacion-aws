<div class="card card-dark card-login">
    <div class="card-header text-center">
        <img src="<?= getFile('dist/img/logo.png') ?>" width="100px">
    </div>

    <div class="card-body bg-secondary">
        <form id="frmLogin" method="post">
            <p class="login-box-msg text-white">Inicio de sesion</p>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="persona@ejemplo.com" name="usuario">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <input type="password" class="form-control" placeholder="********" name="contrasenia">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="fw-bold btn btn-warning w-100">Entrar</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
    </div>
    <!-- /.card-body -->

    <div class="card-footer bg-gradient-blue">
        <div class="row">
            <div class="col-12">
                <button type="button" class="btnOlvido btn btn-block btn-danger">
                    <div class="d-flex justify-content-around">
                        <i class="fas fa-unlock-alt"></i> Recuperar contraseña
                    </div>
                </button>
            </div>
            <!-- /.col -->
        </div>
    </div>
    <!-- /.card-footer-->
</div>
<!-- /.card -->