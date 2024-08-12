<table class="table table-bordered table-hover text-center">
    <thead>
        <tr>
            <th class="col-3">Código</th>
            <th class="col-5">Nombre</th>
            <th class="col-2">Precio</th>
            <th class="col-1">Cantidad</th>
            <th class="col-1">Acciones</th>
        </tr>
    </thead>
    <tbody id="productos">
        <?php foreach ($productos as $producto): ?>
        <tr class="producto">
            <td><?php echo $producto->codigo_venta; ?></td>
            <td><?php echo $producto->descripcion; ?></td>
            <td><input type="number" class="form-control form-control-sm precio" value="<?= $producto->valor_total; ?>"></td>
            <td><input type="number" class="form-control form-control-sm cantidad" value="1" min="1"></td>
            <td>
                <button type="button" class="btn btn-sm btn-primary" onclick="seleccionar_producto(this.value, this)" value="<?= $producto->id_producto?>">
                    <i class="fa fa-plus"></i>
                </button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>