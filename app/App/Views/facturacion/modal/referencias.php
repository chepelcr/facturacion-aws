<div class="modal fade modal-referencias" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">

        <!-- Contenido del modal -->
        <div class="modal-content">
            <!-- Titulo del modal -->
            <div class="modal-header bg-dark">
                <h5 class="modal-title">
                    <i class="fas fa-clipboard-list"></i>
                    Referencias
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Contenido del modal -->
            <div class="modal-body">
                <div class="container">
                    <div class="container-fluid">
                        <table class="table table-hover table-bordered text-center">
                            <thead>
                                <tr>
                                    <th class="col-2">Tipo de documento</th>
                                    <th class="col-4">Clave</th>
                                    <th class="col-1">Fecha emisión</th>
                                    <th class="col-2">Tipo</th>
                                    <th class="col-2">Razón</th>
                                    <th class="col-1">Acciones</th>
                                </tr>
                            </thead>

                            <tbody class="tblDetalleReferencias">
                                <tr class="linea_referencia">
                                    <td class="col-2">
                                        <select class="form-control form-control-sm inp-fct tipo_documento"
                                            name="referencia_tipo_documento[]">
                                            <?php
                                                    foreach ($tipos_documentos as $tipo_documento) {
                                                        echo "<option value='{$tipo_documento->id_tipo_documento}'>{$tipo_documento->descripcion}</option>";
                                                    }
                                                ?>
                                        </select>
                                    </td>

                                    <td class="col-3">
                                        <input type="text" class="form-control form-control-sm clave inp-fct" placeholder="Numero de documento"
                                            name="referencia_clave[]">
                                    </td>

                                    <td class="col-1">
                                        <input type="date" class="form-control form-control-sm fecha inp-fct"
                                            name="referencia_fecha[]" value="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d'); ?>">
                                    </td>

                                    <td class="col-1">
                                        <select class="form-control form-control-sm codigo inp-fct" name="referencia_codigo[]">
                                            <?php
                                                    foreach ($codigos_referencia as $codigo_referencia) {
                                                        echo "<option value='{$codigo_referencia->id_codigo}'>{$codigo_referencia->tipo_referencia}</option>";
                                                    }
                                                ?>
                                        </select>
                                    </td>

                                    <td class="col-2">
                                        <input type="text" class="form-control razon form-control-sm inp-fct" placeholder="Motivo"
                                            name="referencia_razon[]">
                                    </td>

                                    <td class="col-1">
                                    <button type="button" value="0" class="btn btn-danger eliminarLineaReferencia" onclick="eliminar_referencia(this)" disabled>
                                    <i class="fas fa-times-circle"></i>
                                </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Footer del modal -->
            <div class="modal-footer">
                <div class="container">
                    <div class="container-fluid">
                        <div class=" row d-flex justify-content-between">
                            <div class="col-md-1">
                                <!-- Agregar referencia -->
                                <button type="button" onclick="agregar_referencia()"
                                    class="btn btn-warning btt-add-ref btn-block" data-toggle='tooltip'
                                    title="Agregar referencia">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>

                            <div class="col-md-2">
                                <!-- Aceptar -->
                                <button type="button" class="btn btn-success btt-aceptar-ref btn-block"
                                    data-dismiss="modal">
                                    <i class="fas fa-check"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>