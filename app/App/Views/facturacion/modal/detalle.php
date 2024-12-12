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
            <div class="modal-footer">
                <div class="col-md-12">
                    <div class="fc-button-group">
                        <div class="d-flex justify-content-end">
                            <!-- Cerrar -->
                            <button type="button" class="btn btn-success col-3 btn-block btn-fin-det" data-dismiss="modal">
                                Aceptar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>