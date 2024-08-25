<div class="modal fade" id="modalImprimir" tabindex="-1" aria-labelledby="titulo" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <!-- Encabezado -->
            <div class="modal-header">
                <h5 class="modal-title display-5" id="titulo">
                    Imprimir tiquete
                </h5>

                <!-- Icono de pdf a la derecha -->
                <div class="float-right">
                    <i class="fa fa-file-pdf"></i>
                </div>
            </div>

            <!-- Cuerpo -->
            <div class="modal-body">
                <!--<object width="100%" height="400px" data="<?php //baseUrl('documentos/pdf_ticket/' . $clave) ?>" id="pdfObject" type="text/html"></object>-->
                <iframe id="ticketIframe" name="ticketIframe" src="<?= baseUrl('documentos/pdf_ticket/' . $clave) ?>" style="border:none; width:100%; height:65vh;" title="PDF Document" referrerpolicy="origin-when-cross-origin"></iframe>
            </div>

            <!-- Pie -->
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-6">
                        <button type="button" class="btn btn-primary w-100" onclick="imprimirTiquete()">
                            Imprimir
                        </button>
                    </div>
                    <div class="col-md-6">
                        <button type="button" class="btn btn-secondary w-100" data-dismiss="modal">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>