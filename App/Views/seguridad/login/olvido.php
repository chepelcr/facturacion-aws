<div class="card card-dark card-olvido bg-gradient-blue">
    <div class="card-header text-center bg-dark">
        <img src="<?=getFile('dist/img/logo.png')?>" width="100px">
    </div>

    <div class="card-body bg-secondary">
        <form id="frmRecuperar" method="post">
            <p class="login-box-msg text-white"><b>Recuperar clave</b></p>
            <div class="input-group mb-3">
                <input type="email" class="form-control" placeholder="Correo electronico" name="correo">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <button class="btn btn-dark btn-block" type="button" onclick="volver_login()"><i
                            class="fas fa-arrow-left"></i></button>
                </div>
                <!-- /.col -->
                <div class="col-9">
                    <button type="submit" class="btn btn-warning btn-block">Realizar solititud</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->