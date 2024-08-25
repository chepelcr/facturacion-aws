<div class="modal fade" id="modal-<?=$nombre_modulo?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">

        <!-- Contenido del modal -->
        <div class="modal-content">

            <!-- Titulo del modal -->
            <div class="modal-header bg-dark">
                <h5 class="modal-title">
                    <i class="fa <?=$icono?>"></i>
                    <?=ucfirst(str_replace("_", " ", $nombre_modulo))?>
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
                            <!--Recorrer submodulos -->
                            <?php foreach($submodulos as $submodulo):
                                        $nombre_submodulo = $submodulo->nombre_submodulo;
                                        $icono = $submodulo->icono;
                                        $url = $submodulo->url;
                                        $acciones = $submodulo->acciones;
                                    ?>


                            <!-- <?=$nombre_submodulo?> -->
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="d-flex justify-content-between">
                                            <h3 class="card-title">
                                                <?=ucfirst(str_replace('_', ' ', $nombre_submodulo))?>
                                            </h3>

                                            <i class="fa <?=$icono?>"></i>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-8">
                                                <!-- Boton para entrar al modulo -->
                                                <button class="btn btn-info btn-block" data-toggle="tooltip"
                                                    title="Ir a <?=ucfirst(str_replace('_', ' ', $nombre_submodulo))?>"
                                                    onclick="cargar_listado('<?=$nombre_modulo?>', '<?=$submodulo->nombre_submodulo?>', '<?= baseUrl($url)?>')">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach;?>
                            <!-- Fin de recorrer submodulos -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>