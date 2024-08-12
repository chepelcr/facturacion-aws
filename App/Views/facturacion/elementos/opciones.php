<div class="card card-opciones-documentos">
    <div class="card-body">
        <div class="row">
            <!-- Cliente -->
            <div class="col-md-12 col-opciones">
                <button class="btn btn-dark btn-block col-cliente btn-cliente" title="Agregar Cliente" data-toggle="tooltip"
                    onclick="ver_modal_cliente()">
                    <i class="fas fa-user"></i>
                </button>

                <button class="btn btn-dark btn-block col-referencia btn-referencia" title="Agregar Referencia" data-toggle="tooltip"
                    onclick="agregar_referencias()">
                    <i class="fas fa-clipboard-list"></i>
                </button>

                <button class="btn btn-dark btn-block col-walmart btn-walmart" title="Datos Walmart" data-toggle="tooltip"
                    onclick="ver_walmart()">
                    <?=icono('walmart.png', 'Walmart')?>
                </button>
            </div>
        </div>
    </div>
</div>