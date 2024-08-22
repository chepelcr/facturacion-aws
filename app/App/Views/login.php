<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= getEnt('app.name') ?> | Login</title>

    <!-- Google Font : Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= getFile('dist/js/plugins/icheck-bootstrap/icheck-bootstrap.min.css') ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= getFile('dist/css/adminlte.min.css') ?>">
    <!-- Estilo personalizado -->
    <link rel="stylesheet" href="<?= getFile('dist/css/estilos.css') ?>">
    <!-- Logo -->
    <link rel="icon" type="image/png" href="<?= getFile('dist/img/logo.png') ?>">
    <!-- Pace Style-->
    <link rel="stylesheet" href="<?= getFile('dist/js/plugins/pace-progress/themes/center-radar.css') ?>">
</head>

<body class="hold-transition login-page bg-olive">
    <div class="login-box">
        <?= view('seguridad/login/login') ?>

        <?= view('seguridad/login/olvido') ?>
    </div>
    <!-- /.login-box -->

    <!-- SCRIPTS -->
    <?= view('base/script') ?>
</body>

</html>