<div class="row">
    <!-- Contraseña actual -->
    <div class="col-md-12">
        <div class="form-group">
            <label class="text-left">Contraseña actual</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-unlock"></i></span>
                </div>
                <input class="form-control pass" id="old_pass" placeholder="Contraseña actual"
                    name="contra_actual" type="password" max="100">
            </div>
        </div>
    </div>

    <!-- Contraseña nueva -->
    <div class="col-md-12">
        <div class="form-group">
            <label class="text-left">Contraseña nueva</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-unlock"></i></span>
                </div>
                <input class="form-control pass" id="new_pass" name="nueva_contraseña" type="password" 
                    max="100" placeholder="Contraseña nueva">
            </div>
        </div>
    </div>

    <!-- Confirmar contraseña nueva -->
    <div class="col-md-12">
        <div class="form-group">
            <label class="text-left">Confirmar contraseña</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-unlock"></i></span>
                </div>
                <input class="form-control pass" onblur="verificar_contrasenia()" id="new_pass_conf" name="contra_nueva_conf" 
                    type="password" max="100" placeholder="Confirmar contraseña">
            </div>
        </div>
    </div>
</div>