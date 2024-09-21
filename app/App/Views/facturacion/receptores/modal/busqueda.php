<div class="modal fade modal-clientes" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">

        <!-- Contenido del modal -->
        <div class="modal-content">
            <!-- Titulo del modal -->
            <div class="modal-header bg-dark">
                <h5 class="modal-title">
                    <i class="fas fa-user"></i>
                    Clientes
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Contenido del modal -->
            <div class="modal-body">
                <div class="container">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-body card-busqueda-clientes scroll_vertical">
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
                                <div class="card card-clientes card-body">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer del modal -->
            <div class="modal-footer">
                <div class="container">
                    <div class="container-fluid">
                        <div class="row d-flex justify-content-between">
                            <div class="col-md-3 btt-add-clt">
                                <!-- Agregar -->
                                <button type="button" onclick="agregar_cliente()" class="btn btn-warning btn-block">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>