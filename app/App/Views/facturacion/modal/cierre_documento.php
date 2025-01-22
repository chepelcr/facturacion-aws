<div class="modal fade modal-cierre" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">

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
                    <!-- Información de emisión -->
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">
                                    <i class="fas fa-info-circle"></i> Información de emisión
                                </h5>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <!-- Sucursal -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sucursal" class="ivois-label">Sucursal</label>

                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa-solid fa-shop"></i></span>
                                                </div>
                                                <select class="form-control form-control-sm" onchange="selectTerminals(this)" name="branchNumber">
                                                    <option value="">Seleccione una sucursal</option>
                                                    <?php
                                                    foreach ($branches as $branch) {
                                                    ?>
                                                        <option value="<?= $branch->number ?>" <?= sizeof($branches) == 1 ? 'selected' : '' ?> data-terminals='<?= json_encode($branch->terminals) ?>'>
                                                            <?= $branch->name ?>
                                                        </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>

                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-outline-secondary" onclick="actualizar_sucursales()" data-toggle="tooltip" data-placement="top" title="Actualizar sucursales">
                                                        <i class="fas fa-sync-alt"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Terminal -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="terminal" class="ivois-label">Terminal</label>

                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa-solid fa-cart-shopping"></i></span>
                                                </div>
                                                <select class="form-control form-control-sm terminals" <?= sizeof($branches) > 1 ? 'disabled' : '' ?> name="terminalNumber">
                                                    <option value="">Seleccione una terminal</option>

                                                    <?php
                                                    if (sizeof($branches) == 1) {
                                                        foreach ($branches[0]->terminals as $terminal) {
                                                    ?>
                                                            <option value="<?= $terminal->number ?>" <?= sizeof($branches[0]->terminals) == 1 ? 'selected' : '' ?>>
                                                                <?= $terminal->name ?>
                                                            </option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Información de pago -->
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">
                                    <i class="fas fa-money-bill-alt"></i> Información de pago
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Total de la factura -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="total_pago" class="ivois-label">Total a pagar</label>
                                            <input type="text" class="form-control form-control-sm lbl_total" disabled readonly placeholder="Total a pagar">
                                            <input type="hidden" class="form-control form-control-sm total_document">
                                        </div>
                                    </div>

                                    <div class="col-md-8">
                                        <div class="row" class="container_pagos">
                                            <?php
                                            $i = 0;
                                            foreach ($paymentTypes as $forma_pago) {
                                            ?>
                                                <div class="col-md-3 tipo-pago" data-code="<?= $forma_pago->code ?>" hidden>
                                                    <?php
                                                    //Si la descripcion contiene '- Deposito bancario', se elimina del nombre ese texto
                                                    $description = str_replace(" - Deposito bancario", '', $forma_pago->description);

                                                    //Si la descripcion tiene ' (se debe indicar el medio de pago)', se elimina del nombre ese texto
                                                    $description = str_replace(" (se debe indicar el medio de pago)", '', $description);
                                                    ?>
                                                    <div class="form-group">
                                                        <label for="pago_efectivo" class="text-center ivois-label"><?= $description ?></label>
                                                        <input type="text" class="form-control form-control-sm monto" placeholder="Monto a pagar en en <?= $description ?>" name="payments[<?= $i ?>][amount]">
                                                        <select class="slc-pg form-control form-control-sm" name="payments[<?= $i ?>][type]" hidden>
                                                            <option class="opt-emp" value="">Seleccionar forma de pago</option>

                                                            <option class="opt-pg" data-code="<?= $forma_pago->code ?>" value="<?= $forma_pago->typeId ?>"><?= $description ?></option>
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
                </div>
            </div>

            <!-- Footer del modal -->
            <div class="modal-footer">
                <div class="col-md-12">
                    <div class="fc-button-group">
                        <div class="d-flex justify-content-between">
                            <!-- Guardar documento-->
                            <button type="button" class="btn btn-sm btn-success col-2 h-75 btn-guardar-documento" onclick="guardar_documento();" data-toggle="tooltip" title="Guardar">
                                <i class="fas fa-save"></i>
                            </button>

                            <!-- Cancelar -->
                            <button type="button" class="btn btn-sm btn-danger col-2 h-75" data-dismiss="modal" data-toggle="tooltip" title="Volver">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>