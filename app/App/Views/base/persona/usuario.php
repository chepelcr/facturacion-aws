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
                    <input type="text" class="form-control inp perfil nombre_usuario" name="nombre_usuario"
                        value="<?php if(isset($nombre_usuario)) echo $nombre_usuario?>" placeholder="Nombre de usuario">
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

                        <select required class="form-control inp id_rol" name="id_rol">
                            <option value="">Seleccione</option>
                            <?php foreach($roles as $rol): ?>
                            <option value="<?php echo $rol->id_rol; ?>"
                                <?php if(isset($id_rol) && $id_rol == $rol->id_rol) echo 'selected'; ?>>
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

                        <select required class="form-control inp id_empresa" name="id_empresa">
                            <option value="">Seleccione</option>
                            <?php foreach($empresas as $empresa): ?>
                            <option value="<?php echo $empresa->id_empresa; ?>"
                                <?php if(isset($id_empresa) && $id_empresa == $empresa->id_empresa) echo 'selected'; ?>>
                                <?php echo $empresa->nombre; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>