<table class="table table-bordered table-hover text-center" id="listado">
    <thead>
        <tr>
            <th class="col-2">ID</th>
            <th class="col-6">Nombre</th>
            <th class="col-1">Opciones</th>
        </tr>
    </thead>
    <tbody id="tiendas">
        <?php foreach ($tiendas as $key => $tienda):?>
        <tr>
            <td><?=$tienda->id_tienda?></td>
            <td><?=$tienda->nombre?></td>
            <td>
                <div class="btn-group">
                    <!-- Seleccionar -->
                    <button data-toggle="tooltip" title="Seleccionar tienda"
                        onclick="seleccionar_tienda('<?=$tienda->gln?>', '<?=$tienda->nombre?>')" class="btn btn-secondary"
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