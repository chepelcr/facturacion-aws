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
        <input disabled class="form-control inp productId" type="hidden" name="productId">

        <div class="row">
            <div class="col-md-7">
                <div class="row">
                    <!-- Nombre del articulo -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="nombre" class="ivois-label">Nombre</label>
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
                            <label for="descripcion" class="ivois-label">Descripción</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                </div>
                                <textarea class="form-control inp description" name="description" required max="256"></textarea>
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
                    <div class="col-md-6 commercialUnit">
                        <div class="form-group">
                            <label for="measurementUnit_commercialUnit" class="ivois-label">Unidad de medida comercial</label>
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

                    <!-- Validación de producto por empaque -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <!-- Checkbox -->
                            <div class="form-check form-check-inline pt-2">
                                <input class="form-check inp isPackaged" type="checkbox" name="isPackaged" value="1" onchange="showPackagingInfo(this)">
                                <label class="ml-2 ivois-label" for="">Este producto se vende por empaque</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Imagen -->
            <div class="col-md-5">
                <div class="card ivois-image-card mb-2">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <img class="ivois-img-thumbnail" alt="" src="<?= getFile('dist/img/icons/image.png') ?>">
                            </div>
                            <div class="col-md-12 text-center">
                                <button class="btn-cargar-imagen inter-bold underline" type="button">Cargar imagen</button>
                                <p class="ivois-image-text inter-regular">
                                    Formato JPG o PNG.
                                    Dimensiones preferidas: 400x400 pixeles a 72ppp. Tamaño máximo del archivo: 1MB.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>