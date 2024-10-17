<div class="row">
    <!-- Datos generales -->
    <div class="col-md-12">
        <?= view('empresa/producto/elementos/datos_generales', $datos_generales) ?>
    </div>

    <!-- Datos del empaque -->
    <div class="col-md-12">
        <?= view('empresa/producto/elementos/empaque') ?>
    </div>

    <!-- Codigos -->
    <div class="col-md-12">
        <?= view('empresa/producto/elementos/codigos', $data_codigos) ?>
    </div>

    <!-- Hacienda -->
    <div class="col-md-12">
        <?= view('empresa/producto/elementos/hacienda', $data_hacienda) ?>
    </div>

    <!-- Descuentos -->
    <div class="col-md-12">
        <?= view('empresa/producto/elementos/descuentos') ?>
    </div>

    <!-- Impuestos -->
    <div class="col-md-12">
        <?= view('empresa/producto/elementos/impuestos', $data_impuestos) ?>
    </div>

    <!-- Comercial-->
    <div class="col-md-12">
        <?= view('empresa/producto/elementos/valor') ?>
    </div>
</div>