<form class="card-factura" id="card-factura-<?= $numero_documento ?>">
    <div class="form-group" hidden>
        <!-- Select con los tipos de documentos -->
        <select class="form-control form-control-sm documentTypeId" name="documentType">
            <option data-code="<?= $documentType->code ?>" value="<?= $documentType->documentTypeId ?>" selected>
                <?= $documentType->description; ?>
            </option>
        </select>
        <!-- Select con la version del documento -->
        <select class="form-control form-control-sm version" name="versionId">
            <option value="<?= $documentVersion->versionId ?>" selected>
                <?= $documentVersion->description ?>
            </option>
        </select>

        <!-- Branch -->
        <input type="text" class="branchNumber" name="branchNumber" value="<?= getEnt('ivois.api.branch.number') ?>">

        <!-- Terminal -->
        <input type="text" class="terminalNumber" name="terminalNumber" value="<?= getEnt('ivois.api.branch.terminal.number') ?>">
    </div>

    <div class="row">
        <!--Información del documento (Tipo de documento, cliente, tipo de cambio, actividades económicas)-->
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-file-alt"></i>
                    <span><?= $documentType->description ?></span>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <!-- Tipo de venta -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tipo_venta">Tipo de venta</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-handshake"></i></span>
                                            </div>
                                            <select class="form-control slc-saleCondition" id="condicion_venta" name="saleConditionId" required onchange="agregar_termino_credito(this)">
                                                <option value="">Seleccionar</option>
                                                <?php
                                                foreach ($saleConditions as $condicion_venta) :
                                                    if ($condicion_venta->code == '02') {
                                                        $condicion_venta->description = 'Crédito 30 días';

                                                        $creditTerm = 30;
                                                    } else {
                                                        $creditTerm = 0;
                                                    }
                                                ?>
                                                    <option value="<?= $condicion_venta->conditionId ?>" <?= $condicion_venta->code == '01' ? 'selected' : '' ?> data-creditTerm="<?= $creditTerm ?>">
                                                        <?= $condicion_venta->description ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <!-- Termino de credito -->
                                            <input type="hidden" class="form-control inp-fct creditTerm" name="creditTerm" placeholder="Término de crédito" value="0">
                                        </div>
                                    </div>
                                </div>

                                <!-- Tipo de cambio-->
                                <div class="col-md-6">
                                    <div class="row">
                                        <!-- Selector de Moneda -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="currencyCode">Moneda</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                                    </div>
                                                    <select class="form-control currencyCode" name="currencyCode[currencyCode]" required onchange="selectTipoCambio()">
                                                        <?php
                                                        foreach ($countries as $moneda) :
                                                            if ($moneda->currencyCode == 'CRC' || $moneda->currencyCode == 'USD') :
                                                                if ($moneda->currencyCode == 'CRC') {
                                                                    $moneda->name = 'Colones';
                                                                }

                                                                if ($moneda->currencyCode == 'USD') {

                                                                    $moneda->name = 'Dolares';
                                                                }
                                                            endif;

                                                        ?>
                                                            <option data-currencyCode="<?= $moneda->currencyCode ?>" value="<?= $moneda->isoCode ?>" <?= $moneda->currencyCode == 'CRC' ? 'selected' : '' ?>>
                                                                <?= $moneda->name ?>
                                                            </option>
                                                        <?php
                                                        endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Valor de la moneda -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exchangeRate">Tipo de cambio</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-hand-holding-usd"></i></span>
                                                    </div>
                                                    <input class="form-control exchangeRate inp-fct calcular_tipo_cambio" name="currencyCode[exchangeRate]" readonly required>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Valor de la moneda -->
                                    </div>
                                </div>

                                <!-- Actividades económicas -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="actividad_economica">Actividad económica</label>
                                        <select class="form-control form-control-sm activityCode inp-fct" name="activityCode" <?= count($empresa->activities) == 1 ? 'disabled' : '' ?>>
                                            <option value="">Seleccionar</option>
                                            <?php foreach ($empresa->activities as $actividad_economica) : ?>
                                                <option value="<?= $actividad_economica->code ?>" <?= (count($empresa->activities) == 1 || $actividad_economica->type == 'Primaria') ? 'selected' : '' ?>>
                                                    <?= $actividad_economica->description ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="row">
                                <!-- Receptor -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="customerId">Receptor</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-user"></i></span>
                                            </div>
                                            <input type="text" disabled readonly class="form-control nombre-cliente" placeholder="Buscar cliente">
                                            <input type="hidden" class="form-control customerId">

                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-outline-secondary" onclick="ver_modal_cliente();" title="Buscar cliente" data-toggle="tooltip">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Medios de pago -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="medio_pago">Medio de pago</label>
                                        <div class="row">
                                            <!-- Efectivo -->
                                            <div class="col-md-3 col-sm-6">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check form-check-input chk-pg inp-fct" type="checkbox" data-code="01">
                                                    <label class="form-check-label" for="efectivo">
                                                        Efectivo
                                                    </label>
                                                </div>
                                            </div>

                                            <!-- Tarjeta -->
                                            <div class="col-md-3 col-sm-6">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check form-check-input chk-pg inp-fct" type="checkbox" data-code="02">
                                                    <label class="form-check-label" for="tarjeta">
                                                        Tarjeta
                                                    </label>
                                                </div>
                                            </div>

                                            <!-- Simpe -->
                                            <div class="col-md-3 col-sm-6">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check form-check-input chk-pg inp-fct" type="checkbox" data-code="04">
                                                    <label class="form-check-label" for="transferencia">
                                                        SINPE
                                                    </label>
                                                </div>
                                            </div>

                                            <!-- Otro -->
                                            <div class="col-md-3 col-sm-6">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check form-check-input chk-pg inp-fct" type="checkbox" data-code="99">
                                                    <label class="form-check-label" for="otro">
                                                        Otro
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Detalles del documento -->
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row d-flex justify-content-between">
                                        <div class="col-md-9 align-content-center">
                                            <h3 class="card-title">
                                                <i class="fas fa-list"></i> Detalles
                                            </h3>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="input-group input-group-sm">
                                                <!-- Codigo de barras -->
                                                <div class="input-group-prepend" data-toggle="tooltip" title="Ingrese el código de barras o el nombre del articulo">
                                                    <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                                                </div>

                                                <input class="form-control form-control-sm gnl-agregar" type="text" placeholder="Buscar producto">

                                                <!-- Buscar articulo -->
                                                <div class="input-group-append">
                                                    <button class="btn" type="button" data-toggle="tooltip" title="Buscar producto" onclick="buscar_producto(this, '', true)">
                                                        <i class="fas fa-search"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="row cont-details">
                                        <div class="col-md-6 detail">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-3 col-sm-12 mb-2">
                                                            <span class="numero_linea_lbl">Linea 1</span>
                                                            <input type="hidden" class="form-control form-control-sm productId" name="details[0][productId]">
                                                        </div>

                                                        <div class="col-md-9 col-sm-12 mb-2">
                                                            <div class="input-group">
                                                                <!-- Descripcion -->
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fas fa-align-justify"></i></span>
                                                                </div>

                                                                <input class="form-control form-control-sm inp-fct description" name="details[0][description]" type="text" placeholder="Descripción" readonly disabled>
                                                            </div>
                                                        </div>

                                                        <!-- Codigo de barrras -->
                                                        <div class="col-md-6 col-sm-12 mb-2">
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <!-- Codigo de barras -->
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                                                                    </div>

                                                                    <input class="form-control form-control-sm inp-fct saleCode" type="number" min="0" readonly placeholder="Código de barras" disabled>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Cantidad -->
                                                        <div class="col-md-3 col-sm-6 mb-2">
                                                            <div class="input-group input-group-sm">
                                                                <input value="0" class="form-control form-control-sm quantity calcular inp-fct" min="1" type="number" name="details[0][quantity]" required>
                                                            </div>
                                                        </div>

                                                        <!-- Unidad -->
                                                        <div class="col-md-3 col-sm-6 mb-2">
                                                            <div class="input-group input-group-sm">
                                                                <!-- Unidad -->
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fas fa-boxes"></i></span>
                                                                </div>

                                                                <select class="form-control form-control-sm unitId inp-fct" required>
                                                                    <option value="">Seleccionar</option>
                                                                    <!-- Recorrer unidades de medida -->
                                                                    <?php foreach ($unidades_medida as $unidad) : ?>
                                                                        <option value="<?= $unidad->unitId ?>" <?= $unidad->unitId == 85 ? 'selected' : '' ?>>
                                                                            <?= $unidad->description ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <!-- Precio -->
                                                        <div class="col-md-6 col-sm-6 mb-2">
                                                            <div class="input-group input-group-sm">
                                                                <!-- Total linea -->
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">Total</span>
                                                                </div>
                                                                <input value="0" class="form-control form-control-sm totalVL inp-fct" readonly disabled>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 col-sm-6 mb-2">
                                                            <div class="row row-cols-2 row-cols-md-2 row-cols-lg-2 row-cols-sm-2">
                                                                <div class="col d-flex justify-content-center">
                                                                    <button class="btn btn-primary descB btn-sm w-100" type="button" onclick="mostrar_detalles(this)">
                                                                        <i class="fas fa-percent"></i>
                                                                    </button>
                                                                </div>

                                                                <div class="col eliminarLinea d-flex justify-content-center ">
                                                                    <button type="button" class="btn btn-danger btn-sm eliminarLinea w-100" onclick="eliminar_linea(this)" hidden>
                                                                        <i class="fas fa-times-circle"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <?= view('facturacion/modal/detalle', $modalLinea) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row mb-2">
                                <!-- Total Neto -->
                                <div class="col-md-12 mb-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Neto</span>
                                        </div>
                                        <input type="text" disabled readonly class="form-control lbl_neto">
                                    </div>
                                </div>

                                <!-- Descuentos -->
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Descuentos</span>
                                        </div>
                                        <input type="text" disabled readonly class="form-control lbl_descuentos">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-2">
                            <div class="row">
                                <!-- Subtotal -->
                                <div class="col-md-12 mb-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Subtotal</span>
                                        </div>
                                        <input type="text" disabled readonly class="form-control lbl_subtotal">
                                    </div>
                                </div>

                                <!-- I.V.A -->
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Impuestos</span>
                                        </div>
                                        <input type="text" disabled readonly class="form-control lbl_iva">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mb-2">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Total</span>
                                </div>
                                <input type="text" disabled readonly class="form-control lbl_total">
                            </div>
                        </div>

                        <div class="col-md-12 mb-2">
                            <div class="input-group">
                                <input type="text" name="annotations" placeholder="Observaciones" class="form-control bg-gray text-gray">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= view('facturacion/modal/cierre_documento', $modalCierreDocumento) ?>

    <?= view('facturacion/modal/referencias', $data_referencias) ?>

    <div class="contenedor-walmart">

    </div>
</form>