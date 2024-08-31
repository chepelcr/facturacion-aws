<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="es">

<head>
    <?php
    echo view('base/head');
    ?>

</head>

<body class="hold-transition layout-fixed layout-footer-fixed layout-top-nav bg-gray-light">
    <div class="wrapper">
        <div class="loader">
            <div class="circle-small"></div>
            <figure>
                <img class="circle-inner-inner img-fluid" src="<?= getFile('dist/img/logo.png') ?>" alt="Logo Empresa">

                <!-- Colocar 'cargando' abajo de la imagen -->
                <figcaption class="text-center p-5">
                    <h1><?= getEnt('app.name') ?>
                </figcaption>
            </figure>
        </div>

        <?= view('base/navbar', array('modulos' => $modulos)) ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <?php if (getEnt('app.config.ambiente') != 'produccion') : ?>
                <div class="ribbon-wrapper">
                    <div class="ribbon bg-warning">
                        <?= getEnt('app.config.ambiente') ?>
                    </div>
                </div>
            <?php endif; ?>

            <?= view('base/header'); ?>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12" id="inicio">
                            <?php
                            echo view('inicio/dash', array('modulos' => $modulos));
                            ?>
                        </div>

                        <div class="col-md-12">
                            <!-- Recorre submodulos y cargar modulo de inicio y barra de navegacion -->
                            <?php
                            foreach ($modulos as $modulo) {
                                $nombre_modulo = $modulo->nombre_modulo;
                            ?>

                                <div class="contenedor" id="contenedor_<?= $nombre_modulo ?>">
                                    <?php
                                    if ($modulo->nombre_modulo != 'documentos') {
                                        echo view('base/modal/modulo', $modulo);
                                    } else {
                                        $facturacion->modulo = $modulo;

                                        echo view('inicio/' . $modulo->nombre_modulo, $facturacion);
                                    }

                                    //Recorrer submodulos
                                    foreach ($modulo->submodulos as $submodulo) :
                                        $submodulo->nombre_modulo = $modulo->nombre_modulo;

                                        if ($modulo->nombre_modulo != 'documentos') {
                                            echo view('base/modal/submodulo', $submodulo);
                                        } else {
                                            if ($submodulo->nombre_submodulo == 'importar') {
                                                echo view('facturacion/modal/importar');
                                            }
                                        }
                                    endforeach; ?>
                                </div>
                            <?php } ?>
                        </div>


                        <div class="col-md-12">
                            <div class="contenedor" id="contenedor">
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- /.content-wrapper -->

        <!-- Perfil del usuario que ha iniciado sesion -->
        <?= view('base/modal/perfil', array('perfil' => getPerfil())) ?>

        <?= view('base/modal/login') ?>

        <?= view('base/modal/tipo_cambio') ?>

        <!-- Main Footer -->
        <?php echo view('base/footer') ?>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <?php
    if (isset($script)) {
        $data = array(
            'script' => $script
        );

        echo view('base/script', $data);
    } else
        echo view('base/script');
    ?>
</body>

</html>