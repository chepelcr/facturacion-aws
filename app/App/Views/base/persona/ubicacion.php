<div class="card card-form card-ubicacion">
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
            <div class="col-md-4 ubicacion">
                <div class="form-group">
                    <label class="text-left ivois-label" for="residence[stateId]">Provincia</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        </div>
                        <select onchange="obtener_cantones()" class="receiver form-control inp residence_stateId" name="<?= $stateName ?? "residence[stateId]" ?>">
                            <option value="">Seleccionar</option>
                            <?php foreach ($states as $state): ?>
                                <option value="<?= $state->stateId ?>"
                                    <?php if (isset($residence->stateId) && $residence->stateId == $state->stateId) {
                                        echo "selected";
                                    } ?>>
                                    <?= ucfirst($state->stateName) ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-4 ubicacion">
                <div class="form-group">
                    <label class="text-left ivois-label" for="residence[countyId]">Cantón</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        </div>
                        <select onchange="obtener_distritos()" class="receiver form-control inp residence_countyId" name="<?= $countyName ?? "residence[countyId]" ?>">
                            <option value="">Seleccionar</option>

                            <!-- Si existen, recorrer cantones-->
                            <?php if (isset($counties)): ?>
                                <?php foreach ($counties as $county): ?>
                                    <option value="<?= $county->countyId ?>"
                                        <?php if (isset($residence->countyId) && $residence->countyId == $county->countyId) {
                                            echo "selected";
                                        } ?>>
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
                    <label class="text-left ivois-label" for="residence[districtId]">Distrito</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        </div>
                        <select class="receiver form-control inp residence_districtId" name="<?= $districtName ?? "residence[districtId]" ?>" onchange="isOtherLocation()">
                            <option value="">Seleccionar</option>

                            <!-- Si existen, recorrer districts-->
                            <?php if (isset($districts)): ?>
                                <?php foreach ($districts as $district): ?>
                                    <option value="<?= $district->districtId ?>"
                                        <?php if (isset($residence->districtId) && $residence->districtId == $district->districtId) {
                                            echo 'selected';
                                        } ?>>
                                        <?= ucfirst($district->districtName) ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>
            </div>

            <?php /*<div class="col-md-6 ubicacion">
                <div class="form-group">
                    <label class="text-left ivois-label" for="residence[neighborhoodId]">Barrio</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        </div>
                        <select class="receiver form-control inp residence_neighborhoodId" name="<?= $neighborhoodName ?? "residence[neighborhoodId]" ?>" required>
                            <option value="">Seleccionar</option>

                            <!-- Si existen, recorrer neighborhoods-->
                            <?php if (isset($neighborhoods)): ?>
                                <?php foreach ($neighborhoods as $neighborhood): ?>
                                    <option value="<?= $neighborhood->neighborhoodId ?>"
                                        <?php if (isset($residence->neighborhoodId) && $residence->neighborhoodId == $neighborhood->neighborhoodId) {
                                            echo 'selected';
                                        } ?>>
                                        <?= ucfirst($neighborhood->neighborhoodName) ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>
            </div>*/ ?>

            <div class="col-md-12">
                <div class="form-group">
                    <label class="text-left ivois-label" for="residence[address]">Otras señas</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        </div>
                        <textarea class="receiver form-control inp residence_address" name="<?= $addressName ?? "residence[address]" ?>" cols="30" rows="3"
                            placeholder="Direccion Completa"><?= $residence->address ?? '' ?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>