<!-- Modal para enviar la notificación de un documento electronico -->
<div class="modal fade" id="modalNotificar" tabindex="-1" role="dialog" aria-labelledby="tituloNotification" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tituloNotification">
                    <i class="fas fa-envelope"></i> Notificar documento
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Correo electronico -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="correo">Correo electronico</label>
                            <input type="email" class="form-control email" id="correo" name="email" placeholder="opcional">
                        </div>
                    </div>
                    <!-- /.col-md-12 -->
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-around">
                <div class="col-md-5">
                    <button type="button" class="btn btn-secondary w-100" data-dismiss="modal">Cancelar</button>
                </div>
                <div class="col-md-5">
                    <button type="button" class="btn btn-primary w-100 btn-enviar" onclick="enviar_documento(this.value)">Enviar notificación</button>
                </div>
            </div>
        </div>
    </div>