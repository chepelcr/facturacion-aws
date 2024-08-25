<div class="modal fade" id="modalProductos" tabindex="-1" aria-labelledby="titulo" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <!-- Encabezado -->
            <div class="modal-header">
                <h5 class="modal-title display-5" id="titulo">Buscar productos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Cuerpo -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-8 offset-md-2">
                                        <form id="frmBusquedaProductos">
                                            <div class="input-group">
                                                <!-- Ingresar nombre del producto -->
                                                <input type="search" class="form-control form-control-sm"
                                                    placeholder="Nombre o codigo del producto" id="q_productos" onchange="filtrar_tabla('productos', this.value)" onkeyup="filtrar_tabla('productos', this.value)">
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
                            </div>

                            <div class="card-body scroll_vertical" style="max-height: 225px;" id="contenedor_busqueda_productos">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pie -->
            <div class="modal-footer">
                <!-- Buscar producto comun -->
                <button type="button" class="btn btn-primary w-100" onclick="agregar_producto()">
                    Agregar producto
                </button>
            </div>
        </div>
    </div>
</div>