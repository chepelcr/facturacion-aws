<div class="card card-form">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-text-width"></i> Datos generales
        </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fas fa-minus"></i></button>
        </div>
    </div>

    <div class="card-body">
        <input disabled class="form-control inp productId" type="hidden" name="productId">

        <div class="row">
            <div class="col-md-7">
                <?= view('empresa/producto/elementos/info_general') ?>
            </div>
            
            <!-- Imagen -->
            <div class="col-md-5">
                <div class="card ivois-image-card mb-2">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <img class="ivois-img-thumbnail" alt="" src="<?= getFile('dist/img/icons/image.png') ?>">
                            </div>
                            <div class="col-md-12 text-center">
                                <input hidden type="file" class="inp image" name="productImage" accept="image/*">
                                <button class="btn-cargar-imagen inp inter-bold underline" type="button">Cargar imagen</button>
                                <p class="ivois-image-text inter-regular">
                                    Formato JPG o PNG.
                                    Dimensiones preferidas: 400x400 pixeles a 72ppp. Tamaño máximo del archivo: 1MB.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>