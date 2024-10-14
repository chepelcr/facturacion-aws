<div class="modal fade modal-referencias" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
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
                        <table class="table table-hover table-bordered text-center referencesTable">
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

                            <tbody class="documentReferences">
                                <tr class="referenceLine">
                                    <td class="col-2">
                                        <select class="form-control form-control-sm inp-fct inp-fct-ref referenceType" name="references[0][referenceType]">
                                            <option value="">Seleccione un tipo de documento</option>
                                            <?php
                                            foreach ($referenceTypes as $referenceType) {
                                                echo "<option value='{$referenceType->referenceTypeId}'>{$referenceType->description}</option>";
                                            }
                                            ?>
                                        </select>
                                    </td>

                                    <td class="col-3">
                                        <input type="text" class="form-control form-control-sm key inp-fct inp-fct-ref" placeholder="Numero de documento" name="references[0][referenceNumber]">
                                    </td>

                                    <td class="col-1">
                                        <input type="date" class="form-control form-control-sm date inp-fct inp-fct-ref" name="references[0][referenceDate]" max="<?php echo date('Y-m-d'); ?>">
                                    </td>

                                    <td class="col-1">
                                        <select class="form-control form-control-sm code inp-fct inp-fct-ref" name="references[0][referenceCode]">
                                            <option value="">Seleccione un código de referencia</option>
                                            <?php
                                            foreach ($referenceCodes as $referenceCode) {
                                                echo "<option value='{$referenceCode->referenceCodeId}'>{$referenceCode->description}</option>";
                                            }
                                            ?>
                                        </select>
                                    </td>

                                    <td class="col-2">
                                        <input type="text" class="form-control reason form-control-sm inp-fct inp-fct-ref" placeholder="Motivo de la referencia" name="references[0][referenceReason]">
                                    </td>

                                    <td class="col-1">
                                        <button type="button" value="0" class="btn btn-danger btn-dlt" onclick="eliminar_referencia(this)" disabled>
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
                                <button type="button" onclick="agregar_referencia()" class="btn btn-warning btt-add-ref btn-block" data-toggle='tooltip' title="Agregar referencia">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>

                            <div class="col-md-2">
                                <!-- Aceptar -->
                                <button type="button" class="btn btn-success btt-aceptar-ref btn-block" data-dismiss="modal">
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