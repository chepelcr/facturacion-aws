<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-tipo-cambio">
    <div class="modal-dialog modal-dialog-centered" role="document">

        <!-- Contenido del modal -->
        <div class="modal-content">

            <!-- Titulo del modal -->
            <div class="modal-header bg-dark">
                <h5 class="modal-title titulo-form">
                    <!--Icono de dolar-->
                    <i class="fas fa-dollar-sign"></i>
                    Tipo de cambio
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Contenido del modal -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <!-- Compra -->
                        <label for="tipo_compra" class="text-left">Compra</label>
                        <div class="input-group"  data-toggle="tooltip" title="Compra">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                            </div>
                            <input class="form-control form-control-sm" value="0" disabled readonly id="tipo_compra">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <!-- Venta -->
                         <label for="tipo_venta" class="text-left">Venta</label>
                        <div class="input-group" data-toggle="tooltip" title="Venta">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                            </div>
                            <input class="form-control form-control-sm" value="0" disabled readonly id="tipo_venta">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer del modal -->
            <div class="modal-footer">
                <div class="col-md-12">
                    <div class="fc-button-group">
                        <div class="d-flex justify-content-around">
                            <!-- Aceptar -->
                            <button type="button" class="btn btn-success col-8 btn-aceptar" data-dismiss="modal">
                                Aceptar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>