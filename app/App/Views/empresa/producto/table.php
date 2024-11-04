<thead>
    <tr>
        <th>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" onclick="check_documentos(this)" id="check_productos">
                <label class="custom-control-label" for="check_productos"></label>
            </div>
        </th>

        <th id="product_name" class="col-6">Nombre</th>
        <th id="measurementUnit" class="col-2">Unidad</th>
        <th id="saleprice" class="col-2">Precio de venta</th>
        <th id="options" class="col-2">Opciones</th>
    </tr>
</thead>
<tbody>
    <?php foreach ($products as $product): ?>
        <tr>
            <td>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input chk-dct" value="<?= $product->productId ?>" id="article_<?= $product->productId ?>" name="articulos[]">
                    <label class="custom-control-label" for="article_<?= $product->productId ?>"></label>
                </div>
            </td>

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