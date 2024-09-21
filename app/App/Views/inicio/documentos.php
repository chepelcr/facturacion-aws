<div class="row">
    <div class="col-md-11">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <?= view('facturacion/elementos/nav') ?>
                    </div>
                </div>
            </div>
            
            <div class="col-md-12" id="listado_documentos">
            </div>

            <div class="col-md-12 contenedor_facturas" id="contenedor_facturas">
            </div>
        </div>

    </div>

    <div class="col-md-1">
        <div class="d-flex align-items-start flex-column bd-highlight mb-3 h-100">
            <div class="mb-auto pl-2 pr-2 bd-highlight w-100">
                <?php
                echo view('facturacion/elementos/agregar', $infoAgregar);

                echo view('facturacion/elementos/opciones');
                ?>
            </div>
            <div class="pl-2 pr-2 bd-highlight w-100">
                <?= view('facturacion/elementos/finalizar') ?>
            </div>

            <div class="pl-2 pr-2 bd-highlight cont-reporte w-100">
                <?= view('facturacion/elementos/reporte') ?>
            </div>
        </div>
    </div>
</div>

<div id="contenedor_pdf">
</div>

<?php
echo view('facturacion/modal/productos');

echo view('facturacion/receptores/modal/busqueda');

echo view('facturacion/modal/notificar');
?>