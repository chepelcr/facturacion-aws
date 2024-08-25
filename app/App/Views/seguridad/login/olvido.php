<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modas Laura | Recuperar</title>

    <!-- Google Font : Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?=getFile('dist/plugins/fontawesome-free/css/all.min.css')?>">
    <!-- icheck bootstrap -->
    <link rel="stylesheet"
        href="<?=getFile('dist/plugins/icheck-bootstrap/icheck-bootstrap.min.css')?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?=getFile('dist/css/adminlte.min.css')?>">
    <!-- Logo -->
    <link rel="icon" type="image/png" href="<?=getFile('dist/img/logo.png')?>">
    <!-- Pace Style-->
    <link rel="stylesheet" href="<?=getFile('dist/plugins/pace-progress/themes/center-radar.css')?>">
</head>

<body class="hold-transition login-page bg-olive">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-dark bg-gradient-blue">
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
                            <button class="btn btn-dark" type="button" onclick="location.href='<?= baseUrl('login')?>'"><i class="fas fa-arrow-left"></i></button>
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
    </div>
    <!-- /.login-box -->

    <!-- SCRIPTS -->
    <?= view('base/script')?>
</body>

</html>
