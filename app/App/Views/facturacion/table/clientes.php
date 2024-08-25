<table class="table table-bordered table-hover text-center" id="listado">
    <thead>
        <tr>
            <th class="col-2">Identificación</th>
            <th class="col-6">Nombre completo</th>
            <th class="col-1">Opciones</th>
        </tr>
    </thead>
    <tbody id="clientes">
        <?php foreach ($clientes as $key => $cliente):?>
        <tr>
            <td><?=formatear_cedula($cliente->identificacion, $cliente->id_tipo_identificacion)?></td>
            <td><?=$cliente->razon?></td>
            <td>
                <div class="btn-group">
                    <!-- Seleccionar -->
                    <button data-toggle="tooltip" title="Seleccionar cliente"
                        onclick="obtener_cliente('<?=$cliente->identificacion?>')" class="btn btn-secondary"
                        type="button">
                        <i class="fas fa-check"></i>
                    </button>
                </div>
            </td>
            <!--Fin de las opciones-->
        </tr>
        <!--Fin de la fila-->
        <?php endforeach;?>
        <!--Fin del ciclo-->
    </tbody>
    <!--/Cuerpo de la tabla-->
</table>
<!--/Table-->