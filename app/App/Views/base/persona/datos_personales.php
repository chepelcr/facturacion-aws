<div class="card card-form">
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
                                <input class="form-control inp identificacion" onblur="validar_identificacion(this.value)" name="identificacion" type="text" placeholder="Ingrese el número de cédula" value="<?php if (isset($identificacion)) echo formatear_cedula($identificacion, $id_tipo_identificacion) ?>" required max="100">

                                <div class="input-group-append">
                                    <!-- Boton para eliminar el contenido del campo -->
                                    <button class="btn btn-danger inp identificacion btn-eliminar" disabled type="button" onclick="vaciar_cedula()" data-toggle="tooltip" data-placement="top" title="Eliminar">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tipo de cedula-->
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="text-left">Tipo de identificación</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                </div>
                                <select name="id_tipo_identificacion" class="form-control inp id_tipo_identificacion">
                                    <option value="">Seleccionar</option>
                                    <?php foreach ($identificaciones as $key => $identificacion) : ?>
                                        <option value="<?= $identificacion->id_tipo_identificacion ?>" <?php if (isset($id_tipo_identificacion) && $id_tipo_identificacion == $identificacion->id_tipo_identificacion) echo "selected" ?>>
                                            <?= $identificacion->tipo_identificacion ?></option>
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
                        <input class="form-control inp nombre" placeholder="Nombre del contribuyente" name="nombre" required value="<?php if (isset($nombre)) echo $nombre ?>" type="text" max="100">
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label class="text-left">Pais</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        </div>
                        <select name="cod_pais" class="form-control inp cod_pais">
                            <option value="">Seleccionar</option>
                            <?php foreach ($codigos as $key => $codigo) : ?>
                                <option value="<?= $codigo->cod_pais ?>" <?php if (isset($cod_pais) && $cod_pais == $codigo->cod_pais) echo "selected" ?>>
                                    <?= $codigo->nombre ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>