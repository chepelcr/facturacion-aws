<div class="card card-form">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-user-circle"></i> Datos personales
        </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                title="Cerrar">
                <i class="fas fa-minus"></i></button>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <!-- Cédula del cliente -->
                    <div class="col-md-7">
                        <div class="form-group">
                            <label class="text-left">Número de cédula</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                </div>
                                <input class="form-control inp identification_number" onblur="obtener_contribuyente(this.value)"
                                    name="identification[number]" type="text" placeholder="Ingrese el número de cédula" value="<?php if (isset($identification)) {
                                                                                                                                    echo formatear_cedula($identification->number, $identification->code);
                                                                                                                                } ?>" required max="100">

                                <div class="input-group-append">
                                    <!-- Boton para eliminar el contenido del campo -->
                                    <button class="btn btn-danger inp btn-eliminar" disabled type="button" onclick="vaciar_cedula()" data-toggle="tooltip" data-placement="top" title="Eliminar">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tipo de cedula-->
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="text-left" for="identification[typeId]">Tipo de identificación</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                </div>
                                <select name="identification[typeId]"
                                    class="form-control inp identification_typeId">
                                    <option value="">Seleccionar</option>
                                    <?php foreach ($identificaciones as $identificationType): ?>
                                        <option value="<?= $identificationType->typeId ?>" data-code="<?= $identificationType->code ?>"
                                            <?php if (isset($identification) && $identificationType->typeId == $identification->typeId) {
                                                echo "selected";
                                            } ?>>
                                            <?= $identificationType->description ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="form-group">
                    <!-- Nombre del cliente -->
                    <label class="text-left razon">Nombre completo</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input class="form-control inp businessName" placeholder="Nombre del contribuyente" name="businessName" required
                            value="<?php if (isset($businessName)) {
                                        echo $businessName;
                                    } ?>" type="text" max="100">
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label class="text-left">Nacionalidad</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        </div>
                        <select name="nationality" class="form-control inp nationality">
                            <option value="">Seleccionar</option>
                            <?php foreach ($countries as $country): ?>
                                <option value="<?= $country->isoCode ?>"
                                    <?php if (isset($nationality) && $nationality->isoCode == $country->isoCode) {
                                        echo "selected";
                                    } ?>>
                                    <?= $country->name ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>