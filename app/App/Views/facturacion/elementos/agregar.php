<div class="card card-opciones">
    <?php
    foreach ($documentTypes as $documentType) {
        if ($documentType->code == "04") {
            $ticket = "<button data-toggle='tooltip' title='Tiquete electrónico' class='btn btn-dark btn-block' type='button' onclick='agregar_documento($documentType->documentTypeId)'>
                    <i class='fas fa-plus'></i></button>";
        } elseif ($documentType->code == "01") {
            $invoice = "<button class='btn bg-gradient-olive btn-block' title='Factura de venta' data-toggle='tooltip' onclick='agregar_documento($documentType->documentTypeId)'>
                    <i class='fas fa-receipt'></i>
                </button>";
        } elseif ($documentType->code == "03") {
            $creditNote = "<button class='btn bg-gradient-danger btn-block' title='Nota de crédito' data-toggle='tooltip' onclick='agregar_documento($documentType->documentTypeId)'>
                    <i class='fas fa-funnel-dollar'></i>
                </button>";
        } elseif ($documentType->code == "02") {
            $debitNote = "<button class='btn bg-gradient-warning btn-block' title='Nota de débito' data-toggle='tooltip' onclick='agregar_documento($documentType->documentTypeId)'>
                    <i class='fas fa-coins'></i>
                </button>";
        } elseif ($documentType->code == "08") {
            $purchaseInvoice = "<button class='btn bg-gradient-purple btn-block' title='Factura de compra' data-toggle='tooltip' onclick='agregar_documento($documentType->documentTypeId)'>
                    <i class='fas fa-shopping-cart'></i>
                </button>";
        } elseif ($documentType->code == "09") {
            $exportInvoice = "<button class='btn bg-gradient-primary btn-block' title='Factura de exportación' data-toggle='tooltip' onclick='agregar_documento($documentType->documentTypeId)'>
                    <i class='fas fa-plane'></i>
                </button>";
        }
    }
    ?>
    <div class="card-header">
        <div class="row">
            <div class="col-md-12 col-opciones p-1">
                <!--Crear factura electronica
                <button class="btn bg-gradient-olive btn-block" title="Factura de venta" data-toggle="tooltip" onclick="agregar_documento(1")>
                    <i class="fas fa-receipt"></i>
                </button> -->
                <?= $invoice ?>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-12 col-opciones">
                <!-- Tiquete
                <button data-toggle="tooltip" title="Venta rapida" class="btn btn-dark btn-block" type="button" onclick="agregar_documento(4")>
                    <i class="fas fa-plus"></i>
                </button> -->
                <?= $ticket ?>

                <!-- Nota de credito 
                <button class="btn bg-gradient-danger btn-block" title="Nota de crédito" data-toggle="tooltip" onclick="agregar_documento(3")>
                    <i class="fas fa-funnel-dollar"></i>
                </button> -->
                <?= $creditNote ?>

                <!-- Nota de debito 
                <button class="btn bg-gradient-warning btn-block" title="Nota de débito" data-toggle="tooltip" onclick="agregar_documento(2")>
                    <i class="fas fa-coins"></i>
                </button> -->
                <?= $debitNote ?>

                <!-- Factura de compra
                <button class="btn bg-gradient-purple btn-block" title="Factura de compra" data-toggle="tooltip" onclick="agregar_documento(8")>
                    <i class="fas fa-shopping-cart"></i>
                </button> -->
                <?= $purchaseInvoice ?>

                <!-- Factura de exportacion
                <button class="btn bg-gradient-primary btn-block" title="Factura de exportación" data-toggle="tooltip" onclick="agregar_documento(9")>
                    <i class="fas fa-plane"></i>
                </button> -->
                <?= $exportInvoice ?>
            </div>
        </div>
    </div>
</div>