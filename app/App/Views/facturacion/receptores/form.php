<div class="row">
    <div class="col-md-12">
        <?= view('facturacion/receptores/elementos/datos_personales', $datos_personales) ?>
    </div>

    <!-- Informacion de contacto-->
    <div class="col-md-12">
        <?= view('facturacion/receptores/elementos/contacto', $datos_contacto) ?>
    </div>

    <div class="col-md-12">
        <?= view('facturacion/receptores/elementos/ubicacion', $dataProvincias) ?>
    </div>
</div>