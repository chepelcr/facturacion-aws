<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Datos del inventario</h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <input hidden disabled class="form-control inp" type="number" id="id_inventario_detalle"
                        name="id_articulo">
                    <!-- Nombre del articulo -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombre" class="text-left">Cantidad disponible</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                </div>
                                <input class="form-control form-control-lg inp" id="cantidad_inventario"
                                    name="cantidad_inventario" type="number" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="text-left">Cantidad de alerta</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-folder-plus"></i>
                                    </span>
                                </div>
                                <input class="form-control inp" id="cantidad_alerta" name="cantidad_alerta"
                                    type="number">
                            </div>
                        </div>
                    </div>


                    <!-- Unidad de medida -->
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-left">Precio de compra</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-folder-plus"></i>
                                            </span>
                                        </div>
                                        <input class="form-control inp" id="precio_compra" name="precio_compra"
                                            type="number">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-left">Precio de venta</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-folder-plus"></i>
                                            </span>
                                        </div>
                                        <input class="form-control inp" id="precio_venta" name="precio_venta"
                                            type="number">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>