<div class="modal fade" id="modal-<?=$nombre_modulo.'-'.$nombre_submodulo?>" tabindex="-1" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <!-- Contenido del modal -->
        <div class="modal-content">

            <!-- Titulo del modal -->
            <div class="modal-header bg-dark">
                <h5 class="modal-title">
                    <i class="fa <?=$icono?>"></i>
                    <!-- Contenedor para cambiar el titulo: .titulo-submodulo -->
                    <span class="titulo-submodulo">
                        <?=ucfirst(str_replace("_", " ", $nombre_submodulo))?>
                    </span>
                </h5>
                <button type="button" class="close text-white" onclick="cargar_inicio_modulo('<?=$nombre_modulo?>')"
                    data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Contenido del modal -->
            <div class="modal-body">
                <div class="container">
                    <div class="container-fluid contenedor_submodulo">
                    </div>
                </div>
            </div>

            <!-- Footer del modal -->
            <div class="modal-footer">
                <div class="container">
                    <div class="container-fluid">
                        <div class="row d-flex justify-content-between">
                            <div class="col-md-2 card-table">
                                <div class="row">
                                    <div class="col-md-4">
                                        <button type="button" class="btn bg-gradient-teal btn-block"
                                            onclick="cargar_inicio_modulo('<?=$nombre_modulo?>')" data-toggle="tooltip"
                                            title="Volver" data-dismiss="modal">
                                            <i class="fa fa-arrow-left"></i>
                                        </button>
                                    </div>
                                    <div class="col-md-8">
                                        <?php
                                            foreach ($acciones as $accion):
                                                $nombre_accion = $accion->nombre_accion;

                                                if($nombre_accion == 'insertar'):
                                        ?>
                                        <button type="button" data-toggle="tooltip" title="Agregar <?= $objeto?>"
                                            onclick="agregar('Agregar <?=$objeto?>')"
                                            class="btn btn-danger btn-block">
                                            <i class="fas <?=$accion->icono?>"></i>
                                        </button>
                                        <?php endif; endforeach;?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 card-table">
                                <div class="row">
                                    <!-- Descargar listado -->
                                    <div class="col-md-7">
                                        <div class="row">
                                            <!-- Excel -->
                                            <div class="col-md-6">
                                                <button type="button" data-toggle="tooltip" title="Descargar excel"
                                                    onclick="descargar_listado('<?=$nombre_modulo?>', '<?=$nombre_submodulo?>')"
                                                    class="btn btn-success btn-block" disabled>
                                                    <i class="fas fa-file-excel"></i>
                                                </button>
                                            </div>

                                            <!-- PDF -->
                                            <div class="col-md-6">
                                                <button type="button" data-toggle="tooltip" title="Descargar pdf"
                                                    onclick="descargar_listado('<?=$nombre_modulo?>', '<?=$nombre_submodulo?>', 'pdf')"
                                                    class="btn btn-danger btn-block" disabled>
                                                    <i class="fas fa-file-pdf"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Enviar por correo -->
                                    <div class="col-md-5">
                                        <button type="button" data-toggle="tooltip" title="Enviar por correo"
                                            onclick="enviar_correo('<?=$nombre_modulo?>', '<?=$nombre_submodulo?>')"
                                            class="btn bg-gradient-indigo btn-block" disabled>
                                            <i class="fas fa-envelope"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 card-frm">
                                <div class="row d-flex justify-content-between">
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-danger btn-block" data-toggle="tooltip"
                                            title="Cancelar" onclick="cancelar_accion()">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>

                                    <?php if(validar_permiso($nombre_modulo, $nombre_submodulo, 'insertar')):?>
                                    <div class="col-md-2 btt-grd">
                                        <button type="button" onclick="enviar_formulario()" class="btn btn-success btn-grd btn-block" data-toggle="tooltip"
                                            title="Guardar">
                                            <i class="fas fa-save"></i>
                                        </button>
                                    </div>
                                    <?php endif;?>

                                    <?php if(validar_permiso($nombre_modulo, $nombre_submodulo, 'modificar')):?>
                                    <div class="col-md-2 btt-mod">
                                        <button type="button" class="btn bg-gradient-orange btn-mdf btn-block"
                                            data-toggle="tooltip" title="Modificar" onclick="enviar_formulario()">
                                            <i class="fas fa-save"></i>
                                        </button>
                                    </div>

                                    <div class="col-md-2 btt-edt">
                                        <button type="button" class="btn btn-secondary btn-edt btn-block" onclick="editar()"
                                            data-toggle="tooltip" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </div>
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>