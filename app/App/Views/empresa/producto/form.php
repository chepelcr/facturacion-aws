<div class="row">
    <!-- Id del producto -->
    <input type="number" class="id_producto" hidden name="id_producto">
    <!-- Datos generales -->
    <div class="col-md-12">
        <?= view('empresa/producto/elementos/datos_generales', array(
                                        'categorias'=>$categorias,
                                        'unidades'=>$unidades,
        ))?>
    </div>

    <!-- Codigos -->
    <div class="col-md-7">
        <?= view('empresa/producto/elementos/codigos')?>
    </div>

    <!-- Hacienda -->
    <div class="col-md-5">
        <?= view('empresa/producto/elementos/hacienda')?>
    </div>

    <!-- Comercial-->
    <div class="col-md-12">
        <?= view('empresa/producto/elementos/valor')?>
    </div>
</div>