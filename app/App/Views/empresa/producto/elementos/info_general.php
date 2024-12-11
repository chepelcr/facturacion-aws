<div class="row">
    <!-- Nombre del articulo -->
    <div class="col-md-12">
        <div class="form-group">
            <label for="nombre" class="ivois-label">Nombre</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                </div>
                <input class="form-control inp name det-name-mod" name="<?php if (isset($isDetail)) {
                                                                echo "details[0][description]";
                                                            } else {
                                                                echo 'name';
                                                            } ?>"
                    type="text" required max="128">
            </div>
        </div>
    </div>

    <!-- Descripción -->
    <div class="col-md-12">
        <div class="form-group">
            <label for="descripcion" class="ivois-label">Descripción</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                </div>
                <textarea class="form-control inp description" max="256" <?php if (isset($isDetail)) {
                                                                                echo 'disabled readonly';
                                                                            } else {
                                                                                echo 'name="description" required';
                                                                            } ?>>
                </textarea>
            </div>
        </div>
    </div>

    <!-- Unidad de medida -->
    <div class="col-md-6">
        <div class="form-group">
            <label for="measurementUnit_unitId" class="ivois-label">Unidad de medida</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-shopping-basket"></i>
                    </span>
                </div>
                <select class="form-control inp measurementUnit_unitId" onchange="getUnitCode(this)" <?php if (isset($isDetail)) {
                                                                                                            echo 'disabled';
                                                                                                        } else {
                                                                                                            echo 'name="unitId" required';
                                                                                                        }
                                                                                                        ?>>
                    <option value="" selected>Seleccionar</option>

                    <?php foreach ($unidades as $unidad) : ?>
                        <option value="<?php echo $unidad->unitId; ?>" data-code="<?php echo $unidad->code; ?>"><?php echo $unidad->description; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>

    <!-- Unidad de medida comercia (Se habilita en caso de seleccionar otros) -->
    <div class="col-md-6 commercialUnit">
        <div class="form-group">
            <label for="measurementUnit_commercialUnit" class="ivois-label">Unidad de medida comercial</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-shopping-basket"></i>
                    </span>
                </div>
                <input class="form-control inp measurementUnit_commercialUnit" type="text" disabled readonly <?php if (!isset($isDetail)) {
                                                                                                                    echo 'name="commercialUnitMeasure" required';
                                                                                                                } ?>>
            </div>
        </div>
    </div>

    <?php if (!isset($isDetail)) : ?>

        <!-- Validación de producto por empaque -->
        <div class="col-md-12">
            <div class="form-group packageInfo">
                <!-- Checkbox -->
                <div class="form-check form-check-inline pt-2">
                    <input class="form-check inp isPackaged" type="checkbox" name="isPackaged" value="1" onchange="showPackagingInfo(this)">
                    <label class="ml-2 ivois-label" for="">Este producto se vende por empaque</label>
                </div>
            </div>
        </div>

    <?php endif; ?>
</div>