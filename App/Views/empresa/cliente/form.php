<input type="hidden" class="form-control inp id_cliente" name="id_cliente" value="<?= $id_cliente ?? '' ?>">

<div class="row">
    <div class="col-md-12">
        <?= view('base/persona/datos_personales', $datos_personales)?>
    </div>

    <!-- Informacion de contacto-->
    <div class="col-md-8">
        <?php
            if(isset($datos_contacto))
                echo view('base/persona/contacto', $datos_contacto);

            else
                echo view('base/persona/contacto');
        ?>
    </div>

    <!-- Informacion de empresa-->
    <div class="col-md-4">
        <?php
            if(isset($datos_empresa))
                echo view('base/persona/nombre_empresa', $datos_empresa);

            else
                echo view('base/persona/nombre_empresa');
        ?>
    </div>

    <div class="col-md-12">
        <?= view('base/persona/ubicacion', $dataProvincias) ?>
    </div>

</div>