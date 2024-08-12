<!-- Datos de contacto -->
<div class="card card-form">
    <div class="card-header">
        <h4 class="card-title">
            <i class="fas fa-address-book"></i> Información de contacto
        </h4>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- Telefono personal -->
            <div class="col-md-7 contacto">
                <div class="form-group">
                    <label for="personalPhone">
                        Teléfono
                    </label>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                </div>
                                <select name="personalPhone[countryCode]" class="form-control inp personalPhone_countryCode" required>
                                    <option value="">Seleccionar</option>
                                    <?php foreach ($countries as $country) : ?>
                                        <option value="<?= $country->isoCode ?>" <?php if (isset($personalPhone) && $personalPhone->countryCode == $country->isoCode) {echo "selected";} ?>>
                                            <?= $country->name ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-7">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                </div>
                                <input class="form-control inp personalPhone_number" name="personalPhone[number]" type="text" required max="8" value="<?php if (isset($personalPhone)) {echo $personalPhone->number;} ?>" placeholder="Teléfono personal">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Correo electronico -->
            <div class="col-md-5 contacto">
                <div class="form-group">
                    <label for="email">
                        Correo electrónico
                    </label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        </div>
                        <input class="form-control inp perfil email" name="email" type="email" required max="100" value="<?php if (isset($email)) {echo $email;} ?>" placeholder="Correo electrónico">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
