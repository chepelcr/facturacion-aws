<div class="row">
    <div class="col-md-12">
        <?= view('empresa/cliente/elementos/datos_personales', $datos_personales)?>
    </div>

    <!-- Informacion de contacto-->
    <div class="col-md-12">
        <?php
            if(isset($datos_contacto)) {
                echo view('base/persona/contacto', $datos_contacto);
            } else {
                echo view('base/persona/contacto');
            }
        ?>
    </div>

    <div class="col-md-12">
        <?= view('base/persona/ubicacion', $dataProvincias) ?>
    </div>
</div>