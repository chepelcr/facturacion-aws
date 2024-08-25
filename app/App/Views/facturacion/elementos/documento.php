<form class="card-factura" id="card-factura-<?= $numero_documento ?>">
    <div class="form-group" hidden>
        <!-- Select con los tipos de documentos -->
        <select class="form-control form-control-sm id_tipo_documento" name="id_tipo_documento">
            <?php foreach ($tipos_documentos as $tipo_documento) : ?>
                <option value="<?= $tipo_documento->id_tipo_documento; ?>" <?= $tipo_documento->id_tipo_documento == $id_tipo_documento ? 'selected' : '' ?>>
                    <?= $tipo_documento->descripcion; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="row">
        <!--Información del documento (Tipo de documento, cliente, tipo de cambio, actividades económicas)-->
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-file-alt"></i>
                    <span><?= getDocumentName($id_tipo_documento) ?></span>
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
                                            <select class="form-control" id="condicion_venta" name="condicion_venta" required>
                                                <option value="">Seleccionar</option>
                                                <?php foreach ($condiciones_venta as $condicion_venta) : ?>
                                                    <option value="<?= $condicion_venta->codigo ?>" <?= $condicion_venta->codigo == '01' ? 'selected' : '' ?>>
                                                        <?= $condicion_venta->nombre ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tipo de cambio-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tipo_cambio">Tipo de cambio del dolar</label>
                                        <div class="row">
                                            <!-- Selector de la moneda -->
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-coins"></i></span>
                                                    </div>
                                                    <select class="form-control moneda inp-fct" name="moneda" required>
                                                        <option value="">Seleccionar</option>
                                                        <option value="CRC" selected>Colones</option>
                                                        <option value="USD">Dólares</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- Valor de la moneda -->
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-hand-holding-usd"></i></span>
                                                    </div>
                                                    <input class="form-control tipo_cambio inp-fct" name="tipo_cambio" readonly required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Actividades económicas -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="actividad_economica">Actividad económica</label>
                                        <select class="form-control form-control-sm actividad_economica" name="actividad_economica" <?= count($empresa->actividades_economicas) == 1 ? 'disabled' : '' ?>>
                                            <option value="">Seleccionar</option>
                                            <?php foreach ($empresa->actividades_economicas as $actividad_economica) : ?>
                                                <option value="<?= $actividad_economica->cod_actividad ?>" <?= count($empresa->actividades_economicas) == 1 ? 'selected' : '' ?>>
                                                    <?= $actividad_economica->nombre_actividad ?>
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
                                        <label for="identificacion-cliente">Receptor</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-user"></i></span>
                                            </div>
                                            <input type="text" disabled readonly class="form-control nombre-cliente" placeholder="Buscar cliente">
                                            <input type="hidden" class="form-control identificacion-cliente" name="identificacion-cliente">

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
                                                    <input class="form-check form-check-input chk-pg inp-fct efectivo" type="radio" value="01" id="efectivo" name="medio_pago" required checked>
                                                    <label class="form-check-label" for="efectivo">
                                                        Efectivo
                                                    </label>
                                                </div>
                                            </div>

                                            <!-- Tarjeta -->
                                            <div class="col-md-3 col-sm-6">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check form-check-input chk-pg inp-fct tarjeta" type="radio" value="02" id="tarjeta" name="medio_pago" required>
                                                    <label class="form-check-label" for="tarjeta">
                                                        Tarjeta
                                                    </label>
                                                </div>
                                            </div>

                                            <!-- Simpe -->
                                            <div class="col-md-3 col-sm-6">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check form-check-input chk-pg inp-fct transferencia" type="radio" value="04" id="transferencia" name="medio_pago" required>
                                                    <label class="form-check-label" for="transferencia">
                                                        SINPE
                                                    </label>
                                                </div>
                                            </div>

                                            <!-- Otro -->
                                            <div class="col-md-3 col-sm-6">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check form-check-input chk-pg inp-fct otro" type="radio" value="99" id="otro" name="medio_pago" required>
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
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                                                </div>

                                                <input class="form-control form-control-sm gnl-agregar" type="text" placeholder="Ingrese el código de barras o el nombre del articulo">

                                                <!-- Buscar articulo -->
                                                <div class="input-group-append">
                                                    <button class="btn btn-buscar-prod" type="button" data-toggle="tooltip" title="Buscar producto" onclick="buscar_producto(this, '', true)">
                                                        <i class="fas fa-search"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="row cont-details">
                                        <div class="col-md-6 linea">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-3 col-sm-12 mb-2">
                                                            <span class="numero_linea_lbl">Linea 1</span>
                                                            <input type="hidden" class="form-control form-control-sm numero_linea" value="1" name="linea[numero_linea][]">
                                                        </div>

                                                        <div class="col-md-9 col-sm-12 mb-2">
                                                            <div class="input-group">
                                                                <!-- Descripcion -->
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fas fa-align-justify"></i></span>
                                                                </div>

                                                                <input class="form-control form-control-sm inp-fct descripcion" type="text" placeholder="Descripción" readonly disabled>
                                                                <input type="hidden" name="linea[detalle][]" class="descripcion">
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

                                                                    <input class="form-control form-control-sm inp-fct codigo_venta" type="number" min="0" readonly placeholder="Código de barras" disabled>
                                                                    <input type="hidden" name="linea[codigo_venta][]" class="codigo_venta">
                                                                    <input class="codigo" type="hidden" name="linea[codigo][]">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Cantidad -->
                                                        <div class="col-md-3 col-sm-6 mb-2">
                                                            <div class="input-group input-group-sm">
                                                                <input value="0" class="form-control form-control-sm cantidad calcular inp-fct" min="1" type="number" name="linea[cantidad][]" required>
                                                            </div>
                                                        </div>

                                                        <!-- Unidad -->
                                                        <div class="col-md-3 col-sm-6 mb-2">
                                                            <div class="input-group input-group-sm">
                                                                <!-- Unidad -->
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fas fa-boxes"></i></span>
                                                                </div>

                                                                <select class="form-control form-control-sm unidad inp-fct" disabled>
                                                                    <option value="">Seleccionar</option>
                                                                    <!-- Recorrer unidades de medida -->
                                                                    <?php foreach ($unidades_medida as $unidad) : ?>
                                                                        <option value="<?= $unidad->simbolo ?>" <?php if ($unidad->id_unidad == 85) echo 'selected' ?>>
                                                                            <?= $unidad->descripcion ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>

                                                                <input type="hidden" name="linea[unidad][]" class="unidad">
                                                            </div>
                                                        </div>

                                                        <!-- Precio -->
                                                        <div class="col-md-6 col-sm-6 mb-2">
                                                            <div class="input-group input-group-sm">
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
                                            <span class="input-group-text">I.V.A</span>
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
                                <input type="text" name="notas" placeholder="Observaciones" class="form-control bg-gray text-gray">
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