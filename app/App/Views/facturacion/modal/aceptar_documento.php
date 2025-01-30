<!-- Modal para enviar la notificación de un documento electronico -->
<div class="modal fade" id="modalAceptarDocumentos" tabindex="-1" role="dialog" aria-labelledby="tituloAceptarDocumentos" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="frm_aceptar_documento">
                <div class="modal-header">
                    <h5 class="modal-title" id="tituloAceptarDocumentos">
                        <i class="fa-solid fa-file-circle-check"></i> Validar documento
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="documentKey">

                    <div class="row">
                        <!-- Estado de validación -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="status" class="ivois-label">Estado de validacion</label>

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

                        <!-- Mensaje de aceptación -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="message" class="ivois-label">Mensaje de aceptación</label>

                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa-solid fa-comment"></i></span>
                                    </div>
                                    <textarea class="form-control form-control-sm message" name="message" rows="3" placeholder="Mensaje de aceptación"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Sucursal -->
                        <div class="col-md-6 send-validation">
                            <div class="form-group">
                                <label for="sucursal" class="ivois-label">Sucursal</label>

                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa-solid fa-shop"></i></span>
                                    </div>
                                    <select class="form-control form-control-sm branches" onchange="selectTerminals(this, 'aceptacion')" name="branchNumber">

                                    </select>

                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-outline-secondary" onclick="actualizar_sucursales('aceptacion')" data-toggle="tooltip" data-placement="top" title="Actualizar sucursales">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Terminal -->
                        <div class="col-md-6 send-validation">
                            <div class="form-group">
                                <label for="terminal" class="ivois-label">Terminal</label>

                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa-solid fa-cart-shopping"></i></span>
                                    </div>
                                    <select class="form-control form-control-sm terminals" name="terminalNumber">
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Fecha de validacion -->
                        <div class="col-md-12 watch-validation">
                            <div class="form-group">
                                <label for="validationDate" class="ivois-label">Fecha de validación</label>

                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa-solid fa-calendar"></i></span>
                                    </div>
                                    <input type="date" class="form-control form-control-sm validationDate">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer d-flex justify-content-around">
                    <div class="col-md-5">
                        <button type="button" class="btn btn-secondary w-100" data-dismiss="modal">Cerrar</button>
                    </div>
                    <div class="col-md-5 send-validation">
                        <button type="submit" class="btn btn-primary btn-block btn-validar" title="Validar documento" data-toggle="tooltip">
                            Enviar validación <i class="fa-solid fa-envelope-circle-check"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>