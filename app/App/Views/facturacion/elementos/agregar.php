<div class="card card-opciones">
    <div class="card-header">
        <div class="row">
            <div class="col-md-12 col-opciones">
                <!-- Factura -->
                <button class="btn bg-gradient-olive btn-block" title="Factura de venta" data-toggle="tooltip"
                    onclick="agregar_documento('factura')">
                    <i class="fas fa-receipt"></i>
                </button>
                
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-12 col-opciones">
                <!--Crear venta -->
                <button data-toggle="tooltip" title="Venta rapida" class="btn btn-dark btn-block" type="button"
                    onclick="agregar_documento('tiquete')">
                    <i class="fas fa-plus"></i>
                </button>

                <!-- Nota de credito -->
                <button class="btn bg-gradient-danger btn-block" title="Nota de crédito" data-toggle="tooltip"
                    onclick="agregar_documento('nota_credito')">
                    <i class="fas fa-funnel-dollar"></i>
                </button>

                <!-- Nota de debito -->
                <button class="btn bg-gradient-warning btn-block" title="Nota de débito" data-toggle="tooltip"
                    onclick="agregar_documento('nota_debito')">
                    <i class="fas fa-coins"></i>
                </button>

                <!-- Factura de compra -->
                <button class="btn bg-gradient-purple btn-block" title="Factura de compra" data-toggle="tooltip"
                    onclick="agregar_documento('factura_compra')">
                    <i class="fas fa-shopping-cart"></i>
                </button>

                <!-- Factura de exportacion -->
                <button class="btn bg-gradient-primary btn-block" title="Factura de exportación"
                    data-toggle="tooltip" onclick="agregar_documento('factura_exportacion')">
                    <i class="fas fa-plane"></i>
                </button>
            </div>
        </div>
    </div>
</div>