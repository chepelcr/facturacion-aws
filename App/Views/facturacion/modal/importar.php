<div class="modal fade" id="modal-importar" tabindex="-1" aria-hidden="true"  data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Encabezado -->
            <div class="modal-header">
                <h5 class="modal-title display-5" id="titulo">
                    Importar documentos
                </h5>

                <!-- Icono de nube a la derecha -->
                <div class="float-right">
                    <i class="fa-solid fa-cloud-upload"></i>
                </div>
            </div>

            <!-- Cuerpo -->
            <div class="modal-body">
                <form class="box" method="post" action="" enctype="multipart/form-data">
                    <div class="box__input">
                        <input class="box__file" type="file" name="archivos_xml[]" id="archivo_xml"
                            data-multiple-caption="{count} files selected" multiple />
                        <label for="archivo_xml"><strong>Elegir un archivo</strong><span class="box__dragndrop"> o
                                arrastrelo aquí</span>.</label>
                        <button class="box__button" type="submit">Subir</button>
                    </div>
                    <div class="box__uploading">Cargando...</div>
                    <div class="box__success">Listo!</div>
                    <div class="box__error">Error! <span></span>.</div>
                </form>
            </div>

            <!-- Pie -->
            <div class="modal-footer">
                <div class="row w-100">
                    <!-- Cerrar -->
                    <div class="col-md-4">
                        <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal"
                            data-toggle="tooltip" title="Cerrar" onclick="cargar_inicio_modulo('documentos')">
                            <!-- Icono de cerrar -->
                            <i class="fa fa-times"></i>
                        </button>
                    </div>

                    <!-- Ver historial -->
                    <div class="col-md-8">
                        <button type="button" class="btn btn-warning btn-block" data-toggle="tooltip"
                            title="Ver historial">
                            <!-- Icono de historial -->
                            <i class="fa fa-history"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>