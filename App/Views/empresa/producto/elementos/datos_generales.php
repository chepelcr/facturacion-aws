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
            <div class="col-md-8">
                <div class="form-group">
                    <label for="nombre" class="text-left">Nombre</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        </div>
                        <input class="form-control inp description" name="description" type="text" required max="100">
                    </div>
                </div>
            </div>

            <!-- Categoría -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="id_categoria" class="text-left">Categoria</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-cart-plus"></i>
                            </span>
                        </div>
                        <select class="form-control inp category_categoryId" name="categoryId" required>
                            <?php foreach ($categorias as $categoria) : ?>
                                <option value="<?php echo $categoria->id_categoria; ?>">
                                    <?php echo $categoria->nombre_categoria; ?></option>
                            <?php endforeach; ?>
                        </select>
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
                        <textarea class="form-control inp longDescription" name="longDescription" required max="100"></textarea>
                    </div>
                </div>
            </div>


            <!-- Unidad de medida -->
            <div class="col-md-7">
                <div class="form-group">
                    <label class="text-left">Unidad de medida</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-shopping-basket"></i>
                            </span>
                        </div>
                        <select class="form-control inp measurementUnit_unitId" name="unitId" required>
                            <option value="">Seleccionar</option>

                            <?php foreach ($unidades as $unidad) : ?>
                                <option value="<?php echo $unidad->unitId; ?>">
                                    <?php echo $unidad->description; ?></option>
                            <?php endforeach; ?>
                        </select>
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
                        <input class="form-control inp quantity" name="quantity" required type="number" value="1" min="1">
                    </div>
                </div>
            </div>

            <!-- Ver codigos -->
            <div class="col-md-2">
                <div class="form-group">
                    <label class="text-left">Códigos de producto</label>
                    <div class="input-group">
                        <div class="input-group-append w-100">
                            <button type="button" disabled class="btn btn-default w-100" onclick="ver_codigos()" data-toggle="tooltip" title="Ver o agregar códigos">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>