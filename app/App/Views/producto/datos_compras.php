<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-shopping-cart"></i>
            Datos de venta
        </h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Valor unitario</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-dollar-sign"></i>
                            </span>
                        </div>
                        <input class="form-control inp" type="number" id="valor_unitario"
                            name="valor_unitario" required>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Cantidad por empaque</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-box"></i>
                            </span>
                        </div>
                        <input class="form-control inp" type="number" id="cantidad" name="cantidad" required>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Subtotal</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-dollar-sign"></i>
                            </span>
                        </div>
                        <input class="form-control inp" type="number" id="subtotal" name="subtotal" required>
                    </div>
                </div>
            </div>

            <!-- Impuesto -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Impuesto</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-dollar-sign"></i>
                            </span>
                        </div>
                        <input class="form-control inp" type="number" id="valor_impuesto" name="valor_impuesto" required>
                    </div>
                </div>
            </div>

            <!-- Total -->
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">Precio de venta</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-dollar-sign"></i>
                            </span>
                        </div>
                        <input class="form-control inp" type="number" id="precio_venta" name="precio_venta" required>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>