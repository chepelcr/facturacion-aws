<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modas Laura | Login</title>

    <!-- Google Font : Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
        crossorigin="anonymous" />
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= getFile('dist/plugins/icheck-bootstrap/icheck-bootstrap.min.css') ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= getFile('dist/css/adminlte.min.css') ?>">
    <!-- Estilo personalizado -->
    <link rel="stylesheet" href="<?=getFile('dist/css/estilos.css')?>">
    <!-- Logo -->
    <link rel="icon" type="image/png" href="<?= getFile('dist/img/logo.png') ?>">
    <!-- Pace Style-->
    <link rel="stylesheet" href="<?= getFile('dist/plugins/pace-progress/themes/center-radar.css') ?>">
</head>

<body class="hold-transition login-page bg-olive">

    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-dark bg-gradient-blue">
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

            <div class="card card-footer bg-gradient-blue">
                <div class="row">
                    <div class="col-12">
                        <a role="button" href="<?= baseUrl('login/olvido')?>"
                            class="btn btn-block bg-danger fw-bold">Olvidé mi
                            contraseña</a>

                    </div>
                    <!-- /.col -->
                </div>
            </div>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- SCRIPTS -->
    <?= view('base/script')?>
</body>

</html>