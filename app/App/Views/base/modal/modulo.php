<div class="modal fade" id="modal-<?= $nombre_modulo ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">

        <!-- Contenido del modal -->
        <div class="modal-content">

            <!-- Titulo del modal -->
            <div class="modal-header bg-dark">
                <h5 class="modal-title">
                    <i class="fa-solid <?= $icono ?>"></i>

                    <?php
                    $nombre_vista_modulo = $nombre_vista;

                    echo $nombre_vista_modulo;
                    ?>
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" onclick="cargar_inicio()" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Contenido del modal -->
            <div class="modal-body">
                <div class="container">
                    <div class="container-fluid">
                        <div class="row d-flex justify-content-around">
                            <?php

                            $cantidad_submodulos = count((array) $submodulos);

                            $submodulos_recorridos = 0;

                            foreach ($submodulos as $submodulo) :
                                $nombre_submodulo = $submodulo->nombre_submodulo;
                                $nombre_vista_submodulo = $submodulo->nombre_vista;
                                $icono = $submodulo->icono;
                                $url = $submodulo->url;
                                $acciones = $submodulo->acciones;

                                $submodulos_recorridos++;

                                echo '<!-- ' . $nombre_submodulo . ' -->';

                            ?>
                                <div class="<?= getMdSize($cantidad_submodulos, $submodulos_recorridos) ?>">

                                    <div class="card">
                                        <div class="card-header">
                                            <div class="d-flex justify-content-between">
                                                <h3 class="card-title">
                                                    <?= $nombre_vista_submodulo ?>
                                                </h3>

                                                <i class="fa-solid <?= $icono ?>"></i>

                                            </div>
                                        </div>

                                        <div class="card-body">
                                            <div class="row d-flex justify-content-center">
                                                <div class="col-md-8">
                                                    <!-- Boton para entrar al modulo -->
                                                    <button class="btn btn-info btn-block" data-toggle="tooltip" title="Ir a <?= $nombre_vista_submodulo ?>" onclick="cargar_listado('<?= $nombre_modulo ?>', '<?= $nombre_submodulo ?>', '<?= $nombre_vista_modulo ?>', '<?= $nombre_vista_submodulo ?>', '<?= baseUrl($url) ?>')">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <!-- Fin de recorrer submodulos -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>