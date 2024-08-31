<div class="card card-form">
    <div class="card-header">
        <h4 class="card-title">
            <i class="fas fa-user-tie"></i> Informacion de facturación
        </h4>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- Sucursal -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="empresa">Sucursal</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-building"></i>
                            </span>
                        </div>

                        <select required class="form-control inp branchId" name="branchId" onchange="getPointsOfSale(this)">
                            <option value="">Seleccione</option>
                            <?php foreach ($branches as $branch): ?>
                                <option value="<?php echo $branch->number; ?>"
                                    <?php if (isset($branchNumber) && $branchNumber == $branch->number) echo 'selected'; ?>>
                                    <?php echo $branch->name; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Punto de venta -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="punto_venta">Punto de venta</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-store"></i>
                            </span>
                        </div>

                        <select required class="form-control inp pointOfSaleId" name="pointOfSaleId">
                            <option value="">Seleccione</option>

                            <?php if (isset($terminals)): ?>
                                <?php foreach ($terminals as $terminal): ?>
                                    <option value="<?php echo $terminal->number; ?>"
                                        <?php if (isset($terminalNumber) && $terminalNumber == $terminal->number) echo 'selected'; ?>>
                                        <?php echo "Punto de venta " . $terminal->name; ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>