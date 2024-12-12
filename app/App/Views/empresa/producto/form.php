<div class="row">
    <!-- Hacienda -->
    <div class="col-md-12">
        <?= view('empresa/producto/elementos/hacienda', $productTypeData) ?>
    </div>

    <!-- Datos generales -->
    <div class="col-md-12">
        <?= view('empresa/producto/elementos/datos_generales', $datos_generales) ?>
    </div>

    <!-- Partida arancelaria -->
    <div class="col-md-12">
        <?= view('empresa/producto/elementos/partida_arancelaria') ?>
    </div>

    <!-- Datos del empaque -->
    <div class="col-md-12">
        <?= view('empresa/producto/elementos/empaque') ?>
    </div>

    <!-- Codigos -->
    <div class="col-md-12">
        <?= view('empresa/producto/elementos/codigos', $data_codigos) ?>
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