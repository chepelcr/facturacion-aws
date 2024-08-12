<div class="modal fade modal-walmart" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">

        <!-- Contenido del modal -->
        <div class="modal-content">

            <!-- Titulo del modal -->
            <div class="modal-header bg-dark">
                <h5 class="modal-title titulo-form">
                    <?= icono('walmart.png', 'Walmart') ?>
                    Informacion de entrega
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Contenido del modal -->
            <div class="modal-body">
                <div class="row contenedor-datos">
                    <!-- Select con departamento -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="numero_proveedor">Departamento</label>
                            <div class="input-group">
                                <!-- Recorrer los numeros de proveedor -->
                                <select class="form-control inp-fct form-control-sm numero_vendor" name="numero_vendor">
                                    <option value="">Seleccione un departamento</option>
                                    <?php foreach ($numerosProveedor as $numero_proveedor): ?>
                                    <option value="<?=$numero_proveedor->numero_proveedor ?>">
                                        <?=$numero_proveedor->numero_proveedor . ' | ' . $numero_proveedor->nombre ?>
                                    </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Punto de entrega -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="enviar_gnl">Tienda</label>
                            <div class="input-group">
                                <input type="text" class="form-control nombre_gln" placeholder="Buscar tienda" readonly disabled>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary" onclick="buscar_tiendas()" data-toggle="tooltip" title="Buscar">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- enviar_gnl -->
                    <div class="col-md-12" hidden>
                        <input type="text" class="form-control inp-fct enviar_gln" name="enviar_gln">
                    </div>

                    <!-- Numero de orden -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="numero_orden_compra">Orden de compra</label>
                            <div class="input-group">
                                <input type="text" class="form-control inp-fct numero_orden" max="8" min="8"
                                    placeholder="Ingrese el numero de orden" name="numero_orden">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container contenedor-tiendas">
                    <div class="card card-body">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="form-group">
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                            <button type="button" class="btn btn-outline-secondary" disabled>
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>

                                        <input type="text" onkeyup="filtrar_tabla('tiendas', this.value)"
                                            onchange="filtrar_tabla('tiendas', this.value)" class="form-control inp-fct"
                                            id="q_tienda" placeholder="Buscar tienda">
                                    </div>
                                </div>
                            </div>

                            <!-- Boton para volver a la pantalla anterior -->
                            <div class="col-md-2">
                                <button type="button" class="btn btn-outline-secondary btn-block" onclick="ver_walmart()" data-toggle="tooltip" title="Volver">
                                    <i class="fa fa-arrow-left"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card card-body">
                        <?= view('facturacion/table/tiendas', $dataTiendas)?>
                    </div>
                </div>
            </div>

            <!-- Footer del modal -->
            <div class="modal-footer contenedor-datos">
                <div class="col-md-12">
                    <div class="fc-button-group">
                        <div class="d-flex justify-content-around">
                            <!-- Aceptar -->
                            <button type="button" class="btn btn-success col-8 btn-aceptar" data-dismiss="modal">
                                Aceptar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>