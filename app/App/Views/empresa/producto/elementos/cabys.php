<div class="card card-cabys">
    <div class="card-header">
        <div class="card-title">
            <div class="row">
                <div class="col-md-12">
                    <form id="frmCabys">
                        <div class="input-group">
                            <!-- Ingresar nombre del producto -->
                            <input type="search" class="form-control form-control-sm q_cabys" placeholder="Nombre del producto">
                            <div class="input-group-append">
                                <!-- Boton para buscar el producto -->
                                <button type="submit" class="btn btn-sm btn-default" onclick="obtener_cabys()">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Boton para volver a la vista anterior -->
        <div class="card-tools">
            <button type="button" class="btn btn-tool" onclick="cerrar_cabys()" data-toggle="tooltip" title="Volver">
                <i class="fas fa-arrow-left"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-hover text-center">
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