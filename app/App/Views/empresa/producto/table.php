<thead>
    <tr>
        <th id="product_name" class="col-6">Nombre</th>
        <th id="measurementUnit" class="col-2">Unidad de medida</th>
        <th id="saleprice" class="col-2">Precio de venta</th>
        <th id="options" class="col-2">Opciones</th>
    </tr>
</thead>
<tbody>
    <?php foreach ($products as $product): ?>
        <tr>
            <td class="col-6"><?= $product->name ?></td>
            <td class="col-2"><?= $product->measurementUnit->description ?></td>
            <td class="col-2"><?= formatMoney($product->salePrice) ?></td>
            <td class="col-2">
                <?= get_botones($product->productId, 'producto', 'empresa', 'productos', $product->status) ?>
            </td>
            <!--Fin de las opciones-->
        </tr>
        <!--Fin de la fila-->
    <?php endforeach; ?>
    <!--Fin del ciclo-->
</tbody>
<!--/Cuerpo de la tabla-->