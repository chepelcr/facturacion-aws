<input class="form-control form-control-lg inp" id="id_usuario" name="id_usuario" hidden type="text">

<div class="row">
    <!-- Informacion personal -->
    <div class="col-md-12">
        <?= view('base/persona/datos_personales', $datos_personales)?>
    </div>

    <!-- Informacion de contacto -->
    <div class="col-md-12">
        <?php
            if(isset($datos_contacto))
                echo view('base/persona/contacto', $datos_contacto);
            else
                echo view('base/persona/contacto');
            ?>
    </div>

    <!-- Informacion de usuario -->
    <div class="col-md-12">
        <?php
            if(isset($datos_usuario))
                echo view('base/persona/usuario', $datos_usuario);

            else
                echo view('base/persona/usuario');
        ?>
    </div>
</div>