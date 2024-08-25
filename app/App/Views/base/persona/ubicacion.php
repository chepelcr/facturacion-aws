<div class="card card-form">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-map-marker-alt"></i>
            Dirección
        </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                title="Colapsar">
                <i class="fas fa-minus"></i></button>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="text-left">Provincia</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        </div>
                        <select onchange="obtener_cantones(this.value)" class="form-control inp provincia">
                            <option value="">Seleccionar</option>
                            <?php foreach ($provincias as $key => $provincia): ?>
                            <option value="<?=$provincia->cod_provincia?>"
                                <?php if(isset($cod_provincia) && $cod_provincia == $provincia->cod_provincia) echo "selected"; ?>>
                                <?= ucfirst($provincia->provincia)?>
                            </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="text-left">Cantón</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        </div>
                        <select onchange="obtener_distritos()" class="form-control inp canton">
                            <option value="">Seleccionar</option>

                            <!-- Si existen, recorrer cantones-->
                            <?php if(isset($cantones)): ?>
                            <?php foreach ($cantones as $key => $canton): ?>
                            <option value="<?=$canton->cod_canton?>"
                                <?php if(isset($cod_canton) && $cod_canton == $canton->cod_canton) echo "selected"; ?>>
                                <?=ucfirst($canton->canton)?>
                            </option>
                            <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="text-left">Distrito</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        </div>
                        <select onchange="obtener_barrios()" class="form-control inp distrito">
                            <option value="">Seleccionar</option>

                            <!-- Si existen, recorrer distritos-->
                            <?php if(isset($distritos)): ?>
                            <?php foreach ($distritos as $key => $distrito): ?>
                            <option value="<?=$distrito->cod_distrito?>"
                                <?php if(isset($cod_distrito) && $cod_distrito == $distrito->cod_distrito) echo 'selected' ?>>
                                <?=ucfirst($distrito->distrito)?></option>
                            <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="text-left">Barrio</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        </div>
                        <select class="form-control inp barrio id_ubicacion" name="id_ubicacion">
                            <option value="">Seleccionar</option>

                            <!-- Si existen, recorrer barrios-->
                            <?php if(isset($barrios)): ?>
                            <?php foreach ($barrios as $key => $barrio): ?>
                            <option value="<?=$barrio->cod_barrio?>"
                                <?php if(isset($cod_barrio) && $cod_barrio == $barrio->cod_barrio) echo 'selected' ?>>
                                <?=ucfirst($barrio->barrio)?></option>
                            <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label class="text-left">Otras señas</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        </div>
                        <textarea class="form-control inp otras_senas" name="otras_senas" cols="30" rows="3"
                            placeholder="Otras señas"
                            <?php if(isset($otras_senas)) echo 'value="'.$otras_senas.'"'; ?>></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>