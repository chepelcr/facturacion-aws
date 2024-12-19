<div class="modal fade modal_detalle" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <!-- Contenido del modal -->
        <div class="modal-content">

            <!-- Titulo del modal -->
            <div class="modal-header bg-dark">
                <!-- Detalle de linea -->
                <h5 class="modal-title titulo-form">
                    <i class="fas fa-clipboard-list"></i> Detalle de linea
                </h5>
                <button type="button" class="close text-white btn-fin-det" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Contenido del modal -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?= view('empresa/producto/elementos/hacienda', $data_hacienda) ?>
                    </div>

                    <!--Informacion general-->
                    <div class="col-md-12">
                        <?= view('facturacion/lineas/general', $data_general) ?>
                    </div>

                    <?php if ($documentType->code == '09') : ?>
                        <!-- Partida arancelaria -->
                        <div class="col-md-12">
                            <?= view('empresa/producto/elementos/partida_arancelaria', $data_valor) ?>
                        </div>
                        <!-- /.col-md-12 -->
                    <?php endif; ?>

                    <!-- Descuentos -->
                    <div class="col-md-12">
                        <?= view('facturacion/lineas/descuentos') ?>
                    </div>
                    <!-- /.col-md-12 -->

                    <!-- Impuestos -->
                    <div class="col-md-12">
                        <?= view('facturacion/lineas/impuestos', $data_impuesto) ?>
                    </div>
                    <!-- /.col-md-12 -->

                    <!-- Valores -->
                    <div class="col-md-12">
                        <?= view('empresa/producto/elementos/valor', $data_valor) ?>
                    </div>

                    <!-- Totales -->
                    <div class="col-md-12">
                        <?= view('facturacion/lineas/totales') ?>
                    </div>
                    <!-- /.col-md-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.modal-body -->

            <!-- Footer del modal -->
            <div class="modal-footer d-flex justify-content-between">
                <div class="col-md-3">
                    <!-- Eliminar -->
                    <button type="button" class="btn btn-danger w-100" data-toggle="tooltip" title="Eliminar detalle" onclick="eliminar_linea(this, true)">
                        <i class="fas fa-trash-alt"></i> Eliminar
                    </button>
                </div>

                <div class="col-md-3">
                    <!-- Cerrar -->
                    <button type="button" class="btn btn-success w-100 btn-fin-det" data-dismiss="modal">
                        <i class="fas fa-check"></i> Cerrar detalle
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>