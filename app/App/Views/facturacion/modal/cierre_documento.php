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
                    <div class="col-md-12">
                        <div class="row">
                            <!-- Total de la factura -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="total_pago" class="card-title">Total a pagar</label>
                                    <input type="text" class="form-control lbl_total" disabled readonly placeholder="Total a pagar">
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="row" class="container_pagos">
                                    <?php
                                    $i = 0;
                                    foreach ($paymentTypes as $forma_pago) {
                                    ?>
                                        <div class="col-md-3 tipo-pago" data-code="<?= $forma_pago->code ?>" hidden>
                                            <div class="form-group">
                                                <label for="pago_efectivo" class="card-title text-center"><?= $forma_pago->description ?></label>
                                                <input type="text" class="form-control form-control-sm monto" placeholder="Monto en <?= $forma_pago->description ?>" name="payments[<?= $i ?>][amount]">
                                                <select class="slc-pg form-control form-control-sm" name="payments[<?= $i ?>][type]">
                                                    <option class="opt-emp" value="">Seleccionar forma de pago</option>
                                                    <option class="opt-pg" data-code="<?= $forma_pago->code ?>" value="<?= $forma_pago->typeId ?>"><?= $forma_pago->description ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    <?php
                                        $i++;
                                    } ?>
                                </div>
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
                            <div class="col-2 col-dolares">
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