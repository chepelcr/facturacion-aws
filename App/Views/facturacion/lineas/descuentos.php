<!-- Descuentos -->
<div class="card card-descuentos">
    <div class="card-header">
        <div class="row">
            <div class="col-md-2">
                <h4 class="card-title">
                    <i class="fas fa-percent"></i>
                    Descuentos</h4>
            </div>

            <div class="col-md-6"></div>

            <div class="col-md-2">
                <div class="input-group" data-toggle="tooltip" title="Total de descuentos">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                    </div>
                    <input class="form-control form-control-sm descuentoVL" value="0" disabled readonly>
                    <input value="0" class="descM inp-fct" type="hidden" name="linea[monto_descuento][]">
                </div>
            </div>

            <div class="col-md-2">
                <div class="row">
                    <!-- Agregar descuento -->
                    <div class="col-md-6">
                        <button type="button" class="btn btn-outline-primary btn-sm btn-block" onclick="agregar_descuento(this)"
                            data-toggle="tooltip" title="Agregar descuento">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                    
                    <!-- Mininizar -->
                    <div class="col-md-6">
                        <button type="button" class="btn btn-outline-danger btn-sm btn-block" data-card-widget="collapse"
                            data-toggle="tooltip" title="Ver descuentos">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-body">
        <table class="tabla_descuentos table table-bordered table-striped">
            <thead>
                <tr>
                    <th class="col-6">Motivo de descuento</th>
                    <th class="col-2">%</th>
                    <th class="col-3">Monto</th>
                    <th class="col-1">Acciones</th>
                </tr>
            </thead>

            <tbody>
                <tr class="linea_descuento">
                    <td colspan="4">
                        <div class="row">
                            <!-- Motivo -->
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-align-justify"></i>
                                            </span>
                                        </div>
                                        <input class="form-control form-control-sm inp-fct motivo" type="text"
                                            name="descuento[motivo_descuento][]" placeholder="Motivo de descuento">
                                    </div>
                                </div>
                            </div>

                            <!-- Porcentaje -->
                            <div class="col-2">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-percent"></i>
                                            </span>
                                        </div>

                                        <input class="form-control form-control-sm descP calcular inp-fct" min="0"
                                            type="number" max="100" value="0">
                                    </div>
                                </div>
                            </div>

                            <!-- Monto descuento -->
                            <div class="col-3">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </span>
                                        </div>

                                        <input class="form-control form-control-sm descVL" value="0" disabled readonly>

                                        <input value="0" class="descuento" type="hidden"
                                            name="descuento[monto_descuento][]" required>

                                    </div>
                                </div>
                            </div>

                            <!-- Acciones -->
                            <div class="col-1">
                                <div class="form-group">
                                    <button type="button" class="btn btn-outline-danger btn-sm btn-block  btn-dlt"
                                        disabled onclick="eliminar_descuento(this)">
                                        <i class="fa fa-trash"></i>
                                    </button>

                                    <!-- Numero de linea -->
                                    <input value="0" class="numero_linea" type="hidden"
                                        name="descuento[numero_linea][]">
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->