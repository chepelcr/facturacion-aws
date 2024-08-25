<thead>
    <tr>
        <th class="col-2">Código</th>
        <th class="col-5">Nombre</th>
        <th class="col-2">Unidad de medida</th>
        <th class="col-2">Opciones</th>
    </tr>
</thead>
<tbody>
    <?php foreach ($articulos as $key => $articulo):?>
    <tr>
        <td class="col-2"><?=$articulo->codigo_interno?></td>
        <td class="col-5"><?=$articulo->descripcion?></td>
        <td class="col-2"><?=$articulo->nombre_unidad?></td>
        <td class="col-2">
            <?= get_botones($articulo->id_producto, 'producto', 'empresa', 'productos', $articulo->estado)?>
        </td>
        <!--Fin de las opciones-->
    </tr>
    <!--Fin de la fila-->
    <?php endforeach;?>
    <!--Fin del ciclo-->
</tbody>
<!--/Cuerpo de la tabla-->