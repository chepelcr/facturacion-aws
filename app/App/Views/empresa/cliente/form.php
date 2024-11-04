<div class="row">
    <div class="col-md-12">
        <?= view('empresa/cliente/elementos/datos_personales', $datos_personales) ?>
    </div>

    <div class="col-md-12">
        <?= view('base/persona/ubicacion', $dataProvincias) ?>
    </div>

    <!-- Informacion de contacto-->
    <div class="col-md-12">
        <?= view('base/persona/contacto', $datos_contacto) ?>
    </div>
</div>