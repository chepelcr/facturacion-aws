<!--Card-->
<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-hover" id="listado">
            <thead>
                <tr>
                    <th>Codigo</th>
                    <th>Descripcion</th>
                    <th>Precio de venta</th>
                    <th>Cantidad disponible</th>
                    <th>Opciones</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($inventario_detalle as $key => $inventario):?>
                <tr>
                    <td><?=$inventario->codigo?></td>
                    <td><?=$inventario->descripcion?></td>
                    <td>₡<?=$inventario->precio_venta?></td>
                    <td><?=$inventario->cantidad_restante?></td>

                    <td>
                        <div class="dropdown text-center">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opciones</button>
                            <!--Modificar articulo-->

                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <!--Modificar articulo-->
                                <button id="modificar" value="<?=$inventario->id_inventario_detalle?>" class="dropdown-item" type="button">Modificar</button>
                            </div>
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
    </div>
    <!--/Card body-->
</div>
<!--/Card-->

<!--Modal para agregar o modificar un articulo-->
<?php
    echo view('base/form', $dataModal);
?>