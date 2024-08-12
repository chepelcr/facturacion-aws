<div class="card card-form">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-text-width"></i> Datos generales
        </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                title="Collapse">
                <i class="fas fa-minus"></i></button>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <input hidden disabled class="form-control inp" type="number" id="id_articulo" name="id_articulo">
            <!-- Nombre del articulo -->
            <div class="col-md-8">
                <div class="form-group">
                    <label for="nombre" class="text-left">Descripción</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        </div>
                        <input class="form-control inp" id="descripcion" name="descripcion" type="text" required
                            max="100">
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
                        <select class="form-control inp id_categoria" name="id_categoria" required>
                            <?php foreach($categorias as $categoria): ?>
                            <option value="<?php echo $categoria->id_categoria; ?>">
                                <?php echo $categoria->nombre_categoria; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Unidad de medida -->
            <div class="col-md-7">
                <div class="form-group">
                    <label class="text-left">Unidad de
                        medida</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-shopping-basket"></i>
                            </span>
                        </div>
                        <select class="form-control inp id_unidad" name="id_unidad" required>
                            <option value="">Seleccionar</option>

                            <?php foreach($unidades as $unidad): ?>
                            <option value="<?php echo $unidad->id_unidad; ?>">
                                <?php echo $unidad->descripcion; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="form-group">
                    <label class="text-left">Unidades por empaque</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-marker"></i>
                            </span>
                        </div>
                        <input class="form-control inp unidad_empaque" id="" name="unidad_empaque" required type="number"
                            value="1" min="1">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>