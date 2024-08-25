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
                    <div class="col-md-12">
                        <div id="panel_guardar" class="d-flex justify-content-around">
                            <!-- Grupo de botones -->
                            <button type="button" onclick="guardar_perfil()" disabled class="btn btn-grd-prf btn-primary w-75">
                                </i> Guardar
                            </button>

                            <!-- Boton para Cancelar -->
                            <button type="button" onclick="cancelar_perfil()" disabled class="btn btn-cnl-prf btn-danger w-20">
                                <i class="fa fa-times"></i> Cancelar
                            </button>
                        </div>

                        <div id="panel_perfil" class="d-flex justify-content-around row">
                            <div class="col-md-3">
                                <button class="btn btn-info btn-block" type="button" disabled>Editar perfil</button>
                            </div>

                            <div class="col-md-3">
                                <button class="btn btn-danger btn-block" type="button" onclick="cambio_contrasenia()">Cambiar
                                    contraseña</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>