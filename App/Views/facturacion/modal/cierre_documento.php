<div class="modal fade modal-cierre" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">

        <!-- Contenido del modal -->
        <div class="modal-content">

            <!-- Titulo del modal -->
            <div class="modal-header bg-dark">
                <h5 class="modal-title titulo-form">Finalizar documento</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Contenido del modal -->
            <div class="modal-body">
                <div class="row">
                    <!-- Medio de pago -->
                    <div class="col-md-6">
                        <div class="row">
                            <!-- Efectivo -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="card form-check custom-radio">
                                        <div class="card-body d-flex justify-content-center">
                                            <div class="row">
                                                <div class="col-md 6 col-sm-12">
                                                    <label for="efectivo" class="card-title">
                                                        <i class="fas fa-money-bill-alt fa-2x"></i>
                                                    </label>
                                                </div>
                                                <div class="col-md-6 col-md-12">
                                                    <input class="form-check-input chk-pg inp-fct efectivo" type="radio" value="01" name="efectivo" id="efectivo">
                                                    <label class="form-check-label" for="efectivo">Efectivo</label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sinpe -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="card form-check custom-radio">
                                        <div class="card-header d-flex justify-content-center">
                                            <div class="card-title">
                                                <i class="fas fa-exchange-alt fa-2x"></i>
                                                </di>

                                            </div>

                                            <div class="card-body">
                                                <input class="form-check-input chk-pg inp-fct transferencia" name="transferencia" type="radio" value="04" id="transferencia">
                                                <label class="form-check-label" for="transferencia">
                                                    SINPE
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tarjeta -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="card form-check custom-radio">
                                        <div class="card-header d-flex justify-content-center">
                                            <label for="tarjeta" class="card-title"><i class="fas fa-credit-card fa-2x"></i></label>

                                        </div>

                                        <div class="card-body">
                                            <input class="form-check-input tarjeta chk-pg inp-fct" name="tarjeta" type="radio" value="03" id="tarjeta">
                                            <label class="form-check-label" for="tarjeta">
                                                Tarjeta
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Otros -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="card form-check custom-radio">
                                        <div class="card-header d-flex justify-content-center">
                                            <label for="otros" class="card-title"><i class="fas fa-file-invoice-dollar fa-2x"></i></label>
                                        </div>

                                        <div class="card-body">
                                            <input class="form-check-input chk-pg inp-fct otros" type="radio" value="" id="otros">
                                            <label class="form-check-label" for="otros">
                                                Otros
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="row d-flex">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="total_pago" class="card-title">Total a pagar</label>
                                    <input type="text" class="form-control lbl_total" disabled readonly placeholder="Total a pagar">
                                </div>
                                <div class="form-group">
                                    <label for="total_pago" class="card-title">Total pagado</label>
                                    <input type="text" class="form-control" id="total_pago" placeholder="Total pagado">
                                </div>
                            </div>

                            <div class="col-md-6 justify-content-center align-self-center p-3">
                                <!-- Colones -->
                                <button type="button" class="btn btn-outline-secondary right btn-block" onclick="cambiar_colones();" data-toggle="tooltip" title="Colones">
                                    <i class="fas fa-money-bill-wave"></i>
                                </button>

                                <!-- Dolar -->
                                <button type="button" class="btn btn-outline-secondary right btn-block" onclick="cambiar_dolar();" hidden data-toggle="tooltip" title="Dolares">
                                    <i class="fas fa-money-bill-wave"></i>
                                </button>

                                <!-- Contado -->
                                <button type="button" class="btn btn-outline-secondary right btn-block" onclick="cambiar_contado();" data-toggle="tooltip" title="Venta de contado">
                                    <i class="fas fa-money-bill-wave"></i>
                                </button>

                                <!-- Credito -->
                                <button type="button" class="btn btn-outline-secondary right btn-block" onclick="cambiar_credito();" hidden data-toggle="tooltip" title="Venta a credito">
                                    <i class="fas fa-money-bill-wave"></i>
                                </button>
                            </div>
                        </div>
                    </div>


                </div>
            </div>

            <!-- Footer del modal -->
            <div class="modal-footer">
                <div class="col-md-12">
                    <div class="fc-button-group">
                        <div class="d-flex justify-content-between">
                            <div class="col-2 col-dolares" hidden>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm total_dolares" disabled readonly placeholder="Total en dolares">
                                    </div>
                                </div>
                            </div>

                            <!-- Guardar documento-->
                            <button type="button" class="btn btn-sm btn-success col-2 h-75 btn-guardar-documento" onclick="guardar_documento();" data-toggle="tooltip" title="Guardar">
                                <i class="fas fa-save"></i>
                            </button>

                            <!-- Cancelar -->
                            <button type="button" class="btn btn-sm btn-danger col-2 h-75" data-dismiss="modal" data-toggle="tooltip" title="Cerrar">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>