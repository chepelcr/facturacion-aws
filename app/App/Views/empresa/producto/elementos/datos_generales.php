<div class="card card-form">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-text-width"></i> Datos generales
        </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fas fa-minus"></i></button>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <input disabled class="form-control inp productId" type="hidden" name="productId">
            <!-- Nombre del articulo -->
            <div class="col-md-12">
                <div class="form-group">
                    <label for="nombre" class="text-left">Nombre</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        </div>
                        <input class="form-control inp name" name="name" type="text" required max="128">
                    </div>
                </div>
            </div>

            <!-- Descripción -->
            <div class="col-md-12">
                <div class="form-group">
                    <label for="descripcion" class="text-left">Descripción</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        </div>
                        <textarea class="form-control inp description" name="description" required max="256"></textarea>
                    </div>
                </div>
            </div>


            <!-- Unidad de medida -->
            <div class="col-md-5">
                <div class="form-group">
                    <label class="text-left">Unidad de medida</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-shopping-basket"></i>
                            </span>
                        </div>
                        <select class="form-control inp measurementUnit_unitId" name="unitId" required onchange="getUnitCode(this)">
                            <option value="">Seleccionar</option>

                            <?php foreach ($unidades as $unidad) : ?>
                                <option value="<?php echo $unidad->unitId; ?>" data-code="<?php echo $unidad->code; ?>"><?php echo $unidad->description; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Unidad de medida comercia (Se habilita en caso de seleccionar otros) -->
            <div class="col-md-4">
                <div class="form-group">
                    <label class="text-left">Unidad de medida comercial</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-shopping-basket"></i>
                            </span>
                        </div>
                        <input class="form-control inp measurementUnit_commercialUnit" required name="commercialUnitMeasure" type="text" disabled readonly>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label class="text-left">Unidades por empaque</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-marker"></i>
                            </span>
                        </div>
                        <input class="form-control inp quantity calcular" required name="quantity" type="number" value="1" min="1" max="1000">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>