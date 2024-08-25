<div class="modal fade modal-clientes" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">

        <!-- Contenido del modal -->
        <div class="modal-content">
            <!-- Titulo del modal -->
            <div class="modal-header bg-dark">
                <h5 class="modal-title">
                    <i class="fas fa-user"></i>
                    Clientes
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Inicio del formulario -->
            <form id="frm">
                <!-- Contenido del modal -->
                <div class="modal-body">
                    <div class="container">
                        <div class="container-fluid">
                            <?php
                                echo view('facturacion/elementos/cliente', $buscar_cliente);
                            ?>
                        </div>
                    </div>
                </div>

                <!-- Footer del modal -->
                <div class="modal-footer">
                    <div class="container">
                        <div class="container-fluid">
                            <div class="row d-flex justify-content-between">
                                <div class="col-md-2 btt-sct-clt">
                                    <!-- Seleccionar otro cliente -->
                                    <button type="button" onclick="buscar_clientes()"
                                        class="btn btn-secondary btn-block">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>

                                <div class="col-md-2 btt-add-clt">
                                    <!-- Agregar -->
                                    <button type="button" onclick="agregar_cliente()" class="btn btn-warning btn-block">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>

                                <div class="col-md-2">
                                    <div class="row">
                                        <div class="col-md-6 btt-edt-clt">
                                            <!-- Editar -->
                                            <button type="button" onclick="editar_cliente()" class="btn btn-danger btn-block">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </div>

                                        <div class="col-md-6 btt-aceptar-clt">
                                            <!-- Aceptar -->
                                            <button type="button" class="btn btn-success btn-block" data-dismiss="modal">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </div>

                                        <div class="col-md-12 btt-grd-clt-cambios">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <!-- Guardar cambios -->
                                                    <button type="button" class="btn btn-success btn-block">
                                                        <i class="fas fa-save"></i>
                                                    </button>
                                                </div>

                                                <div class="col-md-6">
                                                    <!-- Cancelar cambios -->
                                                    <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 btt-grd-clt">
                                        <!-- Guardar cliente-->
                                            <button type="button" onclick="enviar_formulario()" class="btn btn-success btn-block">
                                                <i class="fas fa-save"></i>
                                            </button>
                                        </div>

                                        <div class="col-md-12 btt-add-clt">
                                            <!-- Aceptar -->
                                            <button type="button" class="btn btn-success btn-block" data-dismiss="modal">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>