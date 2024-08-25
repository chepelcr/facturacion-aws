<div class="card card-cabys">
    <div class="card-header">
        <div class="col-md-8 offset-md-2">
            <form id="frmCabys">
                <div class="input-group">
                    <!-- Ingresar nombre del producto -->
                    <input type="search" class="form-control form-control-sm" placeholder="Nombre del producto"
                        name="q_cabys" id="q_cabys">
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
    <div class="card-body scroll_vertical" style="max-height: 350px;">
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