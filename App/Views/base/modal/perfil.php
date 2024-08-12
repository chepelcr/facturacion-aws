<div class="modal fade" id="perfil" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">

        <!-- Contenido del modal -->
        <div class="modal-content">

            <!-- Titulo del modal -->
            <div class="modal-header bg-dark">
                <h5 class="modal-title">
                    <i class="fas fa-user-circle"></i>
                    Perfil de usuario
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Inicio del modal -->
            <form id="frm_perfil">
                <!-- Contenido del modal -->
                <div class="modal-body">
                    <div class="container">
                        <div class="container-fluid">
                            <?= view('seguridad/usuario/form', $perfil)?>
                        </div>
                    </div>
                </div>

                <!-- Footer del modal -->
                <div class="modal-footer">
                    <div class="panel-guardar w-100">
                        <div class="row d-flex justify-content-between">
                            <div class="col-md-1">
                                <!-- Boton para Cancelar -->
                                <button type="button" onclick="cancelar_perfil()" class="btn btn-danger btn-block"
                                    data-toggle="tooltip" title="Cancelar">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>

                            <div class="col-md-2">
                                <button type="button" onclick="enviar_formulario()" class="btn btn-primary btn-block"
                                    data-toggle="tooltip" title="Guardar">
                                    <i class="fas fa-save"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="panel-perfil w-100">
                        <div class="row panel-perfil d-flex justify-content-around">
                            <!-- Editar perfil -->
                            <div class="col-md-3">
                                <button class="btn btn-info btn-block" type="button" onclick="editar_perfil()"
                                    data-toggle="tooltip" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>

                            <!-- Cambiar contraseña -->
                            <div class="col-md-3">
                                <button class="btn btn-warning btn-block" type="button" onclick="cambio_contrasenia()"
                                    data-toggle="tooltip" title="Cambiar contraseña">
                                    <i class="fas fa-key"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>