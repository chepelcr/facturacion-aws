<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-cog"></i>
            Agregar producto
        </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    <label class="text-left" for="id_producto">Producto</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-store"></i></span>
                        </div>

                        <select class=" form-control producto">
                            <option value="">Seleccione un producto</option>
                            <option value="1">
                                Almohada y funda bebe colores surtidos
                            </option>

                        </select>
                    </div>
                </div>
            </div>

            <!--- Cantidad -->
            <div class="col-md-3">
                <div class="form-group">
                    <label class="text-left" for="cantidad">Cantidad</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-sort-numeric-up"></i></span>
                        </div>
                        <input type="number" class="form-control cantidad" placeholder="Cantidad">
                    </div>
                </div>
            </div>

            <!-- Agregar -->
            <div class="col-md-4">
                <div class="form-group">
                    <label class="text-left" for="cantidad">Acciones</label>
                    <div class="row">
                        <div class="col-md-6">
                            <button type="button" class="btn btn-block btn-success btn-sm agregar">
                                <i class="fas fa-plus"></i> Agregar
                            </button>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-block btn-danger btn-sm limpiar">
                                <i class="fas fa-trash"></i> Limpiar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <!-- Resumen de productos -->
        <h3 class="card-title"><i class="fas fa-cog"></i>
            Resumen de productos
        </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <table class="table-responsive table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="col-3">Producto</th>
                            <th class="col-2">Cantidad</th>
                            <th class="col-2">Valor unitario</th>
                            <th class="col-3">Subtotal</th>
                            <th class="col-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="detalle">
                        <form id="frm_lote">
                            <tr>
                                <td>
                                    <input type="hidden" name="id_producto[]" class="id_producto">
                                    <input type="text" value="Almohada y funda bebe colores surtidos"
                                        class="form-control producto" readonly>
                                </td>

                                <td>
                                    <input type="text" name="cantidad[]" value="10" class="form-control cantidad"
                                        readonly>
                                </td>

                                <td>
                                    <input type="text" name="valor_unitario[]" value="475"
                                        class="form-control valor_unitario" readonly>
                                </td>

                                <td>
                                    <input type="text" name="subtotal[]" value="4750" class="form-control subtotal"
                                        readonly>
                                </td>

                                <td>
                                    <button type="button" class="btn btn-danger btn-block eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </form>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Total del lote -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-cog"></i>
            Total del lote
        </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <!-- Total -->
                <div class="form-group">
                    <label class="text-left" for="total">Total</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                        </div>
                        <input type="text" class="form-control total" value="4750" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
