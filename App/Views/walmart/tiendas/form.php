<div class="row">
    <!-- Id de la tienda -->
    <input type="number" hidden name="id_tienda" class="id_tienda">

    <!-- Datos generales -->
    <div class="col-md-12">
        <div class="card card-form">
            <div class="card-header">
                <h4 class="card-title">
                    <i class="fa fa-pencil-square-o"></i>
                    Datos generales
                </h4>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <!-- Nombre de la tienda -->
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="nombre_tienda">Nombre de la tienda</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <!-- Icono de tienda -->
                                        <i class="fas fa-store"></i>
                                    </div>
                                </div>
                                <input class="form-control inp nombre" name="nombre" type="text"
                                    placeholder="Nombre de la tienda" required>
                            </div>
                        </div>
                    </div>

                    <!-- Seleccionar formato -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="formato">Tipo de tienda</label>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <!-- Icono de formato -->
                                        <i class="fas fa-file-alt"></i>
                                    </div>
                                </div>

                                <select class="form-control inp id_formato" name="id_formato" required>
                                    <option value="">Seleccionar formato</option>
                                    <?php foreach ($formatos as $formato): ?>
                                    <option value="<?=$formato->id_formato?>"><?=$formato->nombre_formato?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Seleccionar pais -->
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="pais">Pais</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <!-- Icono de pais -->
                                        <i class="fas fa-flag"></i>
                                    </div>
                                </div>

                                <!-- Select de pais -->
                                <select class="form-control inp cod_pais" name="cod_pais" required>
                                    <option value="">Seleccionar pais</option>
                                    <?php foreach ($paises as $pais): ?>
                                    <option value="<?=$pais->cod_pais?>">
                                        <?=$pais->nombre_pais?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Gln -->
                    <div class="col-md-7">
                        <div class="form-group">
                            <label for="gln">GLN</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <!-- Icono de gln -->
                                        <i class="fas fa-barcode"></i>
                                    </div>
                                </div>

                                <!-- Input de gln -->
                                <input class="form-control gln" name="gln" type="text" placeholder="GLN"
                                    required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>