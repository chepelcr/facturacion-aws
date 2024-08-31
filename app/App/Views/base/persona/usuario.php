<div class="card card-form">
    <div class="card-header">
        <h4 class="card-title">
            <i class="fas fa-user-tie"></i> Informacion de Usuario
        </h4>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <!--Nombre de usuario -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nombre_usuario">Nombre de usuario</label>
                    <input type="text" class="form-control inp perfil userName" name="userName"
                        value="<?php if (isset($nombre_usuario)) echo $nombre_usuario ?>" placeholder="Nombre de usuario">
                </div>
            </div>

            <!-- Rol -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="rol">Rol</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-user-tag"></i>
                            </span>
                        </div>

                        <select required class="form-control inp rolId" name="rolId">
                            <option value="">Seleccione</option>
                            <?php foreach ($roles as $rol): ?>
                                <option value="<?php echo $rol->id_rol; ?>"
                                    <?php if (isset($id_rol) && $id_rol == $rol->id_rol) echo 'selected'; ?>>
                                    <?php echo $rol->nombre_rol; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Empresa -->
            <div class="col-md-12">
                <div class="form-group">
                    <label for="empresa">Empresa</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-building"></i>
                            </span>
                        </div>

                        <select required class="form-control inp taxpayerId" name="taxpayerId">
                            <option value="">Seleccione</option>
                            <?php foreach ($empresas as $empresa): ?>
                                <option value="<?php echo $empresa->taxpayerId; ?>"
                                    <?php if (isset($id_empresa) && $id_empresa == $empresa->taxpayerId) echo 'selected'; ?>>
                                    <?php echo $empresa->businessName; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>