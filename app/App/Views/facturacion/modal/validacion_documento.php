<!-- Modal para enviar la notificación de un documento electronico -->
<div class="modal fade" id="modalValidacionDocumento" tabindex="-1" role="dialog" aria-labelledby="tituloValidacionDocumento" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tituloValidacionDocumento">
                    <i class="fa-solid fa-landmark"></i> Validación del Ministerio de Hacienda
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Estado de validación -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="status" class="ivois-label">Estado</label>

                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa-solid fa-circle-check"></i></span>
                                </div>
                                <select class="form-control form-control-sm status" name="status">
                                    <option value="1" selected>Aceptado</option>
                                    <option value="2">Parcialmente aceptado</option>
                                    <option value="3">Rechazado</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Errores de validación (Tabla) -->
                    <div class="col-md-12 validation-errors">
                        <!-- Tabla para errores de validación del ministerio de Hacienda 
                             {
                                "code": "-99",
                                "id": null,
                                "row": 0,
                                "message": "La numeración consecutiva 01400002030000000008 del comprobante que se está utilizando para este archivo XML ya existe en nuestras bases de datos desde el día 12-09-2024 11:05:11 en la clave 50612092400010244007701400002030000000008173264006",
                                "column": 0
                                } -->
                        <div class="form-group">
                            <label for="validationDate" class="ivois-label">Errores de validación</label>

                            <div class="table-responsive">
                                <table class="table table-sm table-bordered table-hover table-striped table-validacion">
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer d-flex justify-content-around">
                <div class="col-md-5">
                    <button type="button" class="btn btn-secondary w-100" data-dismiss="modal">Cerrar</button>
                </div>
                <div class="col-md-5 ">
                    <button type="button" onclick="solicitar_validacion(this.value)" class="btn btn-primary btn-block btn-validar documentKey" title="Solicitar validación del documento" data-toggle="tooltip">
                        Revalidar <i class="fa-solid fa-road-circle-check"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>