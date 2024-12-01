<div class="card card-form card-personal">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-user-circle"></i> Datos personales
        </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Cerrar">
                <i class="fas fa-minus"></i></button>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <!-- Tipo de cliente -->
            <div class="col-md-12">
                <div class="form-group">
                    <label for="tipo_cliente" class="ivois-label">Tipo de cliente</label>
                    <div class="row input-group">
                        <?php foreach ($customerTypes as $customerTypeDTO) : ?>
                            <div class="col-md-6 form-group">
                                <!-- Radio buttons -->
                                <div class="form-check form-check-inline">
                                    <input class="receiver form-check form-check-input ivois-radio customerType-radio customerType-<?= $customerTypeDTO->id ?>" type="radio" value="<?= $customerTypeDTO->id ?>" name="<?= $customerTypeName ?? "customerType" ?>" <?php if (isset($customerType) && $customerType == $customerTypeDTO->id) {
                                                                                                                                                                                                                                                                        echo "checked";
                                                                                                                                                                                                                                                                    } ?>>
                                    <label class="form-check form-check-label ivois-label" for="customerType-<?= $customerTypeDTO->id ?>"><?= $customerTypeDTO->description ?></label>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label class="text-left ivois-label" for="nationality">Pais</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        </div>
                        <select name="<?= $nationalityName ?? "nationality" ?>" class="receiver form-control inp nationality">
                            <option value="">Seleccionar</option>
                            <?php foreach ($countries as $country) : ?>
                                <option value="<?= $country->isoCode ?>" <?php if (isset($nationality) && $nationality->isoCode == $country->isoCode) {
                                                                                echo "selected";
                                                                            } ?> data-serviceStatus="<?= $country->serviceStatus ?>">
                                    <?= $country->name ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="row">
                    <!-- Tipo de cedula-->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="text-left ivois-label" for="identification[typeId]">Tipo de identificación</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                </div>
                                <select name="<?= $identificationTypeIdName ?? "identification[typeId]" ?>" class="receiver form-control inp identification_typeId">
                                    <option value="">Seleccionar</option>
                                    <?php foreach ($identificaciones as $identificationType) : ?>
                                        <option value="<?= $identificationType->typeId ?>" <?php if (isset($identification) && $identificationType->typeId == $identification->typeId) {
                                                                                                echo "selected";
                                                                                            } ?> data-code="<?= $identificationType->code ?>">
                                            <?= $identificationType->description ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Cédula del cliente -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="text-left ivois-label" for="identification[number]">Identificación</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                </div>
                                <input class="receiver form-control inp identification_number" name="<?= $identificationNumberName ?? "identification[number]" ?>" type="text" placeholder="Ingrese el número de cédula" value="<?php if (isset($identification)) {
                                                                                                                                                                                                                                    echo formatear_cedula($identification->number, $identification->code);
                                                                                                                                                                                                                                } ?>" required max="100">

                                <div class="input-group-append">
                                    <!-- Boton para eliminar el contenido del campo -->
                                    <button class="btn btn-danger inp btn-dlt-id" disabled type="button" onclick="vaciar_cedula()" data-toggle="tooltip" data-placement="top" title="Eliminar">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8 name">
                <div class="form-group">
                    <!-- Nombre del cliente -->
                    <label class="text-left ivois-label" for="businessName">Nombre completo</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input class="receiver form-control inp businessName" placeholder="Nombre del contribuyente" name="<?= $businessNameName ?? 'businessName' ?>" required value="<?php if (isset($businessName)) {
                                                                                                                                                                                            echo $businessName;
                                                                                                                                                                                        } ?>" type="text" max="100">
                    </div>
                </div>
            </div>

            <!-- Nombre comercial -->
            <div class="col-md-4 name">
                <div class="form-group">
                    <label class="ivois-label text-left" for="tradeName">Nombre Comercial</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        </div>
                        <input type="text" class="receiver form-control inp tradeName" name="<?= $tradeNameName ?? "tradeName" ?>" placeholder="Nombre de la empresa" value="<?= $tradeName ?? $businessName ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>