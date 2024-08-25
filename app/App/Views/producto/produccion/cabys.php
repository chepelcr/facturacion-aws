<div class="modal fade" style="padding-top: 20%; background-color: darkslategrey;" id="modalCABYS" tabindex="-1" aria-labelledby="titulo" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Encabezado -->
            <div class="modal-header">
                <h5 class="modal-title display-5" id="titulo">Codigo CABYS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Cuerpo -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <form id="frmCabys">
                            <div class="input-group">
                            <!-- Ingresar nombre del producto -->
                                <input type="search" class="form-control form-control-sm" placeholder="Producto"
                                    name="q" id="q">
                                <div class="input-group-append">
                                    <!-- Boton para buscar el producto -->
                                    <button type="submit" class="btn btn-sm btn-default">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="row" style="padding-top: 4%;">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Descripcion</th>
                                <th>Impuesto</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="cabys"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>