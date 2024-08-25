<div class="modal fade" style="padding-top: 10%;" id="modalUsuario" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">

        <!-- Contenido del modal -->
        <div class="modal-content">

            <!-- Titulo del modal -->
            <div class="modal-header bg-dark">
                <h5 class="modal-title" id="titulo">Registrate</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Inicio del formulario -->
            <form id="frmRegistro">
                <!-- Contenido del modal -->
                <div class="modal-body">
                    <div class="container">
                        <div class="container-fluid">
                            <div class="row">
                                <!-- Numero de identificacion -->
                                <div class="input-group mb-3 col-md-6">
                                    <label class="text-left col-4 text-dark">Numero de identificacion</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                    </div>
                                    <input class="form-control form-control-lg inp" onblur="verificar()"
                                        id="cedula_usuario" name="cedula_usuario" type="text" required max="100">
                                </div>

                                <!-- Nombre de usuario -->
                                <div class="input-group mb-3 col-md-6">
                                    <label class="text-left col-4 text-dark">Nombre de usuario</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input class="form-control form-control-lg inp" id="nombre_usuario"
                                        name="nombre_usuario" required>
                                </div>

                                <!-- Nombre del cliente -->
                                <div class="input-group mb-3 col-md-6">
                                    <label class="text-left col-4 text-dark">Nombre</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-id-card-alt"></i></span>
                                    </div>
                                    <input class="form-control inp" id="nombre" name="nombre" type="text" required
                                        max="100">
                                </div>

                                <!-- Apellidos -->
                                <div class="input-group mb-3 col-md-6">
                                    <label class="text-left col-4 text-dark">Apellidos</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-id-card-alt"></i></span>
                                    </div>
                                    <input class="form-control inp" id="apellido" name="apellido" type="text" required
                                        max="100">
                                </div>

                                <!-- Correo electronico -->
                                <div class="input-group mb-3 col-md-8">
                                    <label class="text-left col-4 text-dark">Correo electronico</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input class="form-control form-control-lg inp" id="correo" name="correo"
                                        type="email" required max="100">
                                </div>

                                <!-- Activo -->
                                <div class="input-group col-md-4">
                                    <label class="text-left col-10 text-dark">Acepto los <a
                                            href="<?=baseUrl('files/terminos.pdf')?>">Terminos y
                                            condiciones</a></label>
                                    <input class="form-control inp" required id="estado" name="estado" type="checkbox">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer del modal -->
                <div class="modal-footer">
                    <div class="fc-button-group">
                        <button type="submit" class="btn btn-primary btt-grd">Registrarme</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>