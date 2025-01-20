<!-- Modal para enviar la notificación de un documento electronico -->
<div class="modal fade" id="modalSubirDocumentos" tabindex="-1" role="dialog" aria-labelledby="tituloSubirDocumentos" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="frm_subir_documento" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="tituloSubirDocumentos">
                        <i class="fas fa-envelope"></i> Subir documento XML
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="documento">Seleccionar documento</label>
                                <input type="file" class="form-control documento" name="documento" accept=".xml" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer d-flex justify-content-around">
                    <div class="col-md-5">
                        <button type="button" class="btn btn-secondary w-100" data-dismiss="modal">Cancelar</button>
                    </div>
                    <div class="col-md-5">
                        <button type="submit" class="btn btn-primary btn-block" title="Cargar documento" data-toggle="tooltip">
                            <i class="fas fa-upload"></i> Cargar documento
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>