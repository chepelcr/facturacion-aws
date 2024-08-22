<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-info-circle"></i>
            Datos generales
        </h3>
    </div>

    <div class="card-body">
        <div class="row">
            <input hidden disabled class="form-control inp" type="number" id="id_producto" name="id_producto">
            <!-- Nombre del articulo -->
            <div class="col-md-12">
                <div class="form-group">
                    <label for="nombre" class="text-left">Descripción</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-pencil-alt"></i>
                            </span>
                        </div>
                        <input class="form-control inp" id="descripcion" name="descripcion" type="text" required
                            max="100">
                    </div>
                </div>
            </div>

            <!-- Tipo de producto (compra o produccion) -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="tipo" class="text-left">Tipo</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-hand-pointer"></i>
                            </span>
                        </div>
                        <select class="form-control inp" id="tipo_producto" name="tipo_producto" required>
                            <option value="">Seleccione una opción</option>
                            <option value="C">Compra</option>
                            <option value="P">Producción</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Unidad de medida -->
            <div class="col-md-6">
                <div class="form-group">
                    <label class="text-left">Unidad de
                        medida</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-ruler-combined"></i>
                            </span>
                        </div>
                        <select class="form-control inp" name="id_unidad" required id="id_unidad">
                            <option value="">Seleccionar</option>
                            <!-- Metros -->
                            <optgroup label="Metros">
                                <option value="1">Metro</option>
                                <option value="2">Centimetro</option>
                            </optgroup>

                            <!-- Kilogramos -->
                            <optgroup label="Kilogramos">
                                <option value="3">Kilogramo</option>
                                <option value="4">Gramo</option>
                            </optgroup>

                            <!-- Litros -->
                            <optgroup label="Litros">
                                <option value="5">Litro</option>
                                <option value="6">Mililitro</option>
                            </optgroup>

                            <!-- Unidades -->
                            <optgroup label="Unidades">
                                <option value="7">Unidad</option>
                            </optgroup>

                            <!-- Servicios -->
                            <optgroup label="Servicio">
                                <option value="8">Servicio</option>
                            </optgroup>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>