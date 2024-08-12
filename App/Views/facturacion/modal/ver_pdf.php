<div class="modal fade" id="modalVerPdf" tabindex="-1" aria-labelledby="titulo" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <!-- Encabezado -->
            <div class="modal-header">
                <h5 class="modal-title display-5" id="titulo">
                    Documento PDF
                </h5>
                
                <!-- Icono de pdf a la derecha -->
                <div class="float-right">
                    <i class="fa fa-file-pdf"></i>
                </div>
            </div>

            <!-- Cuerpo -->
            <div class="modal-body">
                <object width="100%" height="400px" data="<?=baseUrl('documentos/pdf_ticket/'.$clave) ?>"
                    type="text/html"></object>
            </div>

            <!-- Pie -->
            <div class="modal-footer">
                <!-- Cerrar -->
                <button type="button" class="btn btn-secondary w-100" data-dismiss="modal">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>