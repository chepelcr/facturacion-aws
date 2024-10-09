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
            <!-- País de residencia -->
            <div class="col-md-6 ubicacion">
                <div class="form-group">
                    <label class="text-left" for="residence[countryCode]">País de residencia</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        </div>
                        <select onchange="obtener_provincias(this.value)" class="form-control inp residence_countryCode" name="receiver[residence][countryCode]" required>
                            <option value="">Seleccionar</option>
                            <?php foreach ($countries as $country): ?>
                                <option value="<?= $country->isoCode ?>" data-serviceStatus="<?= $country->serviceStatus ?>">
                                    <?= ucfirst($country->name) ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>


            <div class="col-md-6 ubicacion">
                <div class="form-group">
                    <label class="text-left">Provincia</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        </div>
                        <select onchange="obtener_cantones()" class="form-control inp residence_stateId" name="receiver[residence][stateId]" required>
                            <option value="">Seleccionar</option>
                            <?php foreach ($states as $state): ?>
                                <option value="<?= $state->stateId ?>">
                                    <?= ucfirst($state->stateName) ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-4 ubicacion">
                <div class="form-group">
                    <label class="text-left">Cantón</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        </div>
                        <select onchange="obtener_distritos()" class="form-control inp residence_countyId" name="receiver[residence][countyId]" required>
                            <option value="">Seleccionar</option>

                            <!-- Si existen, recorrer cantones-->
                            <?php if (isset($counties)): ?>
                                <?php foreach ($counties as $county): ?>
                                    <option value="<?= $county->countyId ?>">
                                        <?= ucfirst($county->countyName) ?>
                                    </option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-4 ubicacion">
                <div class="form-group">
                    <label class="text-left">Distrito</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        </div>
                        <select onchange="obtener_barrios()" class="form-control inp residence_districtId" name="receiver[residence][districtId]" required>
                            <option value="">Seleccionar</option>

                            <!-- Si existen, recorrer districts-->
                            <?php if (isset($districts)): ?>
                                <?php foreach ($districts as $district): ?>
                                    <option value="<?= $district->districtId ?>">
                                        <?= ucfirst($district->districtName) ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-4 ubicacion">
                <div class="form-group">
                    <label class="text-left">Barrio</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        </div>
                        <select class="form-control inp residence_neighborhoodId" name="receiver[residence][neighborhoodId]" required>
                            <option value="">Seleccionar</option>

                            <!-- Si existen, recorrer neighborhoods-->
                            <?php if (isset($neighborhoods)): ?>
                                <?php foreach ($neighborhoods as $neighborhood): ?>
                                    <option value="<?= $neighborhood->neighborhoodId ?>">
                                        <?= ucfirst($neighborhood->neighborhoodName) ?></option>
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
                        <textarea class="form-control inp residence_address" name="receiver[residence][address]" cols="30" rows="3" required
                            placeholder="Direccion Completa"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>