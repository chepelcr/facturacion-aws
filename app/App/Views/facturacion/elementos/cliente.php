<div class="row">
    <div class="col-md-12">
        <div class="card card-body card-busqueda-clientes">
            <form id="frmBusquedaCliente">
                <div class="input-group">
                    <!-- Ingresar nombre del producto -->
                    <input type="search" class="form-control form-control-sm" placeholder="Cedula  o nombre del cliente"
                        id="q_clientes" onchange="filtrar_tabla('clientes', this.val())" onkeyup="filtrar_tabla('clientes', this.value)">
                    <div class="input-group-append">
                        <!-- Boton para buscar el producto -->
                        <button type="submit" class="btn btn-sm btn-default" disabled>
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card card-clientes card-body scroll_vertical" style="max-height: 200px;">
        </div>
    </div>

    <div class="col-md-12">
        <form id="frm_cliente">
            <?= view('empresa/cliente/form', $dataForm)?>
        </form>
    </div>
</div>